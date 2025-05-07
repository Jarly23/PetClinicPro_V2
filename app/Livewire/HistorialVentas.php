<?php

namespace App\Livewire;

use App\Models\Ventas;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VentasExport;

class HistorialVentas extends Component
{
    public $ventas;
    public $ventaSeleccionada;
    public $ventaAEliminar = null; // 🆕 Para el modal de confirmación
    public $filtroFecha = 'todas';
    public $fechaInicio;
    public $fechaFin;
    public $busquedaCliente = '';

    public function mount()
    {
        $this->filtrar();
    }

    public function aplicarFiltroFechas()
    {
        $this->filtrar();
    }

    public function buscarCliente()
    {
        $this->filtrar();
    }

    public function filtrar()
    {
        $query = Ventas::with(['cliente', 'detalles.producto']);

        if ($this->filtroFecha === 'hoy') {
            $query->whereDate('fecha', Carbon::today());
        } elseif ($this->filtroFecha === 'ayer') {
            $query->whereDate('fecha', Carbon::yesterday());
        } elseif ($this->filtroFecha === 'rango' && $this->fechaInicio && $this->fechaFin) {
            $query->whereBetween('fecha', [$this->fechaInicio, $this->fechaFin]);
        }

        if ($this->busquedaCliente) {
            $query->whereHas('cliente', function ($q) {
                $q->where('name', 'like', '%' . $this->busquedaCliente . '%')
                  ->orWhere('lastname', 'like', '%' . $this->busquedaCliente . '%');
            });
        }

        $this->ventas = $query->orderBy('fecha', 'desc')->get();
    }

    public function verDetalles($idVenta)
    {
        $this->ventaSeleccionada = Ventas::with(['cliente', 'detalles.producto'])->find($idVenta);
    }

    public function cerrarModal()
    {
        $this->ventaSeleccionada = null;
        $this->ventaAEliminar = null;
    }

    public function confirmarEliminar($idVenta)
    {
        $this->ventaAEliminar = $idVenta;
    }

    public function eliminarVenta($idVenta)
    {
        $venta = Ventas::with('detalles.producto')->find($idVenta);

        if (!$venta) {
            session()->flash('error', 'La venta no existe.');
            return;
        }

        foreach ($venta->detalles as $detalle) {
            if ($detalle->producto) {
                $detalle->producto->current_stock += $detalle->cantidad;
                $detalle->producto->save();
            }
        }

        $venta->detalles()->delete();
        $venta->delete();

        $this->filtrar();
        $this->ventaAEliminar = null;

        session()->flash('success', 'Venta eliminada y stock restaurado correctamente.');
    }
    public function exportarExcel()
    {
    return Excel::download(new VentasExport($this->ventas), 'ventas.xlsx');
    }

    public function render()
    {
        return view('livewire.historial-ventas');
    }
}
