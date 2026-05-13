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
        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_pengirim');
            $table->string('telepon_pengirim')->nullable(); 
            $table->string('nama_penerima');
            $table->string('telepon_penerima'); 
            $table->string('jenis_barang'); 
            $table->text('deskripsi_barang'); 
            $table->string('foto_barang')->nullable();
            
            // Kolom berat menggunakan decimal agar akurat (misal: 1.5kg)
            $table->decimal('berat_kg', 8, 2)->nullable(); 
            
            // Penambahan kolom HARGA FINAL untuk mengatasi error Dashboard
            $table->decimal('harga_final', 12, 2)->nullable(); 
            
            $table->string('kantor_pengiriman'); 
            $table->string('perwakilan_ambil'); 
            
            // Status pengiriman default saat pendaftaran
            $table->string('status_pengiriman')->default('Menunggu Penimbangan'); 
            $table->string('status_pembayaran')->default('Belum Lunas');
            
            // Penambahan kolom LOKASI TERKINI untuk fitur tracking
            $table->string('lokasi_terkini')->default('Kantor Asal'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos');
    }
};