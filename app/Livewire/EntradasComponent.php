<?php

namespace App\Livewire;

use App\Models\EntradaInve;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EntradasExport;

class EntradasComponent extends Component
{
    public $entradaId, $id_product, $cantidad, $fecha, $precio_u;
    public $open = false;

    protected $rules = [
        'id_product' => 'required|exists:products,id_product',
        'cantidad' => 'required|integer|min:1',
        'fecha' => 'required|date',
        'precio_u' => 'required|numeric|min:0.01',
    ];

    public function mount()
    {
        $this->fecha = Carbon::now()->format('Y-m-d\TH:i');
    }

    public function openModal()
    {
        $this->resetInput();
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function saveEntrada()
    {
        $this->validate();

        if ($this->entradaId) {
            // Modo edición
            $entradaExistente = EntradaInve::find($this->entradaId);

            if ($entradaExistente) {
                $producto = Product::find($entradaExistente->id_product);

                // Revertir stock anterior
                $producto->current_stock -= $entradaExistente->cantidad;

                // Si el producto se cambia en la edición, ajustar el stock del nuevo producto
                if ($entradaExistente->id_product != $this->id_product) {
                    $producto->save(); // Guardamos el ajuste al producto anterior
                    $producto = Product::find($this->id_product); // Buscamos el nuevo producto
                }

                // Aplicar nuevo stock
                $producto->current_stock += $this->cantidad;
                $producto->save();

                // Actualizar entrada
                $entradaExistente->update([
                    'id_product' => $this->id_product,
                    'cantidad' => $this->cantidad,
                    'fecha' => $this->fecha,
                    'precio_u' => $this->precio_u,
                ]);
            }

            session()->flash('message', 'Entrada actualizada correctamente.');
        } else {
            // Modo creación
            EntradaInve::create([
                'id_product' => $this->id_product,
                'cantidad' => $this->cantidad,
                'fecha' => $this->fecha,
                'precio_u' => $this->precio_u,
            ]);

            $producto = Product::find($this->id_product);
            $producto->current_stock += $this->cantidad;
            $producto->save();

            session()->flash('message', 'Entrada registrada correctamente.');
        }

        $this->resetInput();
        $this->fecha = Carbon::now()->format('Y-m-d\TH:i');
        $this->open = false;
    }

    public function editEntrada($id)
    {
        $entrada = EntradaInve::findOrFail($id);

        $this->entradaId = $entrada->id_entrada;
        $this->id_product = $entrada->id_product;
        $this->cantidad = $entrada->cantidad;
        $this->fecha = Carbon::parse($entrada->fecha)->format('Y-m-d\TH:i');
        $this->precio_u = $entrada->precio_u;
        $this->open = true;
    }

    public function deleteEntrada($id)
    {
        $entrada = EntradaInve::findOrFail($id);
        $producto = Product::find($entrada->id_product);

        if ($producto) {
            $producto->current_stock -= $entrada->cantidad;
            $producto->save();
        }

        $entrada->delete();

        session()->flash('message', 'Entrada eliminada correctamente.');
    }

    private function resetInput()
    {
        $this->reset(['entradaId', 'id_product', 'cantidad', 'precio_u']);
    }

    public function exportarExcel()
    {
        return Excel::download(new EntradasExport, 'entradas.xlsx');
    }

    public function render()
    {
        return view('livewire.entradas-component', [
            'productos' => Product::all(),
            'entradas' => EntradaInve::with('producto.category', 'producto.supplier')->latest()->get(),
        ]);
    }
}
