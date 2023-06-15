<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAccountable;
use Illuminate\Http\Request;
use stdClass;

class UserGetAccountable extends Controller
{
    public function get_accountable(){
        $users = User::all();

        $response = new stdClass;
        $i = 0;
        foreach($users as $user){
            $accountable = (UserAccountable::where('user_id', $user->id)->first());
            if(isset($accountable->id)){
            $user->user_accountable_id = $accountable->id;
            $accountable->secretary = $user->secretary;
				$accountable->active = 1;
				$accountable->save();
				//dd($accountable);
            $response->$i = ['user' => $user->id,'accountable' => $accountable->id];
            //dd($response);
            //$user->user_accountable_id = $accountable->id;
				
            $user->save();
				//dd($user);
            //dd($accountable);
            $i++;
            }
        }
        //dd($users);
        return print_r($response);
        
    }
}
