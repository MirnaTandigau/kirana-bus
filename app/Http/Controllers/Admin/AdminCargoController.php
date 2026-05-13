<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use Illuminate\Http\Request;

class AdminCargoController extends Controller
{
    // Menampilkan daftar cargo masuk
    public function index()
    {
        $cargos = Cargo::latest()->get();
        return view('admin.cargos.index', compact('cargos'));
    }

    // Memproses berat asli dan harga final (Update Data)
    public function processCargo(Request $request, $id)
    {
        $request->validate([
            'berat_final' => 'required|numeric',
            'harga_final' => 'required|numeric',
        ]);

        $cargo = Cargo::findOrFail($id);
        $cargo->update([
            'berat_final' => $request->berat_final,
            'harga_final' => $request->harga_final,
            'status_pengiriman' => 'Menunggu Pembayaran' // Status berubah setelah ditimbang
        ]);

        return back()->with('success', 'Berat dan harga final berhasil disimpan.');
    }

    // Mengupdate status pembayaran dan lokasi tracking
    public function updateTracking(Request $request, $id)
    {
        $cargo = Cargo::findOrFail($id);
        
        $cargo->update([
            'status_pengiriman' => $request->status_pengiriman ?? $cargo->status_pengiriman,
            'lokasi_terkini' => $request->lokasi_terkini ?? $cargo->lokasi_terkini
        ]);

        return back()->with('success', 'Status dan lokasi barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Sesuaikan 'Cargo' dengan nama model Anda (misal: Ekspedisi, Cargo, dll)
        $cargo = \App\Models\Cargo::findOrFail($id); 

        $cargo->delete();

        return redirect()->back()->with('success', 'Data pengiriman berhasil dihapus.');
    }

    // Menampilkan halaman cetak resi
    public function printResi($id)
    {
        $cargo = Cargo::findOrFail($id);
        return view('admin.cargos.resi', compact('cargo'));
    }
}