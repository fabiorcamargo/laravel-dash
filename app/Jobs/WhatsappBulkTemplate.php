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

class WhatsappBulkTemplate implements ShouldQueue
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
    public function __construct($leads, $template, $campaign) 
    {
        $this->leads = $leads;
        $this->template = $template;
        $this->campaign = $campaign;
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
            $response = $bulk->template_msg_send($this->template, $lead, $this->campaign);
            sleep(5);
        }
    }
    public function chunkSize(): int
    {
        return 5;
    }
}
