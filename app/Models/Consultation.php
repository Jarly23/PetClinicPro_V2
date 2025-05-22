<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;
    protected $fillable = [
        'pet_id',
        'customer_id',
        'user_id',
        'reservation_id',
        'consultation_date',
        'motivo_consulta',
        'peso',
        'temperatura',
        'frecuencia_cardiaca',
        'frecuencia_respiratoria',
        'estado_general',
        'desparasitacion',
        'vacunado',
        'observations',
        'diagnostico',
        'recomendaciones',
        'tratamiento',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, 'consultation_service');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
