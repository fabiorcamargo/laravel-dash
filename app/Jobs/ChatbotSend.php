<?php

namespace App\Jobs;

use App\Http\Controllers\ChatbotAsset as ControllersChatbotAsset;
use App\Models\ChatbotAsset;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChatbotSend implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ChatbotAsset $chatbot)
    {
        $this->chatbot = $chatbot;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $send = new ControllersChatbotAsset;
        $send->chatbot_send();
    }
}
