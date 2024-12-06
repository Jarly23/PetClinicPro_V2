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
    public $reservation_id, $reservation_date, $status = 'Pending', $pet_id, $customer_id, $veterinarian_id, $service_id, $start_time, $end_time;

    // Para almacenar las mascotas filtradas
    public $pets = [];

    protected $rules = [
        'reservation_date' => 'required|date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'status' => 'required|string|in:Pending,Confirmed,Canceled',
        'pet_id' => 'required|exists:pets,id',
        'customer_id' => 'required|exists:customers,id',
        'veterinarian_id' => 'required|exists:veterinarians,id',
        'service_id' => 'required|exists:services,id',
    ];

    // Método para actualizar las mascotas basadas en el customer_id
    public function updatedCustomerId($value)
    {
        $this->pets = Pet::where('owner_id', $value)->get(); // Filtrar las mascotas por el cliente seleccionado
        $this->pet_id = null; // Limpiar el pet_id cuando cambie el cliente
    }

    public function render()
    {
        return view('livewire.reservation-crud', [
            'reservations' => Reservation::with('pet', 'customer', 'veterinarian', 'service')->paginate(10),
            'pets' => $this->pets, // Pasar las mascotas filtradas a la vista
            'customers' => Customer::all(),
            'veterinarians' => Veterinarian::all(),
            'services' => Service::all(),
        ]);
    }

    public function save()
{
    // Validar la disponibilidad del veterinario
    $this->validate();

    // Verificar si el veterinario está disponible en la fecha y horario seleccionados
    $existingReservation = Reservation::where('veterinarian_id', $this->veterinarian_id)
        ->where('reservation_date', $this->reservation_date)
        ->where(function($query) {
            $query->whereBetween('start_time', [$this->start_time, $this->end_time])
                ->orWhereBetween('end_time', [$this->start_time, $this->end_time]);
        })
        ->exists();

    if ($existingReservation) {
        session()->flash('error', 'El veterinario ya tiene una reserva en este horario. Por favor, seleccione otro horario.');
        return; // Salir si el veterinario no está disponible
    }

    // Si no hay conflictos, guarda o actualiza la reserva
    $data = [
        'customer_id' => $this->customer_id,
        'pet_id' => $this->pet_id,
        'veterinarian_id' => $this->veterinarian_id,
        'service_id' => $this->service_id,
        'reservation_date' => $this->reservation_date,
        'start_time' => $this->start_time,
        'end_time' => $this->end_time,
        'status' => $this->status,
    ];

    if ($this->reservation_id) {
        $reservation = Reservation::find($this->reservation_id);
        if ($reservation) {
            $reservation->update($data);
        }
    } else {
        Reservation::create($data);
    }

    $this->resetForm();
    $this->open = false;
    session()->flash('message', '¡Reserva guardada exitosamente!');
}

    public function resetForm()
    {
        $this->reservation_id = null;
        $this->reservation_date = null;
        $this->status = 'Pending';
        $this->pet_id = null;
        $this->customer_id = null;
        $this->veterinarian_id = null;
        $this->service_id = null;
        $this->start_time = null;
        $this->end_time = null;
    }

    public function edit($id)
    {
        $reservation = Reservation::find($id);
        if ($reservation) {
            $this->reservation_id = $reservation->id;
            $this->reservation_date = $reservation->reservation_date;
            $this->status = $reservation->status;
            $this->pet_id = $reservation->pet_id;
            $this->customer_id = $reservation->customer_id;
            $this->veterinarian_id = $reservation->veterinarian_id;
            $this->service_id = $reservation->service_id;
            $this->start_time = $reservation->start_time;
            $this->end_time = $reservation->end_time;
            $this->open = true;
        }
    }

    public function delete($id)
    {
        $reservation = Reservation::find($id);
        if ($reservation) {
            $reservation->delete();
            session()->flash('message', 'Reserva eliminada con éxito.');
        }
    }
}
