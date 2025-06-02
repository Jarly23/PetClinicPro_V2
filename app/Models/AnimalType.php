<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalType extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function pet ()
    {
        $this-> hasMany(Pet::class, 'pet_id');
    }
}
