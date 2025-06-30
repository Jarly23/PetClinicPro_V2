<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Egreso;
use App\Models\Consultation;
use App\Models\detalle_venta;
use Carbon\Carbon;

class Egresos extends Component
{
    use WithPagination;

    public $open = false;
    public $confirmingDelete = false;
    public $egresoToDelete = null;
    public $nombre, $descripcion, $monto, $fecha, $egresoId;
    public $filtroMes; // <-- filtro mensual
    public $balance;
    protected $rules = [
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string|max:1000',
        'monto' => 'required|numeric|min:0.01',
        'fecha' => 'required|date|before_or_equal:today',
    ];

    protected $messages = [
        'nombre.required' => 'El nombre del egreso es obligatorio.',
        'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
        'descripcion.max' => 'La descripción no puede tener más de 1000 caracteres.',
        'monto.required' => 'El monto es obligatorio.',
        'monto.numeric' => 'El monto debe ser un número válido.',
        'monto.min' => 'El monto debe ser mayor a 0.',
        'fecha.required' => 'La fecha es obligatoria.',
        'fecha.date' => 'La fecha debe tener un formato válido.',
        'fecha.before_or_equal' => 'La fecha no puede ser futura.',
    ];

    public function openModal()
    {
        $this->resetFields();
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function save()
    {
        $this->validate();

        Egreso::updateOrCreate(
            ['id' => $this->egresoId],
            [
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'monto' => $this->monto,
                'fecha' => $this->fecha,
            ]
        );

        $this->resetFields();
        $this->open = false;

        session()->flash('message', 'Egreso guardado correctamente.');
    }

    public function edit($id)
    {
        $egreso = Egreso::findOrFail($id);
        $this->egresoId = $id;
        $this->nombre = $egreso->nombre;
        $this->descripcion = $egreso->descripcion;
        $this->monto = $egreso->monto;
        $this->fecha = $egreso->fecha->format('Y-m-d');

        $this->open = true;
    }

    public function confirmDelete($id)
    {
        $this->egresoToDelete = $id;
        $this->confirmingDelete = true;
    }

    public function delete()
    {
        Egreso::destroy($this->egresoToDelete);
        $this->confirmingDelete = false;
        $this->egresoToDelete = null;

        session()->flash('message', 'Egreso eliminado.');
    }

    public function resetFields()
    {
        $this->reset(['nombre', 'descripcion', 'monto', 'fecha', 'egresoId']);
    }

    public function getEstadisticasBalance()
    {
        $fecha = $this->filtroMes ? Carbon::parse($this->filtroMes) : now();
        
        // Estadísticas del mes anterior para comparación
        $mesAnterior = $fecha->copy()->subMonth();
        
        $serviciosMesAnterior = Consultation::whereMonth('created_at', $mesAnterior->month)
            ->whereYear('created_at', $mesAnterior->year)
            ->with('services')
            ->get()
            ->sum(function ($consultation) {
                return $consultation->services->sum('price');
            });

        $gananciaProductosMesAnterior = detalle_venta::whereHas('venta', function ($q) use ($mesAnterior) {
            $q->whereMonth('fecha', $mesAnterior->month)
              ->whereYear('fecha', $mesAnterior->year);
        })
        ->join('products', 'products.id_product', '=', 'detalle_ventas.id_product')
        ->selectRaw('SUM((detalle_ventas.p_unitario - products.purchase_price) * detalle_ventas.cantidad) as ganancia')
        ->value('ganancia') ?? 0;

        $egresosMesAnterior = Egreso::totalPorPeriodo($mesAnterior->month, $mesAnterior->year);
        $balanceMesAnterior = ($serviciosMesAnterior + $gananciaProductosMesAnterior) - $egresosMesAnterior;

        return [
            'mes_actual' => $fecha->format('F Y'),
            'mes_anterior' => $mesAnterior->format('F Y'),
            'balance_mes_anterior' => $balanceMesAnterior,
            'diferencia' => $this->balance - $balanceMesAnterior,
            'tendencia' => $this->balance > $balanceMesAnterior ? 'positiva' : 'negativa'
        ];
    }

    public function exportarEgresos()
    {
        $fecha = $this->filtroMes ? Carbon::parse($this->filtroMes) : now();
        
        $egresos = Egreso::porMes($fecha->month, $fecha->year)
            ->orderBy('fecha')
            ->get();

        $filename = 'egresos_' . $fecha->format('Y_m') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($egresos) {
            $file = fopen('php://output', 'w');
            
            // Encabezados CSV
            fputcsv($file, ['Fecha', 'Nombre', 'Descripción', 'Monto']);
            
            // Datos
            foreach ($egresos as $egreso) {
                fputcsv($file, [
                    $egreso->fecha->format('d/m/Y'),
                    $egreso->nombre,
                    $egreso->descripcion,
                    number_format($egreso->monto, 2)
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function limpiarFiltro()
    {
        $this->filtroMes = null;
    }

    public function getEvolucionMensual()
    {
        $year = now()->year;
        $meses = range(1, 12);

        $servicios = [];
        $gananciaProductos = [];
        $egresos = [];
        $balance = [];

        foreach ($meses as $mes) {
            // Servicios
            $totalServicios = \App\Models\Consultation::whereMonth('created_at', $mes)
                ->whereYear('created_at', $year)
                ->with('services')
                ->get()
                ->sum(function ($consultation) {
                    return $consultation->services->sum('price');
                });

            // Ganancia productos
            $ganancia = \App\Models\detalle_venta::whereHas('venta', function ($q) use ($mes, $year) {
                    $q->whereMonth('fecha', $mes)
                      ->whereYear('fecha', $year);
                })
                ->join('products', 'products.id_product', '=', 'detalle_ventas.id_product')
                ->selectRaw('SUM((detalle_ventas.p_unitario - products.purchase_price) * detalle_ventas.cantidad) as ganancia')
                ->value('ganancia') ?? 0;

            // Egresos
            $egresosMes = \App\Models\Egreso::porMes($mes, $year)->sum('monto');

            // Balance
            $balanceMes = ($totalServicios + $ganancia) - $egresosMes;

            $servicios[] = round($totalServicios, 2);
            $gananciaProductos[] = round($ganancia, 2);
            $egresos[] = round($egresosMes, 2);
            $balance[] = round($balanceMes, 2);
        }

        return [
            'labels' => array_map(function($m) { return \Carbon\Carbon::create()->month($m)->translatedFormat('F'); }, $meses),
            'servicios' => $servicios,
            'gananciaProductos' => $gananciaProductos,
            'egresos' => $egresos,
            'balance' => $balance,
        ];
    }

    public function render()
    {
        $fecha = $this->filtroMes ? Carbon::parse($this->filtroMes) : now();

        $egresos = Egreso::porMes($fecha->month, $fecha->year)
            ->latest()
            ->paginate(10);

        $precioConsulta = 50; // Valor fijo
        $cantidadConsultas = Consultation::whereMonth('created_at', $fecha->month)

        // Total por servicios - Calculamos el precio real de los servicios prestados
        $totalServicios = Consultation::whereMonth('created_at', $fecha->month)

            ->whereYear('created_at', $fecha->year)
            ->with('services')
            ->get()
            ->sum(function ($consultation) {
                return $consultation->services->sum('price');
            });


        // Ganancia productos - Optimizamos la consulta

        $gananciaProductos = detalle_venta::whereHas('venta', function ($q) use ($fecha) {
            $q->whereMonth('fecha', $fecha->month)
              ->whereYear('fecha', $fecha->year);
        })
        ->join('products', 'products.id_product', '=', 'detalle_ventas.id_product')
        ->selectRaw('SUM((detalle_ventas.p_unitario - products.purchase_price) * detalle_ventas.cantidad) as ganancia')
        ->value('ganancia') ?? 0;


        $egresosMes = Egreso::whereMonth('fecha', $fecha->month)
            ->whereYear('fecha', $fecha->year)
            ->sum('monto');

        
        // Egresos del mes usando el método del modelo
        $egresosMes = Egreso::totalPorPeriodo($fecha->month, $fecha->year);

        $this->balance = ($totalServicios + $gananciaProductos) - $egresosMes;
        $balance = $this->balance;
        $estadisticas = $this->getEstadisticasBalance();


        // Evolución mensual para el gráfico
        $evolucion = $this->getEvolucionMensual();

        return view('livewire.egresos', compact(
            'egresos', 
            'totalServicios', 
            'gananciaProductos', 
            'egresosMes', 
            'balance',
            'estadisticas',
            'evolucion'
        ));
    }
}
