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
    public $cliente_guardado = false;

    public $nuevo_cliente_nombre;
    public $nuevo_cliente_apellido;
    public $nuevo_cliente_email;
    public $nuevo_cliente_phone;
    public $nuevo_cliente_tipo_documento;
    public $nuevo_cliente_documento;
    public $nuevo_cliente_dniruc;
    public $nuevo_cliente_address;
    public $search = '';
public $cliente = [];
public $mostrarLista = false;
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

        if (!$producto || !$this->cantidad || $this->cantidad <= 0) {
            session()->flash('message', 'Seleccione un producto válido y cantidad mayor a cero.');
            return;
        }

        if ($producto->current_stock < $this->cantidad) {
            session()->flash('message', 'No hay suficiente stock disponible para este producto.');
            return;
        }

        $total_producto = $producto->sale_price * $this->cantidad;

        $this->productos_seleccionados[] = [
            'producto' => $producto,
            'cantidad' => $this->cantidad,
            'total' => $total_producto
        ];

        $this->producto_id = null;
        $this->cantidad = null;

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

    public function guardarNuevoCliente()
{
    // Validación dinámica dependiendo del tipo de documento (DNI o RUC)
    $this->validate([
        'nuevo_cliente_nombre' => 'required|string|max:100',
        'nuevo_cliente_apellido' => 'required|string|max:100',
        'nuevo_cliente_email' => 'nullable|email',
        'nuevo_cliente_phone' => 'nullable|string|max:20',
        'nuevo_cliente_tipo_documento' => 'required|in:DNI,RUC', // Asegura que el tipo sea DNI o RUC
        'nuevo_cliente_documento' => [
            'required',
            'string',
            'max:20',
            'unique:customers,dniruc', // Asegura que el DNI/RUC sea único
            function ($attribute, $value, $fail) {
                // Validación para el DNI (8 dígitos)
                if ($this->nuevo_cliente_tipo_documento === 'DNI' && strlen($value) !== 8) {
                    $fail('El DNI debe tener exactamente 8 dígitos.');
                }
                // Validación para el RUC (11 dígitos)
                if ($this->nuevo_cliente_tipo_documento === 'RUC' && strlen($value) !== 11) {
                    $fail('El RUC debe tener exactamente 11 dígitos.');
                }
            }
        ],
        'nuevo_cliente_address' => 'nullable|string|max:255',
    ]);

    // Crear el nuevo cliente con los datos validados
    $cliente = Customer::create([
        'name' => $this->nuevo_cliente_nombre,
        'lastname' => $this->nuevo_cliente_apellido,
        'email' => $this->nuevo_cliente_email,
        'phone' => $this->nuevo_cliente_phone,
        'address' => $this->nuevo_cliente_address,
        'dniruc' => $this->nuevo_cliente_documento,
    ]);

    // Asignar el cliente y cambiar el estado del tipo de cliente
    $this->cliente_id = $cliente->id;
    $this->tipo_cliente = 'existente'; // Cambiar a tipo cliente 'existente'
    $this->reset([ // Limpiar los campos del formulario
        'nuevo_cliente_nombre',
        'nuevo_cliente_apellido',
        'nuevo_cliente_email',
        'nuevo_cliente_phone',
        'nuevo_cliente_tipo_documento',
        'nuevo_cliente_documento',
        'nuevo_cliente_address',
    ]);

    // Refrescar la lista de clientes
    $this->clientes = Customer::orderBy('name')->get(); 
    session()->flash('message', 'Cliente registrado correctamente.');
}



public function guardarVenta()
{
    if ($this->tipo_cliente === 'nuevo' && !$this->cliente_guardado) {
        session()->flash('message', 'Debe guardar primero al nuevo cliente.');
        return;
    }

    if (!$this->cliente_id || empty($this->productos_seleccionados)) {
        session()->flash('message', 'Debe seleccionar un cliente y al menos un producto.');
        return;
    }

    $venta = Ventas::create([
        'customer_id' => $this->cliente_id,
        'fecha' => $this->fecha,
        'total' => $this->total_venta,
        'estado' => true
    ]);

    foreach ($this->productos_seleccionados as $item) {
        detalle_venta::create([
            'id_venta' => $venta->id_venta,
            'id_product' => $item['producto']->id_product,
            'cantidad' => $item['cantidad'],
            'p_unitario' => $item['producto']->sale_price,
            'total' => $item['total']
        ]);

        $producto = Product::find($item['producto']->id_product);
        $producto->current_stock -= $item['cantidad'];
        $producto->save();
    }

    // Generar PDF inmediatamente
    $detalleVentas = $venta->detalles;

    $html = view('pdf.nota_venta', [
        'venta' => $venta,
        'detalleVentas' => $detalleVentas,
    ])->render();

    $pdf = PDF::loadHTML($html)->setPaper('A4', 'portrait');

    // Limpiar formulario después de generar PDF
    $this->reset([
        'tipo_cliente', 'cliente_id', 'cliente_guardado',
        'nuevo_cliente_nombre', 'nuevo_cliente_apellido', 'nuevo_cliente_email',
        'nuevo_cliente_phone', 'nuevo_cliente_dniruc', 'nuevo_cliente_address',
        'producto_id', 'cantidad', 'productos_seleccionados', 'total_venta'
    ]);

    $this->fecha = Carbon::now()->format('Y-m-d\TH:i');
    $this->numero_factura = Ventas::max('id_venta') + 1;
    $this->clientes = Customer::all();

    // Retornar el PDF como descarga
    return response()->streamDownload(function() use ($pdf) {
        echo $pdf->output();
    }, 'nota_venta_' . $venta->id_venta . '.pdf');
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

        $html = view('pdf.nota_venta', [
            'venta' => $venta,
            'detalleVentas' => $detalleVentas,
        ])->render();

        $pdf = PDF::loadHTML($html)->setPaper('A4', 'portrait');

        return $pdf->download('nota_venta_' . $venta->id_venta . '.pdf');
    }
    public function updatedSearch($value)
    {
        $this->mostrarLista = true;

        if (empty($value)) {
            $this->clientes = Customer::limit(10)->get(); // mostrar todos
        } else {
            $this->clientes = Customer::where('name', 'like', '%' . $value . '%')
                                    ->orWhere('lastname', 'like', '%' . $value . '%')
                                    ->limit(10)
                                    ->get();
        }
    }


    public function buscarCliente()
    {
        $this->mostrarLista = true;

        if (empty($this->search)) {
            $this->clientes = Customer::limit(10)->get(); // mostrar todos
        } else {
            $this->clientes = Customer::where('name', 'like', '%' . $this->search . '%')
                                    ->orWhere('lastname', 'like', '%' . $this->search . '%')
                                    ->limit(10)
                                    ->get();
        }
    }
    public function seleccionarCliente($id)
    {
        $cliente = Customer::find($id);
        
        if ($cliente) {
            $this->cliente_id = $cliente->id;
            $this->search = $cliente->name . ' ' . $cliente->lastname;
        }

        $this->clientes = [];
        $this->mostrarLista = false;
    }
    public function cargarClientes()
    {
        if (empty($this->search)) {
            $this->clientes = Customer::limit(10)->get();
        } else {
            $this->clientes = Customer::where('name', 'like', '%' . $this->search . '%')
                                    ->orWhere('lastname', 'like', '%' . $this->search . '%')
                                    ->limit(10)
                                    ->get();
        }
    }

    public function render()
    {
        return view('livewire.nota-venta');
    }
}
