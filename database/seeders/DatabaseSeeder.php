<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            "name" => "Admin",
            "email" => "admin@example.com",
            "phone" => "629000000",
            "password" => Hash::make("123456"),
        ]);

        User::factory(10)->create();

        $this->call(
            [
                BrandSeeder::class,
                VehicleTypeSeeder::class,
                AdSeeder::class,
            ]
        );
    }
}
