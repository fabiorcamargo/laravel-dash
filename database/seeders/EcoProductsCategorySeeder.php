<?php

namespace Database\Seeders;

use App\Models\EcoProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EcoProductsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EcoProductCategory::insert([
            [
                'id' => 1,
                'name' => 'Administrativo',
            ],
            [
                'id' => 2,
                'name' => 'Informática',
            ],
            [
                'id' => 3,
                'name' => 'Profissionalizante',
            ],
            [
                'id' => 4,
                'name' => 'Inglês',
            ],
            [
                'id' => 5,
                'name' => 'Kids',
            ],
            [
                'id' => 6,
                'name' => 'Programação',
            ],
            [
                'id' => 7,
                'name' => 'Especialidades',
            ],
        ]);
    }
}
