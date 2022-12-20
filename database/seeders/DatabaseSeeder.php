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
            UsersSeeder::class,
            StatesTableSeeder::class,
            CitiesTableSeeder::class,
            TypePaymentsSeeder::class,
            CademisSeeder::class
        ]);
    }
}
