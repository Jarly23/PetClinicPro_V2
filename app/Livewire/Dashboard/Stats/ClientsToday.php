<?php

namespace App\Livewire\Dashboard\Stats;

use Livewire\Component;
use App\Models\Customer;
use Carbon\Carbon;
class ClientsToday extends Component
{
    public $title = 'Clientes totales';
    public $icon = 'images/icons/user-group.svg';
    public $secondIcon;
    public $value; // Total de clientes
    public $additionalData; // Nuevos hoy

    public function mount()
    {
        $totalClientes = Customer::count();
        $nuevosHoy = Customer::whereDate('created_at', Carbon::today())->count();

        $this->value = $totalClientes;

        $this->secondIcon = $nuevosHoy > 0
            ? 'images/icons/VectorArrowUp.svg'
            : 'images/icons/VectorArrowDown.svg';

        $this->additionalData = $nuevosHoy > 0
            ? "$nuevosHoy nuevo(s) hoy"
            : 'No hubo nuevos clientes hoy';
    }

    public function render()
    {
        return view('livewire.dashboard.stats.clients-today');
    }
}
