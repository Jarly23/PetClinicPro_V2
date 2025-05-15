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
    public $animalTypeId;
    public $topServices ;
    public $animalTypes ;

    public function mount()
    {
        $this->startDate = Carbon::now()->subDays(6)->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
        $this->animalTypes = AnimalType::all();
        $this->animalTypeId = optional($this->animalTypes->first())->id;
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

    public function updatedAnimalTypeId()
    {
        $this->loadChartData();
    }

    public function loadChartData()
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        $this->topServices = DB::table('services')
            ->select('services.name', DB::raw('COUNT(*) as total'))
            ->join('consultation_service', 'services.id', '=', 'consultation_service.service_id')
            ->join('consultations', 'consultations.id', '=', 'consultation_service.consultation_id')
            ->join('pets', 'consultations.pet_id', '=', 'pets.id')
            ->where('pets.animal_type_id', $this->animalTypeId)
            ->whereBetween('consultations.created_at', [$start, $end])
            ->groupBy('services.name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $this->js(<<<JS
            window.dispatchEvent(new CustomEvent('chartUpdated', {
                detail: {
                    labels: {$this->topServices->pluck('name')->toJson()},
                    data: {$this->topServices->pluck('total')->toJson()}
                }
            }));
        JS);
    }

    public function exportToExcelRaw()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Servicio');
        $sheet->setCellValue('B1', 'Cantidad de consultas');

        $row = 2;
        foreach ($this->topServices as $service) {
            $sheet->setCellValue('A' . $row, $service->name);
            $sheet->setCellValue('B' . $row, $service->total);
            $row++;
        }

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
