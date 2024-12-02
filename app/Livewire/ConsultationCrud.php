<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Consultation;
use App\Models\Pet;
use App\Models\Customer;
use App\Models\Veterinarian;
use App\Models\Service;


class ConsultationCrud extends Component
{
    use WithPagination;
    public $open = false;
    public $consultation_id, $consultation_date, $observations, $pet_id, $customer_id, $veterinarian_id, $service_id;
   
    protected $rules = [
        'consultation_date' => 'required|date',
        'observations' => 'nullable|string',
        'pet_id' => 'required|exists:pets,id',
        'customer_id' => 'required|exists:customers,id',
        'veterinarian_id' => 'required|exists:veterinarians,id',
        'service_id' => 'required|exists:services,id',
    ];

    public function render()
    {
        return view('livewire.consultation-crud', [
            'consultations' => Consultation::with('pet', 'customer', 'veterinarian', 'service')->paginate(10),
            'pets' => Pet::all(),
            'customers' => Customer::all(),
            'veterinarians' => Veterinarian::all(),
            'services' => Service::all(),
        ]);
    }
    public function save()
    {
        $this->validate(); // Validación

        // Guardar o actualizar la consulta
        if ($this->consultation_id) {
            $consultation = Consultation::find($this->consultation_id);
            $consultation->update([
                'customer_id' => $this->customer_id,
                'pet_id' => $this->pet_id,
                'veterinarian_id' => $this->veterinarian_id,
                'service_id' => $this->service_id,
                'consultation_date' => $this->consultation_date,
                'observations' => $this->observations,
   
            ]);
        } else {
            Consultation::create([
                'customer_id' => $this->customer_id,
                'pet_id' => $this->pet_id,
                'veterinarian_id' => $this->veterinarian_id,
                'service_id' => $this->service_id,
                'consultation_date' => $this->consultation_date,
                'observations' => $this->observations,

            ]);
        }

        // Limpiar formulario y cerrar modal
        $this->resetForm();
        $this->open = false;
    }

    public function resetForm()
    {
        $this->consultation_id = null;
        $this->customer_id = null;
        $this->pet_id = null;
        $this->veterinarian_id = null;
        $this->service_id = null;
        $this->consultation_date = null;
        $this->observations = null;

    }

    public function edit(Consultation $consultation)
    {
        $this->consultation_id = $consultation->id;
        $this->consultation_date = $consultation->consultation_date;
        $this->observations = $consultation->observations;
        $this->pet_id = $consultation->pet_id;
        $this->customer_id = $consultation->customer_id;
        $this->veterinarian_id = $consultation->veterinarian_id;
        $this->service_id = $consultation->service_id;
        $this->open = true;
    }

    public function delete(Consultation $consultation)
    {
        $consultation->delete();
    }
}
