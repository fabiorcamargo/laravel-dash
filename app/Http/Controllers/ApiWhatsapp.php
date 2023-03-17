<?php

namespace App\Http\Controllers;

use App\Models\FormCampain;
use App\Models\User;
use App\Models\Whatsapp_client;
use App\Models\Whatsapp_msg;
use App\Models\WhatsappApi;
use App\Models\WhatsappTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\InvalidOrderException;
use App\Models\FormLead;

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
            dd($data);
            $campaign = FormCampain::find($id);
            $template = WhatsappTemplate::find($data->templates);
            $leads = FormLead::all();
            
            $model = new User;
            $fillables = ($model->getFillable());
            //dd($fillables[0]);
            //dd($template->variables);
            
            //ApiWhatsapp::template_msg_send($template, $data);
            
            dd($leads[20]->user->get($data->version_compare));
            foreach($leads as $lead){
                for ($i=1; $i < $template->variables; $i++) {
                    $n = "variavel$i";
                    foreach($fillables as $fillable){
                        
                        if($fillable == $data->$n){
                           
                            dd($data->$n);
                           
                        }
                        
                        
                        //dd($lead->user->get([$data->$n]));
                }
                }
            }
   
            //dd($dados_lead);
            dd($template);


        }

        public function template_msg_send($template, $data){

            
            //dd($data->variavel1);
            for ($i=1; $i < $template->variables; $i++) { 
                $var[$i] = ["type" => $data->variavel1];
            }

            dd($var);

            $data = '{
                "messaging_product": "whatsapp",
                "recipient_type": "individual",
                "to": "5544988605751",
                "type": "template",
                "template": {
                    "name": "' . $template->name .'",
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
                                    "text": "Lilly"
                                },
                                {
                                    "type": "text",
                                    "text": "GRA4561"
                                },
                                {
                                    "type": "text",
                                    "text": "Telêmaco Borba - PR"
                                }
                                
                            ]
                        }
                    ]
                }
            }';
        

        }
}

