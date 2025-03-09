<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 0; $i < 10; $i++) { // Loop untuk membuat 10 data dummy
            Karyawan::create([
                'nama_karyawan' => $faker->name, // Nama acak
                'id_jabatan' => $faker->numberBetween(1, 5), // Pastikan id_jabatan sesuai dengan data tabel jabatan
                'gaji_pokok' => $faker->randomFloat(2, 3000000, 10000000), // Gaji pokok acak antara 3 juta hingga 10 juta
                'status_karyawan' => $faker->randomElement(['Aktif', 'Tidak Aktif']), // Pilihan status karyawan
                'alamat_karyawan' => $faker->address, // Alamat acak
                'no_telepon' => $faker->phoneNumber, // Nomor telepon acak
            ]);
        }
    }
}
