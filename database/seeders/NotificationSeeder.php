<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('notifications')->insert([
            'message' => 'Notification de test',
            'date_notification' => now(),
            'read' => false,
            'user_id' => 1,
        ]);
    }
}