<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Ventas;
use App\Models\EntradaInve;
use App\Models\detalle_venta;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Supplier;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\DB;


class ControlVentas extends Component
{
    public $totalProducts;
    public $lowStockProducts;
    public $totalSalesToday;
    public $entriesToday;
    public $exitsToday;
    public $entryProductsToday;
    public $exitProductsToday;
    public $productsWithStock;

    public $ventasPorMesLabels;
    public $ventasPorMesData;
    public $categoryLabels;
    public $categoryTotals;
    public $dailySalesLabels;
    public $dailySalesData;
    public $topSellingProducts;
    public $totalSalesMonth;
    public $totalPurchasesMonth;
    public $stockTotal;
    public $topCustomers;
    public $topSuppliers;
    public $supplierLabels;
    public $supplierCounts;
    

    public function mount()
    {
        $this->totalProducts = Product::count();
        $this->totalPurchasesMonth = EntradaInve::whereMonth('fecha', Carbon::now()->month)
        ->selectRaw('SUM(cantidad * precio_u) as total')
        ->value('total');
        $this->stockTotal = Product::sum('current_stock');
        $this->totalSalesMonth = Ventas::whereMonth('fecha', Carbon::now()->month)->sum('total');

        $this->lowStockProducts = Product::whereColumn('current_stock', '<=', 'minimum_stock')->count();
        $this->totalSalesToday = Ventas::whereDate('fecha', Carbon::today())->sum('total');
        $this->entriesToday = EntradaInve::whereDate('fecha', Carbon::today())->sum('cantidad');
        $this->exitsToday = detalle_venta::whereHas('venta', function ($query) {
            $query->whereDate('fecha', Carbon::today());
        })->sum('cantidad');

        $this->entryProductsToday = EntradaInve::whereDate('fecha', Carbon::today())
            ->with('product')
            ->get();

        $this->exitProductsToday = detalle_venta::whereHas('venta', function ($query) {
                $query->whereDate('fecha', Carbon::today());
            })
            ->with('product')
            ->get();
        $this->productsWithStock = Product::select('name', 'current_stock')->get();

        $ventasPorMes = Ventas::selectRaw('MONTH(fecha) as month, SUM(total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $this->ventasPorMesLabels = $ventasPorMes->keys()
            ->map(fn($month) => Carbon::create()->month($month)->format('F'))
            ->toArray();

        $this->ventasPorMesData = $ventasPorMes->values()->toArray();
        $this->buildCategorySalesChart();
        $this->buildDailySalesChart();
        

        $this->topSellingProducts = detalle_venta::select('id_product', DB::raw('SUM(cantidad) as total_vendido'))
        ->groupBy('id_product')
        ->orderByDesc('total_vendido')
        ->with('product') // Trae la info del producto
        ->take(10)
        ->get();
        
         $this->topCustomers = Customer::withCount('ventas')
        ->orderBy('ventas_count', 'desc')
        ->take(5)
        ->get();

        $topSuppliers = Supplier::withCount('products')
        ->orderBy('products_count', 'desc')
        ->take(10)
        ->get();

        $this->supplierLabels = $topSuppliers->pluck('name')->toArray();
        $this->supplierCounts = $topSuppliers->pluck('products_count')->toArray();



    }

    protected function buildSalesChart()
    {
    $salesPerMonth = Ventas::selectRaw('MONTH(fecha) as month, SUM(total) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    $chart = new Chart();
    $chart->labels($salesPerMonth->keys()->map(fn($month) => Carbon::create()->month($month)->format('F')));
    $chart->dataset('Ventas', 'bar', $salesPerMonth->values())->backgroundColor('#6366F1');

    return $chart;
    }


    protected function buildCategorySalesChart()
    {
        $categorySales = detalle_venta::join('products', 'detalle_ventas.id_product', '=', 'products.id_product')
            ->join('categories', 'products.id_category', '=', 'categories.id_category')
            ->selectRaw('categories.name as category, SUM(detalle_ventas.cantidad * detalle_ventas.p_unitario) as total')
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->pluck('total', 'category');

        $this->categoryLabels = $categorySales->keys()->toArray();
        $this->categoryTotals = $categorySales->values()->toArray();
    }


   protected function buildDailySalesChart()
    {
    $dailySales = collect();
    $labels = collect();

    // Últimos 7 días (de más antiguo a hoy)
    foreach (range(6, 0) as $i) {
        $date = Carbon::today()->subDays($i);
        $total = Ventas::whereDate('fecha', $date)->sum('total');
        $labels->push($date->format('d M')); // Ej: "14 May"
        $dailySales->push($total);
    }

    // Asignamos los datos a propiedades públicas para usarlas en la vista
    $this->dailySalesLabels = $labels->toArray();
    $this->dailySalesData = $dailySales->toArray();
    }



    public function render()
    {
    $salesChart = $this->buildSalesChart();
    $categorySalesChart = $this->buildCategorySalesChart();
    $dailySalesChart = $this->buildDailySalesChart();

    return view('livewire.control-ventas', compact('salesChart', 'categorySalesChart', 'dailySalesChart'));
    }

}
