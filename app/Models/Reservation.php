<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'reservation_date',
        'time',
        'Status',
        'pet_id',
        'customer_id',
        'veterinarian_id',
        'service_id',
    ];
    public function veterinarian()
    {
        return $this->belongsTo(Veterinarian::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
