<?php

namespace App\Livewire\Web;

use Livewire\Component;
use App\Models\Veterinarian;
class ShowVeterinans extends Component
{
    public function render()
    {
        $veterinarians = Veterinarian::all();
        return view('livewire.web.show-veterinans',compact('veterinarians'));
    }
}
