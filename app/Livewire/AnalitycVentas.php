<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Sale;
use App\Models\InventoryEntry;
use App\Models\InventoryExit;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class AnalitycVentas extends Component
{
    public $totalProducts;
    public $lowStockProducts;
    public $totalSales;
    public $entriesToday;
    public $exitsToday;
    public $salesChart;

    public function mount()
    {
        // Total de productos
        $this->totalProducts = Product::count();

        // Productos con stock bajo
        $this->lowStockProducts = Product::where('current_stock', '<', 10)->count(); // Asumimos que 10 es el mínimo

        // Total de ventas hoy
        $this->totalSales = Sale::whereDate('created_at', today())->sum('total');

        // Entradas y salidas de productos hoy
        $this->entriesToday = InventoryEntry::whereDate('created_at', today())->count();
        $this->exitsToday = InventoryExit::whereDate('created_at', today())->count();

        // Crear un gráfico de ventas por mes
        $salesData = Sale::selectRaw('MONTH(created_at) as month, sum(total) as total')
                         ->groupBy('month')
                         ->orderBy('month')
                         ->get();
                         
        $chart = new Chart();
        $chart->labels($salesData->pluck('month')->toArray())
              ->dataset('Ventas por Mes', 'line', $salesData->pluck('total')->toArray())
              ->color('#3490dc')
              ->backgroundColor('rgba(52, 144, 220, 0.2)');

        $this->salesChart = $chart;
    }

    public function render()
    {
        return view('livewire.analityc-ventas');
    }
}
