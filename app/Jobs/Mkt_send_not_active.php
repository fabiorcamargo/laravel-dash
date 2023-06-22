<?php

namespace App\Jobs;

use App\Http\Controllers\MktController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Mkt_send_not_active implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $nome;
    private $telefone;
    private $type;
    private $msg_text; 
    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($nome, $telefone, $type, $msg_text, $id)
    {
        $this->nome = $nome;
        $this->telefone = $telefone;
        $this->type = $type;
        $this->msg_text =$msg_text; 
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mkt = new MktController;
        $mkt->send_not_active($this->nome, $this->telefone, $this->type, $this->msg_text, $this->id);
    }
}
