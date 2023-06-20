<?php

namespace App\Jobs;

use App\Http\Controllers\MktController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Mkt_resend_not_active implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $msg_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($msg_id)
    {
        $this->msg_id = $msg_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mkt = new MktController;
        $mkt->resend_not_active($this->msg_id);
    }
}
