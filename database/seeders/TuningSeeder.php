<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tuning;
use App\Models\User;

class TuningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // Obtener el primer usuario
        if ($user) {
            Tuning::create([
                'user_id' => $user->id,
                'name' => 'Standard E',
                'instrument_type' => 'Guitar',
                'tuning_1' => 'E',
                'tuning_2' => 'A',
                'tuning_3' => 'D',
                'tuning_4' => 'G',
                'tuning_5' => 'B',
                'tuning_6' => 'E',
            ]);
        }

        if ($user) {
            Tuning::create([
                'user_id' => $user->id,
                'name' => 'Drop D',
                'instrument_type' => 'Guitar',
                'tuning_1' => 'D',
                'tuning_2' => 'A',
                'tuning_3' => 'D',
                'tuning_4' => 'G',
                'tuning_5' => 'B',
                'tuning_6' => 'E',
            ]);
        }
    }
}
