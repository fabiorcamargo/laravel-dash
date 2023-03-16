<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Whatsapp_client;
use App\Models\Whatsapp_msg;
use App\Models\WhatsappApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiWhatsapp extends Controller
{
    public function msg_receive(Request $request){
        
        $data = $request->input('entry');
        $body_contact = $request->input('entry.0.changes.0.value.contacts');
        $phone = $request->input('entry.0.changes.0.value.contacts.0.wa_id');
        $name = $request->input('entry.0.changes.0.value.contacts.0.profile.name');
        $body_msg = $request->input('entry.0.changes.0.value.messages.0');
        $msg_id = $request->input('entry.0.changes.0.value.messages.0.id');
		//dd($body_msg);
        //$data = (json_decode($request->getContent()));
        //dd($data->hub_challenge);
        //$phone2 = (str_replace("55","", $phone));
        //$phone2 = (substr($phone2, 0, 2) . 9 . substr($phone2, 2, 10));
        //dd(User::where('cellphone', 'like', "%$phone2%")->first());

        WhatsappApi::create([
            'body'=>json_encode($request->all())
        ]);

        if(Whatsapp_client::where('phone', $phone)->first()){
            $client = Whatsapp_client::where('phone', $phone)->first();
        }else{
        $client = Whatsapp_client::create([
            'name' => $name,
            'phone' => $phone,
            'body' => json_encode($body_contact)
        ]);
    }
        //dd($client);

        $client->wp_msg()->create([
            'msg_id' => $msg_id,
            'body' => json_encode($body_msg),
        ]);
        
        
        Storage::put('whatsapp_api.txt', json_encode($data));
        
    }

    public function chat_show(){
        $clients = Whatsapp_client::all()->reverse();
        //dd($clients);
        
        foreach($clients as &$client){
            $client->message = $client->wp_msg()->get()->reverse();
            foreach($client->message as $message){
                $data = json_decode($message->body);
                $message->id = $data->id;
                $message->from = $data->from;
                if(isset($data->text)){
                $message->body = $data->text->body;
                }
                //$message->date = $data->timestamp;
                //dd(json_decode($message->body));
            }
            }

            //dd($clients);

        //dd($chats[0]->body->entry[0]->changes[0]->value->contacts[0]->profile->name);
        //dd(($chats[0]->body->entry[0]->changes[0]->value->contacts[0]->profile->name));
        return view('pages.app.chat.show', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('clients'));
    }
}

