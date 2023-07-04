<?php

namespace App\Http\Controllers;

use App\Models\Flow as ModelsFlow;
use App\Models\FlowEntry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class Flow extends Controller
{
    public function show_add(){
        return view('pages.app.flow.add', ['title' => 'Profissionaliza EAD | Adicionar Fluxo ', 'breadcrumb' => 'add flow']);
    }
    public function flow_add(Request $request){
        for ($i=1; $i < $request->steps; $i++) { 
            $steps[$i] = array("name" => "Etapa $i", "order" => "$i");
        }
        $json = (json_encode($steps));
        //dd(json_decode($json,true)[1]);

        $flow = ModelsFlow::create([
            'name' => $request->name,
            'context' => $request->context,
            'steps' => $request->steps,
            'item' => $request->item
        ]);
        $status = "Fluxo criado com sucesso";
        return back()->with('status', __($status));
    }

    public function flow_config_show($id){
        $flow = ModelsFlow::find($id);
        
        return view('pages.app.flow.config_flow', ['title' => 'Profissionaliza EAD | Configurar Fluxo ', 'breadcrumb' => 'config flow'], compact('flow'));
    }

    public function new_entry($id, $step, $seller, $product){
        //dd($id);
        //dd($seller);
        //dd($product);
        $flow = ModelsFlow::find($id);
        $user = Auth::user();
        //dd($user);
        $body = json_encode(['saller' => $seller, 'date' => now(), 'step' => $step, 'product' => [$product]]);
        //dd($user->flow_entry()->all());
        if($user == null){
            /*
            $flow->entry()->create([
                'user_id' => env('ECO_USER_VISITOR'),
                'step' => $step,
                'body' => $body,
                'seller' => $seller,
                'product_id' => $product->id
            ]);*/
        }else{
            if($user->flow_entry()->where(['flow_id' => $id, 'seller' => $seller, 'product_id' => $product->id])->exists()){
                $flow = $user->flow_entry()->where(['flow_id' => $id, 'seller' => $seller, 'product_id' => $product->id])->first();
                $flow->step = $step;
                $flow->body = $body;
                $flow->update();
                //dd(json_decode($flow->body));
                //dd('s');
            }else{
                //dd('n');
                
                $flow->entry()->create([
                    'user_id' => $user->id,
                    'step' => $step,
                    'body' => $body,
                    'seller' => $seller,
                    'product_id' => $product->id
                ]);
                //dd('n');
            }
        }
        
        
    }

    public function flow_show($id){
        //dd(Auth::user()->eco_seller->id);
        $flow = ModelsFlow::find($id);
        if(Auth::user()->role >= 6 ){
            //dd('s');
        $flow_entries = (FlowEntry::with('user')->where('flow_id', $id)->get());    
        }else{
            //dd(Auth::user()->eco_seller);
        $flow_entries = (FlowEntry::with('user')->where(['flow_id' => $id, 'seller' => (Auth::user()->eco_seller->id)])->get());    
        }
        //dd($flow_entries);
        return view('pages.app.flow.show', ['title' => 'Profissionaliza EAD | Entradas do Fluxo ', 'breadcrumb' => 'show flow'], compact('flow', 'flow_entries'));
    }
    public function flow_show_all(){

        $flow_entries = (FlowEntry::all());    
        //dd($flow_entries);
        return view('pages.app.flow.show', ['title' => 'Profissionaliza EAD | Entradas do Fluxo ', 'breadcrumb' => 'show flow'], compact('flow', 'flow_entries'));
    }

    public function list(){
        $flows = ModelsFlow::all();

        return view('pages.app.flow.list', ['title' => 'Profissionaliza EAD | Entradas do Fluxo ', 'breadcrumb' => 'show flow'], compact('flows'));

    }
}
