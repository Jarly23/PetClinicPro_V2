<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;

class CustomerCrud extends Component
{
    use WithPagination;

    public $open = false;
    public $search;
    public $customer_id, $name, $lastname, $email, $phone, $address, $dniruc, $documentType;

    protected $rules = [
        'name' => 'required',
        'lastname' => 'required',
        'email' => 'required|email',
        'phone' => 'required|digits:9',
        'address' => 'required',
        'documentType' => 'required|in:dni,ruc',
        'dniruc' => 'required',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function searchCustomers()
    {
        // Si ya estás filtrando en el render, este método puede quedar vacío.
        $this->resetPage(); // Si necesitas resetear la paginación.
    }

    public function render()
    {
        $customers = Customer::where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('lastname', 'LIKE', '%' . $this->search . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search . '%')
            ->orWhere('phone', 'LIKE', '%' . $this->search . '%')
            ->orWhere('address', 'LIKE', '%' . $this->search . '%')
            ->orWhere('dniruc', 'LIKE', '%' . $this->search . '%')
            ->get();
        return view('livewire.customer-crud', compact('customers'));
    }

    public function save()
    {
        $this->validate();

        // Validación dinámica según el tipo de documento
        if ($this->documentType === 'dni' && strlen($this->dniruc) !== 8) {
            $this->addError('dniruc', 'El DNI debe tener exactamente 8 dígitos.');
            return;
        } elseif ($this->documentType === 'ruc' && strlen($this->dniruc) !== 11) {
            $this->addError('dniruc', 'El RUC debe tener exactamente 11 dígitos.');
            return;
        }

        if ($this->customer_id) {
            $customer = Customer::find($this->customer_id);
            $customer->update([
                'name' => $this->name,
                'lastname' => $this->lastname,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'dniruc' => $this->dniruc,
            ]);
        } else {
            Customer::create([
                'name' => $this->name,
                'lastname' => $this->lastname,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'dniruc' => $this->dniruc,
            ]);
        }

        $this->resetForm();
        $this->open = false;
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        $this->customer_id = $id;
        $this->name = $customer->name;
        $this->lastname = $customer->lastname;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
        $this->address = $customer->address;
        $this->dniruc = $customer->dniruc;

        // Determinar el tipo de documento (suponiendo que puedes distinguirlo por la longitud)
        $this->documentType = strlen($this->dniruc) === 8 ? 'dni' : 'ruc';

        $this->open = true;
    }

    public function delete($id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            $customer->delete();
            $this->dispatch('alert', ['type' => 'success', 'message' => 'Cliente eliminado correctamente.']);
        } else {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Cliente no encontrado.']);
        }
    }

    public function resetForm()
    {
        $this->customer_id = '';
        $this->name = '';
        $this->lastname = '';
        $this->email = '';
        $this->phone = '';
        $this->address = '';
        $this->dniruc = '';
        $this->documentType = '';
    }
}
