<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Menambahkan kolom trip_type
            $table->string('trip_type')->nullable()->after('status_pembayaran');
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('trip_type');
        });
    }
};