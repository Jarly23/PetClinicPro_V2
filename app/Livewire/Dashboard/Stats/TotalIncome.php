<?php

namespace App\Livewire\Dashboard\Stats;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TotalIncome extends Component
{
    public $title = 'Ingresos Totales';
    public $icon = 'images/icons/dollar.svg';
    public $value;

    public function mount()
    {
        $this->calculateTotalIncome();
    }

    public function calculateTotalIncome()
    {
        $this->value = DB::table('consultation_service')
            ->join('services', 'services.id', '=', 'consultation_service.service_id')
            ->join('consultations', 'consultations.id', '=', 'consultation_service.consultation_id')
            ->sum('services.price');
    }
    public function render()
    {
        return view('livewire.dashboard.stats.total-income');
    }
}
