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
        /*$schedule->call(function () {
            $firstUser = User::first();
            dispatch(new CademiProcess($firstUser));
        })->dailyAt('20:53');*/

        $schedule->command('telescope:prune --hours=48')->daily();
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
