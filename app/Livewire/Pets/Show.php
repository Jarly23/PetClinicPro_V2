<?php

namespace App\Livewire\Pets;

use Livewire\Component;
use App\Models\Pet;

class Show extends Component
{
    public Pet $pet;
    public string $tab = 'details';

    public function mount(Pet $pet)
    {
        $this->pet = $pet;
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
    }
    public function render()
    {
        return view('livewire.pets.show' );
    }
}
