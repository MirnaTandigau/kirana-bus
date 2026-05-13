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
        Schema::table('cargos', function (Blueprint $table) {
        // Berat asli hasil timbangan kantor
        if (!Schema::hasColumn('cargos', 'berat_final')) {
            $table->decimal('berat_final', 8, 2)->nullable()->after('berat_kg');
        }
        
        // Harga final yang harus dibayar
        if (!Schema::hasColumn('cargos', 'harga_final')) {
            $table->decimal('harga_final', 12, 2)->nullable()->after('berat_final');
        }
        
        // Kolom status untuk tracking real-time admin
        if (!Schema::hasColumn('cargos', 'lokasi_terkini')) {
            $table->string('lokasi_terkini')->default('Kantor Perwakilan Asal')->after('status_pengiriman');
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cargos', function (Blueprint $table) {
            //
        });
    }
};
