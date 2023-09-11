<?php

namespace App\Jobs\Cademi;

use App\Models\Cademi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ClientProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $users;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $users)
    {
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            foreach($this->users as $user){
                Storage::disk('local')->append('file6.txt', now() . " $user->id");
                //Avalia se o usuário possui perfil na cademi    
                if($cademi = Cademi::where('user_id', $this->user->id)->first()){

                    //Consulta acessos liberados do usuário na cademi
                    $response = Http::withToken(env('CADEMI_TOKEN_API'))->get("https://profissionaliza.cademi.com.br/api/v1/usuario/acesso/$cademi->user");
                    $profiler = json_decode($response->body(), true);

                    //Se acessos existirem captura os produtos
                    if ($response->status() == 200) {
                        $produtos = (object)($profiler['data']['acesso']);

                        //Passa por todos os produtos
                        foreach ($produtos as $produto) {
                            if ($this->user->CademiProgress()->where('product', $produto['produto']['id'])->first() == null) {
                                    $this->user->CademiProgress()->create([
                                        'product' => $produto['produto']['id'],
                                        'name' => $produto['produto']['nome'],
                                        'percent' => ''
                                    ]);
                                }
                        }
                    }
                }
            }
            //Passa por todos os usuários
    }
}
