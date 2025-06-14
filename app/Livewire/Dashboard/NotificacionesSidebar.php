<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class NotificacionesSidebar extends Component
{
    public function render()
    {
        $notificaciones = auth()->user()->notifications; // todas
        return view('livewire.dashboard.notificaciones-sidebar', compact('notificaciones'));
    }
}
