<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notification::create(['name' => '1er aviso','days' => 7]);
        Notification::create(['name' => '2do aviso','days' => 3]);
        Notification::create(['name' => '3er aviso','days' => 1]);
    }
}
