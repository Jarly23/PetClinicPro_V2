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
    public $showSuggestions = false;

    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $this->searchClients();
            $this->showSuggestions = true;
        } else {
            $this->results = [];
            $this->noResults = false;
            $this->showSuggestions = false;
        }
    }

    public function searchClients()
    {
        if (strlen($this->search) < 2) {
            $this->results = [];
            $this->noResults = false;
            $this->showSuggestions = false;
            return;
        }

        $found = Customer::where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('lastname', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('dniruc', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->limit(8)
            ->get();

        $this->results = $found->toArray();
        $this->noResults = $found->isEmpty();
        $this->showSuggestions = true;
    }

    public function selectClient($id)
    {
        $client = Customer::find($id);
        if ($client) {
            $this->selectedClient = $client;
            $this->search = $client->name . ' ' . $client->lastname;
            $this->results = [];
            $this->showSuggestions = false;
            $this->noResults = false;

            // Emitir evento al componente padre
            $this->dispatch('clientSelected', [
                'id' => $client->id,
                'name' => $client->name,
                'lastname' => $client->lastname,
                'email' => $client->email,
                'phone' => $client->phone,
                'dniruc' => $client->dniruc,
                'address' => $client->address,
            ]);
        }
    }

    public function clearSelection()
    {
        $this->selectedClient = null;
        $this->search = '';
        $this->results = [];
        $this->showSuggestions = false;
        $this->noResults = false;
        
        // Emitir evento de limpieza al componente padre
        $this->dispatch('clientCleared');
    }

    public function render()
    {
        return view('livewire.client-selector');
    }
}
