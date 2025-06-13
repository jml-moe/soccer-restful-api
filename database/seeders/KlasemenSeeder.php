<?php

namespace Database\Seeders;

use App\Models\Klasemen;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KlasemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Klasemen::insert([
            [
                'tim_id' => 1,
                'points' => 10,
                'wins' => 3,
                'draws' => 1,
                'losses' => 0,
                'goals_for' => 7,
                'goals_against' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tim_id' => 2,
                'points' => 8,
                'wins' => 2,
                'draws' => 2,
                'losses' => 0,
                'goals_for' => 6,
                'goals_against' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tim_id' => 3,
                'points' => 4,
                'wins' => 1,
                'draws' => 1,
                'losses' => 2,
                'goals_for' => 4,
                'goals_against' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
