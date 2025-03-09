<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 1; $i <= 5; $i++) { // Buat 5 jabatan
            Jabatan::create([
                'nama_jabatan' => 'Jabatan ' . $i,
                'tunjangan' => $faker->randomFloat(2, 1000000, 3000000), // Tunjangan antara 1 juta - 3 juta
                'gaji' => $faker->randomFloat(2, 5000000, 15000000), // Gaji antara 5 juta - 15 juta
            ]);
        }
    }
}
