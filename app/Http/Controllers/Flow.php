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
        dd(json_decode($json,true)[1]);

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

    public function new_entry($id, $step){
        //dd($id);
        $flow = ModelsFlow::find($id);
        $user = Auth::user();
        $flow->entry()->create([
            'user_id' => $user->id,
            'step' => $step,
        ]);
    }

    public function flow_show($id){
        $flow = ModelsFlow::find($id);
        $flow_entries = (FlowEntry::with('user')->where('flow_id', $id)->get());    
        //dd($flow);
        return view('pages.app.flow.show', ['title' => 'Profissionaliza EAD | Entradas do Fluxo ', 'breadcrumb' => 'show flow'], compact('flow', 'flow_entries'));
    }
}
