<?php

namespace Database\Seeders;

use App\Models\Cademi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CademisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cademi::insert(
            [
            'user_id' => '2',
            'user' => '5063742',
            'nome' => 'Fabio Aluno',
            'email' => 'fabio.xina@gmail.com',
            'celular' => null,
            'login_auto' => 'https://profissionaliza.cademi.com.br/auth/login?crstk=MS06MzQ1MToyNDczNjA1OmJ2ZW5oZmg6OnNwcTA5czg3Nzg2Mm83MjgxOTUwMHNuczZyMW85OXA5',
            'gratis' => false,
            'visible' => 1,
            ]);
    }
}
