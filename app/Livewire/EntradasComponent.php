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
    public $precio_actual;
    public $showUpdatePriceModal = false;  // Variable de control del modal de confirmación
    public $expiration_date;
    public $confirmingDelete = false;
    public $entradaToDelete = null;



    protected $rules = [
        'id_product' => 'required|exists:products,id_product',
        'cantidad' => 'required|integer|min:1',
        'fecha' => 'required|date',
        'precio_u' => 'required|numeric|min:0.01',
        'expiration_date' => 'nullable|date|after_or_equal:today',
    ];

    public function mount()
    {
        $this->fecha = Carbon::now()->format('Y-m-d\TH:i');
    }

    public function updatedIdProduct()
    {
        if ($this->id_product) {
            $producto = Product::find($this->id_product);
            $this->precio_actual = $producto->purchase_price;
        }
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

        // Verifica si el precio unitario difiere del precio de compra actual
        $producto = Product::find($this->id_product);

        if ($this->precio_u != $producto->purchase_price) {
            $this->open = false; // Cierra el modal de entrada inmediatamente
            $this->showUpdatePriceModal = true; // Muestra el modal de actualización de precio
        } else {
            $this->guardarEntrada($producto);
        }
    }

    // Método para guardar la entrada, ya sea actualizando el precio o no
    public function guardarEntrada($producto)
    {
        if (!$this->entradaId) {
            EntradaInve::create([
                'id_product' => $this->id_product,
                'cantidad' => $this->cantidad,
                'fecha' => $this->fecha,
                'precio_u' => $this->precio_u,
                'expiration_date' => $this->expiration_date,
            ]);

            $producto->increment('current_stock', $this->cantidad);

            session()->flash('message', 'Entrada registrada correctamente.');
        } else {
            $entradaExistente = EntradaInve::find($this->entradaId);
            $productoAnterior = Product::find($entradaExistente->id_product);
            $productoAnterior->decrement('current_stock', $entradaExistente->cantidad);

            if ($entradaExistente->id_product != $this->id_product) {
                $productoAnterior->save();
                $producto = Product::find($this->id_product);
            }

            $producto->increment('current_stock', $this->cantidad);

            $entradaExistente->update([
                'id_product' => $this->id_product,
                'cantidad' => $this->cantidad,
                'fecha' => $this->fecha,
                'precio_u' => $this->precio_u,
                'expiration_date' => $this->expiration_date,
            ]);

            session()->flash('message', 'Entrada actualizada correctamente.');
        }

        $this->resetInput();
        $this->fecha = Carbon::now()->format('Y-m-d\TH:i');
        $this->open = false; // Cierra el modal de registro de entrada
    }

    public function updatePrice()
    {
        $producto = Product::find($this->id_product);

        // Actualiza el precio de compra si el usuario aceptó
        $producto->update([
            'purchase_price' => $this->precio_u
        ]);

        // Guarda la entrada con el nuevo precio
        $this->guardarEntrada($producto);

        $this->showUpdatePriceModal = false;  // Cierra el modal de actualización de precio
        $this->open = false;  // Cierra el modal de registro
    }

    public function cancelUpdatePrice()
    {
        $this->showUpdatePriceModal = false;  // Cierra el modal de actualización de precio
    }

    public function editEntrada($id)
    {
        $entrada = EntradaInve::findOrFail($id);

        $this->entradaId = $entrada->id_entrada;
        $this->id_product = $entrada->id_product;
        $this->cantidad = $entrada->cantidad;
        $this->fecha = Carbon::parse($entrada->fecha)->format('Y-m-d\TH:i');
        $this->precio_u = $entrada->precio_u;
        $this->precio_actual = Product::find($this->id_product)->purchase_price;
        $this->expiration_date = Carbon::parse($entrada->expiration_date)->format('Y-m-d');
        $this->open = true;
    }

   public function deleteEntrada()
    {
        $entrada = EntradaInve::findOrFail($this->entradaToDelete);
        $producto = Product::find($entrada->id_product);

        if ($producto) {
            $producto->decrement('current_stock', $entrada->cantidad);
        }

        $entrada->delete();

        session()->flash('message', 'Entrada eliminada correctamente.');

        $this->confirmingDelete = false;
        $this->entradaToDelete = null;
    }


    private function resetInput()
    {
        $this->reset(['entradaId', 'id_product', 'cantidad', 'precio_u', 'precio_actual','expiration_date']);
    }

    public function exportarExcel()
    {
        return Excel::download(new EntradasExport, 'entradas.xlsx');
    }
        public function confirmDeleteEntrada($id)
    {
        $this->entradaToDelete = $id;
        $this->confirmingDelete = true;
    }


    public function render()
    {
        return view('livewire.entradas-component', [
            'productos' => Product::all(),
            'entradas' => EntradaInve::with('product.category', 'product.supplier')->latest()->get(),
        ]);
    }
}
