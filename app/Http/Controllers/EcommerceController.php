<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Asaas\AsaasController;
use App\Mail\SendMailUser;
use App\Models\CademiTag;
use App\Models\Customer;
use App\Models\EcoProduct;
use App\Models\EcoProductCategory;
use App\Models\EcoSales;
use App\Models\EcoSeller;
use App\Models\RdCrmFlow;
use App\Models\RdCrmOportunity;
use App\Models\Sales;
use App\Models\User;
use Canducci\Cep\Cep;
use Canducci\Cep\CepModel;
use CodePhix\Asaas\Asaas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;



class EcommerceController extends Controller



{
    public function product_category($id)
    {
        $category = EcoProductCategory::where("state_id",$id)
                    ->pluck('name','id');
                   //dd($cities);
        return json_encode($category);
    }

    public function edit($id){

        $product = EcoProduct::find($id);
        $products = EcoProduct::all();
        $categorys = EcoProductCategory::all();
        $sellers = EcoSeller::all();
        $flows = RdCrmFlow::all();
        $seller = EcoSeller::where("user_id", $product->seller)->first();
        $tags = CademiTag::all();
        $comments = json_decode($product->comment);
        //dd($comments->img);
        //dd($comments);
        //dd($products[0]->image);
        //dd(explode(",", $products[0]->image));
        return view('pages.app.eco.edit', ['title' => 'Shop | Profissionaliza EAD', 'breadcrumb' => 'Lista Produtos'], compact('products', 'product', 'categorys', 'sellers', 'flows', 'seller', 'tags', 'comments'));
    }

    public function add_show(){
        $categorys = EcoProductCategory::all();
        $products = EcoProduct::all();
        $sellers = EcoSeller::all();
        $flows = RdCrmFlow::all();
        $tags = CademiTag::all();
        //dd($category);
        return view('pages.app.eco.add', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('categorys', 'products', 'flows', 'sellers', 'tags'));
    }

    public function add(Request $request){
        
        //dd($request->all());
        //dd(Carbon::now()->timestamp);


        $time = Carbon::now()->timestamp;

        /*
        if(json_decode($request->comment) == ""){
            $produtos = (json_decode($request->image));
        foreach($produtos as $produto){
            Storage::delete('product/' . $produto);
        }
            return back()->with('success', 'Formato dos comentários inválido');
        }*/
        
        if (EcoProduct::where('name', $request->name)->first()) {
            $request->name = $request->name . $time;
            /*
            $produtos = (json_decode($request->image));
        foreach($produtos as $produto){
            Storage::delete('product/' . $produto);
        }
            return back()->with('success', 'Nome do Curso já existe');
            */
        }
/*
        $comments = collect(json_decode($request->comment));
        dd($comments);
        if($comments !== ""){
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
    }*/

        //$comments = json_encode($comments);
        $product = $request->all();
        //$product['image'] = json_encode(array_reverse(Storage::disk('product')->Files($product['course_name'])));
        $product['price'] = (float)str_replace(",", ".", $product['price']);
        $product['public'] = ($request->public ? "1" : "0");
        $product['percent'] = (float)$request->percent/100;

        $eco = new EcoProduct;
        $eco->course_id = $product['course_c'];
        $eco->course_b = $product['course_b'];
        $eco->course_c = $product['course_c'];
        $eco->name = $product['course_name'];
        $eco->description = $product['description'];
        $eco->specification = $product['specification'];
        $eco->tag = $product['tag'];
        $eco->category = $product['category'];
        //$eco->image = $product['image'];
        $eco->public = $product['public'];
        $eco->price = $product['price'];
        $eco->percent = $product['percent'];
        $eco->specification = $product['specification'];
        $eco->seller = $product['seller'];
        $eco->product_url = $time;
        $eco->product_base = $product['product_base'];
        //$eco->comment = $comments;
        $eco->flow = $product['flow'];
        $eco->save();

        //dd($eco);

        return redirect(getRouterValue() . "/app/eco/product/$eco->id/edit");

        
        
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
        //$response = $asaas->create_client($user->id);
        //dd($response);
        $customer = new Customer();
        $customer->user_id = $user->id;
        //$customer->gateway_id = $response->id;
        //$customer->body = json_encode($response);
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

        //dd($product->id);
        
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

        

        //Cria CRM no RD
        $rd = new RdController;
        $rd->rd_client_register($user->id, $password, $product);
       
        $rd2 = new RdController;
        $rd2->rd_create_opportunity($user->id, $product);

        //Mail::to($user->email)->send(new SendMailUser($user));

        Auth::login($user);

        return redirect(getRouterValue() . "/app/eco/checkout/$product->id/pay/$user->id");
        //return view('pages.eco.checkout_pay', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'prefixRouters' => 'modern-light-menu'], compact('product', 'user'));

    }

