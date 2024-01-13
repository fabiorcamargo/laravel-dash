<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class cademi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;

    public function __construct(User $user)
    {
        $this->user = $user;
        
        
    }

    public function handle()
    {
        
        $data = Storage::get('file.txt', $this->user);
        Storage::put('file.txt', $data . $this->user);
    }
}
