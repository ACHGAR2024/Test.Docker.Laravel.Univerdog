<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('dogs')->insert([
            [
                'name_dog' => 'Rex',
                'breed' => 'Labrador',
                'birth_date' => '2020-05-15',
                'weight' => 30.50,
                'sex' => 'Mâle',
                'medical_info' => 'Vaccins à jour, allergies au pollen.',
                'qr_code' => 'QR1234567890',
                'user_id' => 1,  
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_dog' => 'Bella',
                'breed' => 'Berger Allemand',
                'birth_date' => '2018-08-22',
                'weight' => 28.00,
                'sex' => 'Femelle',
                'medical_info' => 'Traitement contre les puces, bonne santé.',
                'qr_code' => 'QR0987654321',
                'user_id' => 2,  
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_dog' => 'Charlie',
                'breed' => 'Beagle',
                'birth_date' => '2019-11-30',
                'weight' => 12.75,
                'sex' => 'Mâle',
                'medical_info' => 'En surpoids, surveiller l’alimentation.',
                'qr_code' => 'QR1122334455',
                'user_id' => 3,  
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}