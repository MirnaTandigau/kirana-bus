<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    public function index()
    {
        $schedules = Schedule::where('tipe_jadwal', 'reguler')
                        ->where('tanggal_berangkat', '>=', now()->toDateString())
                        ->orderBy('tanggal_berangkat', 'asc')
                        ->get();

        Ticket::where('status_pembayaran', 'Menunggu Pembayaran')
              ->where('expired_at', '<', now())
              ->delete();

        $bookedSeats = Ticket::whereIn('status_pembayaran', ['Menunggu Pembayaran', 'Menunggu Validasi', 'Lunas'])
                             ->get()
                             ->groupBy('schedule_id')
                             ->map(function ($tickets) {
                                 return $tickets->flatMap(function ($t) {
                                     return is_array($t->nomor_kursi) ? $t->nomor_kursi : json_decode($t->nomor_kursi, true);
                                 })->unique()->toArray();
                             })->toArray();

        $myTickets = Ticket::where('user_id', Auth::id())
                           ->where('booking_type', 'reguler') 
                           ->with('schedule') 
                           ->latest()
                           ->get();

        return view('tickets.index', compact('schedules', 'myTickets', 'bookedSeats'));
    }

    /**
     * PROSES SIMPAN TIKET KURSI
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required',
            'bus_name' => 'required',
            'harga_satuan' => 'required',
            'tanggal_berangkat' => 'required',
            'nama_penumpang' => 'required',
            'nomor_telepon' => 'required',
            'kategori_penumpang' => 'required',
            'jumlah_kursi' => 'required|integer|min:1',
            'nomor_kursi' => 'required|array',
            'titik_jemput' => 'required',
            'titik_turun' => 'required',
            'action' => 'required',
            'bukti_ktm' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:50000' 
        ]);

        $bookedSeats = Ticket::whereIn('status_pembayaran', ['Menunggu Pembayaran', 'Menunggu Validasi', 'Lunas'])
                             ->where('schedule_id', $request->schedule_id)
                             ->where('id', '!=', $request->ticket_id) 
                             ->pluck('nomor_kursi')
                             ->flatMap(fn($item) => is_array($item) ? $item : json_decode($item, true))
                             ->toArray();

        foreach ($request->nomor_kursi as $seat) {
            if (in_array($seat, $bookedSeats)) {
                return back()->with('error', 'Maaf, kursi nomor ' . $seat . ' baru saja dipesan orang lain.');
            }
        }

        $schedule = Schedule::findOrFail($request->schedule_id);
        $hargaDasar = $schedule->harga;
        $potongan = ($request->kategori_penumpang == 'Mahasiswa') ? 50000 : 0;
        $totalBayar = ($hargaDasar - $potongan) * $request->jumlah_kursi;

        $status = ($request->action == 'confirm') ? 'Menunggu Pembayaran' : 'Draft';
        $expired = ($request->action == 'confirm') ? now()->addHours(24) : null;

        $ktmPath = null;
        if ($request->ticket_id) {
            $existingTicket = Ticket::find($request->ticket_id);
            $ktmPath = $existingTicket ? $existingTicket->bukti_ktm : null;
        }

        if ($request->hasFile('bukti_ktm')) {
            $ktmPath = $request->file('bukti_ktm')->store('bukti_ktm', 'public');
        }

        $ticket = Ticket::updateOrCreate(
            ['id' => $request->ticket_id],
            [
                'user_id' => Auth::id(),
                'schedule_id' => $request->schedule_id,
                'booking_type' => 'reguler', 
                'bus_name' => $request->bus_name,
                'tanggal_berangkat' => $request->tanggal_berangkat,
                'jam_berangkat' => \Carbon\Carbon::parse($schedule->tanggal_berangkat)->format('Y-m-d') . ' ' . \Carbon\Carbon::parse($schedule->jam_berangkat)->format('H:i:s'),
                'nama_penumpang' => $request->nama_penumpang,
                'nomor_telepon' => $request->nomor_telepon,
                'kategori_penumpang' => $request->kategori_penumpang,
                'jumlah_kursi' => $request->jumlah_kursi,
                'nomor_kursi' => json_encode($request->nomor_kursi), 
                'titik_jemput' => $request->titik_jemput,
                'titik_turun' => $request->titik_turun,
                'total_bayar' => $totalBayar,
                'status_pembayaran' => $status,
                'expired_at' => $expired,
                'bukti_ktm' => $ktmPath, 
            ]
        );

        if ($request->action == 'confirm') {
            return redirect()->route('tickets.payment', $ticket->id)
                             ->with('success', 'Pesanan berhasil dikonfirmasi. Silakan unggah bukti transfer Anda.');
        }

        return redirect()->route('tickets.index')->with('success', 'Draft berhasil diperbarui.');
    }

    /**
     * HALAMAN CHARTER BUS (SEWA UNIT)
     */
    public function charterIndex()
    {
        // 1. CARI JADWAL YANG SUDAH LAKU / SEDANG DIPROSES
        // Kita ambil semua ID jadwal yang statusnya bukan 'Dibatalkan'
        $bookedScheduleIds = Ticket::where('booking_type', 'charter')
                                ->whereIn('status_pembayaran', [
                                    'Menunggu Validasi', 
                                    'Lunas'
                                ])
                                ->pluck('schedule_id')
                                ->filter() // Membuang yang nilainya null (jika ada)
                                ->toArray();

        // 2. TAMPILKAN HANYA JADWAL YANG MASIH KOSONG
        $schedules = Schedule::where('tipe_jadwal', 'charter')
                        ->where('tanggal_berangkat', '>=', now()->toDateString())
                        ->whereNotIn('id', $bookedScheduleIds) // <--- KODE AJAIB UNTUK MENYEMBUNYIKAN JADWAL
                        ->orderBy('tanggal_berangkat', 'asc')
                        ->get();
        
        // 3. AMBIL RIWAYAT TIKET MILIK USER
        $myTickets = Ticket::where('user_id', Auth::id())
                        ->where('booking_type', 'charter')
                        ->latest()
                        ->get();
        
        return view('tickets.charter', compact('schedules', 'myTickets'));
    }

    /**
     * SIMPAN PERMINTAAN CHARTER
     */
    public function storeCharter(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_berangkat' => 'required',
            'pickup_point' => 'required|string|max:255',
            'destination_point' => 'required|string|max:255',
            'trip_type' => 'required|in:one_way,round_trip',
            'nomor_telepon' => 'required|string|max:20',
            'schedule_id' => 'nullable'
        ]);

        $busName = 'Charter Full Unit';
        if ($request->schedule_id) {
            $sch = Schedule::find($request->schedule_id);
            if ($sch) $busName = $sch->nama_bus;
        }

        $formattedJam = Carbon::parse($request->jam_berangkat)->format('H:i:s');

        $charter = Ticket::create([
            'user_id'           => Auth::id(),
            'schedule_id'       => $request->schedule_id,
            'booking_type'      => 'charter', 
            'bus_name'          => $busName,
            'tanggal_berangkat' => $request->tanggal,
            'jam_berangkat'     => $formattedJam,
            'nama_penumpang'    => Auth::user()->name,
            'nomor_telepon'     => $request->nomor_telepon,
            'kategori_penumpang'=> 'Umum',
            'jumlah_kursi'      => 0, 
            'nomor_kursi'       => json_encode(['Full Unit']),
            'titik_jemput'      => $request->pickup_point,
            'titik_turun'       => $request->destination_point,
            'total_bayar'       => 0, 
            'status_pembayaran' => 'Menunggu Tinjauan',
            'expired_at'        => null,
            'trip_type'         => $request->trip_type,
        ]);

        return redirect()->route('tickets.charter.index')->with('success', 'Permintaan sewa bus berhasil dikirim!');
    }

    /**
     * METHOD PENDUKUNG (PAYMENT, CANCEL, DESTROY, DOWNLOAD)
     */
    public function payment($id)
    {
        $ticket = Ticket::findOrFail($id);
        if ($ticket->user_id !== Auth::id()) { abort(403); }
        return view('tickets.payment', compact('ticket'));
    }

   public function uploadProof(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $rules = [
            'bukti_pembayaran' => 'required|file|mimes:jpeg,png,jpg|max:50000',
        ];

        if ($ticket->kategori_penumpang == 'Mahasiswa' && empty($ticket->bukti_ktm)) {
            $rules['bukti_ktm'] = 'required|file|mimes:jpeg,png,jpg,pdf|max:50000';
        } elseif ($request->hasFile('bukti_ktm')) {
            $rules['bukti_ktm'] = 'file|mimes:jpeg,png,jpg,pdf|max:50000';
        }

        $request->validate($rules);

        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_transfer', 'public');
            $ticket->bukti_pembayaran = $buktiPath;
        }

        if ($request->hasFile('bukti_ktm')) {
            $ktmPath = $request->file('bukti_ktm')->store('bukti_ktm', 'public');
            $ticket->bukti_ktm = $ktmPath;
        }

        $ticket->status_pembayaran = 'Menunggu Validasi';
        $ticket->save();

        // ---- PERBAIKAN REDIRECT ADA DI SINI ----
        // Cek apakah ini tiket charter atau reguler
        if ($ticket->booking_type == 'charter') {
            // Arahkan ke halaman riwayat charter
            return redirect()->route('tickets.charter.index')->with('success', 'Bukti pembayaran charter berhasil diunggah! Menunggu validasi admin.');
        } else {
            // Arahkan ke halaman riwayat reguler
            return redirect()->route('tickets.index')->with('success', 'Bukti pembayaran berhasil diunggah! Menunggu validasi admin.');
        }
    }

    /**
     * BATALKAN PESANAN
     */
    public function cancel($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        if ($ticket->user_id !== Auth::id()) { abort(403); }

        $allowedToCancel = ['Draft', 'Menunggu Pembayaran', 'Menunggu Tinjauan'];
        if (!in_array($ticket->status_pembayaran, $allowedToCancel)) {
            return redirect()->back()->with('error', 'Pesanan ini sudah diproses dan tidak dapat dibatalkan.');
        }

        $ticket->status_pembayaran = 'Dibatalkan';
        $ticket->save();

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * HAPUS RIWAYAT
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        if ($ticket->user_id !== Auth::id()) { abort(403); }
        
        // Mencegah penghapusan jika sedang divalidasi
        $preventDelete = ['Menunggu Validasi'];
        if (in_array($ticket->status_pembayaran, $preventDelete)) {
            return redirect()->back()->with('error', 'Pesanan sedang divalidasi admin, tidak dapat dihapus.');
        }
        
        $ticket->delete();
        return redirect()->back()->with('success', 'Riwayat pesanan berhasil dihapus dari daftar Anda.');
    }

    /**
     * DOWNLOAD TIKET PDF
     */
    public function download($id)
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->status_pembayaran !== 'Lunas') {
            return redirect()->back()->with('error', 'Tiket belum lunas.');
        }

        // Deteksi apakah ini tiket charter
        $isCharter = false;
        if (isset($ticket->schedule) && $ticket->schedule->tipe_jadwal == 'charter') {
            $isCharter = true;
        } elseif (!empty($ticket->trip_type) || !empty($ticket->pickup_point)) {
            $isCharter = true;
        }

        // Memanggil file blade ticket-charter atau ticket-reguler sesuai bahasa asli Anda
        $viewName = $isCharter ? 'tickets.ticket-charter' : 'tickets.ticket-reguler';

        // 2. PROSES HTML MENJADI PDF
        $pdf = Pdf::loadView($viewName, compact('ticket'));
        
        // Atur ukuran kertas ke A4
        $pdf->setPaper('A4', 'portrait');

        // 3. NAMA FILE SAAT TERDOWNLOAD OTOMATIS
        $fileName = 'E-Ticket_Kirana_' . ($isCharter ? 'Charter_' : 'Reguler_') . $ticket->id . '.pdf';

        // 4. PERINTAH UNDUH OTOMATIS
        return $pdf->download($fileName);
    }
}