<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Role::insert([
            [
            'id' => 1,
            'name' => 'Aluno',
            ],
            [
                'id' => 2,
                'name' => 'Secretaria',
            ],
            [
                'id' => 3,
                'name' => 'Financeiro',
            ],
            [
                'id' => 4,
                'name' => 'E-commerce',
            ],
            [
                'id' => 5,
                'name' => 'Vendedor',
            ],
            [
                'id' => 6,
                'name' => 'Admin',
            ],
            [
                'id' => 7,
                'name' => 'Super Admin',
            ],
        ]);

    }
}
