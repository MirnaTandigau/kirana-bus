<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bus'); 
            $table->string('rute'); 
            $table->date('tanggal_berangkat');
            $table->time('jam_berangkat');
            $table->decimal('harga', 12, 2); // Harga tiket per kursi
            $table->integer('kapasitas')->default(33); // Untuk kontrol kursi
            $table->enum('tipe_jadwal', ['reguler', 'charter'])->default('reguler');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
