<?php

namespace App\Livewire\Dashboard\Charts;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MonthlyConsultationsChart extends Component
{
    public $selectedYear;
    public $years = [];

    public $labels = [];
    public $data = [];

    public function mount()
    {
        $this->selectedYear = now()->year;

        $this->years = DB::table('consultations')
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        $this->loadChartData();
    }

    public function updatedSelectedYear()
    {
        $this->loadChartData();
    }

    public function loadChartData()
    {
        $monthlyIncome = DB::table('consultation_service')
            ->join('services', 'services.id', '=', 'consultation_service.service_id')
            ->join('consultations', 'consultations.id', '=', 'consultation_service.consultation_id')
            ->whereYear('consultations.created_at', $this->selectedYear)
            ->selectRaw('MONTH(consultations.created_at) as month, SUM(services.price) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $this->labels = [];
        $this->data = [];

        foreach (range(1, 12) as $month) {
            $this->labels[] = Carbon::create()->month($month)->locale('es')->translatedFormat('F');
            $this->data[] = $monthlyIncome->get($month, 0);
        }
    }
    public function render()
    {
        return view('livewire.dashboard.charts.monthly-consultations-chart');
    }
}
