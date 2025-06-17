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
    public $typeFilter = '';
    public $ownerFilter = '';

    public $results = [];

    protected $listeners = ['refreshPets' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->results = Pet::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->typeFilter, fn($q) => $q->where('animal_type_id', $this->typeFilter))
            ->when($this->ownerFilter, fn($q) => $q->where('owner_id', $this->ownerFilter))
            ->with('owner')
            ->limit(10)
            ->get();
    }

    public function selectSuggestion($name)
    {
        $this->search = $name;
        $this->updatedSearch();
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
            ->when(
                $this->search,
                fn($q) =>
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('animaltype', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                    ->orWhere('breed', 'like', '%' . $this->search . '%')
            )
            ->when($this->typeFilter, fn($q) => $q->where('animal_type_id', $this->typeFilter))
            ->when($this->ownerFilter, fn($q) => $q->where('owner_id', $this->ownerFilter))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.pets.index', [
            'pets' => $pets,
            'animalTypes' => AnimalType::all(),
            'customers' => Customer::all(),
        ]);
    }
}
