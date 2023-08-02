<?php

namespace App\Jobs\Certificates;

use App\Models\User;
use App\Models\UserCertificatesCondition;
use App\Models\UserCertificatesEmit;
use App\Models\UserCertificatesModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class CertEmit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $user;
    private $cert_model;
    private $percent;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $cert_model, $percent)
    {
        $this->user = $user;
        $this->cert_model = UserCertificatesModel::find($cert_model);
        $this->percent = $percent;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        //Avalia novamente se o usuário tem certificado emitido
        if($this->user->getCertificates()->where('user_certificates_models_id', $this->cert_model->id)->first() == null){

            //Se não tiver emite um novo certificado
            $this->user->getCertificates()->create([
                'code' => (string)Str::ulid(),
                'user_certificates_models_id' => $this->cert_model->id,
                'percent' => $this->percent
            ]);
            
        }
    }
}
