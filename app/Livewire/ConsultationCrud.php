<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Consultation;
use App\Models\Pet;
use App\Models\Customer;
use App\Models\User;
use App\Models\Service;

class ConsultationCrud extends Component
{
    use WithPagination;

    public $open = false;
    public $showDetails = false;
    public $search = "";
    public $consultation_id, $consultation_date, $observations, $pet_id, $customer_id, $user_id, $service_id, $recomendaciones, $diagnostico;

    public $consultation_details, $export_format;

    public $pets = []; // Almacena las mascotas filtradas

    protected $rules = [
        'consultation_date' => 'required|date',
        'observations' => 'nullable|string',
        'recomendaciones' => 'nullable|string',
        'diagnostico' => 'nullable|string',
        'pet_id' => 'required|exists:pets,id',
        'customer_id' => 'required|exists:customers,id',
        'user_id' => 'required|exists:users,id',
        'service_id' => 'required|exists:services,id',
    ];

    // Método que escucha el cambio del customer_id
    public function updatedCustomerId($value)
    {
        $this->pets = Pet::where('owner_id', $value)->get();
        $this->pet_id = null;
    }

    public function render()
    {
        $consultations = Consultation::with('pet', 'customer', 'user', 'service')
            ->whereHas('customer', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('pet', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhere('observations', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.consultation-crud', [
            'consultations' => $consultations,
            'customers' => Customer::all(),
            'veterinarians' => User::role('Veterinario')->get(),
            'services' => Service::all(),
            'pets' => $this->pets,
        ]);
    }
    public function updated($propertyName)
{
    $this->validateOnly($propertyName);
}
    public function searchConsultations()
    {
        $this->resetPage(); 
    }

    public function save()
    {
        $this->validate();

        if ($this->consultation_id) {
            $consultation = Consultation::find($this->consultation_id);
            $consultation->update([
                'customer_id' => $this->customer_id,
                'pet_id' => $this->pet_id,
                'user_id' => $this->user_id,
                'service_id' => $this->service_id,
                'consultation_date' => $this->consultation_date,
                'observations' => $this->observations,
                'recomendaciones' => $this->recomendaciones,
                'diagnostico' => $this->diagnostico,
            ]);
        } else {
            Consultation::create([
                'customer_id' => $this->customer_id,
                'pet_id' => $this->pet_id,
                'user_id' => $this->user_id,
                'service_id' => $this->service_id,
                'consultation_date' => $this->consultation_date,
                'observations' => $this->observations,
                'recomendaciones' => $this->recomendaciones,
                'diagnostico' => $this->diagnostico,
            ]);
        }

        $this->resetForm();
        $this->open = false;
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->consultation_id = null;
        $this->customer_id = null;
        $this->pet_id = null;
        $this->user_id = null;
        $this->service_id = null;
        $this->consultation_date = null;
        $this->observations = null;
        $this->recomendaciones = null;
        $this->diagnostico = null;
    }

    public function edit(Consultation $consultation)
    {
        $this->consultation_id = $consultation->id;
        $this->consultation_date = $consultation->consultation_date;
        $this->observations = $consultation->observations;
        $this->pet_id = $consultation->pet_id;
        $this->customer_id = $consultation->customer_id;
        $this->user_id = $consultation->user_id;
        $this->service_id = $consultation->service_id;
        $this->recomendaciones = $consultation->recomendaciones;
        $this->diagnostico = $consultation->diagnostico;
        $this->open = true;
    }

    public function delete(Consultation $consultation)
    {
        $consultation->delete();
        $this->resetPage();
    }

    public function viewDetails($id)
    {
        $this->consultation_details = Consultation::with('customer', 'pet', 'user', 'service')->find($id);
        $this->showDetails = true;
    }
}
