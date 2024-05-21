<?php

namespace App\Http\Controllers;

use App\Models\CademiTag;
use App\Models\ChatbotGroup;
use App\Models\City;
use App\Models\EcoSeller;
use App\Models\State;
use App\Models\User;
use App\Models\WpGroup;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function group_create(Request $request){

        $group = new ChatbotGroup();
        $group->create([

        ]);

    }

    public function group_add_show(){

        // $users = User::where('role', 7)->get();
        // $sellers = EcoSeller::where('type', 2)->get();
        $tags = CademiTag::all();

        return view('pages.app.group.add', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('tags'));

    }

    public function group_add_create(Request $request){

            $request->validate([
                'cademi_code' => 'required',
                'name' => 'required|string',
                'link' => 'required|url',
                'inicio' => 'required|date|before_or_equal:fim',
                'fim' => 'required|date|after_or_equal:inicio',
            ]);
            
            WpGroup::create([
                'cademi_code' => $request->cademi_code,
                'name' => $request->name,
                'description' => $request->description,
                'link' => $request->link,
                'inicio' => $request->inicio,
                'fim' => $request->fim,
            ]);

        return back()->with('success', 'Grupo criado com sucesso');  

    }

    public function my_group(){
        
    }
}
