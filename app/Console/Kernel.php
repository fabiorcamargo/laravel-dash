<?php

namespace App\Console;

use App\Http\Controllers\CademiProcessController;
use App\Http\Controllers\ChatbotAsset;
use App\Jobs\Cademi\CademiProcess;
use App\Jobs\CademiProgress;
use App\Jobs\ChatbotSend;
use App\Jobs\UserMg_FailSend;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    use DispatchesJobs;
    
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {   

        //Chama comando para verificação de 
        //$schedule->command('teste:cron')->dailyAt('08:30');
        
        $schedule->call(function () {
            $users = User::where('courses', 'not like', 'NÃO')->get(); // Consulta todos os usuários
            $batches = $users->chunk(1000);
                foreach ($batches as $batch) {
                    foreach ($batch as $user) {
                        dd($user);
                        Storage::disk('local')->append('file6.txt', now() . " A " .  $user->id);
                    }
                }
        })->dailyAt('12:49');
        
        //CademiProgress::dispatch();
        //$schedule->job(new CademiProgress())->everyMinute();
        //$schedule->command('ProductProgressCommand:cron')->dailyAt('02:00');
        //$schedule->command('CertCheckCommand:cron')->dailyAt('03:00');
        
        

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
