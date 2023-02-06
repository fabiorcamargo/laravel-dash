<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Asaas\AsaasController;
use App\Mail\SendMailUser;
use App\Models\Customer;
use App\Models\EcoProduct;
use App\Models\Sales;
use App\Models\User;
use Canducci\Cep\Cep;
use Canducci\Cep\CepModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EcommerceController extends Controller

{
    public function add(Request $request){
        if (EcoProduct::where('course_id', $request->course_id)->first()){
            return back()->with('success', 'Id do curso já existe');
        } else if (EcoProduct::where('name', $request->name)->first()) {
            return back()->with('success', 'Nome do Curso já existe');
        }
       
        //dd($course);
    //dd($request->all());
        $product = $request->all();
        $product['image'] = json_encode(Storage::disk('product')->allFiles($product['name']));
        
        $product['price'] = (float)str_replace(",", ".", $product['price']);
        $product['public'] = ($request->public ? "1" : "0");
        $product['percent'] = (float)$request->percent/100;

        $eco = EcoProduct::create([
            "course_id" => $product['course_id'],
            "name" => $product['name'],
            "description" => $product['description'],
            "specification" => $product['specification'],
            "tag" => $product['tag'],
            "category" => $product['category'],
            "image" => $product['image'],
            "public" => $product['public'],
            "price" => $product['price'],
            "percent" => $product['percent'],
            "specification" => $product['specification'],
        ]);

        return redirect(getRouterValue() . "/eco/product/$eco->id");

        
        
    }

    public function product_show($id){
        $product = (EcoProduct::find($id));
        if($product->perc > 15 || $product->percent < 30){
            $product->perc = "<span class='badge badge-light-success mb-3'>" . $product->percent*100 . "% off</span>";
        }else if($product->perc > 30 || $product->percent < 60){
            $product->percent = "<span class='badge badge-light-warning mb-3'>" . $product->percent*100 . "% off</span>";
        }else if($product->perc > 60 || $product->percent < 80){
            $product->perc = "<span class='badge badge-light-danger mb-3'>" . $product->percent*100 . "% off</span>";
        }

        $product->oprice = ($product->price / (1-$product->percent));
        $product->image = json_decode($product->image);
        //dd($product);

        

        return view('pages.eco.detail', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('product'));
    }

    public function checkout_show($id){
        
        if(isset(Auth::user()->id)){
            $user = Auth::user();
            $product = (EcoProduct::find($id));
            if($product->perc > 15 || $product->percent < 30){
                $product->perc = "<span class='badge badge-light-success mb-3'>" . $product->percent*100 . "% off</span>";
            }else if($product->perc > 30 || $product->percent < 60){
                $product->percent = "<span class='badge badge-light-warning mb-3'>" . $product->percent*100 . "% off</span>";
            }else if($product->perc > 60 || $product->percent < 80){
                $product->perc = "<span class='badge badge-light-danger mb-3'>" . $product->percent*100 . "% off</span>";
            }
    
            $product->oprice = ($product->price / (1-$product->percent));
    
            return view('pages.eco.checkout_pay', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'prefixRouters' => 'modern-light-menu'], compact('product', 'user'));

        } else {
            $product = (EcoProduct::find($id));
            return view('pages.eco.checkout', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'prefixRouters' => 'modern-light-menu'], compact('product'));
        }
    }
    public function checkout_post($product_id, Request $request){

        
        
        $cepResponse = \Canducci\Cep\Facades\Cep::find('01010000');
        $data = $cepResponse->getCepModel();
        dd($data);
        
       
        $product = (EcoProduct::find($product_id));
        //dd($product);
        $type = $request->payment;
        //dd($type);
        if ((User::where('email', $request->email))->first()){
            return back()->with('erro', 'Email já existe, por favor faça login com este email para continuar');
        } 
        $faker = \Faker\Factory::create();
        $password = ($faker->randomNumber(5, false));
        //dd($request->all());
        $nome = explode(" ", $request->nome, 2);

        $user = new User;
        $user->username = $request->email;
        $user->name =$nome[0];
        $user->lastname =  (isset($nome[1])) ? $nome[1] : "";
        $user->email = $request->email;
        $user->email2 = $request->email;
        $user->cellphone = preg_replace('/[^0-9]/', '',$request->cellphone);
        $user->cellphone2 = preg_replace('/[^0-9]/', '',$request->cellphone);
        $user->document = preg_replace('/[^0-9]/', '', $request->cpfCnpj);
        $user->secretary = "TB";
        $user->seller = "Internet";
        $user->password = bcrypt($password);
        $user->role = "1";
        $user->active = "1";
        $user->courses = "$product->course_id";

        $user->payment = $request->payment;
        //dd($user);
        $user->save();

        //dd($user);
        $user->password = $password;
        //dd($user);
        $asaas = new AsaasController();
        $response = $asaas->create_client($user->id);
        //dd($response);
        $customer = new Customer();
        $customer->user_id = $user->id;
        $customer->gateway_id = $response->id;
        $customer->body = json_encode($response);
        $customer->save();

        $sales = new Sales();
        $sales->user_id = $user->id;
        $sales->customer = $customer->gateway_id;
        $sales->seller = $user->seller;
        $sales->save();


        $cobranca = $asaas->create_payment($user->id, $product_id, $sales->id, $type);



        dd($cobranca);

        Mail::to("fabiorcamargo@gmail.com")->send(new SendMailUser($user));

        //dd($asaas);

        //dd('ete');

        //dd($request->all());

        return back()->with('success', 'Usuário criado com sucesso, seus dados de acesso foram enviados no seu email');

    }
    public function checkout_client_post($product_id, Request $request){

        $product = (EcoProduct::find($product_id));
        if ((User::where('email', $request->email))->first()){
            return back()->with('erro', 'Email já existe, por favor faça login com este email para continuar');
        } 

        $faker = \Faker\Factory::create();
        $password = ($faker->randomNumber(5, false));

        $nome = explode(" ", $request->nome, 2);

        $user = new User;
        $user->username = $request->email;
        $user->name =$nome[0];
        $user->lastname =  (isset($nome[1])) ? $nome[1] : "";
        $user->email = $request->email;
        $user->email2 = $request->email;
        $user->cellphone = preg_replace('/[^0-9]/', '',$request->cellphone);
        $user->cellphone2 = preg_replace('/[^0-9]/', '',$request->cellphone);
        $user->secretary = "TB";
        $user->seller = "Internet";
        $user->password = bcrypt($password);
        $user->role = "1";
        $user->active = "1";
        $user->courses = "$product->course_id";
        $user->document = 99999999999;
        $user->save();

        $user->password = $password;

        Mail::to($user->email)->send(new SendMailUser($user));

        return redirect(getRouterValue() . "/eco/checkout/$product->id/pay/$user->id");
        //return view('pages.eco.checkout_pay', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'prefixRouters' => 'modern-light-menu'], compact('product', 'user'));

    }

    public function checkout_client_pay($product_id, $client){

        //dd('sim');

        $product = (EcoProduct::find($product_id));
        $user = User::find($client);

        //dd($client);

        return view('pages.eco.checkout_pay', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'prefixRouters' => 'modern-light-menu'], compact('product', 'user'));


    }

    public function checkout_pay_end_post($product_id, $client, Request $request){
    
        $type = (object)$request->all();
        //dd($type);
        $expiry = explode("/", str_replace(array(' ', "\t", "\n"), '', $type->expiry));
        $type->expiryMonth = $expiry[0];
        $type->expiryYear = $expiry[1];

        $product = EcoProduct::find($product_id);
        $user = User::find($client);

        $user->city = $request->cidade;
        $user->city2 = $request->cidade;
        $user->uf = $request->uf;
        $user->uf2 = $request->uf;
        $user->payment = strtoupper($request->payment);
        $user->document = preg_replace('/[^0-9]/', '', $request->cpfCnpj);
        if(isset($user->courses)){
        $user->courses = $product->course_id;
        } else {
            $user->courses = $user->courses . ", $product->course_id";
        }
        $user->save();

        $asaas = new AsaasController();
        $response = $asaas->create_client($user->id);
        //dd($response);
        $customer = new Customer();
        $customer->user_id = $user->id;
        $customer->gateway_id = $response->id;
        $customer->body = json_encode($response);
        $customer->save();

        $sales = new Sales();
        $sales->user_id = $user->id;
        $sales->customer = $customer->gateway_id;
        $sales->seller = $user->seller;
        $sales->save();

        $cobranca = $asaas->create_payment($user->id, $product_id, $sales->id, $type);

        return $cobranca;

    }
}
