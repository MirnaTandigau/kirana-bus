<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bus',
        'rute',
        'tanggal_berangkat',
        'jam_berangkat',
        'harga',
        'kapasitas',
        'tipe_jadwal'
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}