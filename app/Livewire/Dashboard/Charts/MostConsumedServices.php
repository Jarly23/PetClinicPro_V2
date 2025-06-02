<?php

namespace App\Livewire\Dashboard\Charts;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\AnimalType;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MostConsumedServices extends Component
{
    public $startDate;
    public $endDate;
    public $topServices;
    public $labels = [];
    public $data = [];

    public function mount()
    {
        $this->loadChartData();
    }

    public function updatedStartDate()
    {
        $this->loadChartData();
    }

    public function updatedEndDate()
    {
        $this->loadChartData();
    }

    public function loadChartData()
    {
        $this->topServices = DB::table('services')
            ->select('services.name', DB::raw('count(*) as total'))
            ->join('consultation_service', 'services.id', '=', 'consultation_service.service_id')
            ->join('consultations', 'consultations.id', '=', 'consultation_service.consultation_id')
            ->groupBy('services.name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Asignar directamente a las propiedades públicas para usarlas en Blade
        $this->labels = $this->topServices->pluck('name')->toArray();
        $this->data = $this->topServices->pluck('total')->toArray();
    }
    public function exportToExcelRaw()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $sheet->setCellValue('A1', 'Servicio');
        $sheet->setCellValue('B1', 'Cantidad de consultas');

        // Cargar los datos filtrados
        $row = 2;
        foreach ($this->topServices as $service) {
            $sheet->setCellValue('A' . $row, $service->name);
            $sheet->setCellValue('B' . $row, $service->total);
            $row++;
        }

        // Crear archivo temporal
        $writer = new Xlsx($spreadsheet);
        $filename = 'servicios_mas_consumidos.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    public function render()
    {
        return view('livewire.dashboard.charts.most-consumed-services');
    }
}
