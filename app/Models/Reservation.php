<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_date',
        'status',
        'pet_id',
        'customer_id',
        'user_id',
        'service_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
