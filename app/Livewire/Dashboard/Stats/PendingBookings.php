<?php

namespace App\Livewire\Dashboard\Stats;

use Livewire\Component;
use App\Models\Reservation;
use Carbon\Carbon;

class PendingBookings extends Component
{
    public $title = 'Reservas pendientes';
    public $icon = 'images/icons/calendar-clock.svg'; // ícono personalizado
    public $secondIcon = 'images/icons/VectorClock.svg'; // ícono constante
    public $value;
    public $additionalData = 'Para hoy';

    public function mount()
    {
        $today = Carbon::today()->toDateString();

        $this->value = Reservation::where('status', 'Confirmed')
            ->whereDate('reservation_date', $today)
            ->count();
    }
    public function render()
    {
        return view('livewire.dashboard.stats.pending-bookings');
    }
}
