<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    // Menampilkan daftar semua jadwal bus (Reguler & Charter)
    public function index()
    {
        $schedules = Schedule::latest()->get();
        return view('admin.schedules.index', compact('schedules'));
    }

    // Menampilkan form tambah jadwal dengan parameter tipe
    public function create(Request $request)
    {
        // Menangkap parameter ?type= dari URL (default: reguler)
        $type = $request->query('type', 'reguler'); 
        return view('admin.schedules.create', compact('type'));
    }

    // Menyimpan jadwal baru (Reguler atau Charter) ke database
    public function store(Request $request)
    {
        $rules = [
            'nama_bus' => 'required|string',
            'rute' => 'required|string',
            'kapasitas' => 'required|integer',
            'tanggal_berangkat' => 'required|date',
            'jam_berangkat' => 'required',
            'type' => 'required|in:reguler,charter', // Validasi tipe jadwal
        ];

        // Jika tipe reguler, harga wajib diisi. Jika charter, harga tidak wajib (0)
        if ($request->type == 'reguler') {
            $rules['harga'] = 'required|numeric|min:0';
        }

        $request->validate($rules);

        Schedule::create([
            'nama_bus'          => $request->nama_bus,
            'rute'              => $request->rute,
            'kapasitas'         => $request->kapasitas,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'jam_berangkat'     => $request->jam_berangkat,
            'harga'             => $request->type == 'reguler' ? $request->harga : 0,
            'tipe_jadwal'       => $request->type, // Menyimpan pembeda (reguler/charter)
        ]);

        // ---- PERBAIKAN REDIRECT STORE ----
        if ($request->type == 'charter') {
            return redirect()->route('admin.schedules.index', ['tab' => 'charter'])
                             ->with('success', 'Jadwal Charter berhasil ditambahkan.');
        } else {
            return redirect()->route('admin.schedules.index', ['tab' => 'reguler'])
                             ->with('success', 'Jadwal Reguler berhasil ditambahkan.');
        }
    }

    // Menampilkan form edit jadwal
    public function edit(Schedule $schedule)
    {
        // Mengirimkan tipe jadwal yang ada saat ini agar form edit menyesuaikan
        $type = $schedule->tipe_jadwal;
        return view('admin.schedules.edit', compact('schedule', 'type'));
    }

    // Memperbarui data jadwal di database
    public function update(Request $request, Schedule $schedule)
    {
        $rules = [
            'nama_bus' => 'required|string',
            'rute' => 'required|string',
            'kapasitas' => 'required|integer',
            'tanggal_berangkat' => 'required|date',
            'jam_berangkat' => 'required',
        ];

        // Validasi harga tetap berlaku jika jadwal yang diedit bertipe reguler
        if ($schedule->tipe_jadwal == 'reguler') {
            $rules['harga'] = 'required|numeric|min:0';
        }

        $request->validate($rules);

        $schedule->update([
            'nama_bus'          => $request->nama_bus,
            'rute'              => $request->rute,
            'kapasitas'         => $request->kapasitas,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'jam_berangkat'     => $request->jam_berangkat,
            'harga'             => $schedule->tipe_jadwal == 'reguler' ? $request->harga : 0,
        ]);

        // ---- PERBAIKAN REDIRECT UPDATE ----
        if ($schedule->tipe_jadwal == 'charter') {
            return redirect()->route('admin.schedules.index', ['tab' => 'charter'])
                             ->with('success', 'Jadwal Charter berhasil diperbarui.');
        } else {
            return redirect()->route('admin.schedules.index', ['tab' => 'reguler'])
                             ->with('success', 'Jadwal Reguler berhasil diperbarui.');
        }
    }

    // Menghapus jadwal
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }
}