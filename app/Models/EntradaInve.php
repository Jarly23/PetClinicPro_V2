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
        'expiration_date',
    ];

    // Relación con el modelo Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    // Accessor para formatear la fecha de vencimiento (opcional)
    public function getExpirationDateFormattedAttribute()
    {
        return $this->expiration_date 
            ? \Carbon\Carbon::parse($this->expiration_date)->format('d/m/Y') 
            : null;
    }
}
