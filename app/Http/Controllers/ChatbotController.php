<?php

namespace App\Http\Controllers;

use App\Models\CademiTag;
use App\Models\ChatbotGroup;
use App\Models\User;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function group_create(Request $request){

        $group = new ChatbotGroup();
        $group->create([

        ]);

    }

    public function group_add_show(){

        $users = User::where('role', 7)->get();
        $tags = CademiTag::all();
        return view('pages.app.group.add', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('tags', 'users'));

    }

    public function group_add_create(Request $request){
        //dd($request->all());

        if(ChatbotGroup::where('group_code', $request->course_id)->first()){
            return back()->with('error', 'Já existe um grupo para esse Código de Curso');            
        }else{
            ChatbotGroup::create([
                'group_id' => $request->group_id,
                'group_code' => $request->course_id,
                'periodo' => $request->inicio . " até " . $request->fim,
                'group_name' => $request->course_name,
                'responsavel' => $request->responsavel,
                'group_link' => $request->group_link
            ]);
        }

        return back()->with('success', 'Grupo criado com sucesso');  

    }
}
