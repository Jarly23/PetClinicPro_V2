<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Reservation;
use App\Models\Pet;
use App\Models\Customer;
use App\Models\Veterinarian;
use App\Models\Service;


class ReservationCrud extends Component
{

    use WithPagination;
    public $open = false;
    public $reservation_id, $reservation_date, $status, $pet_id, $customer_id, $veterinarian_id, $service_id;

    protected $rules = [
        'reservation_date' => 'required|date',
        'status' => 'required|string',
        'pet_id' => 'required|exists:pets,id',
        'customer_id' => 'required|exists:customers,id',
        'veterinarian_id' => 'required|exists:veterinarians,id',
        'service_id' => 'required|exists:services,id',
    ];

    public function render()
    {
        return view('livewire.reservation-crud', [
            'reservations' => Reservation::with('pet', 'customer', 'veterinarian', 'service')->paginate(10),
            'pets' => Pet::all(),
            'customers' => Customer::all(),
            'veterinarians' => Veterinarian::all(),
            'services' => Service::all(),
        ]);
    }

    public function save()
    {
        try {
            $this->validate();
    
            if ($this->reservation_id) {
                // Actualizar reserva existente
                $reservation = Reservation::find($this->reservation_id);
                $reservation->update([
                    'customer_id' => $this->customer_id,
                    'pet_id' => $this->pet_id,
                    'veterinarian_id' => $this->veterinarian_id,
                    'service_id' => $this->service_id,
                    'reservation_date' => $this->reservation_date,
                    'status' => $this->status, // Estado actualizado
                ]);
            } else {
                // Crear nueva reserva con estado predeterminado
                Reservation::create([
                    'customer_id' => $this->customer_id,
                    'pet_id' => $this->pet_id,
                    'veterinarian_id' => $this->veterinarian_id,
                    'service_id' => $this->service_id,
                    'reservation_date' => $this->reservation_date,
                    'status' => 'Pending', // Siempre "Pending" al crear
                ]);
            }
    
            $this->resetForm();
            $this->open = false;
            session()->flash('message', '¡Reserva guardada exitosamente!');
        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un error al guardar la reserva: ' . $e->getMessage());
        }
    }
    public function updateStatus(Reservation $reservation, $newStatus)
    {
        try {
            $reservation->update(['status' => $newStatus]);
            session()->flash('message', 'Estado actualizado correctamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el estado: ' . $e->getMessage());
        }
    }
    public function resetForm()
    {
        $this->reservation_id = null;
        $this->customer_id = null;
        $this->pet_id = null;
        $this->veterinarian_id = null;
        $this->service_id = null;
        $this->reservation_date = null;
        $this->status = null;
    }

    public function edit(Reservation $reservation)
    {
        $this->reservation_id = $reservation->id;
        $this->reservation_date = $reservation->reservation_date;
        $this->status = $reservation->status;
        $this->pet_id = $reservation->pet_id;
        $this->customer_id = $reservation->customer_id;
        $this->veterinarian_id = $reservation->veterinarian_id;
        $this->service_id = $reservation->service_id;
        $this->open = true;
    }

    public function delete(Reservation $reservation)
    {
        try {
            $reservation->delete();
            session()->flash('message', 'Reserva eliminada con éxito.');
        } catch (\Exception $e) {
            session()->flash('error', 'No se pudo eliminar la reserva: ' . $e->getMessage());
        }
    }
}
