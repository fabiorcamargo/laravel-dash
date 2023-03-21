<?php

namespace Database\Seeders;

use App\Models\Whatsapp_msg_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WhatsappMsgType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Whatsapp_msg_type::insert([
            ['name'=>'text'],
            ['name'=>'reaction'],
            ['name'=>'image'],
            ['name'=>'sticker'],
            ['name'=>'unknown'],
            ['name'=>'button'],
            ['name'=>'list_reply'],
            ['name'=>'button_reply'],
            ['name'=>'order'],
            ['name'=>'system']
        ]);
    }
}
