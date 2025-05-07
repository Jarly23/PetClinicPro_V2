<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Supplier;

class SuppliersCrud extends Component
{
    public $name, $contact, $phone, $address, $supplierId, $open = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:suppliers,name',
        'contact' => 'required|string|max:255',
        'phone' => 'required|digits_between:7,15', 
        'address' => 'required|string',
    ];

    public function openModal()
    {
        $this->reset(['name', 'contact', 'phone', 'address', 'supplierId']);
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function save()
    {
        $this->validate();

        Supplier::updateOrCreate(
            ['id_supplier' => $this->supplierId], // Clave primaria correcta
            [
                'name' => $this->name,
                'contact' => $this->contact,
                'phone' => $this->phone,
                'address' => $this->address
            ]
        );

        session()->flash('message', 'Proveedor guardado con éxito.');
        $this->closeModal();
        $this->dispatch('refreshSuppliers'); // Para actualizar la lista
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $this->supplierId = $supplier->id_supplier;
        $this->name = $supplier->name;
        $this->contact = $supplier->contact;
        $this->phone = $supplier->phone;
        $this->address = $supplier->address;
        $this->open = true;
    }

    public function delete($id)
    {
        Supplier::findOrFail($id)->delete();
        session()->flash('message', 'Proveedor eliminado con éxito.');
    }

    public function render()
    {
        return view('livewire.suppliers-crud', [
            'suppliers' => Supplier::all()
        ]);
    }
}
