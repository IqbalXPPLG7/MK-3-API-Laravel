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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id('id_karyawan'); // Primary key
            $table->string('nama_karyawan');
            $table->unsignedBigInteger('id_jabatan');
            $table->decimal('gaji_pokok', 10, 2);
            $table->string('status_karyawan');
            $table->text('alamat_karyawan');
            $table->string('no_telepon');
            $table->timestamps();
        
            $table->foreign('id_jabatan')
                  ->references('id')
                  ->on('jabatan')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
