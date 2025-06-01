<?php

namespace App\Livewire\Dashboard\Stats;

use App\Models\Pet;
use Livewire\Component;
use Carbon\Carbon;

class PetsTotal extends Component
{
    public $title = 'Mascotas totales';
    public $icon = 'images/icons/user-group.svg';
    public $secondIcon;
    public $value; // Total de clientes
    public $additionalData; // Nuevos hoy

    public function mount()
    {
        $totalMascotas = Pet::count();
        $nuevosHoy = Pet::whereDate('created_at', Carbon::today())->count();

        $this->value = $totalMascotas;

        $this->secondIcon = $nuevosHoy > 0
            ? 'images/icons/VectorArrowUp.svg'
            : 'images/icons/VectorArrowRight.svg';

        $this->additionalData = $nuevosHoy > 0
            ? "$nuevosHoy nuevo(s) hoy"
            : 'No hubo nuevos clientes hoy';
    }
    public function render()
    {
        return view('livewire.dashboard.stats.pets-total');
    }
}
