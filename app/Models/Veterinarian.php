<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veterinarian extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'specialty',
        'photo'
    ];
}
