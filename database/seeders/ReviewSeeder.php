<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('reviews')->insert([
            [
                'rating' => 5,
                'comment' => 'Excellent service, highly recommend!',
                'date_review' => '2023-08-01',
                'professional_id' => 1,  
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rating' => 4,
                'comment' => 'Good experience, will come again.',
                'date_review' => '2023-08-05',
                'professional_id' => 2,  
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}