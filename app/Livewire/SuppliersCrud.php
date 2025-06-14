<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Supplier;

class SuppliersCrud extends Component
{
    public $name, $contact, $phone, $address, $document_type, $document_number;
    public $supplierId, $open = false, $search = '';
    public $confirmingDelete = false;
    public $supplierToDelete = null;

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'phone' => 'required|digits_between:7,15',
            'address' => 'required|string',
            'document_type' => 'nullable|in:DNI,RUC',
            'document_number' => 'nullable'
        ];

        if ($this->document_type === 'DNI') {
            $rules['document_number'] = 'nullable|digits:8';
        } elseif ($this->document_type === 'RUC') {
            $rules['document_number'] = 'nullable|digits:11';
        }

        return $rules;
    }

    public function openModal()
    {
        $this->reset(['name', 'contact', 'phone', 'address', 'document_type', 'document_number', 'supplierId']);
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function save()
    {
        $this->validate();

        $action = $this->supplierId ? 'editado' : 'creado';

        Supplier::updateOrCreate(
            ['id_supplier' => $this->supplierId],
            [
                'name' => $this->name,
                'contact' => $this->contact,
                'phone' => $this->phone,
                'address' => $this->address,
                'document_type' => $this->document_type,
                'document_number' => $this->document_number
            ]
        );

        session()->flash('message', "Proveedor {$action} correctamente.");
        $this->closeModal();
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $this->supplierId = $supplier->id_supplier;
        $this->name = $supplier->name;
        $this->contact = $supplier->contact;
        $this->phone = $supplier->phone;
        $this->address = $supplier->address;
        $this->document_type = $supplier->document_type;
        $this->document_number = $supplier->document_number;
        $this->open = true;
    }

    public function delete()
    {
        Supplier::findOrFail($this->supplierToDelete)->delete();
        $this->confirmingDelete = false;
        $this->supplierToDelete = null;
        session()->flash('message', 'Proveedor eliminado correctamente.');
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->supplierToDelete = $id;
    }


    public function render()
    {
        $suppliers = Supplier::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('contact', 'like', '%' . $this->search . '%');
            })->get();

        return view('livewire.suppliers-crud', compact('suppliers'));
    }
}
