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
        //$msg->send = 0;
        $msg->save();
      }
      //$msgs->update();
      //dd($msgs);
      
    }
    public function msg_receive(Request $request){
        
        //dd(Whatsapp_msg::find(31));
        //Type: text, reaction, image, sticker, errors, location, contacts, button, interactive { list_reply }, interactive { button_reply }, system(For update profile)
        $data = json_encode($request->all());
        $data = json_decode($data);

        //dd($data->entry[0]->changes[0]->value->messages[0]->context);
        $body = new stdClass;
        $body->contact = isset($data->entry[0]->changes[0]->value->contacts) ? $data->entry[0]->changes[0]->value->contacts : "";
        $body->message = isset($data->entry[0]->changes[0]->value->messages) ? $data->entry[0]->changes[0]->value->messages : "";
        $body->statuses = isset($data->entry[0]->changes[0]->value->statuses) ? $data->entry[0]->changes[0]->value->statuses : "";
        $body->context = isset($data->entry[0]->changes[0]->value->messages[0]->context) ? $data->entry[0]->changes[0]->value->messages[0]->context : "";
        

        //dd($body->context->id);


        $phone = $body->contact[0]->wa_id;
        $name = $body->contact[0]->profile->name;
        $msg_id = $body->message[0]->id;

        
        WhatsappApi::create([
            'body'=>json_encode($request->all())
        ]);
        
        $client = (new ControllersWhatsappManipulation)->client($phone, $name);

        if($body->context->id !== ""){
          $status = $client->wp_msg()->create([
            'msg_id' => $msg_id,
            'body' => json_encode($body->message[0], true),
            'send' => 3,
            'type' => $body->message[0]->type
        ]);

        $text = "😄 Muito obrigado pela confirmação, em breve você receberá o endereço e horários disponíveis para retirada do seu código de acesso.";
        sleep(5);
        $status = ApiWhatsapp::msg_send($phone, $name, $text);
        return  response("Msg: $status criada com sucesso!", 200);

        }else{
          $status = $client->wp_msg()->create([
            'msg_id' => $msg_id,
            'body' => json_encode($body->message[0], true),
            'send' => 0,
            'type' => $body->message[0]->type
        ]);
        }
        
        
        
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
                  $message->type == "image" ? $message->body = $key    = hash('sha256', $data->image->sha256) : "";
                  $message->type == "sticker" ? $message->body = $data->sticker->sha256 : "";
                  $message->type == "unknown" ? $message->body = $data->errors->details : "";
                  $message->type == "button" ? $message->body = "Button: " . $data->button->text : "";
                  $message->type == "list_reply" ? $message->body = $data->interactive->list_reply->title : "";
                  $message->type == "button_reply" ? $message->body = $data->interactive->button_reply->title : "";
                  $message->type == "order" ? $message->body = json_encode($data->order) : "";
                  $message->type == "system" ? $message->body = $data->system->body : "";
                }
                if(isset($data->text)){
                $message->body = $data->text->body;
                }
            }
            }
        return view('pages.app.chat.show', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('clients'));
    }

    public function wp_msg_send_button() {

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
               //$template_name = $template->name;
               $phone = "55" . $user->cellphone;
               $name = $user->name;
               $username = $user->username;
               $city = $campaign->city;
               //dd($var);
               $response = ApiWhatsapp::template_msg_send($template, $username, $name, $phone, $city);
               print_r("Enviado " . $response . "<br>");
               sleep(3);
            }



        }

        public function template_msg_send($template, $username, $name, $phone, $city){
            
            $payload = '{
                "messaging_product": "whatsapp",
                "recipient_type": "individual",
                "to": "' . $phone . '",
                "type": "template",
                "template": {
                  "name": "' . $template->name . '",
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
                          "text": "' . $name . '"
                        },
                        {
                          "type": "text",
                          "text": "' . $username . '"
                        },
                        {
                          "type": "text",
                          "text": "' . $city . '"
                        }
                      ]
                    }
                  ]
                }
              }';

              //dd($payload);
              //dd(json_decode($payload, true));

            //dd($data);
            //$response = ApiWhatsapp::msg_send($payload);

            $url = "https://graph.facebook.com/v15.0/" . env('WHATSAPP_PHONE_NUMBER_ID') . "/messages";
            $response = json_decode(Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => env('WHATSAPP_API_TOKEN')
            ])->post("$url", json_decode($payload, true)));
    
            //dd($response);
            $phone = $response->contacts[0]->wa_id;
            $msg_id = $response->messages[0]->id;
            //$name = $name;

            $client = (new ControllersWhatsappManipulation)->client($phone, $name);  
            if($template->button == 1){
            $client->wp_msg()->create([
                'msg_id' => $msg_id,
                'body' => json_encode($response),
                'send' => 1,
                'type' => "button",
            ]);
            }

            return ($msg_id);
            sleep(2);


        }

        public function msg_send($phone, $name, $text){

            $payload = '{
              "messaging_product": "whatsapp",    
              "recipient_type": "individual",
              "to": "'. $phone . '",
              "type": "text",
              "text": {
                  "preview_url": false,
                  "body": "'. $text . '"
              }
              }';

            $url = "https://graph.facebook.com/v15.0/" . env('WHATSAPP_PHONE_NUMBER_ID') . "/messages";
            $response = json_decode(Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => env('WHATSAPP_API_TOKEN')
            ])->post("$url", json_decode($payload, true)));
            //$data = json_decode($response->body());
            //dd($data->id);
            $phone = $response->contacts[0]->wa_id;
            $msg_id = $response->messages[0]->id;

            $client = (new ControllersWhatsappManipulation)->client($phone, $name);  
            
            $client->wp_msg()->create([
                'msg_id' => $msg_id,
                'body' => json_encode($response),
                'send' => 1,
                'type' => "text",
            ]);
            

            return ("Eviado " . $msg_id . "<br>");

        }
}

