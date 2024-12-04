<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Veterinarian;
use Livewire\WithFileUploads;

class VeterinarianCrud extends Component
{
    use WithFileUploads;

    public $open = false;
    public $veterinarian_id, $name, $phone, $email, $specialty, $photo;
    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'required|digits:9',  // Validación para que tenga 9 dígitos
        'email' => 'required|email|max:255',  // Validación de correo
        'specialty' => 'required|string|max:255',
        'photo' => 'nullable|image|max:1024', // Validación para la foto
    ];
    

    public function render()
    {
        $veterinarians = Veterinarian::all();
        return view('livewire.veterinarian-crud', compact('veterinarians'));

    }
    public function save()
    {
        $this->validate(); // Validación

        // Guardar la foto si se ha subido
        $photoPath = null;
        if ($this->photo) {
            $photoPath = $this->photo->store('photos', 'public'); // Guardar la foto en 'public/photos'
        }

        if ($this->veterinarian_id) {
            $veterinarian = Veterinarian::find($this->veterinarian_id);
            $veterinarian->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'specialty' => $this->specialty,
                'photo' => $photoPath, // Actualizar la foto
            ]);
        } else {
            // Guardar el nuevo veterinario
            Veterinarian::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'specialty' => $this->specialty,
                'photo' => $photoPath, // Guardar la foto si se ha subido
            ]);
        }

        $this->resetForm();
        $this->open = false;
    }

    public function edit($id)
    {
        $veterinarian = Veterinarian::find($id);
        $this->veterinarian_id = $veterinarian->id;
        $this->name = $veterinarian->name;
        $this->phone = $veterinarian->phone;
        $this->email = $veterinarian->email;
        $this->specialty = $veterinarian->specialty;
        $this->photo = $veterinarian->photo;
        $this->open = true;
    }

    public function delete($id)
    {
        $veterinarian = Veterinarian::find($id);
        $veterinarian->delete();
    }

    private function resetForm()
    {
        $this->veterinarian_id = null;
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->specialty = '';
        $this->photo = '';
    }
}
