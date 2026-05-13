<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_pengirim',
        'telepon_pengirim',
        'nama_penerima',
        'telepon_penerima',
        'jenis_barang',
        'deskripsi_barang',
        'foto_barang',
        'berat_kg',          // Estimasi dari user
        'berat_final',       // Update asli dari admin
        'harga_final',       // Harga resmi setelah ditimbang
        'kantor_pengiriman',
        'perwakilan_ambil',
        'status_pengiriman', // 'Menunggu Penimbangan', 'Lunas', 'Diterima', dll
        'lokasi_terkini'     // Update perkembangan lokasi barang
    ];
}