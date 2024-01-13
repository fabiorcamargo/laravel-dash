<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Getuser extends Component
{
    public $search;
    public $i;
    public $n;
 
    protected $queryString = ['search'];
 
    public function render()
    {
        
        return view('livewire.getuser', [
            'users' => User::where('username', 'like', $this->search == "" ? "" : $this->search.'%')->get(),
        ]);
    }
}