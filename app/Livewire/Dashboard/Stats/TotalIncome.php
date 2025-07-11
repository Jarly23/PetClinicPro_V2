<?php

namespace App\Livewire\Dashboard\Stats;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;
class TotalIncome extends Component
{
    public $title = 'Ingresos Totales';
    public $icon = 'images/icons/dollar.svg';
    public $value;

    public $recentLabels = [];
    public $recentData = [];
    public $recentConsultations = [];

    public function mount()
    {
        $this->calculateTotalIncome();
        $this->loadRecentIncomeData();
    }

    public function calculateTotalIncome()
    {
        $this->value = DB::table('consultation_service')
            ->join('services', 'services.id', '=', 'consultation_service.service_id')
            ->join('consultations', 'consultations.id', '=', 'consultation_service.consultation_id')
            ->sum('services.price');
    }

    public function loadRecentIncomeData()
    {
        // Mini gráfico diario de los últimos 7 días
        $incomes = DB::table('consultation_service')
            ->join('services', 'services.id', '=', 'consultation_service.service_id')
            ->join('consultations', 'consultations.id', '=', 'consultation_service.consultation_id')
            ->where('consultations.consultation_date', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(consultations.consultation_date) as date, SUM(services.price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $this->recentLabels = [];
        $this->recentData = [];

        foreach (range(6, 0) as $i) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $this->recentLabels[] = Carbon::parse($date)->translatedFormat('D d');
            $this->recentData[] = $incomes->get($date, 0);
        }

        // Lista de últimas 5 consultas
        $this->recentConsultations = DB::table('consultation_service')
            ->join('services', 'services.id', '=', 'consultation_service.service_id')
            ->join('consultations', 'consultations.id', '=', 'consultation_service.consultation_id')
            ->select('services.name as service_name', 'services.price', 'consultations.consultation_date')
            ->orderBy('consultations.consultation_date', 'desc')
            ->limit(5)
            ->get();
    }
    public function render()
    {
        return view('livewire.dashboard.stats.total-income');
    }
}
