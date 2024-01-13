<?php

namespace App\Jobs;

use App\Http\Controllers\ApiWhatsapp;
use App\Models\User;
use App\Models\Whatsapp_client;
use App\Models\WhatsappBulkStatus;
use App\Models\WhatsappTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class WhatsappBulk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $leads;
    private $template;
    private $campaign;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $failOnTimeout = false;
    public $timeout = 120000;

    public function __construct($leads) 
    {
        $this->leads = $leads;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->leads as $lead){
            $bulk = new ApiWhatsapp;
            $bulk->bulk_msg_send($lead);
            sleep(4);
            $bulk2 = new ApiWhatsapp;
            $bulk2->bulk_msg_send2($lead);
        }
    }
}
