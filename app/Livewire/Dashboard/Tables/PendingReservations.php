<?php

namespace App\Livewire\Dashboard\Tables;

use Livewire\Component;
use App\Models\Reservation;
use Carbon\Carbon;


class PendingReservations extends Component
{
    public $todayReservations = [];

    public function mount()
    {
        $this->loadReservations();
    }

    public function loadReservations()
    {
        $now = Carbon::now();
        $today = $now->toDateString();

        $this->todayReservations = Reservation::with(['pet', 'customer'])
            ->where('status', 'Pending ')
            ->whereDate('reservation_date', $today)
            ->orderBy('start_time', 'asc')
            ->get()
            ->map(function ($reservation) use ($now) {
                $startTime = Carbon::createFromFormat('H:i:s', $reservation->start_time);
                $timeLeft = $startTime->diffInMinutes($now, false);

                $reservation->time_diff = $timeLeft > 0
                    ? "Hace {$timeLeft} min"
                    : 'En ' . abs($timeLeft) . ' min';

                return $reservation;
            });
    }
    public function render()
    {
        return view('livewire.dashboard.tables.pending-reservations');
    }
}
