<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Liga;

class LigaSeeder extends Seeder
{
    public function run(): void
    {
        Liga::insert([
            [
                'nama' => 'Liga 1 Indonesia',
                'tahun_mulai' => '2024',
                'tahun_selesai' => '2025',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Premier League',
                'tahun_mulai' => '2024',
                'tahun_selesai' => '2025',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'La Liga',
                'tahun_mulai' => '2024',
                'tahun_selesai' => '2025',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 