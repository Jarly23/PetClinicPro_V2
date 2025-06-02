<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Consultation;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportsPayments extends Component
{
    public $search = ''; // Para buscar cliente por DNI o RUC
    public $customer_id = null, $consultation_id = null;
    public $customers = [], $consultations = [], $selectedCustomer = null, $selectedConsultation = null;

    // Método para realizar la búsqueda manualmente
    public function searchCustomer()
    {
        // Verifica si el campo de búsqueda no está vacío
        if ($this->search !== '') {
            // Buscar cliente por DNI o RUC
            $this->selectedCustomer = Customer::where('dniruc', 'LIKE', '%' . $this->search . '%')->first();

            if ($this->selectedCustomer) {
                // Si el cliente es encontrado, obtenemos las consultas
                $this->consultations = Consultation::where('customer_id', $this->selectedCustomer->id)->get();
            } else {
                // Si no se encuentra el cliente, limpiar las consultas
                $this->consultations = [];
            }
        } else {
            // Si el campo de búsqueda está vacío, limpiamos la información
            $this->selectedCustomer = null;
            $this->consultations = [];
        }
    }

    // Método que escucha el cambio de consulta
    public function updatedConsultationId($value)
    {
        if ($value) {
            // Obtener los detalles completos de la consulta
            $this->selectedConsultation = Consultation::with('service')->find($value);
        } else {
            $this->selectedConsultation = null;
        }
    }

    // Método para generar el reporte en PDF
    public function generatePDF()
    {
        // Verifica si el cliente y la consulta están seleccionados
        if ($this->selectedCustomer && $this->selectedConsultation) {
            // Crea una nueva instancia de DomPDF
            $pdf = new Dompdf();

            // Cargar el contenido HTML para el PDF
            $html = view('pdf.reports', [
                'customer' => $this->selectedCustomer,
                'consultation' => $this->selectedConsultation,
            ])->render();

            // Cargar el HTML al PDF
            $pdf->loadHtml($html);

            // (Opcional) Definir el tamaño del papel y la orientación
            $pdf->setPaper('A4', 'portrait');

            // Renderizar el PDF
            $pdf->render();

            // Descarga el PDF
            return response()->stream(function() use ($pdf) {
                echo $pdf->output();
            }, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="reporte_cliente_' . $this->selectedCustomer->dni . '.pdf"',
            ]);
        } else {
            // Si no se ha seleccionado un cliente o consulta, se podría agregar un mensaje o acción
            session()->flash('error', 'Por favor, selecciona un cliente y una consulta.');
        }
    }

    public function render()
    {
        return view('livewire.reports-payments', [
            'customers' => $this->customers,
            'consultations' => $this->consultations,
            'selectedCustomer' => $this->selectedCustomer,
            'selectedConsultation' => $this->selectedConsultation,
        ]);
    }
}
