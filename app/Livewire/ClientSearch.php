<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;

class ClientSearch extends Component
{

    public $owner_search = '';
    public $owner_data = [];
    public $owner_id = null;
    public $showNewOwnerForm = false;
  
    public $new_owner =[
        'name' =>'',
        'lastname' => '',
        'email' => '',
        'phone' => '',
        'addres' => '',
        'dni' =>'',
    ];

    public function updatedOwnerSearch()
    {
        $this-> searchOwner();
    }

    // Logica de busqueda de propietario
    public function searchOwner()
    {
        if (strlen($this->owner_search) < 2) {
            $this->resetOwner();
            return;
        }
        $owners = Customer::where('name', 'like', '%'.$this->owner_search.'%' )
        ->orWhere('email' ,'like','%'.$this->owner_search.'%')
        ->orWhere('dni', 'like','%'. $this->owner_search . '%')
        ->limit(5)
        ->get();

        if($owners->count() == 1){
            $this->setOwner($owners->first());
        } elseif ($owners->count() > 0){
            $this->owner_data = $owners->toArray();
            $this->owner_id = null;
            $this->showNewOwnerForm = false;
        } else {
            $this->resetOwner();
        }
    }
    public function showOwnerForm()
    {
        $this->showNewOwnerForm = true;
    }
    public function createNewOwner()
    {
        $data = $this->validateNewOwner();

        $customer = Customer::create($data);
        $this->setOwner($customer);

        $this->dispatch('pet-crud', 'ownerSelected', $customer->id);
    }

    public function selectOwner($id)
    {
        $owner = Customer::find($id);

        if ($owner) {
            $this->setOwner($owner);
        }
    }
    private function setOwner(Customer $owner)
    {
        $this->owner_id = $owner->id;
        $this->owner_data = $owner->toArray();
        $this->owner_search = $owner->name;
        $this->showNewOwnerForm = false;

        $this->dispatch('ownerSelected', $owner->id);
    }
    private function resetOwner()
    {
        $this->owner_id = null;
        $this->owner_data = [];
        $this->showNewOwnerForm = false;
    }
    private function validateNewOwner()
    {
        return $this->validate([
            'new_owner.name' => 'required|string|max:255',
            'new_owner.lastname' => 'required|string|max:255',
            'new_owner.email' => 'nullable|email|unique:customers,email',
            'new_owner.phone' => 'nullable|string|max:20',
            'new_owner.address' => 'nullable|string|max:255',
            'new_owner.dni' => 'required|string|max:20|unique:customers,dni',
        ])['new_owner'];
    }

    public function render()
    {
        return view('livewire.client-search');
    }
}
