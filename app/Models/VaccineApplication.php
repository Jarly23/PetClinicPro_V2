<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineApplication extends Model
{

    use HasFactory;

    protected $fillable  = ['vaccine_id','application_date', 'notes', 'pet_id', 'user_id' , 'with_deworming'];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class);
    }

        public function user()
    {
        return $this->belongsTo(User::class);
    }
}
