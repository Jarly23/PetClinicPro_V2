<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Consultation;
use App\Models\Pet;
use App\Models\Customer;
use App\Models\Veterinarian;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;

class ConsultationCrud extends Component
{
    use WithPagination;

    public $open = false;
    public $showDetails = false;
    public $consultation_id, $consultation_date, $observations, $pet_id, $customer_id, $veterinarian_id, $service_id;
    public $consultation_details, $export_format;

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
        $this->validate();

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

        $this->resetForm();
        $this->open = false;
        $this->resetPage();
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
        $this->resetPage();
    }

    public function viewDetails($id)
    {
        $this->consultation_details = Consultation::with('customer', 'pet', 'veterinarian', 'service')->find($id);
        $this->showDetails = true;
    }

    public function export($id)
    {
        if ($this->export_format == 'pdf') {
            return $this->printPdf($id);
        } elseif ($this->export_format == 'word') {
            return $this->printWord($id);
        } elseif ($this->export_format == 'excel') {
            return $this->printExcel($id);
        }
    }

    public function printPdf($id)
    {
        $consultation = Consultation::with('customer', 'pet', 'veterinarian', 'service')->find($id);

        if (!$consultation) {
            session()->flash('error', 'Consulta no encontrada.');
            return;
        }

        $pdf = Pdf::loadView('pdf.consultation-details', compact('consultation'));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'consulta_detalles.pdf');
    }

    public function printWord($id)
    {
        $consultation = Consultation::with('customer', 'pet', 'veterinarian', 'service')->find($id);

        if (!$consultation) {
            session()->flash('error', 'Consulta no encontrada.');
            return;
        }

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addText("Detalles de la Consulta");
        $section->addText("Cliente: " . $consultation->customer->name);
        $section->addText("Mascota: " . $consultation->pet->name);
        $section->addText("Veterinario: " . $consultation->veterinarian->name);
        $section->addText("Servicio: " . $consultation->service->name);
        $section->addText("Fecha: " . $consultation->consultation_date);
        $section->addText("Observaciones: " . $consultation->observations);

        $fileName = 'consulta_detalles.docx';
        $filePath = storage_path('app/public/' . $fileName);
        $phpWord->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }

    public function printExcel($id)
    {
        $consultation = Consultation::with('customer', 'pet', 'veterinarian', 'service')->find($id);

        if (!$consultation) {
            session()->flash('error', 'Consulta no encontrada.');
            return;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Detalles de la Consulta');
        $sheet->setCellValue('A2', 'Cliente: ' . $consultation->customer->name);
        $sheet->setCellValue('A3', 'Mascota: ' . $consultation->pet->name);
        $sheet->setCellValue('A4', 'Veterinario: ' . $consultation->veterinarian->name);
        $sheet->setCellValue('A5', 'Servicio: ' . $consultation->service->name);
        $sheet->setCellValue('A6', 'Fecha: ' . $consultation->consultation_date);
        $sheet->setCellValue('A7', 'Observaciones: ' . $consultation->observations);

        $fileName = 'consulta_detalles.xlsx';
        $filePath = storage_path('app/public/' . $fileName);
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend();
    }
}
