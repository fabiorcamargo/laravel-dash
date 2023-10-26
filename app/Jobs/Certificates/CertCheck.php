<?php

namespace App\Jobs\Certificates;

use App\Models\User;
use App\Models\UserCertificatesCondition;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CertCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $user;
    protected $i;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->i = $this->i + 1;
    }

    /**
     * Execute the job.
     * @param  User  $user
     * @return void
     */
    public function handle()
    {
        //Busca as condições de Emissão de Certificado
        $conditions = UserCertificatesCondition::all();

        //Passa por todas as condições
        foreach($conditions as &$condition){

            //Captura os produtos da condição
            $condition->product = collect(json_decode($condition->body));

                //Passa por todos os produtos da condição
                foreach($condition->product as &$product){

                    //Avalia se o produto tem progresso para esse usuário
                    if($progress = $this->user->CademiProgress()->where('product', $product->value)->first()){
                        $product->percent = $progress->percent;
                    }
                }

                    //Avalia se a média de progresso é maior que a média de emissão de certificado
                    if($condition->product->avg('percent') > $condition->percent){

                        //Avalia se o usuário já tem certificado emitido
                        if($this->user->getCertificates()->where('user_certificates_models_id', $condition->user_certificates_models_id)->first() == null){
                           
                           //Se não tiver certificado emitido, gera um novo certificado
                           $job = new CertEmit($this->user, $condition->user_certificates_models_id, $condition->product->avg('percent'));
                           dispatch($job);
                        }
                    }
        }



        $nextUser = User::where('id', '>', $this->user->id) //Verifica se o id é maior que o anterior
        ->where('courses', 'not like', 'NÃO') //Verifica se tem cursos
        ->where(function ($query) { //Cria uma nova pesquisa
            $query->whereExists(function ($subQuery) { //Se a pesquisa existir
                $subQuery->from('user_cademi_progress') //Na tabela cademis
                    ->whereRaw('user_cademi_progress.user_id = users.id'); //verificar se o usuário existe
            });
        })->first(); //seleciona o que está nessa condição.


        if ($nextUser) { //Se existir próximo usuário prosseguir
            dispatch(new CertCheck($nextUser))->delay(now()->addSeconds($this->i)); //Dispachar novo job com adicional de tempo
        }
    }
}
