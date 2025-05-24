<?php

namespace App\Livewire\Pets;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pet;
use App\Models\Customer;
use App\Models\AnimalType;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    protected $listeners = ['refreshPets' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function edit($petId)
    {
        $this->dispatch('editPet', petId: $petId);
    }

    public function delete($petId)
    {
        $this->dispatch('deletePet', petId: $petId);
    }
    public function render()
    {
        $pets = Pet::with(['owner', 'animaltype'])
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhereHas('animaltype', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->orWhere('breed', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        return view('livewire.pets.index', [
            'pets' => $pets,
        ]);
    }
}
