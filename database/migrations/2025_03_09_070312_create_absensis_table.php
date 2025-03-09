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
        Schema::create('absensi', function (Blueprint $table) {

            // Perbaikan: Menambahkan unsignedBigInteger agar sesuai dengan id_karyawan di tabel karyawan
            $table->increments('id');  
            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')->references('id_karyawan')->on('karyawan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('tanggal');
            $table->enum('status', ['Hadir', 'Sakit', 'Izin', 'Alpa']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
