<?php

namespace App\Livewire\Dashboard\Stats;

use Livewire\Component;
use App\Models\Reservation;

class PendingBookings extends Component
{
    public $title = 'Reservas pendientes';
    public $icon = 'images/icons/calendar-clock.svg'; // ícono personalizado
    public $secondIcon = 'images/icons/VectorClock.svg'; // ícono constante
    public $value;
    public $additionalData = 'Para hoy';

    public function mount()
    {
        $this->value = Reservation::where('status', 'Confirmed')->count();
    }
    public function render()
    {
        return view('livewire.dashboard.stats.pending-bookings');
    }
}
