<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bus',         // Bus 1 / Bus 2
        'rute',             // Manado-Toraja / Toraja-Manado
        'tanggal_berangkat',
        'jam_berangkat',
        'harga',            // Harga per kursi
        'kapasitas',
        'tipe_jadwal'
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
    ];

    // Relasi ke Tiket: Satu jadwal memiliki banyak tiket
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}