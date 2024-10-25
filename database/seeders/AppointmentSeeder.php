<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('appointments')->insert([
            [
                'date_appointment' => '2024-09-15',
                'time_appointment' => '10:00:00',
                'reason' => 'Maladie et traumatisme',
                'status' => 'Confirmé',
                'dog_id' => 1,  
                'professional_id' => 1,  
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date_appointment' => '2024-09-14',
                'time_appointment' => '14:30:00',
                'reason' => 'Maladie chronique',
                'status' => 'En attente',
                'dog_id' => 1,  
                'professional_id' => 1,  
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date_appointment' => '2024-09-01',
                'time_appointment' => '09:15:00',
                'reason' => 'Maladie sangrée',
                'status' => 'Annulé',
                'dog_id' => 1,  
                'professional_id' => 1,  
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}