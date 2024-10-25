<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name_product' => 'Croquettes pour chiens',
                'description_product' => 'Croquettes de haute qualité adaptées aux besoins nutritionnels des chiens.',
                'price' => 19.99,
                'affiliation_link' => 'https://www.ultrapremiumdirect.com/produits/croquettes-sans-cereales-pour-chien-sensible-toutes-tailles/',
                'products_category_id' => 1,  
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_product' => 'Jouet en corde',
                'description_product' => 'Jouet résistant en corde pour divertir et nettoyer les dents des chiens.',
                'price' => 8.50,
                'affiliation_link' => 'https://www.temu.com/ul/kuiper/un9.html',
                'products_category_id' => 2,  
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_product' => 'Collier en cuir',
                'description_product' => 'Collier en cuir durable et confortable pour chiens.',
                'price' => 15.75,
                'affiliation_link' => 'https://www.temu.com/fr/',
                'products_category_id' => 3,  
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}