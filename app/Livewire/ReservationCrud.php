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
use Hamcrest\Type\IsBoolean;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class ReservationCrud extends Component
{
    use WithPagination;

    public $open = false;
    public $openConsultationModal = false;

    public $reservation_id, $reservation_date, $status = 'Pending',
        $pet_id, $customer_id, $user_id, $service_id;

    public $pets = [];
    public $diagnostico, $recomendaciones, $peso, $motivo_consulta, $temperatura, $estado_general,
        $tratamiento, $observations, $frecuencia_cardiaca, $frecuencia_respiratoria,
        $desparasitacion, $vacunado;
    public $selected_services = [];
    public $owner_found = false;

    protected $listeners = ['ownerSelected', 'saveReservation', 'clientSelected' => 'loadClientPets'];

    protected $rules = [
        'reservation_date' => 'required|date',
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

        $reservasDelDia = Reservation::where('user_id', $this->user_id)
            ->whereDate('reservation_date', $this->reservation_date)
            ->when($this->reservation_id, function ($query) {
                $query->where('id', '!=', $this->reservation_id);
            })
            ->count();

        if ($reservasDelDia >= 10) {
            session()->flash('error', 'El veterinario ya tiene el máximo de 10 reservas para este día.');
            return;
        }

        $data = [
            'customer_id' => $this->customer_id,
            'pet_id' => $this->pet_id,
            'user_id' => $this->user_id,
            'service_id' => $this->service_id,
            'reservation_date' => $this->reservation_date,
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
            $this->reservation_id = $reservation->id;
            $this->customer_id = $reservation->customer_id;
            $this->pet_id = $reservation->pet_id;
            $this->user_id = $reservation->user_id;
            $this->service_id = $reservation->service_id;
            $this->reservation_date = now();

            $this->motivo_consulta = '';
            $this->peso = '';
            $this->temperatura = '';
            $this->frecuencia_cardiaca = '';
            $this->frecuencia_respiratoria = '';
            $this->estado_general = '';
            $this->desparasitacion = false;
            $this->vacunado = false;
            $this->observations = '';
            $this->diagnostico = '';
            $this->recomendaciones = '';
            $this->tratamiento = '';
            $this->selected_services = [];

            $this->openConsultationModal = true;
        } else {
            session()->flash('error', 'No se puede iniciar la consulta para esta reserva.');
        }
    }

    public function cancelReservation($reservationId)
    {
        $reservation = Reservation::find($reservationId);

        if ($reservation) {
            if (in_array($reservation->status, ['Pending', 'Confirmed'])) {
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
            'motivo_consulta' => 'nullable|string|max:255',
            'peso' => 'nullable|numeric|min:0|max:100',
            'temperatura' => 'nullable|numeric|min:30|max:45',
            'frecuencia_cardiaca' => 'nullable|string|max:50',
            'frecuencia_respiratoria' => 'nullable|string|max:50',
            'estado_general' => 'nullable|string|max:100',
            'desparasitacion' => 'boolean',
            'vacunado' => 'boolean',
            'observations' => 'nullable|string',
            'diagnostico' => 'nullable|string',
            'recomendaciones' => 'nullable|string',
            'tratamiento' => 'nullable|string',
            'selected_services' => 'array|min:0',
            'selected_services.*' => 'exists:services,id',
        ]);

        // Si quieres que permita editar una consulta existente:
        $consultation = Consultation::updateOrCreate(
            ['reservation_id' => $this->reservation_id],
            [
                'customer_id' => $this->customer_id,
                'pet_id' => $this->pet_id,
                'user_id' => $this->user_id,
                'consultation_date' => now(),
                'motivo_consulta' => $this->motivo_consulta,
                'peso' => $this->peso === '' ? null : $this->peso,
                'temperatura' => $this->temperatura === '' ? null : $this->temperatura,
                'frecuencia_cardiaca' => $this->frecuencia_cardiaca === '' ? null : $this->frecuencia_cardiaca,
                'frecuencia_respiratoria' => $this->frecuencia_respiratoria === '' ? null : $this->frecuencia_respiratoria,
                'estado_general' => $this->estado_general,
                'desparasitacion' => $this->desparasitacion ?? false,
                'vacunado' => $this->vacunado ?? false,
                'observations' => $this->observations,
                'diagnostico' => $this->diagnostico,
                'recomendaciones' => $this->recomendaciones,
                'tratamiento' => $this->tratamiento,
            ]
        );

        $consultation->services()->sync($this->selected_services);

        // Actualiza estado de reserva a completada
        Reservation::find($this->reservation_id)->update(['status' => 'Completed']);

        // Resetea campos
        $this->reset([
            'diagnostico',
            'recomendaciones',
            'motivo_consulta',
            'tratamiento',
            'peso',
            'temperatura',
            'frecuencia_cardiaca',
            'frecuencia_respiratoria',
            'estado_general',
            'desparasitacion',
            'vacunado',
            'observations',
            'openConsultationModal',
            'selected_services',
        ]);

        session()->flash('message', 'Consulta registrada exitosamente.');
    }
}
