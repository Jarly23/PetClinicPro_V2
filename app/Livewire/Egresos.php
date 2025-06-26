<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Egreso;
use App\Models\Consultation;
use App\Models\Ventas;
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

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'monto' => 'required|numeric|min:0',
        'fecha' => 'required|date',
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

    public function render()
    {
        $fecha = $this->filtroMes ? Carbon::parse($this->filtroMes) : now();

        $egresos = Egreso::whereMonth('fecha', $fecha->month)
            ->whereYear('fecha', $fecha->year)
            ->latest()
            ->paginate(10);

        // Total por servicios
        $precioConsulta = 50; // Valor fijo
        $cantidadConsultas = Consultation::whereMonth('created_at', $fecha->month)
            ->whereYear('created_at', $fecha->year)
            ->count();
        $totalServicios = $cantidadConsultas * $precioConsulta;

        // Ganancia productos
        $gananciaProductos = detalle_venta::whereHas('venta', function ($q) use ($fecha) {
            $q->whereMonth('fecha', $fecha->month)
              ->whereYear('fecha', $fecha->year);
        })
        ->join('products', 'products.id_product', '=', 'detalle_ventas.id_product')
        ->selectRaw('SUM((detalle_ventas.p_unitario - products.purchase_price) * detalle_ventas.cantidad) as ganancia')
        ->value('ganancia') ?? 0;
        
        // Egresos del mes
        $egresosMes = Egreso::whereMonth('fecha', $fecha->month)
            ->whereYear('fecha', $fecha->year)
            ->sum('monto');

        $balance = ($totalServicios + $gananciaProductos) - $egresosMes;

        return view('livewire.egresos', compact('egresos', 'totalServicios', 'gananciaProductos', 'egresosMes', 'balance'));
    }
}
