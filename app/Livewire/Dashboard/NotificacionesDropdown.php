<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Product;

class NotificacionesDropdown extends Component
{
    public function marcarNotificacionesComoLeidas()
    {
        // Marcar todas las notificaciones no leídas del usuario autenticado como leídas
        auth()->user()->unreadNotifications->markAsRead();

        // Opcional: si quieres actualizar la propiedad de notificaciones después
        $this->emit('notificacionesActualizadas');
    }

    public function render()
    {
        $notificaciones = auth()->user()->unreadNotifications->take(5);

        // Productos con stock bajo
        $productosBajoStock = Product::whereColumn('current_stock', '<', 'minimum_stock')->get();

        // Productos con al menos una entrada próxima a vencer (en los próximos 7 días)
        $productosPorVencer = Product::whereHas('entradasInve', function ($query) {
            $query->whereDate('expiration_date', '<=', now()->addDays(7))
                ->whereDate('expiration_date', '>=', now()); // sólo futuras o hoy
        })->get();

        return view('livewire.dashboard.notificaciones-dropdown', compact(
            'notificaciones',
            'productosPorVencer',
            'productosBajoStock'
        ));
    }
}
