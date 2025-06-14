<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pertandingan;

class PertandinganSeeder extends Seeder
{
    public function run(): void
    {
        Pertandingan::insert([
            [
                'tanggal' => '2024-08-01',
                'waktu' => '15:00:00',
                'lokasi' => 'Stadion Utama',
                'tim_home_id' => 1,
                'tim_away_id' => 2,
                'skor_home' => 2,
                'skor_away' => 1,
                'liga_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => '2024-08-02',
                'waktu' => '18:00:00',
                'lokasi' => 'Stamford Bridge',
                'tim_home_id' => 3,
                'tim_away_id' => 4,
                'skor_home' => 0,
                'skor_away' => 0,
                'liga_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => '2024-08-03',
                'waktu' => '20:00:00',
                'lokasi' => 'Camp Nou',
                'tim_home_id' => 5,
                'tim_away_id' => 6,
                'skor_home' => 3,
                'skor_away' => 2,
                'liga_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 