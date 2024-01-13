<?php

namespace App\Http\Livewire;

use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserNotifyCount extends Component
{
    public $notify_count;
    
    protected $listeners = [
        'delNotify'
    ];

    public function mount()
    {
    $this->notify_count = UserNotification::where('user_id', Auth::user()->id)->where('show', "1")->get()
        ->count();
    }

    public function delNotify()
    {
    $this->notify_count = UserNotification::where('user_id', Auth::user()->id)->where('show', "1")->get()
        ->count();
    }

    public function render()
    {
        return view('livewire.user-notify-count');
    }
}
