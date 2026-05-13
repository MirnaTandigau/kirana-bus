<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('tickets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
        $table->string('bus_name');
        $table->string('nama_penumpang');
        $table->string('nomor_telepon'); 
        $table->string('kategori_penumpang'); 
        $table->integer('jumlah_kursi'); 
        $table->text('nomor_kursi'); 
        $table->string('titik_jemput');
        $table->string('titik_turun');
        $table->dateTime('tanggal_berangkat');
        $table->time('jam_berangkat')->nullable();
        $table->decimal('total_bayar', 12, 2);
        $table->string('status_pembayaran')->default('Draft');
        $table->string('bukti_pembayaran')->nullable();
        $table->dateTime('expired_at')->nullable();
        $table->string('booking_type')->default('reguler'); 
        $table->boolean('is_manual_booking')->default(false);
        $table->string('bukti_ktm')->nullable(); 
        $table->string('alasan_penolakan')->nullable();
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};