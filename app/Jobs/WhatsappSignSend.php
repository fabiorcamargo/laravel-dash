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

class WhatsappSignSend implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $template;
    private $name;
    private $phone;
    private $username;
    private $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $failOnTimeout = false;
    public $timeout = 120000;

    public function __construct($template, $name, $phone, $username, $password) 
    {
        $this->template = $template;
        $this->name = $name;
        $this->phone = $phone;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            //dd($this->user);
            $bulk = new ApiWhatsapp;
            $bulk->sign_msg_send($this->template,
            $this->name,
            $this->phone,
            $this->username,
            $this->password
        );

    }
}
