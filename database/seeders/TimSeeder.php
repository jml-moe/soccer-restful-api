<?php

namespace Database\Seeders;

use App\Models\Tim;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Tim::insert([
            ['nama' => 'Arema FC', 'kota' => 'Malang', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Persebaya', 'kota' => 'Surabaya', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Persib', 'kota' => 'Bandung', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Persija', 'kota' => 'Jakarta', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
