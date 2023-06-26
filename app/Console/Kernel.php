<?php

namespace App\Console;

use App\Http\Controllers\ChatbotAsset;
use App\Jobs\ChatbotSend;
use App\Jobs\UserMg_FailSend;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {   
        //$schedule->call(fn() => $chatbot->queue_send())
        //->everyMinute();
        //$schedule->call(new UserMg_FailSend)->everyMinute();
        
        /*$schedule->call(function () {
            $job = new UserMg_FailSend;
            //dispatch($job);
            // Código para agendar a tarefa Redis
            //Storage::put('file5.txt', 'test');
            
        })->everyMinute(); // Agendamento a cada minuto (exemplo)*/

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
