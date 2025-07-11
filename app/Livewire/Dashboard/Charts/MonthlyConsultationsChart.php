<?php

namespace App\Livewire\Dashboard\Charts;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MonthlyConsultationsChart extends Component
{
    public $labels = [];
    public $data = [];

    public function mount()
    {
        $this->loadChartData();
    }

    public function loadChartData()
    {
        $yearlyIncome = DB::table('consultation_service')
            ->join('services', 'services.id', '=', 'consultation_service.service_id')
            ->join('consultations', 'consultations.id', '=', 'consultation_service.consultation_id')
            ->selectRaw('YEAR(consultations.consultation_date) as year, SUM(services.price) as total')
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('total', 'year');

        $this->labels = $yearlyIncome->keys()->toArray();
        $this->data = $yearlyIncome->values()->toArray();
    }
    public function render()
    {
        return view('livewire.dashboard.charts.monthly-consultations-chart');
    }
}
