<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\State;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class CepSearch extends Component
{
    public $estados;
    public $estadoSelect;
    public $cidadeSelect;
    public $cities = [];
    public $rua;
    public $results = [];


    public function mount()
    {
        $this->estados = State::orderBy('name')->get();
    }

    public function estadoChange()
    {

        //dd($this->estadoSelect);
        $this->cities = State::where('abbr', $this->estadoSelect)->first()->city()->orderBy('name')->get();
    }

    public function getCep()
    {

        // Codificar os parâmetros para garantir que a URL seja válida
        $estado = rawurlencode($this->estadoSelect);
        $cidade = rawurlencode($this->cidadeSelect);
        $rua = rawurlencode($this->rua);

        // Construir a URL completa
        $url = "https://viacep.com.br/ws/{$estado}/{$cidade}/{$rua}/json/";

        // Fazer a solicitação HTTP GET
        $response = Http::get($url);

       
        // Verificar se a resposta foi bem-sucedida
        if ($response->successful()) {
            $this->results = $response->json();
            // Faça algo com os dados
        } else {
            // Tratar erros
            // Por exemplo, você pode lançar uma exceção ou registrar um erro
            throw new \Exception('Erro ao buscar dados do CEP: ' . $response->status());
        }
    }

    public function render()
    {
        return view('livewire.cep-search');
    }
}
