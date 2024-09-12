<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\PersonalAccessToken;
use Livewire\Component;

class GetOldSystemToken extends Component
{

    public $user;
    public $link;
    public $title;
    public $card;

    public function mount()
    {
        $this->user = Auth::user();
        $this->token_exists();
    }

    public function token_exists()
    {

        //Busca o usuário na plataforma antiga
        $response = Http::get('https://ead.profissionalizaead.com.br/webservice/rest/server.php/token_login.php', [
            'wstoken' => env('TOKEN_PMOODLE'),
            'wsfunction' => 'core_user_get_users_by_field',
            'moodlewsrestformat' => 'json',
            'field' => 'username',
            'values[0]' => $this->user->username
        ]);

        //Decodifica os dados
        $data = (json_decode($response->body()));

        //Se obtiver resposta
        if (isset($data[0]->id)) {
            if (isset($data[0]->customfields)) {
                foreach ($data[0]->customfields as $key => $value) {
                    if ($value->shortname == 'token_alunos') {
                        $token = $value->value;

                        //Verifica se o token é válido
                        $newToken = PersonalAccessToken::findToken($token);
                    }
                }
            }
            // Crie um novo token
            if (!isset($newToken) || $newToken == null) {
                $newToken = $this->user->createToken('old_system')->plainTextToken;
            }
        }



        $this->link = 'https://ead.profissionalizaead.com.br/auth/token_login.php?' . 'token=' . env('EAD_TOKEN') . '&' . 'username=' . $this->user->username . '&' . 'moodlewsrestformat=json&' . 'token_alunos=' . $newToken;
    }

    public function render()
    {
        return view('livewire.get-old-system-token');
    }
}
