<?php

namespace App\Http\Controllers;

use App\Models\CademiTag;
use App\Models\PushNotificationCampaign;
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
        $pushNotifications = PushNotificationCampaign::orderBy('created_at', 'desc')->get();
        
        $tags = CademiTag::all();
        
        return view('pages.app.user.addnotify', ['title' => "Enviar Notificação", 'tags' => $tags, 'pushNotifications' => $pushNotifications]);
    }

    public function store(Request $request){
        //dd($request->all());
        $ApiPush = new ApiAppController;
        $users = $ApiPush->getByCourse($request->cademi_code);
        $users = json_decode($users->content());
        //dd($users);
        $request->merge(['usernames' => $users]);

        

        $fire = new FirebaseMessagingController;
        $fire->sendMessages($request);

        return back()->with('status', 'Notificações enviadas com sucesso');

    }
}
