<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;
    protected $fillable = [
        'pet_id', 'customer_id', 'veterinarian_id', 'service_id', 'consultation_date', 'observations',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function veterinarian()
    {
        return $this->belongsTo(Veterinarian::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
