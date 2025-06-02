<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ventas;
class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',
        'address',
        'dni'
    ];
    public function ventas()
    {

        return $this->hasMany(ventas::class, 'customer_id');


    }
}
