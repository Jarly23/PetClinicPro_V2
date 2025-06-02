<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
class Pet extends Model
{
    use HasFactory;

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'name',
        'animal_type_id',
        'breed',
        'birth_date',
        'sex',
        'color',
        'sterilized',
        'photo',
        'owner_id',
    ];

    /**
     * Relación: una mascota pertenece a un propietario.
     */
    public function animaltype()
    {
        return $this->belongsTo(AnimalType::class, 'animal_type_id');
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

    protected function age(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->birth_date ? Carbon::parse($this->birth_date)->age : null,
        );
    }
}
