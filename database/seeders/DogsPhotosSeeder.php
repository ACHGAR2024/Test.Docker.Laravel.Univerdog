<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DogsPhotosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('dogs_photos')->insert([
            [
                'dog_id' => 1,  
                'photo_name_dog' => 'chien1_photo1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dog_id' => 1,  
                'photo_name_dog' => 'chien1_photo2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dog_id' => 2,  
                'photo_name_dog' => 'chien2_photo1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}