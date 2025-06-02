<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalle_venta extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_detalle';

    protected $fillable = [
        'id_venta',
        'id_product',
        'cantidad',
        'p_unitario',
        'total',
    ];

    public function venta()
    {
        return $this->belongsTo(Ventas::class, 'id_venta');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
