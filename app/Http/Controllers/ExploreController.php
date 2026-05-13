<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Explore; // Pastikan Model Explore diimpor

class ExploreController extends Controller
{
    public function index()
    {
        // Mengambil semua data destinasi terbaru dari tabel explores di database
        // latest() akan mengurutkan dari yang paling baru ditambahkan oleh admin
        $destinations = Explore::latest()->get();

        // Mengirimkan variabel $destinations ke view explore.index
        return view('explore.index', compact('destinations'));
    }
}