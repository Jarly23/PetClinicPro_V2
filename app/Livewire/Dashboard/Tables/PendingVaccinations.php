<?php

namespace App\Livewire\Dashboard\Tables;

use Livewire\Component;
use App\Models\Pet;
use Illuminate\Support\Carbon;

class PendingVaccinations extends Component
{
    public $pendingVaccinations;

    public function mount()
    {
        $this->loadPendingVaccinations();
    }

    public function loadPendingVaccinations()
    {
        $today = Carbon::today();
        $sevenDaysLater = $today->copy()->addDays(7);

        $this->pendingVaccinations = Pet::whereHas('vaccineApplications', function ($query) use ($today, $sevenDaysLater) {
            $query->join('vaccines', 'vaccines.id', '=', 'vaccine_applications.vaccine_id')
                ->whereRaw("
                DATE_ADD(vaccine_applications.application_date, INTERVAL vaccines.application_interval_days DAY)
                BETWEEN ? AND ?", [$today, $sevenDaysLater]);
        })
            ->with([
                'owner',
                'vaccineApplications.vaccine',
                'vaccineApplications.user',
            ])
            ->get()
            ->each(function ($pet) {
                // Filtra y guarda solo la próxima vacuna en una propiedad virtual
                $pet->next_vaccine_application = $pet->vaccineApplications
                    ->filter(function ($app) {
                        return \Carbon\Carbon::parse($app->application_date)
                            ->addDays($app->vaccine->application_interval_days)
                            ->between(now(), now()->addDays(7));
                    })
                    ->sortBy('application_date')
                    ->first();
            });
    }
    public function render()
    {
        return view('livewire.dashboard.tables.pending-vaccinations', [
            'pendingVaccinations' => $this->pendingVaccinations,
            'total' => $this->pendingVaccinations->count(),
        ]);
    }
}
