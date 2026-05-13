<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Cargo;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ==========================================
        // 1. STATISTIK ANGKA (Untuk Widget di Atas)
        // ==========================================
        
        // Tiket yang butuh tindakan admin (Validasi Transfer atau Tinjau Harga Charter)
        $totalTiketBaru = Ticket::whereIn('status_pembayaran', ['Menunggu Validasi', 'Menunggu Tinjauan'])->count();
        $totalPendapatanTiket = Ticket::where('status_pembayaran', 'Lunas')->sum('total_bayar');

        // Statistik Cargo yang masih murni baru masuk loket (Pending)
        $cargoPending = Cargo::where('status_pengiriman', 'Menunggu Penimbangan')->count();
        
        // Pendapatan cargo dihitung dari yang statusnya sudah jalan/selesai (bukan lagi menunggu penimbangan)
        $totalPendapatanCargo = Cargo::where('status_pengiriman', '!=', 'Menunggu Penimbangan')->sum('harga_final');

        // Statistik User (Pastikan sesuai dengan kolom database Anda: is_admin = false)
        $totalUser = User::where('is_admin', false)->count();


        // ==========================================
        // 2. DATA DAFTAR ANTREAN (Untuk To-Do List)
        // ==========================================
        
        // Ambil 5 antrean tiket teratas yang butuh aksi admin
        $pendingTickets = Ticket::whereIn('status_pembayaran', ['Menunggu Validasi', 'Menunggu Tinjauan'])
                                ->latest()
                                ->take(5)
                                ->get();

        // Ambil 5 antrean barang teratas yang baru di-drop dan butuh ditimbang/dihargai
        $pendingCargosList = Cargo::where('status_pengiriman', 'Menunggu Penimbangan')
                                ->latest()
                                ->take(5)
                                ->get();

        // Kirim semua variabel ke tampilan view admin.dashboard
        return view('admin.dashboard', compact(
            'totalTiketBaru', 
            'totalPendapatanTiket', 
            'cargoPending', 
            'totalPendapatanCargo',
            'totalUser',
            'pendingTickets',
            'pendingCargosList'
        ));
    }
}