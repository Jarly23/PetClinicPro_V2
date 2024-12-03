<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'name',
        'species',
        'breed',
        'age',
        'weight',
        'owner_id',
    ];

    /**
     * Relación: una mascota pertenece a un propietario.
     */
    public function owner()
    {
        return $this->belongsTo(Customer::class, 'owner_id');
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}
