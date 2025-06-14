<?php

namespace App\Livewire\Dashboard\Stats;

use Livewire\Component;
use App\Models\Consultation;
use Carbon\Carbon;
class ServicesToday extends Component
{
    public $title = 'Total de Servicios Realizados';
    public $icon = 'images/icons/briefcase.svg';
    public $secondIcon;
    public $value; // Total de consultas
    public $additionalData; // Nuevas hoy

    public function mount()
    {
        $total = Consultation::count();
        $hoy = Consultation::whereDate('created_at', Carbon::today())->count();

        $this->value = $total;

        $this->secondIcon = $hoy > 0
            ? 'images/icons/VectorArrowUp.svg'
            : 'images/icons/VectorArrowDown.svg';

        $this->additionalData = $hoy > 0
            ? "$hoy servicio(s) hoy"
            : 'No hubo servicios hoy';
    }
    public function render()
    {
        return view('livewire.dashboard.stats.services-today');
    }
}
