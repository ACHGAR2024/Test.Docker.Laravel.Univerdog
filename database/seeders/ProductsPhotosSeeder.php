<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsPhotosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('products_photos')->insert([
            [
                'product_id' => 1,  
                'photo_name_product' => 'produit1_photo1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,  
                'photo_name_product' => 'produit1_photo2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,  
                'photo_name_product' => 'produit2_photo1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}