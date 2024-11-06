<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([ 
            'name' => 'selfservicead',
            'email' => 'selfservicead@aviva.pe',
            'email_verified_at' => now(),
            'password' => Hash::make("Atudexi2$"),
            'remember_token' => Str::random(50),
        ]);

        DB::table('personal_access_tokens')->insert([
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => 1,
            'name' => 'selfservicead',
            'token' => '7a64f742184dca3430c65af7799b879a39c31c9a5ee8cd30aa0e0f81450b8729',
            'abilities' => '["read","create","update"]',
        ]);
        $this->call([
            NotificationSeeder::class,
            ScheduleSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
