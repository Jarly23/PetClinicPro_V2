<?php

namespace App\Livewire\Pets;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pet;
use Illuminate\Support\Facades\Storage;

class Detail extends Component
{
    use WithFileUploads;

    public $pet;
    public $photo;
    public function mount(Pet $pet)
    {
        $this->pet = $pet;
    }
    public function savePhoto()
    {
        // Validar y guardar la foto si se sube una nueva
        if ($this->photo) {
            $this->validate([
                'photo' => 'image|max:2048', // Tamaño máximo 2MB
            ]);

            // Guardar la foto en la carpeta 'pets'
            $path = $this->photo->store('pets', 'public');

            // Actualizar el registro de la mascota con la nueva foto
            $this->pet->update(['photo' => $path]);

            session()->flash('message', 'Foto actualizada correctamente.');
        }
    }
    public function render()
    {
        return view('livewire.pets.detail');
    }
}
