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

    public $consultation_id, $consultation_date, $observations, $pet_id, $customer_id, $user_id;
    public $recomendaciones, $diagnostico, $motivo_consulta, $peso, $temperatura;
    public $frecuencia_cardiaca, $frecuencia_respiratoria, $estado_general;
    public $desparasitacion = false, $vacunado = false, $tratamiento;

    public $consultation_details, $export_format;
    public $service_ids = []; // Servicios múltiples
    public $pets = [];
    protected $rules = [
        'consultation_date' => 'required|date',
        'pet_id' => 'required|exists:pets,id',
        'customer_id' => 'required|exists:customers,id',
        'user_id' => 'required|exists:users,id',
        'service_ids' => 'required|array|min:1',
        'service_ids.*' => 'exists:services,id',
        // Nuevos campos
        'motivo_consulta' => 'nullable|string|max:255',
        'peso' => 'nullable|numeric|min:0|max:100',
        'temperatura' => 'nullable|numeric|min:30|max:45',
        'frecuencia_cardiaca' => 'nullable|string|max:50',
        'frecuencia_respiratoria' => 'nullable|string|max:50',
        'estado_general' => 'nullable|string|max:100',
        'desparasitacion' => 'boolean',
        'vacunado' => 'boolean',
        'observations' => 'nullable|string',
        'recomendaciones' => 'nullable|string',
        'diagnostico' => 'nullable|string',
        'tratamiento' => 'nullable|string',
    ];

    // Actualiza mascotas cuando cambia el cliente
    public function updatedCustomerId($value)
    {
        $this->pets = Pet::where('owner_id', $value)->get();
        $this->pet_id = null;
    }

    public function render()
    {
        $consultations = Consultation::with('pet', 'customer', 'user', 'services')
            ->where(function ($query) {
                $query->whereHas('customer', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                    ->orWhereHas('pet', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                    ->orWhereHas('user', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                    ->orWhere('observations', 'like', '%' . $this->search . '%');
            })
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

        $data = [
            'customer_id' => $this->customer_id,
            'pet_id' => $this->pet_id,
            'user_id' => $this->user_id,
            'consultation_date' => $this->consultation_date,
            'motivo_consulta' => $this->motivo_consulta,
            'peso' => $this->peso,
            'temperatura' => $this->temperatura,
            'frecuencia_cardiaca' => $this->frecuencia_cardiaca,
            'frecuencia_respiratoria' => $this->frecuencia_respiratoria,
            'estado_general' => $this->estado_general,
            'desparasitacion' => $this->desparasitacion,
            'vacunado' => $this->vacunado,
            'observations' => $this->observations,
            'diagnostico' => $this->diagnostico,
            'recomendaciones' => $this->recomendaciones,
            'tratamiento' => $this->tratamiento,
        ];

        if ($this->consultation_id) {
            $consultation = Consultation::findOrFail($this->consultation_id);
            $consultation->update($data);
        } else {
            $consultation = Consultation::create($data);
        }

        // Relación muchos a muchos
        $consultation->services()->sync($this->service_ids);

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
        $this->consultation_date = null;
        $this->motivo_consulta = null;
        $this->peso = null;
        $this->temperatura = null;
        $this->frecuencia_cardiaca = null;
        $this->frecuencia_respiratoria = null;
        $this->estado_general = null;
        $this->desparasitacion = false;
        $this->vacunado = false;
        $this->observations = null;
        $this->recomendaciones = null;
        $this->diagnostico = null;
        $this->tratamiento = null;
        $this->service_ids = [];
        $this->pets = [];
    }


    public function edit(Consultation $consultation)
    {
        $this->consultation_id = $consultation->id;
        $this->consultation_date = $consultation->consultation_date;
        $this->motivo_consulta = $consultation->motivo_consulta;
        $this->peso = $consultation->peso;
        $this->temperatura = $consultation->temperatura;
        $this->frecuencia_cardiaca = $consultation->frecuencia_cardiaca;
        $this->frecuencia_respiratoria = $consultation->frecuencia_respiratoria;
        $this->estado_general = $consultation->estado_general;
        $this->desparasitacion = $consultation->desparasitacion;
        $this->vacunado = $consultation->vacunado;
        $this->observations = $consultation->observations;
        $this->recomendaciones = $consultation->recomendaciones;
        $this->diagnostico = $consultation->diagnostico;
        $this->tratamiento = $consultation->tratamiento;
        $this->pet_id = $consultation->pet_id;
        $this->customer_id = $consultation->customer_id;
        $this->user_id = $consultation->user_id;
        $this->service_ids = $consultation->services->pluck('id')->toArray();
        $this->pets = Pet::where('owner_id', $this->customer_id)->get();
        $this->open = true;
    }

    public function delete(Consultation $consultation)
    {
        $consultation->delete();
        $this->resetPage();
    }

    public function viewDetails($id)
    {
        $this->consultation_details = Consultation::with('customer', 'pet', 'user', 'services')->find($id);
        $this->showDetails = true;
    }
}
