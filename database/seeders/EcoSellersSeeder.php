<?php

namespace Database\Seeders;

use App\Models\EcoSeller;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EcoSellersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EcoSeller::insert([
        [ 'name' => 'Danilo Martins',
        'secretary' => 'MGA',
        'type' => '2'],
        [ 'name' => 'FÁBIO',
        'secretary' => 'TB',
        'type' => '2'],
        [ 'name' => 'BRUNNO',
        'secretary' => 'TB',
        'type' => '2'],
        [ 'name' => 'GUILHERME',
        'secretary' => 'MGA',
        'type' => '2'],
        [ 'name' => 'HENRIQUE',
        'secretary' => 'MGA',
        'type' => '2'],
        [ 'name' => 'INATIVO',
        'secretary' => 'MGA',
        'type' => '2'],
        [ 'name' => 'KESIA',
        'secretary' => 'MGA',
        'type' => '2'],
        [ 'name' => 'LUCAS/PAMILA',
        'secretary' => 'MGA',
        'type' => '2'],
        [ 'name' => 'MAILSON',
        'secretary' => 'MGA',
        'type' => '2'],
        [ 'name' => 'MARCOS',
        'secretary' => 'MGA',
        'type' => '2'],
        [ 'name' => 'MAURO',
        'secretary' => 'TB',
        'type' => '2'],
        [ 'name' => 'NATÁLIA LIMA',
        'secretary' => 'MGA',
        'type' => '2'],
        [ 'name' => 'PAULO',
        'secretary' => 'MGA',
        'type' => '2'],
        [ 'name' => 'SANDRO',
        'secretary' => 'MGA',
        'type' => '2'],
        [ 'name' => 'TIAGO',
        'secretary' => 'MGA',
        'type' => '2'],
        [ 'name' => 'WILLIAN',
        'secretary' => 'MGA',
        'type' => '2']
        ]);
    }
}
