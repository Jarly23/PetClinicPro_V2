<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Customer; // Suponiendo que tienes un modelo Client
use App\Models\Consultation; // Suponiendo que tienes un modelo Consultation

class ReportsCrud extends Component
{
    public $dniOrRuc;
    public $clients = [];
    public $selectedClient;
    public $consultations = [];
    public $selectedConsultation;
    public $report;

    // Buscar clientes por DNI o RUC
    public function updatedDniOrRuc()
    {
        $this->clients = Customer::where('dni', $this->dniOrRuc)
            ->orWhere('ruc', $this->dniOrRuc)
            ->get();
    }

    // Cargar las consultas del cliente seleccionado
    public function loadConsultations()
    {
        if ($this->selectedClient) {
            $this->consultations = Consultation::where('client_id', $this->selectedClient)->get();
        }
    }

    // Crear un reporte basado en la consulta seleccionada
    public function createReport()
    {
        if ($this->selectedConsultation) {
            // Lógica para crear un reporte
            $this->report = "Reporte creado para la consulta ID: " . $this->selectedConsultation;
        }
    }

    public function render()
    {
        return view('livewire.reports-crud');
    }
}
