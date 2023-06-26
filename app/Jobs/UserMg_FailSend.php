<?php

namespace App\Jobs;

use App\Http\Controllers\MktController;
use App\Models\UserMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserMg_FailSend implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $msg_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //dd($this->msg_id->id);
        
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //dd($this->msg_id->msg_id);
       $mkt = new MktController;
       dispatch($mkt->send());
        
    }
}
