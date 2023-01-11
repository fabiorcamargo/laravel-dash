<?php

namespace Database\Seeders;

use App\Models\Avatar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvatarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Avatar::insert([
            [
            'user_id' => 1,
            'folder' => 'avatar/fabiotb',
            'file' => 'Fábio.jpg',
        ],[
            'user_id' => 2,
            'folder' => 'avatar',
            'file' => 'default.jpeg',
        ],
        ]
    
    );
    }
}
