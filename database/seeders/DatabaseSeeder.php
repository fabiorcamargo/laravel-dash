<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call([
            StatesTableSeeder::class,
            CitiesTableSeeder::class,
            EcoSellersSeeder::class,
            UsersSeeder::class,
            AvatarsSeeder::class,
            EcoProductsCategorySeeder::class,
            EcoSellersSeeder::class,
            RoleSeeder::class,

        ]);
    }
}
