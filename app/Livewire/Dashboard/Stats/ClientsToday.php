<?php

namespace App\Livewire\Dashboard\Stats;

use Livewire\Component;
use App\Models\Customer;
use Carbon\Carbon;
class ClientsToday extends Component
{
    public $title = 'Clientes hoy';
    public $icon = 'images/icons/user-group.svg'; // ícono personalizado
    public $secondIcon;
    public $value;
    public $additionalData;

    public function mount()
    {
        $hoy = Customer::whereDate('created_at', Carbon::today())->count();
        $ayer = Customer::whereDate('created_at', Carbon::yesterday())->count();
        $cambio = $hoy - $ayer;
        $porcentaje = $ayer > 0 ? ($cambio / $ayer) * 100 : 0;

        $this->value = $hoy;
        $this->secondIcon = $cambio > 0
            ? 'images/icons/VectorArrowUp.svg'
            : ($cambio < 0
                ? 'images/icons/VectorArrowDown.svg'
                : 'images/icons/VectorArrowRight.svg');

        $this->additionalData = $cambio !== 0
            ? number_format(abs($porcentaje), 2) . '% respecto a ayer'
            : 'Sin cambio respecto a ayer';
    }

    public function render()
    {
        return view('livewire.dashboard.stats.clients-today');
    }
}
