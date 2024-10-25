<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CombinedSeeder::class);
        $this->call(ProfessionalSeeder::class);
        $this->call(DogSeeder::class);
        $this->call(DogsPhotosSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(ProductsCategorySeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(AvailabilitySeeder::class);
        $this->call(ProductsPhotosSeeder::class);
        $this->call(SpecialtySeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(AppointmentSeeder::class);
  
    }
}