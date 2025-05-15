<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    use HasFactory;

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'name',
        'species',
        'breed',
        'age',
        'owner_id',
        'animal_type_id'
    ];

    /**
     * Relación: una mascota pertenece a un propietario.
     */
    public function animaltype(){
        return$this->belongsTo(AnimalType::class, 'animal_type_id');
    }
    public function owner()
    {
        return $this->belongsTo(Customer::class, 'owner_id');
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
    public function vaccineApplications()
{
    return $this->hasMany(VaccineApplication::class);
}
}
