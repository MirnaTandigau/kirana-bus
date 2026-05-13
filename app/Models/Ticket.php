<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'schedule_id',      
        'bus_name',
        'nama_penumpang',
        'nomor_telepon',
        'kategori_penumpang',
        'jumlah_kursi',
        'nomor_kursi',
        'titik_jemput',
        'titik_turun',
        'booking_type',
        'tanggal_berangkat',
        'jam_berangkat',
        'total_bayar',
        'status_pembayaran', 
        'bukti_pembayaran',
        'trip_type',
        'bukti_ktm',
        'alasan_penolakan',
        'expired_at',
        'is_manual_booking'
    ];

    protected $casts = [
        'tanggal_berangkat' => 'datetime',
        'expired_at' => 'datetime',
        'is_manual_booking' => 'boolean', 
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}