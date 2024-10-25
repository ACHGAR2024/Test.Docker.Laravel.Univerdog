<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('products_category')->insert([
            [
                'name_product_cat' => 'Aliments pour chiens',  
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_product_cat' => 'Jouets',  
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_product_cat' => 'Accessoires',  
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}