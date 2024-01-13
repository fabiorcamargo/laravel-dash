<?php

namespace App\Http\Livewire\Flow;

use App\Models\Flow;
use Livewire\Component;

class ChangeName extends Component
{
    public $flowId;
    public $nameId;
    public $title;
    public $nome;
    public $name;
    public $mensagem;
    public $modalAberto = false;

    protected $listeners = ['atualizarInformacao'=> 'render'];


    public function abrirModal()
    {
        $this->modalAberto = true;
    }

    public function fecharModal()
    {
        $this->modalAberto = false;
    }

    public function mount($n, $f)
    {
        $this->flowId = $f;
        $this->nameId = $n;

        
        
        $this->carregarModelo();
    }

    public function carregarModelo()
    {
        
        $flow = Flow::find($this->flowId);
        $this->title = json_decode($flow->body)->title;
    }

    
    public function atualizar()
    {
        /*$this->validate([
            'campo1' => 'required',
            'campo2' => 'required',
        ]);*/

        $flow = Flow::find($this->flowId);
        $body = json_decode($flow->body);
        
        $body->title[$this->nameId] = $this->nome;
        //dd($body);
        $flow->body = json_encode($body);
        //dd($flow);
        $flow->save();

        //dd($flow);
        $this->emit('atualizarInformacao');

        //session()->flash('mensagem', 'Título atualizado com sucesso!');

        $this->fecharModal();
        
    }

    public function render()
    {
        $flow = Flow::find($this->flowId);
        $body = json_decode($flow->body);
        $this->name = $body->title[$this->nameId];

        return view('livewire.flow.change-name');
    }
}
