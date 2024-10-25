<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('availability')->insert([
            [
                'day' => 'Lundi',
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'professional_id' => 1,  
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'day' => 'Mardi',
                'start_time' => '10:00:00',
                'end_time' => '18:00:00',
                'professional_id' => 2,  
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'day' => 'Mercredi',
                'start_time' => '08:00:00',
                'end_time' => '16:00:00',
                'professional_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}