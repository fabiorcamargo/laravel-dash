<?php

namespace App\Http\Livewire\Flow;

use App\Models\Flow;
use Livewire\Component;

class ShowName extends Component
{
    public $name;

    protected $listeners = ['atualizarInformacao'=> '$refresh'];
    
    

    public function mount($n, $f)
    {

    $flow = Flow::find($f);
    $body = json_decode($flow->body);
    $this->name = $body->title[$n];

    }

    public function render()
    {
        return view('livewire.flow.show-name');
    }
}
