<?php

namespace App\Console\Commands;

use App\Jobs\Certificates\CertCheck;
use App\Models\User;
use Illuminate\Console\Command;

class CertCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CertCheckCommand:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica condições para emissão de certificado';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Captura todos os usuários
        $users = User::all();

            //Passa por todos os usuários
            foreach($users as $user){

                    //Emite tarefa verificação das condições para emissão de certificado
                    $job = new CertCheck($user);
                    dispatch($job);

                    //Da um intervalo de 1 segundo para evitar carga do servidor
            }
        
    return Command::SUCCESS;
    }
}
