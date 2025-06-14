<?php

namespace App\Livewire\Dashboard\Tables;

use Livewire\Component;
use App\Models\Reservation;
use Carbon\Carbon;


class PendingReservations extends Component
{
    public $pendingReservations ;

    public function mount()
    {
        $this->loadReservations();
    }

    public function loadReservations()
    {
         $this->pendingReservations = Reservation::with(['pet', 'customer', 'user'])
            ->where('status', 'Confirmed')
            ->orderBy('reservation_date', 'asc')
            ->get();
    }
    public function render()
    {
        return view('livewire.dashboard.tables.pending-reservations',  [
        'total' => $this->pendingReservations ? $this->pendingReservations->count() : 0,
    ]);
    }
}
