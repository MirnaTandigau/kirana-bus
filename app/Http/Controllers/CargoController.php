<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CargoController extends Controller
{
    public function index()
    {
        // Mengambil riwayat pengiriman milik pengguna yang sedang login
        $cargos = Cargo::where('user_id', Auth::id())->latest()->get();
        
        return view('cargos.index', compact('cargos'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nama_pengirim' => 'required|string|max:255',
            'telepon_pengirim' => 'nullable|string|max:15', // Optional
            'nama_penerima' => 'required|string|max:255',
            'telepon_penerima' => 'required|string|max:20', // Wajib
            'jenis_barang' => 'required',
            'deskripsi_barang' => 'required|string', // Deskripsi barang
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg|max:50000',
            'berat_kg' => 'required|numeric|min:0.5',
            'kantor_pengiriman' => 'required', // Kantor asal
            'perwakilan_ambil' => 'required', // Kantor tujuan
        ]);

        $path = null;
        if ($request->hasFile('foto_barang')) {
        $path = $request->file('foto_barang')->store('foto_cargo', 'public'); // Simpan ke storage
        }

        // Menyimpan data ke database
        Cargo::create([
            'user_id' => Auth::id(),
            'nama_pengirim' => $request->nama_pengirim,
            'telepon_pengirim' => $request->telepon_pengirim,
            'nama_penerima' => $request->nama_penerima,
            'telepon_penerima' => $request->telepon_penerima,
            'jenis_barang' => $request->jenis_barang,
            'deskripsi_barang' => $request->deskripsi_barang,
            'foto_barang' => $path,
            'berat_kg' => $request->berat_kg,
            'kantor_pengiriman' => $request->kantor_pengiriman,
            'perwakilan_ambil' => $request->perwakilan_ambil,
            'status_pengiriman' => 'Pending', 
        ]);

        return redirect()->route('cargos.index')->with('success', 'Data pengiriman barang berhasil didaftarkan!');
    }

    public function updateStatus(Request $request, $id)
    {
    $cargo = Cargo::findOrFail($id);
    
    // Admin mengisi harga setelah timbang dan memperbarui lokasi
    $cargo->update([
        'berat_kg' => $request->berat_asli, // Berat nyata hasil timbangan
        'harga_final' => $request->harga_final, // Harga resmi
        'status_pembayaran' => 'Lunas',
        'status_pengiriman' => $request->status_baru, // Contoh: "Dikirim" atau "Siap Diambil"
        'lokasi_terkini' => $request->lokasi_baru // Contoh: "Dalam perjalanan ke Makale"
    ]);

    return back()->with('success', 'Status Cargo diperbarui.');
    }
}