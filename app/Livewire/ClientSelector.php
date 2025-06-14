<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;

class ClientSelector extends Component
{
    public $search = '';
    public $results = [];
    public $selectedClient = null;
    public $noResults = false;


    public function updatedSearch()
    {
        $this->searchClients();
    }

    public function searchClients()
    {
        if (strlen($this->search) < 2) {
            $this->results = [];
            $this->noResults = false;
            return;
        }

        $found = Customer::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('dniruc', 'like', '%' . $this->search . '%')
            ->limit(5)
            ->get();

        $this->results = $found->toArray();
        $this->noResults = $found->isEmpty();
    }

    public function selectClient($id)
    {
        $client = Customer::find($id);
        if ($client) {
            $this->selectedClient = $client;
            $this->search = $client->name;
            $this->results = [];

            // Emitir evento al componente padre
            $this->dispatch('clientSelected', [
                'id' => $client->id,
                'name' => $client->name,
                'email' => $client->email,
            ]);
        }
    }
    public function render()
    {
        return view('livewire.client-selector');
    }
}
