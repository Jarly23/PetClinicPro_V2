<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Disease;


class ManageDiseases extends Component
{
        public $name, $disease_id, $editMode = false;

    public function save()
    {
        $this->validate(['name' => 'required|string']);

        if ($this->editMode) {
            Disease::find($this->disease_id)->update(['name' => $this->name]);
        } else {
            Disease::create(['name' => $this->name]);
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $disease = Disease::find($id);
        $this->disease_id = $disease->id;
        $this->name = $disease->name;
        $this->editMode = true;
    }

    public function delete($id)
    {
        Disease::find($id)->delete();
    }

    public function resetForm()
    {
        $this->reset(['name', 'disease_id', 'editMode']);
    }

    public function render()
    {
        return view('livewire.manage-diseases',[
            'diseases' => Disease::orderBy('name')->get()
        ]);
    }
}
