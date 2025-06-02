<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Reservation;
use App\Models\Pet;
use App\Models\Customer;
use App\Models\User;
use App\Models\Service;
use App\Models\Consultation;
use Illuminate\Support\Facades\Log;

class ReservationCrud extends Component
{
    use WithPagination;

    public $open = false;
    public $openConsultationModal = false;

    public $reservation_id, $reservation_date, $status = 'Pending',
        $pet_id, $customer_id, $user_id, $service_id,
        $start_time, $end_time;

    public $pets = [];
    public $diagnostico, $recomendaciones;
    public $selected_services = [];
    public $owner_found = false;

    protected $listeners = ['ownerSelected', 'saveReservation', 'clientSelected' => 'loadClientPets'];

    protected $rules = [
        'reservation_date' => 'required|date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'status' => 'required|string|in:Pending,Confirmed,Canceled',
        'pet_id' => 'required|exists:pets,id',
        'customer_id' => 'required|exists:customers,id',
        'user_id' => 'required|exists:users,id',
        'service_id' => 'required|exists:services,id',
    ];

    public function render()
    {
        return view('livewire.reservation-crud', [
            'reservations' => Reservation::with(['pet', 'customer', 'user', 'service'])->latest()->paginate(10),
            'pets' => $this->pets,
            'customers' => Customer::all(),
            'veterinarians' => User::role('Veterinario')->get(),
            'services' => Service::all(),
        ]);
    }

    public function updatedCustomerId($value)
    {
        $this->pets = Pet::where('owner_id', $value)->get();
        $this->pet_id = null;
        $this->owner_found = true;
    }

    public function loadClientPets($clientData)
    {
        $this->customer_id = $clientData['id'];
        $this->pets = Pet::where('owner_id', $this->customer_id)->get();
    }

    public function saveReservation()
    {
        $this->save();
    }

    public function save()
    {
        $this->validate();

        $conflict = Reservation::where('user_id', $this->user_id)
            ->where('reservation_date', $this->reservation_date)
            ->where(function ($query) {
                $query->whereTime('start_time', '<', $this->end_time)
                    ->whereTime('end_time', '>', $this->start_time);
            })
            ->when($this->reservation_id, function ($query) {
                $query->where('id', '!=', $this->reservation_id);
            })
            ->exists();

        if ($conflict) {
            session()->flash('error', 'El veterinario ya tiene una reserva en este horario.');
            return;
        }

        $data = [
            'customer_id' => $this->customer_id,
            'pet_id' => $this->pet_id,
            'user_id' => $this->user_id,
            'service_id' => $this->service_id,
            'reservation_date' => $this->reservation_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
        ];

        if ($this->reservation_id) {
            Reservation::findOrFail($this->reservation_id)->update($data);
        } else {
            Reservation::create($data);
        }

        $this->resetForm();
        $this->resetPage();
        $this->open = false;

        session()->flash('message', '¡Reserva guardada exitosamente!');
    }

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);

        $this->reservation_id = $reservation->id;
        $this->reservation_date = $reservation->reservation_date;
        $this->start_time = $reservation->start_time;
        $this->end_time = $reservation->end_time;
        $this->status = $reservation->status;
        $this->customer_id = $reservation->customer_id;
        $this->updatedCustomerId($this->customer_id);
        $this->pet_id = $reservation->pet_id;
        $this->user_id = $reservation->user_id;
        $this->service_id = $reservation->service_id;

        $this->open = true;
    }

    public function delete($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        $this->resetPage();
        session()->flash('message', 'Reserva eliminada con éxito.');
    }

    public function updateStatus($reservationId, $newStatus)
    {
        $reservation = Reservation::find($reservationId);

        if ($reservation) {
            $reservation->update(['status' => $newStatus]);
            session()->flash('success', 'Estado actualizado con éxito.');
        } else {
            session()->flash('error', 'La reserva no se encontró.');
        }
    }

    public function resetForm()
    {
        $this->reset([
            'reservation_id',
            'reservation_date',
            'start_time',
            'end_time',
            'status',
            'pet_id',
            'customer_id',
            'user_id',
            'service_id',
            'pets',
            'owner_found',
        ]);

        $this->status = 'Pending';
        $this->open = false;
        $this->openConsultationModal = false;
    }
    public function confirmReservation($reservationId)
    {
        $reservation = Reservation::find($reservationId);

        if ($reservation) {
            if ($reservation->status === 'Pending') {
                // Cambiar el estado a "Confirmed"
                $reservation->status = 'Confirmed';
                $reservation->save();

                session()->flash('success', 'La reserva ha sido confirmada con éxito.');
            } else {
                session()->flash('error', 'La reserva ya está confirmada o no puede ser confirmada.');
            }
        } else {
            session()->flash('error', 'La reserva no se encontró.');
        }
    }
    public function startConsultation($reservationId)
    {
        $reservation = Reservation::with(['pet', 'customer'])->find($reservationId);

        if ($reservation && $reservation->status === 'Confirmed') {
            // Cargar datos relacionados
            $this->reservation_id = $reservation->id;
            $this->customer_id = $reservation->customer_id;
            $this->pet_id = $reservation->pet_id;
            $this->user_id = $reservation->user_id;
            $this->service_id = $reservation->service_id;
            $this->reservation_date = now();
            $this->diagnostico = '';
            $this->recomendaciones = '';
            $this->openConsultationModal = true;
        } else {
            session()->flash('error', 'No se puede iniciar la consulta para esta reserva.');
        }
    }

    public function cancelReservation($reservationId)
    {
        $reservation = Reservation::find($reservationId);

        if ($reservation) {
            if ($reservation->status === 'Pending' || $reservation->status === 'Confirmed') {
                // Cambiar el estado a "Canceled" si la reserva está pendiente o confirmada
                $reservation->status = 'Canceled';
                $reservation->save();

                session()->flash('success', 'La reserva ha sido cancelada.');
            } else {
                session()->flash('error', 'La reserva no se puede cancelar en este estado.');
            }
        } else {
            session()->flash('error', 'La reserva no se encontró.');
        }
    }
    public function saveConsultation()
    {
        $this->validate([
            'diagnostico' => 'required|string|min:3',
            'recomendaciones' => 'required|string|min:3',
        ]);

        $consultation = Consultation::create([
            'reservation_id' => $this->reservation_id,
            'customer_id' => $this->customer_id,
            'pet_id' => $this->pet_id,
            'user_id' => $this->user_id,
            'consultation_date' => now(),
            'diagnostico' => $this->diagnostico,
            'recomendaciones' => $this->recomendaciones,
            'observations' => '',
        ]);

        // Guardar servicios seleccionados en la tabla pivote consultation_service
        $consultation->services()->sync($this->selected_services);

        // Cambiar estado de la reserva
        Reservation::find($this->reservation_id)->update(['status' => 'Completed']);

        $this->reset(['diagnostico', 'recomendaciones', 'openConsultationModal', 'selected_services']);

        session()->flash('message', 'Consulta registrada exitosamente.');
    }
}
