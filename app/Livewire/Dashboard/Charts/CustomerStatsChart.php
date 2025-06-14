<?php

namespace App\Livewire\Dashboard\Charts;

use Livewire\Component;
use App\Models\Customer;
use Carbon\Carbon;
class CustomerStatsChart extends Component
{
    public $timeFrame = 'weekly';

    public $weeklyData = [];
    public $monthlyData = [];
    public $yearlyData = [];

    public function mount()
    {
        $this->generateAllData();
    }

    public function changeTimeFrame($frame)
    {
        $this->timeFrame = $frame;
    }

    public function generateAllData()
    {
        $this->weeklyData = $this->getWeeklyData();
        $this->monthlyData = $this->getMonthlyData();
        $this->yearlyData = $this->getYearlyData();
    }

    private function getWeeklyData()
    {
        $start = Carbon::now()->startOfWeek();
        $labels = [];
        $data = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $start->copy()->addDays($i);
            $labels[] = $date->format('D');
            $count = Customer::whereDate('created_at', $date)->count();
            $data[] = $count;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getMonthlyData()
    {
        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::create()->month($i)->format('F');
            $labels[] = $month;
            $count = Customer::whereMonth('created_at', $i)
                ->whereYear('created_at', Carbon::now()->year)
                ->count();
            $data[] = $count;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getYearlyData()
    {
        $currentYear = Carbon::now()->year;
        $startYear = $currentYear - 4;
        $labels = [];
        $data = [];

        for ($year = $startYear; $year <= $currentYear; $year++) {
            $labels[] = $year;
            $count = Customer::whereYear('created_at', $year)->count();
            $data[] = $count;
        }

        return ['labels' => $labels, 'data' => $data];
    }
    public function render()
    {
        return view('livewire.dashboard.charts.customer-stats-chart');
    }
}
