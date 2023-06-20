<?php

namespace App\Http\Livewire;

use App\Events\LiveModelUpdateEvent;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserNotifyLive extends Component
{
 public $notifies;
 public $notify;

 protected $listeners = [
    'delNotify'
];

 

 public function dismiss($id)
 {
     //dd($id);
        $this->getNotify($id);
        $this->notify->show = 0;
       // dd($this->notify);
        $this->notify->save();

        $this->mount();
        $this->emit('delNotify');
     
 }
 
    public function mount()
    {
        $this->getNotifies();
    }

    public function getNotify($id)
    {
        $this->notify = UserNotification::find($id);
        
    }

    public function delNotify()
    {
        $this->getNotifies();
    }

    public function getNotifies()
    {
        $this->notifies = UserNotification::where('show', 1)
        ->where('user_id', auth()->user()->id)
        ->get();
    }
    
    public function render()
    {

        return view('livewire.user-notify-live');
    }
}
