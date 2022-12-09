<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateCademiRequest;
use App\Models\{
  Cademi,
  User
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ApiController extends Controller
{
  protected $cademi;
  protected $user;

    public function __construct(Cademi $cademi, User $user)
    {
        $this->cademi = $cademi;
        $this->user = $user;
    }

        public function getAllUsers(Request $request){

                $explode_id = json_decode($request->getContent(), true);
                Storage::disk('local')->put('example.txt', $explode_id['event_id']);
                $user = $explode_id['event']['usuario']['email'];
              // $user = $this->model->find(10);
                $id = DB::table('users')->where('email', $user)->value('id');

                return redirect()->route('api.cademi.store', $id);
        }




        public function store(Request $request)
                {
                
                  $data = json_decode($request->getContent(), true);
                  $arr = (object)$data['event']['usuario'];
                  //dd($arr->id);

                  $tabela = $this->user->where('email', $arr->email)->first();
                  
                  $userId = $tabela['id'];

                  if (!$user = $this->user->find($userId)) {
                    return redirect()->back();
                  }

                  
                $response =  $user->cademis()->create([
                    'user' => $arr->id,
                    'nome' => $arr->nome,
                    'email' => $arr->email,
                    'celular' => $arr->celular,
                    'login_auto' => $arr->login_auto,
                    'gratis' => $arr->gratis,
                    'visible' => isset($arr->visible)
                ]);
                  

                    return response($userId, 200);
          }

}
