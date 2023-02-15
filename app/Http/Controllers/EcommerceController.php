<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Asaas\AsaasController;
use App\Mail\SendMailUser;
use App\Models\Customer;
use App\Models\EcoProduct;
use App\Models\EcoProductCategory;
use App\Models\RdCrmFlow;
use App\Models\Sales;
use App\Models\User;
use Canducci\Cep\Cep;
use Canducci\Cep\CepModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class EcommerceController extends Controller



{
    public function product_category($id)
    {
        $category = EcoProductCategory::where("state_id",$id)
                    ->pluck('name','id');
                   //dd($cities);
        return json_encode($category);
    }
    public function add_show(){
        $categorys = EcoProductCategory::all();
        $flows = RdCrmFlow::all();
        //dd($category);
        return view('pages.app.eco.add', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('categorys', 'flows'));
    }

    public function add(Request $request){
        
        if(json_decode($request->comment) == ""){
            $produtos = (json_decode($request->image));
        foreach($produtos as $produto){
            Storage::delete('product/' . $produto);
        }
            return back()->with('success', 'Formato dos comentários inválido');
        }
        
        if (EcoProduct::where('name', $request->name)->first()) {
            $produtos = (json_decode($request->image));
        foreach($produtos as $produto){
            Storage::delete('product/' . $produto);
        }
            return back()->with('success', 'Nome do Curso já existe');
        }

        $comments = collect(json_decode($request->comment));
 
        foreach($comments as &$comment){
                $data = Http::get("https://xsgames.co/randomusers/avatar.php?g=$comment->gender");
                $uri = (json_encode($data->transferStats->getEffectiveUri()));
                $img = (json_decode($uri));
            if ($comments->firstWhere('img', $img)){
                $data = Http::get("https://xsgames.co/randomusers/avatar.php?g=$comment->gender");
                $uri = (json_encode($data->transferStats->getEffectiveUri()));
                $img = (json_decode($uri));
                $comment->img = $img;
            } else {
                $comment->img = $img;
            }
            
            $contents = file_get_contents($comment->img);
            Storage::makeDirectory('directory', 0775);
            Storage::put("product/$request->name/avatar/$comment->name.jpg", $contents, ['visibility' => 'public', 'directory_visibility' => 'public']);
            $comment->img = "product/$request->name/avatar/$comment->name.jpg";
        }

        $comments = json_encode($comments);
        $product = $request->all();
        $product['image'] = json_encode(array_reverse(Storage::disk('product')->Files($product['name'])));
        $product['price'] = (float)str_replace(",", ".", $product['price']);
        $product['public'] = ($request->public ? "1" : "0");
        $product['percent'] = (float)$request->percent/100;

        $eco = new EcoProduct;
        $eco->course_id = $product['course_id'];
        $eco->name = $product['name'];
        $eco->description = $product['description'];
        $eco->specification = $product['specification'];
        $eco->tag = $product['tag'];
        $eco->category = $product['category'];
        $eco->image = $product['image'];
        $eco->public = $product['public'];
        $eco->price = $product['price'];
        $eco->percent = $product['percent'];
        $eco->specification = $product['specification'];
        $eco->comment = $comments;
        $eco->flow = $product['flow'];
        $eco->save();

        //dd($eco);

        return redirect(getRouterValue() . "/app/eco/product/$eco->id");

        
        
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

        $product->oprice = number_format(($product->price / (1-$product->percent)),0);
        $product->image = json_decode($product->image);
        $product->comments = json_decode($product->comment);
        //dd($product);

        

        return view('pages.app.eco.detail', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('product'));
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
    
            return view('pages.app.eco.checkout_pay', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'prefixRouters' => 'modern-light-menu'], compact('product', 'user'));

        } else {
            $product = (EcoProduct::find($id));
            return view('pages.app.eco.checkout', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'prefixRouters' => 'modern-light-menu'], compact('product'));
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
        

        $rd = new RdController;
        $teste = $rd->rd_client_register($user->id, $password, $product);

        //Mail::to($user->email)->send(new SendMailUser($user));

        return redirect(getRouterValue() . "/app/eco/checkout/$product->id/pay/$user->id");
        //return view('pages.eco.checkout_pay', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'prefixRouters' => 'modern-light-menu'], compact('product', 'user'));

    }

    public function checkout_client_pay($product_id, $client){

        //dd('sim');

        $product = (EcoProduct::find($product_id));
        $user = User::find($client);

        //dd($client);

        $success = "Seu usuário foi criado, as informações de acesso serão enviadas no seu email.";

        return view('pages.app.eco.checkout_pay', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'prefixRouters' => 'modern-light-menu', 'success' => $success], compact('product', 'user'));


    }

    public function checkout_pay_end_post($product_id, $client, Request $request){
    
        $type = (object)$request->all();
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

    public function show(){
        
        $products = EcoProduct::all();
        //dd($products[0]->image);
        //dd(explode(",", $products[0]->image))
        return view('pages.app.eco.list', ['title' => 'Shop | Profissionaliza EAD', 'breadcrumb' => 'Lista Produtos'], compact('products'));
    }
    public function shop(){
        $products = EcoProduct::all();
        foreach ($products as $product){
            //dd(array_reverse(json_decode($product->image)));
            //dd($product);
            $product->thumb = array_reverse(json_decode($product->image))[0];
            //dd(($product->thumb));
            
        }
        //dd($products[0]->image);
        //dd(explode(",", $products[0]->image));
        return view('pages.app.eco.shop', ['title' => 'Shop | Profissionaliza EAD', 'breadcrumb' => 'Lista Produtos'], compact('products'));
    }
    public function edit($id){
        $product = EcoProduct::find($id);
        //dd($products[0]->image);
        //dd(explode(",", $products[0]->image));
        return view('pages.app.eco.edit', ['title' => 'Shop | Profissionaliza EAD', 'breadcrumb' => 'Lista Produtos'], compact('product'));
    }
    public function edit_save($id, Request $request){
        //dd("chegou");
        $product = EcoProduct::find($id);
        //dd($request->all());
        $request->percent = $request->percent /100;
        $request->price = (int)($request->price);
        
        //dd ($request->percent);
        $request->public = ($request->public ? (int)"1" : (int)"0");
        //dd($product);

        $product->name !== $request->name ? $product->name = $request->name : "";
        $request->description !== null ? $product->description = $request->description : "";
        $product->tag !== $request->tag ? $product->tag = $request->tag : "";
        $product->category !== $request->category ? $product->category = $request->category : "";
        $request->specification !== null ? $product->specification = $request->specification : "";
        $product->price !== $request->price ? $product->price = $request->price : "";
        $product->percent !== $request->percent ? $product->percent = $request->percent : "";
        $product->public !== $request->public ? $product->public = $request->public : "";
        $product->course_id !== $request->course_id ? $product->course_id = $request->course_id : "";

        $product->save();

        

        
        //dd($products[0]->image);
        //dd(explode(",", $products[0]->image));
        $sucess = "Atualizado";
        return redirect(getRouterValue() . "/app/eco/product/$product->id")->with('sucess', 'Verdade');
    }
}
