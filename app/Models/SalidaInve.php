<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidaInve extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_salida';

    protected $fillable = [
        'id_product',
        'cantidad',
        'fecha',
        'razon',
    ];

    public function producto()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
