<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class NotificacionesDropdown extends Component
{
    public function render()
    {
        $notificaciones = auth()->user()->unreadNotifications->take(5);
        return view('livewire.dashboard.notificaciones-dropdown', compact('notificaciones'));
    }
}
