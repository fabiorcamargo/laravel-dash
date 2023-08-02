<?php

namespace App\Console\Commands;

use App\Jobs\CademiProgress;
use App\Jobs\CertEmit;
use App\Jobs\Certificates\CertCheck;
use App\Models\Cademi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TesteCron extends Command
{
    protected $user;
    protected $cademi;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teste:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica progresso dos usuários';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        //Captura todos os usuários
        $users = User::all();
            Storage::disk('local')->append('file6.txt', now() . ' iniciou');
            //Passa por todos os usuários
            foreach($users as $user){
                $this->user = $user;
                    if($this->cademi = Cademi::where('user_id', $this->user->id)->first()){
                        if($user->courses !== null && $user->courses !== 'NÃO'){

                                $inputDate = Carbon::parse($user->access_date == null ? Carbon::now() : $user->access_date);
                                $now = Carbon::now();
                                $differenceInHours = $inputDate->diffInHours($now);

                            if ($differenceInHours < 24) {
                                    $job = new CademiProgress($user);
                                    dispatch($job);
                                    sleep(1);
                            }       
                        }
                    }
            }

        return Command::SUCCESS;
    }
}
