<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;
    protected $fillable = [
        'pet_id', 'customer_id', 'user_id', 'service_id', 'consultation_date', 'observations',
        'recomendaciones','diagnostico'
    ];

    public function pet()
    {   
        return $this->belongsTo(Pet::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
