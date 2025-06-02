<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',

    ];
public function vaccines()
{
    return $this->belongsToMany(Vaccine::class, 'vaccine_disease')->withTimestamps();
}

}
