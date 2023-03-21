<?php

namespace App\Http\Controllers;

use App\Models\FormCampain;
use App\Models\User;
use App\Models\Whatsapp_client;
use App\Models\Whatsapp_msg;
use App\Models\WhatsappApi;
use App\Models\WhatsappTemplate;
use App\Http\Controllers\Whatsapp\WhatsappManipulation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\InvalidOrderException;
use App\Http\Controllers\WhatsappManipulation as ControllersWhatsappManipulation;
use App\Models\FormLead;
use App\Models\Whatsapp_msg_type;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use stdClass;

class ApiWhatsapp extends Controller
{
    public function correct_type_msg()
    {
      $msgs = Whatsapp_msg::all();
      foreach($msgs as &$msg){
        $msg->type = (json_decode($msg->body)->type);
        $msg->save();
      }
      //$msgs->update();
      //dd($msgs);
      
    }
    public function msg_receive(Request $request){
        
        //Type: text, reaction, image, sticker, errors, location, contacts, button, interactive { list_reply }, interactive { button_reply }, system(For update profile)
        $data = json_encode($request->all());
        $data = json_decode($data);

        $body = new stdClass;
        $body->contact = isset($data->entry[0]->changes[0]->value->contacts) ? $data->entry[0]->changes[0]->value->contacts : "";
        $body->message = isset($data->entry[0]->changes[0]->value->messages) ? $data->entry[0]->changes[0]->value->messages : "";
        $body->statuses = isset($data->entry[0]->changes[0]->value->statuses) ? $data->entry[0]->changes[0]->value->statuses : "";

        $phone = $body->contact[0]->wa_id;
        $name = $body->contact[0]->profile->name;
        $msg_id = $body->message[0]->id;

        
        WhatsappApi::create([
            'body'=>json_encode($request->all())
        ]);
        
        $client = (new ControllersWhatsappManipulation)->client($phone, $name);

        //dd(json_encode($body->message[0], true));
        $status = $client->wp_msg()->create([
            'msg_id' => $msg_id,
            'body' => json_encode($body->message[0], true),
            'send' => 0,
            'type' => $body->message[0]->type
        ]);
        
        
        Storage::put('whatsapp_api.txt', json_encode($data));

        return  response("Msg: $status->id criada com sucesso!", 200);
        
    }

    public function chat_show(){
        $clients = Whatsapp_client::all()->reverse();
        $types = Whatsapp_msg_type::all();
        //dd($types);
        //dd($clients);
        $i=0;
        foreach($clients as &$client){
            $client->message = $client->wp_msg()->get()->reverse();
          
            foreach($client->message as $message){
                $data = json_decode($message->body);
                
                $message->id = $message->id;
                $message->from = $data->from;
                foreach($types as $type){
                  $message->type == "text" ? $message->body = $data->text->body : "";
                  $message->type == "reaction" ? $message->body = $data->reaction->emoji : "";
                  $message->type == "image" ? $message->body = $data->image->sha256 : "";
                  $message->type == "sticker" ? $message->body = $data->sticker->sha256 : "";
                  $message->type == "unknown" ? $message->body = $data->errors->details : "";
                  $message->type == "button" ? $message->body = "Button: " . $data->button->text : "";
                  $message->type == "list_reply" ? $message->body = $data->interactive->list_reply->title : "";
                  $message->type == "button_reply" ? $message->body = $data->interactive->button_reply->title : "";
                  $message->type == "order" ? $message->body = json_encode($data->order) : "";
                  $message->type == "system" ? $message->body = $data->system->body : "";
                  //dd($message);
                }
                if(isset($data->text)){
                $message->body = $data->text->body;
                }
            }
            }

            //dd($clients);

        //dd($chats[0]->body->entry[0]->changes[0]->value->contacts[0]->profile->name);
        //dd(($chats[0]->body->entry[0]->changes[0]->value->contacts[0]->profile->name));
        return view('pages.app.chat.show', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('clients'));
    }

    public function wp_msg_send() {

    }

    public function wp_msg_form_send($id) {
        $form = FormCampain::find($id);
        $templates = WhatsappTemplate::all();
        $model = new User;
        $fillable = ($model->getFillable());
        return view('pages.app.campaign.msg_form', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('form', 'templates', 'fillable'));

    }

