<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntradaInve extends Model
{
    use HasFactory;

    protected $table = 'entradas_inve';
    protected $primaryKey = 'id_entrada';

    protected $fillable = [
        'id_product',
        'cantidad',
        'fecha',
        'precio_u',
    ];

    // Relación con el modelo Product
    public function producto()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