    public function checkout_client_pay($product_id, $client){

        $product = (EcoProduct::find($product_id));
        $user = User::find($client);

        $success = "Seu usuário foi criado, as informações de acesso serão enviadas no seu email.";
        return view('pages.app.eco.checkout_pay', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'prefixRouters' => 'modern-light-menu', 'success' => $success], compact('product', 'user'));

    }

    public function checkout_pay_end_post($product_id, $client, Request $request){
    
        //Captura dados do pagamento
        $pay = (object)$request->all();
        $cep = str_replace("-","", $request->cep);
        $expiry = explode("/", str_replace(array(' ', "\t", "\n"), '', $pay->expiry));
        if($pay->payment == "CREDIT_CARD"){
        $pay->expiryMonth = $expiry[0];
        $pay->expiryYear = $expiry[1];
        }
        $parcelac = $request->parcelac;
        $parcelab = $request->parcelab;
        $product = EcoProduct::find($product_id);
        $user = User::find($client);
        $codesale = $product->course_id . "-" . $user->id;
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

            //Cria o cliente no gateway
            if(!($user->eco_client()->first())){
            $asaas = new AsaasController();
            $response = $asaas->create_client($user, $cep);
            }else{
            }
            
            //Cria cobrança no gateway
            /*
            if($user->eco_sales()->where('codesale', $codesale)->first()){
                $cobranca = $user->eco_sales()->where('codesale', $codesale)->first();

            }else{
                $asaas = new AsaasController();
                $cobranca = $asaas->create_payment($user, $product, $pay, $codesale);
            }*/

            $asaas = new AsaasController();
            $cobranca = $asaas->create_payment($user, $product, $pay, $codesale);

            //dd($cobranca);
            $invoice = json_decode($cobranca->body)->invoiceUrl;

            $product->cobranca = $cobranca;

            $status = $cobranca->status; 

            $rd = new RdController;
            $rd->rd_update_opportunity($user, $product);

            if ($cobranca->status == "PENDING"){
                //dd($cobranca);
                $pix = json_decode($cobranca->body)->pix;
                $copy = json_decode($cobranca->body)->copy;
                return view('pages.app.eco.checkout_end', ['title' => 'Profissionaliza EAD | Finalização Pagamento ', 'breadcrumb' => 'checkout end', 'status' => "$status", 'invoice' => $invoice, 'pix' => $pix, 'copy' => $copy]);
            }
            //return redirect(getRouterValue() . "/app/eco/checkout_end");
            return view('pages.app.eco.checkout_end', ['title' => 'Profissionaliza EAD | Finalização Pagamento ', 'breadcrumb' => 'checkout end', 'status' => "$status", 'invoice' => $invoice]);
            //dd($cobranca);

    }

    public function checkout_end($id, $status){

    }

    public function list_sales(){

        $sales = EcoSales::first()->orderBy('updated_at', 'desc')->paginate(20);
        foreach($sales as &$sale){
            $user = User::find($sale->user_id);
            $sale->name = $user->name . " " . $user->lastname;
            $sale->cellphone = $user->cellphone;
            $sale->email = $user->email;
            $sale->seller = $user->seller;
            $sale->venda = json_decode($sale->body);
            //dd($sale);
        }

        //dd($sales);

        return view('pages.app.eco.list_sales', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('sales'));
    }

   public function search_sales(Request $request){
        
        $search = $request->search ?? '';
         

        $sales = EcoSales::where(function ($query) use ($search) {
            if ($search) {
                $query->where('user_id', $search);
                $query->orWhere('codesale', 'LIKE', "%{$search}%");
                $query->orWhere('seller', 'LIKE', "%{$search}%");
                $query->orWhere('status', 'LIKE', "%{$search}%");
                $query->orWhere('body', 'LIKE', "%{$search}%");
            }
        })
        ->paginate();

        foreach($sales as &$sale){
            $user = User::find($sale->user_id);
            $sale->name = $user->name . " " . $user->lastname;
            $sale->cellphone = $user->cellphone;
            $sale->email = $user->email;
            $sale->seller = $user->seller;
            $sale->venda = json_decode($sale->body);
            //dd($sale);
        }

        //dd($sales);

        return view('pages.app.eco.list_sales', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('sales'));
    }

    public function show(){
        
        $products = EcoProduct::all();

        
        //dd($products[0]->image);
        //dd(explode(",", $products[0]->image))
        return view('pages.app.eco.list', ['title' => 'Shop | Profissionaliza EAD', 'breadcrumb' => 'Lista Produtos'], compact('products'));
    }
    public function shop(Request $request){
        //dd($request->public);
        if($request->public == 1){
            $public = 0;
            $products = EcoProduct::all();
        }else{
            $public = 1;
            $products = EcoProduct::where([['public', 1]])->get();
        }
        //dd($request->all());
        
        foreach ($products as $product){
            //dd(array_reverse(json_decode($product->image)));
            //dd($product);
            $product->thumb = array_reverse(json_decode($product->image))[0];
            //dd(($product->thumb));
            
        }
        //dd($products[0]->image);
        //dd(explode(",", $products[0]->image));
        return view('pages.app.eco.shop', ['title' => 'Shop | Profissionaliza EAD', 'breadcrumb' => 'Lista Produtos'], compact('products', 'public'));
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
        $product->flow !== $request->flow ? $product->flow = $request->flow : "";
        $product->seller !== $request->seller ? $product->seller = $request->seller : "";
        $request->specification !== null ? $product->specification = $request->specification : "";
        $product->price !== $request->price ? $product->price = $request->price : "";
        $product->percent !== $request->percent ? $product->percent = $request->percent : "";
        $product->public !== $request->public ? $product->public = $request->public : "";
        $product->course_id !== $request->course_c ? $product->course_c = $request->course_c : "";
        $product->course_c !== $request->course_c ? $product->course_c = $request->course_c : "";
        $product->course_b !== $request->course_b ? $product->course_b = $request->course_b : "";

        $product->save();

        
        $sucess = "Atualizado";
        return redirect(getRouterValue() . "/app/eco/product/$product->id")->with('sucess', 'Verdade');
    }

    public function create_seller ($id, Request $request){
        $type = $request->type;
        //dd($type);
        $user = User::find($id);
        $user->eco_seller()->create([
            "name" => $user->name . " " . $user->lastname,
            "type" => $type,
        ]);
        return back();
    }

    public function delete_seller ($id){

        $user = User::find($id);
        $user->eco_seller()->update([
            "type" => 0,
        ]);
        return back();
    }


    public function delete_product ($id){

        //dd($id);

        $product = EcoProduct::find($id);
        //dd($product);
        
        $product->delete();
        $status = "Produto deletado com sucesso!";
        return back()->with('status', __($status));
    }

    public function comment_edit ($id, $i){
        $product = EcoProduct::find($id);
        dd($id);
        $comments = json_decode($product->comment) != "" ? json_decode($product->comment) : "";
        $n = 0;
        //dd($comments);
        foreach($comments as $comment){
            if($i == $n){
                return view('pages.app.eco.edit_comment', ['title' => 'Shop | Profissionaliza EAD', 'breadcrumb' => 'Lista Produtos'], compact('comment', 'id', 'i'));
            }

        $n++;
        }

        return back();
    }

    public function comment_save (Request $request, $id, $i){
        //dd($request->all());
        $product = EcoProduct::find($id);
        $comments = json_decode($product->comment);
        $n = 0;
        //dd($comments);
        foreach($comments as &$comment){
            if($i == $n){
                $request->name !== null ? $comment->name = $request->name : "";
                $request->gender !== null ? $comment->gender = $request->gender : "";
                $request->star !== null ? $comment->star = $request->star : "";
                $request->comment !== null ? $comment->comment = $request->comment : "";
            }
        $n++;
        }

        //dd($comments);
        $product->comment = json_encode($comments);
        $product->save();
        return redirect(getRouterValue() . "/app/eco/product/$id/edit");
        
    }

    public function comment_add (Request $request, $id){
        //dd($request->all());
        $comment_clean = strip_tags($request->comment);
        //dd($cleaner_input);
        $product = EcoProduct::find($id);
        $comments = json_decode($product->comment);

        
        //dd($product);
                $data = Http::get("https://xsgames.co/randomusers/avatar.php?g=$request->gender");
                $uri = (json_encode($data->transferStats->getEffectiveUri()));
                $img = (json_decode($uri));

                $comment = (object)[
                    'name' => $request->name,
                    'gender' => $request->gender,
                    'star' => $request->star,
                    'comment' => $comment_clean,
                    'img' => $img,
                ]; 

        

        $contents = file_get_contents($comment->img);
            Storage::makeDirectory('directory', 0775);
            Storage::put("product/$product->id/avatar/$comment->name.jpg", $contents, ['visibility' => 'public', 'directory_visibility' => 'public']);
            $comment->img = "product/$product->id/avatar/$comment->name.jpg";

        
        if(isset($comments)){
               $row = count($comments);
               $comments[$row] = ($comment);
               $product->comment = json_encode($comments);
               //dd($product);
               $product->save();
               return redirect(getRouterValue() . "/app/eco/product/$id/edit");
        }else{
            $product->comment = "[" . json_encode($comment) . "]";
            //dd($product);
            $product->save();
            return redirect(getRouterValue() . "/app/eco/product/$id/edit");
        }

        
        
    }


}