    public function wp_msg_template_create(){
        return view('pages.app.campaign.msg_template_create', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb']);
    }

    public function wp_msg_template_post(Request $request){
        $data = (object)($request->all());
        //dd($data);
        $template = WhatsappTemplate::create([
            'name' => $data->name,
            'msg' => $data->msg,
            'img' => (float)$data->img,
            'button' => (float)$data->button,
            'variables' => (float)$data->variables
        ]);

        if($template->id != null)
        $status = [
            'status'=>'success', 
            'msg'=>"Template criado com sucesso"
        ];
        //dd($template);
       
        return redirect()
        ->back()
        ->withInput()
        ->with($status['status'], $status['msg']);
}
        public function wp_templates ($id){
         $variable = WhatsappTemplate::find($id)->variable;
         return $variable;
        }

        public function bulk_send(Request $request, $id){
            $data = (object)$request->all();
            //dd($data);
            $campaign = FormCampain::find($id);
            $template = WhatsappTemplate::find($data->templates);
            $leads = FormLead::all();
            
            $model = new User;
            $fillables = ($model->getFillable());
            //dd($fillables[0]);
            //dd($template->variables);
            
            //ApiWhatsapp::template_msg_send($template, $data);
            
           //dd($leads);
            foreach($leads as $lead){
               $user = ($lead->user()->first());
               $var[0] = $template->name;
               $var[1] = "55" . $user->cellphone;
               $var[2] = $user->name;
               $var[3] = $user->username;
               $var[4] = $campaign->city;
               //dd($var);
               ApiWhatsapp::template_msg_send($var);
            }



        }

        public function template_msg_send($var){
            
            $payload = '{
                "messaging_product": "whatsapp",
                "recipient_type": "individual",
                "to": "' . $var[1] . '",
                "type": "template",
                "template": {
                  "name": "' . $var[0] . '",
                  "language": {
                    "code": "pt_BR"
                  },
                  "components": [
                    {
                      "type": "header",
                      "parameters": [
                        {
                          "type": "image",
                          "image": {
                            "link": "https://alunos.profissionalizaead.com.br/product/Bg/Curso%20Gratuito.png"
                          }
                        }
                      ]
                    },
                    {
                      "type": "body",
                      "parameters": [
                        {
                          "type": "text",
                          "text": "' . $var[2] . '"
                        },
                        {
                          "type": "text",
                          "text": "' . $var[3] . '"
                        },
                        {
                          "type": "text",
                          "text": "' . $var[4] . '"
                        }
                      ]
                    }
                  ]
                }
              }';

              //dd(json_decode($payload, true));

            //dd($data);
            //$response = ApiWhatsapp::msg_send($payload);


            $url = "https://graph.facebook.com/v15.0/112150361820278/messages";
            $response = json_decode(Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer EAAgBfS7NZCFgBAFHX9Q9DsUfZAHzN59ZBBHOzo7Y5x7k0QKZAjZCduM2iJfHeV4Dlz8biRwkBovaORZAWLbUJ8ZB4z2EA2397kNa6qWmyQIKaIXKh0cDQNn0WqCgnYzWswZCexHm51onjBrfEt5HAIZB5cDWnqAMCxYCo1uwsJugGIcXILbf03MUShh3kV1ZAnaTD9Dey63qZBFpgZDZD'
            ])->post("$url", json_decode($payload, true)));
    
            //dd($response);
            $phone = $response->contacts[0]->wa_id;
            $msg_id = $response->messages[0]->id;

            //dd($msg_id);

            $phone_t[0] = $phone;
            $phone_t[1] = (str_replace("55","", $phone));
            $phone_t[2] = (substr($phone_t[1], 0, 2) . 9 . substr($phone_t[1], 2, 10));
            $phone_t[3] = (substr($phone_t[1], 0, 2) . substr($phone_t[1], 3, 10));

            $i = 0;
            foreach($phone_t as $ph){
                //dd($ph);
                if(User::where('cellphone', 'like', "%$ph%")->first()){

                    $user = (User::where('cellphone', 'like', "%$ph%")->first());

                    //dd($user);

                    if(Whatsapp_client::where('user_id', $user->id)->first()){
                        $client = Whatsapp_client::where('phone', $phone)->first();
                    }else{
                    $client = Whatsapp_client::create([
                        'user_id' => $user->id,
                        'name' => $var[2],
                        'phone' => $phone,
                        'body' => json_encode($response)
                    ]);
                }
            }
            
            //dd($client);


            
        }
            //dd($client);
    
            $client->wp_msg()->create([
                'msg_id' => $msg_id,
                'body' => json_encode($response),
            ]);
            echo("Eviado " . $msg_id . "<br>");
            sleep(2);
            //dd($client);

            //return json_encode($response,true);

            //return $response;

        }

        public function msg_send($payload){


/*
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer EAAgBfS7NZCFgBAFHX9Q9DsUfZAHzN59ZBBHOzo7Y5x7k0QKZAjZCduM2iJfHeV4Dlz8biRwkBovaORZAWLbUJ8ZB4z2EA2397kNa6qWmyQIKaIXKh0cDQNn0WqCgnYzWswZCexHm51onjBrfEt5HAIZB5cDWnqAMCxYCo1uwsJugGIcXILbf03MUShh3kV1ZAnaTD9Dey63qZBFpgZDZD'
            ])->post('https://graph.facebook.com/v15.0/112150361820278/messages/', $payload);
            $data = json_decode($response->body());
            dd($data->id);*/
        }
}

