<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
            'username' => 'fabiotb',
            'name' => 'Fábio Camargo',
            'email' => 'fabiorcamargo@gmail.com',
            'password' => bcrypt('277888'),
            'cellphone' => '42991622889',
            'city' => 'Telêmaco Borba',
            'uf' => 'PR',
            'payment' => 'CARTÃO',
            'role' => 7,
            '10courses' => true,
            'secretary' => 'TB',
            'document' => '05348908908',
            'seller' => 'Fábio Divulgador',
            'courses' => '02 - BANCÁRIO + 10 CURSOS',
        ],[
            'username' => '61001',
            'name' => 'Fábio Aluno',
            'email' => 'fabio.xina@gmail.com',
            'password' => bcrypt('277888'),
            'cellphone' => '42991622889',
            'city' => 'Telêmaco Borba',
            'uf' => 'PR',
            'payment' => 'CARTÃO',
            'role' => 1,
            '10courses' => true,
            'secretary' => 'TB',
            'document' => '05348908908',
            'seller' => 'Fábio Divulgador',
            'courses' => '02 - BANCÁRIO + 10 CURSOS',
        ],
        ]
    
    );
    }
}
