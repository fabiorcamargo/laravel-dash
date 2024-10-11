<?php

namespace App\Jobs\Cademi;

use App\Jobs\CademiProgress;
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
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class CademiProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    protected $i;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->i += 1;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
            //Avalia se o usuário possui perfil na cademi    
            if (Cademi::where('user_id', $this->user->id)->exists())
            {
                Storage::disk('local')->append('file6.txt', now() . " cademi-progress " .  $this->user->id);
                $cademi = Cademi::where('user_id', $this->user->id)->first();
                
                //Consulta acessos liberados do usuário na cademi
                $response = Http::withToken(env('CADEMI_TOKEN_API'))->get("https://profissionaliza.cademi.com.br/api/v1/usuario/acesso/$cademi->user");
                $profiler = json_decode($response->body(), true);

                //Se acessos existirem captura os produtos
                if ($response->status() == 200) {
                    $produtos = (object)($profiler['data']['acesso']);

                    //Passa por todos os produtos
                    foreach ($produtos as $produto) {
                        if ($this->user->CademiProgress()->where('product', $produto['produto']['id'])->first() == null) {
                            $product = $this->user->CademiProgress()->create([
                                'product' => $produto['produto']['id'],
                                'name' => $produto['produto']['nome'],
                                'percent' => ''
                            ]);
                            dispatch(new ProductProgress($this->user, $cademi->user, $product))->delay(now()->addSeconds($this->i));
                            
                        }else{
                            dispatch(new ProductProgress($this->user, $cademi->user, $this->user->CademiProgress()->where('product', $produto['produto']['id'])->first()))->delay(now()->addSeconds($this->i));
                        }
                        $this->i += 1;
                    }
                }
            }
        

        // Crie uma nova entrada na fila para o próximo usuário (se houver)
        $nextUser = User::where('id', '>', $this->user->id) //Verifica se o id é maior que o anterior
        ->where('courses', 'not like', 'NÃO') //Verifica se tem cursos
        ->where(function ($query) { //Cria uma nova pesquisa
            $query->whereExists(function ($subQuery) { //Se a pesquisa existir
                $subQuery->from('cademis') //Na tabela cademis
                    ->whereRaw('cademis.user_id = users.id'); //verificar se o usuário existe
            });
        })->first(); //seleciona o que está nessa condição.

        
        if ($nextUser) { //Se existir próximo usuário prosseguir
            dispatch(new CademiProcess($nextUser))->delay(now()->addSeconds($this->i)); //Dispachar novo job com adicional de tempo
        }

    }
}