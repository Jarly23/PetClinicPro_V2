<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Ventas;
use App\Models\detalle_venta;
use Livewire\Component;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class NotaVenta extends Component
{
    public $clientes;
    public $productos;
    
    public $tipo_cliente = ''; 
    public $cliente_id;
    public $nuevo_cliente_nombre;
    public $nuevo_cliente_apellido;
    public $nuevo_cliente_email;
    public $nuevo_cliente_phone;
    public $nuevo_cliente_dniruc;
    public $nuevo_cliente_address;
    public $nuevo_cliente_tipo_documento;
    public $nuevo_cliente_documento;

    public $numero_factura;
    public $fecha;
    
    public $producto_id;
    public $cantidad;

    public $productos_seleccionados = [];
    public $total_venta = 0;

    public function mount()
    {
        $this->clientes = Customer::all();
        $this->productos = Product::with('category')->get();
        $this->numero_factura = Ventas::max('id_venta') + 1;
        $this->fecha = Carbon::now()->format('Y-m-d\TH:i');
    }

    public function agregarProducto()
    {
    $producto = Product::with('category')->find($this->producto_id);

    // Verificar si el producto existe
    if (!$producto || !$this->cantidad || $this->cantidad <= 0) {
        session()->flash('message', 'Seleccione un producto válido y cantidad mayor a cero.');
        return;
    }

    // Verificar si hay suficiente stock
    if ($producto->current_stock < $this->cantidad) {
        session()->flash('message', 'No hay suficiente stock disponible para este producto.');
        return;
    }

    // Calcular el total del producto seleccionado
    $total_producto = $producto->sale_price * $this->cantidad;

    // Agregar el producto al array de productos seleccionados
    $this->productos_seleccionados[] = [
        'producto' => $producto,
        'cantidad' => $this->cantidad,
        'total' => $total_producto
    ];

    // Limpiar los campos de entrada
    $this->producto_id = null;
    $this->cantidad = null;

    // Calcular el total de la venta
    $this->calcularTotalVenta();
    }



    public function eliminarProducto($id)
    {
        $this->productos_seleccionados = array_filter($this->productos_seleccionados, function ($item) use ($id) {
            return $item['producto']->id_product != $id;
        });

        $this->calcularTotalVenta();
    }

    public function calcularTotalVenta()
    {
        $this->total_venta = array_sum(array_column($this->productos_seleccionados, 'total'));
    }

    public function guardarVenta()
    {
    // Si el tipo de cliente es "nuevo"
    if ($this->tipo_cliente === 'nuevo') {
        // Validar los campos del cliente nuevo
        $validatedData = $this->validate([
            'nuevo_cliente_nombre' => 'required|string|max:255',
            'nuevo_cliente_apellido' => 'required|string|max:255',
            'nuevo_cliente_email' => 'required|email|max:255',
            'nuevo_cliente_phone' => 'required|string|max:15',
            'nuevo_cliente_dniruc' => 'required|string|max:20',
            'nuevo_cliente_address' => 'required|string|max:255',
            'nuevo_cliente_tipo_documento' => 'required|string',
            'nuevo_cliente_documento' => 'required|string|max:20',
        ]);

        // Crear un nuevo cliente
        $cliente = Customer::create([
            'name' => $this->nuevo_cliente_nombre,
            'lastname' => $this->nuevo_cliente_apellido,
            'email' => $this->nuevo_cliente_email,
            'phone' => $this->nuevo_cliente_phone,
            'dniruc' => $this->nuevo_cliente_dniruc,
            'address' => $this->nuevo_cliente_address,
            'tipo_documento' => $this->nuevo_cliente_tipo_documento,
            'documento' => $this->nuevo_cliente_documento,
        ]);

        $this->cliente_id = $cliente->id; // Guardar el ID del cliente recién creado
    }

    // Verificar que haya un cliente seleccionado y productos seleccionados
    if (!$this->cliente_id || !$this->productos_seleccionados) {
        session()->flash('message', 'Debe seleccionar un cliente y al menos un producto.');
        return;
    }

    // Guardar la venta
    $venta = Ventas::create([
        'customer_id' => $this->cliente_id,
        'fecha' => $this->fecha,
        'total' => $this->total_venta,
        'estado' => true
    ]);

    // Guardar los detalles de la venta y actualizar el stock
    foreach ($this->productos_seleccionados as $item) {
        detalle_venta::create([
            'id_venta' => $venta->id_venta,
            'id_product' => $item['producto']->id_product,
            'cantidad' => $item['cantidad'],
            'p_unitario' => $item['producto']->sale_price,
            'total' => $item['total']
        ]);

        // Actualizar el stock del producto
        $producto = Product::find($item['producto']->id_product);
        $producto->current_stock -= $item['cantidad']; // Decrementar el stock
        $producto->save();
    }

    // Mensaje de éxito
    session()->flash('message', 'Venta registrada con éxito!');

    // Resetear los datos del formulario
    $this->reset([
        'tipo_cliente', 'cliente_id', 'nuevo_cliente_nombre', 'nuevo_cliente_apellido',
        'nuevo_cliente_email', 'nuevo_cliente_phone', 'nuevo_cliente_dniruc', 'nuevo_cliente_address',
        'producto_id', 'cantidad', 'productos_seleccionados', 'total_venta'
    ]);

    $this->fecha = Carbon::now()->format('Y-m-d\TH:i');
    $this->numero_factura = Ventas::max('id_venta') + 1;
    $this->clientes = Customer::all();
    }
    public function generatePDF()
{
    if (!$this->cliente_id || !$this->productos_seleccionados) {
        session()->flash('message', 'Debe seleccionar un cliente y al menos un producto.');
        return;
    }

    $venta = Ventas::latest()->first();

    if (!$venta) {
        session()->flash('message', 'No se pudo encontrar la venta.');
        return;
    }

    $detalleVentas = $venta->detalles;

    // Cargar el contenido HTML para el PDF
    $html = view('pdf.nota_venta', [
        'venta' => $venta,
        'detalleVentas' => $detalleVentas,
    ])->render();

    // Usar la fachada PDF que fue registrada en config/app.php
    $pdf = PDF::loadHTML($html);

    // Opcional: Definir el tamaño del papel y la orientación
    $pdf->setPaper('A4', 'portrait');

    // Renderizar el PDF
    $pdf->render();

    // Descargar el PDF
    return $pdf->download('nota_venta_' . $venta->id_venta . '.pdf');
}

    
    


    public function render()
    {
        return view('livewire.nota-venta');
    }
}
