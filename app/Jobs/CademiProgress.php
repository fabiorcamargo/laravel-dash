<?php

namespace App\Jobs;

use App\Jobs\Cademi\ProductProgress;
use App\Models\Cademi;
use App\Models\User;
use App\Models\UserCertificatesCondition;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use stdClass;

class CademiProgress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

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
}
