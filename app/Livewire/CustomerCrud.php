<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;

class CustomerCrud extends Component
{
    public $open = false;
    public $customer_id, $name, $lastname, $email, $phone, $address;

    protected $rules = [
        'name' => 'required',
        'lastname' => 'required',
        'email' => 'required|email',
        'phone' => 'required|digits:9',
        'address' => 'required',
    ];

    public function render()
    {
        $customers = Customer::all();
        return view('livewire.customer-crud', compact('customers'));
    }

    public function save()
    {
        $this->validate();

        if ($this->customer_id) {
            $customer = Customer::find($this->customer_id);
            $customer->update([
                'name' => $this->name,
                'lastname' => $this->lastname,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
            ]);
        } else {
            Customer::create([
                'name' => $this->name,
                'lastname' => $this->lastname,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
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
    }
}
