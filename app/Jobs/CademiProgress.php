<?php

namespace App\Jobs;

use App\Jobs\Cademi\ProductProgress;
use App\Models\Cademi;
use App\Models\User;
use App\Models\UserCertificatesCondition;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
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
    use Batchable,  Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $users = User::where('courses', 'not like', 'NÃO')->get();

            foreach($users as $user){
                Storage::disk('local')->append('file6.txt', now() . " $user->id");
            }
            //Passa por todos os usuários
            /*
            foreach($users as $user){
                $this->user = $user;
                    if($this->cademi = Cademi::where('user_id', $this->user->id)->first()){

                                $inputDate = Carbon::parse($user->access_date == null ? Carbon::now() : $user->access_date);
                                $now = Carbon::now();
                                $differenceInHours = $inputDate->diffInHours($now);

                            if ($differenceInHours < 24) {
                                    $job = new CademiProgress($user);
                                    dispatch($job);
                                    sleep(1);
                            }       
                    }
            }*/
        /*
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
        }*/
    }
}
