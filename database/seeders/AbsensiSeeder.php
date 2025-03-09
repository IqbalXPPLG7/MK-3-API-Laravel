<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Database\Seeder;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // Mendapatkan ID karyawan yang ada di tabel karyawan
        $karyawanIds = Karyawan::pluck('id_karyawan');

        // Mengecek apakah tabel karyawan memiliki data
        if ($karyawanIds->isEmpty()) {
            $this->command->info('Tidak ada data karyawan. Pastikan tabel karyawan memiliki data.');
            return;
        }

        // Looping untuk setiap ID karyawan
        foreach ($karyawanIds as $id) {
            for ($i = 0; $i < 5; $i++) {
                Absensi::create([
                    'karyawan_id' => $id, // Foreign key ke tabel absensi
                    'tanggal' => $faker->dateTimeBetween('-1 month', 'now'), // Tanggal absensi acak
                    'status' => $faker->randomElement(['Hadir', 'Izin', 'Sakit', 'Alpa']), // Status absensi acak
                    // Kolom 'id' tidak perlu diisi karena Laravel akan mengisinya secara otomatis
                ]);
            }
        }

        $this->command->info('Seeder absensi selesai.');
    }
}
