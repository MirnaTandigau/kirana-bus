<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminTicketController extends Controller
{
    /**
     * HALAMAN UTAMA MANAJEMEN TIKET (GABUNGAN)
     * Menyatukan Validasi, Daftar Penumpang, dan Penjualan Loket
     */
    public function index(Request $request)
    {
        // 1. DATA UNTUK TAB VALIDASI (Tiket yang butuh tindakan admin segera)
        $pendingTickets = Ticket::with('schedule')
            ->where('status_pembayaran', 'Menunggu Validasi')
            ->latest()
            ->get();

        // 2. DATA UNTUK TAB MANAJEMEN / MANIFEST (Seluruh Penumpang)
        $query = Ticket::with('schedule');

        // Filter berdasarkan Jadwal jika dipilih
        if ($request->has('schedule_id') && $request->schedule_id != '') {
            $query->where('schedule_id', $request->schedule_id);
        }

        // Filter berdasarkan Status jika dipilih
        if ($request->has('status') && $request->status != '') {
            $query->where('status_pembayaran', $request->status);
        }

        $allTickets = $query->latest()->paginate(15);

        // 3. DATA JADWAL (Untuk filter dan Form Booking Manual)
        $schedules = Schedule::where('tanggal_berangkat', '>=', now()->toDateString())
            ->orderBy('tanggal_berangkat', 'asc')
            ->get();

        // 4. DATA KURSI TERBOOKING (Untuk Denah Kursi Interaktif di Form Manual)
        $bookedSeatsWithStatus = [];
        $allBookedTickets = Ticket::whereIn('status_pembayaran', ['Menunggu Pembayaran', 'Menunggu Validasi', 'Lunas'])
            ->get();

        foreach ($allBookedTickets as $ticket) {
            $seats = is_array($ticket->nomor_kursi) ? $ticket->nomor_kursi : json_decode($ticket->nomor_kursi, true);
            if ($seats) {
                foreach ($seats as $seat) {
                    // Jika ada kursi yang statusnya ganda, Lunas diprioritaskan
                    $existingStatus = $bookedSeatsWithStatus[$ticket->schedule_id][$seat] ?? null;
                    if ($existingStatus !== 'Lunas') {
                        $bookedSeatsWithStatus[$ticket->schedule_id][$seat] = $ticket->status_pembayaran;
                    }
                }
            }
        }

        // Pastikan Anda mem-passing variabel baru ini di fungsi compact()
        return view('admin.tickets.index', compact(
            'pendingTickets', 
            'allTickets', 
            'schedules', 
            'bookedSeatsWithStatus' // <-- Ubah variabel ini di compact
        ));
    }

    /**
     * Validasi Pembayaran
     */
    public function validatePayment(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        $ticket->status_pembayaran = $request->status;

        if ($request->status == 'Ditolak') {
            $ticket->alasan_penolakan = $request->alasan_penolakan;
        } else {
            $ticket->alasan_penolakan = null; 
        }

        $ticket->save();

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    /**
     * Booking Manual oleh Admin (Penjualan Loket)
     */
    public function storeManual(Request $request) 
    {
        $request->validate([
            'schedule_id' => 'required',
            'nama_penumpang' => 'required|string',
            'nomor_kursi' => 'required|array',
            'titik_jemput' => 'required|string',
            'titik_turun' => 'required|string',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);
        $jumlahKursi = count($request->nomor_kursi);

        $hargaDasar = $schedule->harga; 
        $potongan = ($request->kategori_penumpang === 'Mahasiswa') ? 50000 : 0;
        $totalBayarAkhir = ($hargaDasar - $potongan) * $jumlahKursi;

        Ticket::create([
            'user_id' => Auth::id(),
            'schedule_id' => $schedule->id, 
            'bus_name' => $schedule->nama_bus,
            'nama_penumpang' => $request->nama_penumpang,
            'nomor_telepon' => $request->nomor_telepon,
            'kategori_penumpang' => $request->kategori_penumpang ?? 'Umum',
            'jumlah_kursi' => $jumlahKursi,
            'nomor_kursi' => json_encode($request->nomor_kursi),
            'titik_jemput' => $request->titik_jemput,
            'titik_turun' => $request->titik_turun,
            'tanggal_berangkat' => $schedule->tanggal_berangkat,
            'jam_berangkat' => $schedule->jam_berangkat, // Tambahkan jam berangkat agar sinkron
            'total_bayar' => $totalBayarAkhir, 
            'status_pembayaran' => 'Lunas', // Loket biasanya langsung lunas (Cash)
            'is_manual_booking' => 1,
            'booking_type' => 'reguler',
        ]);

        return back()->with('success', 'Tiket loket berhasil diterbitkan.');
    }

    /**
     * Set Harga untuk Charter
     */
    public function setCharterPrice(Request $request, $id)
    {
        $request->validate(['total_bayar' => 'required|numeric|min:0']);

        $ticket = Ticket::findOrFail($id);
        $ticket->update([
            'total_bayar' => $request->total_bayar,
            'status_pembayaran' => 'Menunggu Pembayaran'
        ]);

        return back()->with('success', 'Harga sewa telah dikirim ke pelanggan.');
    }

    /**
     * Cetak Manifest
     */
    public function printManifest(Request $request)
    {
        $query = Ticket::where('status_pembayaran', 'Lunas')->with('schedule');

        if ($request->schedule_id) {
            $query->where('schedule_id', $request->schedule_id);
        }

        $tickets = $query->get();

        $sortedTickets = $tickets->sortBy(function ($ticket) {
            $seats = is_array($ticket->nomor_kursi) ? $ticket->nomor_kursi : json_decode($ticket->nomor_kursi, true);
            return (int) ($seats[0] ?? 99); 
        });

        $scheduleInfo = $request->schedule_id ? Schedule::find($request->schedule_id) : null;

        return view('admin.tickets.print', [
            'tickets' => $sortedTickets,
            'schedule' => $scheduleInfo
        ]);
    }
}