<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer;

class CustomerCrud extends Component
{
    use WithPagination;

    public $open = false;
    public $search = '';
    public $customer_id, $name, $lastname, $email, $phone, $address, $dni;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|digits:9',
            'address' => 'required|string|max:255',
            'dni' => 'required|digits:8|unique:customers,dni,'
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function searchCustomer()
    {
        $this->resetPage(); 
    }

    public function render()
    {
        $customers = Customer::query()
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('lastname', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%")
                    ->orWhere('address', 'like', "%{$this->search}%")
                    ->orWhere('dni', 'like', "%{$this->search}%");
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.customer-crud', compact('customers'));
    }

    public function save()
    {
        $this->validate();

        $data = $this->only(['name', 'lastname', 'email', 'phone', 'address', 'dni']);

        if ($this->customer_id) {
            Customer::findOrFail($this->customer_id)->update($data);
        } else {
            Customer::create($data);
        }

        $this->resetForm();
        $this->open = false;

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => $this->customer_id ? 'Cliente actualizado.' : 'Cliente creado.'
        ]);
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        $this->fillCustomerFields($customer);
        $this->open = true;
    }

    public function delete($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Cliente no encontrado.'
            ]);
        }

        $customer->delete();

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Cliente eliminado correctamente.'
        ]);
    }

    public function resetForm()
    {
        $this->reset(['customer_id', 'name', 'lastname', 'email', 'phone', 'address', 'dni']);
    }

    protected function fillCustomerFields($customer)
    {
        $this->customer_id = $customer->id;
        $this->name = $customer->name;
        $this->lastname = $customer->lastname;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
        $this->address = $customer->address;
        $this->dni = $customer->dni;
    }
    public function cancel(){
        $this-> resetForm();
        $this->open= false;
    }
}
