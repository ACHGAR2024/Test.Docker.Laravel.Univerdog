<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('professionals')->insert([
            [
                'company_name' => 'Pet Care Inc.',
                'description_pro' => 'Services de soins pour animaux de compagnie professionnels, y compris la toilette et l\'hébergement.',
                'rates' => '50-100',
                'user_id' => 1, 
                'place_id' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'Vet Services Ltd.',
                'description_pro' => 'Services véterinaire spécialiste dans les petits animaux.',
                'rates' => '100-200',
                'user_id' => 2,
                'place_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}