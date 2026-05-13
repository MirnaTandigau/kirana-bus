<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Explore; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Penting untuk menghapus foto lama

class AdminExploreController extends Controller
{
    public function index()
    {
        // Mengurutkan dari yang terbaru agar admin mudah memantau
        $explores = Explore::latest()->get(); 
        return view('admin.explore.index', compact('explores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'lokasi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Simpan foto ke folder public/explores
        $path = $request->file('foto') ? $request->file('foto')->store('explores', 'public') : null;

        Explore::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'foto' => $path
        ]);

        return back()->with('success', 'Destinasi wisata berhasil dipublikasikan ke halaman User!');
    }

    public function update(Request $request, $id)
    {
        $explore = Explore::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'lokasi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Logika ganti foto: Hapus foto lama jika ada upload baru
        $path = $explore->foto;
        if ($request->hasFile('foto')) {
            if ($explore->foto) {
                Storage::disk('public')->delete($explore->foto);
            }
            $path = $request->file('foto')->store('explores', 'public');
        }

        $explore->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'foto' => $path
        ]);

        return back()->with('success', 'Perubahan destinasi wisata berhasil disimpan.');
    }

    public function destroy($id)
    {
        $explore = Explore::findOrFail($id);

        // Hapus file fisik foto dari storage sebelum hapus data database
        if ($explore->foto) {
            Storage::disk('public')->delete($explore->foto);
        }

        $explore->delete();

        return back()->with('success', 'Destinasi wisata telah dihapus dari sistem.');
    }
}