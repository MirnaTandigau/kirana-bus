<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Cargo; // Sesuaikan jika nama model ekspedisi Anda berbeda

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Cari tagihan tiket yang belum dibayar/menunggu validasi
        $unpaidTickets = Ticket::where('user_id', $userId)
            ->whereIn('status_pembayaran', ['Menunggu Pembayaran', 'Menunggu Validasi', 'Menunggu Tinjauan'])
            ->get();

        // 2. Cari tiket perjalanan terdekat (sudah lunas & tanggal >= hari ini)
        $upcomingTicket = Ticket::where('user_id', $userId)
            ->where('status_pembayaran', 'Lunas')
            ->where('tanggal_berangkat', '>=', now()->toDateString())
            ->orderBy('tanggal_berangkat', 'asc')
            ->first();

        // 3. Cari paket ekspedisi yang sedang aktif (belum diterima)
        $activeCargos = Cargo::where('user_id', $userId)
            ->whereNotIn('status_pengiriman', ['Diterima', 'Dibatalkan'])
            ->get();

        // 4. Riwayat transaksi terbaru (Ambil 4 tiket terbaru)
        $recentTickets = Ticket::where('user_id', $userId)
            ->latest()
            ->take(4)
            ->get();

        return view('dashboard', compact('unpaidTickets', 'upcomingTicket', 'activeCargos', 'recentTickets'));
    }
}