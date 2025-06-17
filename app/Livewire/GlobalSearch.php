<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Consultation;
use App\Models\Pet;

class GlobalSearch extends Component
{
    public $query = '';
    public $results = [];

    public function search()
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            return;
        }

        $this->results = [
            'clientes' => Customer::where('name', 'like', '%' . $this->query . '%')
                ->orWhere('lastname', 'like', '%' . $this->query . '%')
                ->get(),

            'mascotas' => Pet::where('name', 'like', '%' . $this->query . '%')->get(),

            'consultas' => Consultation::where('motivo_consulta', 'like', '%' . $this->query . '%')->get(),
        ];
    }
    public function render()
    {
        return view('livewire.global-search');
    }
}
