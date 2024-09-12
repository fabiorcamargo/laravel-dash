<?php

namespace App\Http\Controllers;

use App\Models\CademiTag;
use Illuminate\Http\Request;

class UserNotify extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $tags = CademiTag::all();
        return view('pages.app.user.addnotify', ['title' => "Enviar Notificação", 'tags' => $tags]);
    }

    public function store(Request $request){
        //dd($request->all());
        $ApiPush = new ApiAppController;
        $users = $ApiPush->getByCourse($request->cademi_code);
        $users = $users->content();
        $request->merge(['usernames' => $users]);

        

        $fire = new FirebaseMessagingController;
        $fire->sendMessages($request);

    }
}
