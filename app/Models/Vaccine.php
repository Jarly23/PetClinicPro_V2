<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'application_interval_days'];

public function diseases()
{
    return $this->belongsToMany(Disease::class, 'vaccine_disease')->withTimestamps();
}
}
