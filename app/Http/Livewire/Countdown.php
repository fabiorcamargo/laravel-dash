<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Countdown extends Component
{
    public $countdown = 10; // Tempo inicial em segundos

    public function decrement()
    {
        $this->countdown -= 1;
    }

    public function render()
    {
        return view('livewire.countdown');
    }
}
