<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_venta';

    protected $fillable = [
        'customer_id',
        'fecha',
        'total',
        'estado',
    ];

    // Relación con cliente
    public function cliente()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relación con detalles de venta
    public function detalles()
    {
        return $this->hasMany(detalle_venta::class, 'id_venta');
    }
}
