<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id_product';
    protected $fillable = [
        'name',
        'description',
        'id_category',
        'id_supplier',
        'purchase_price',
        'sale_price',
        'current_stock',
        'minimum_stock',
        'expiration_date'
    ];

    // Relación con Categoría
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    // Relación con Proveedor
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
    // Relación con Ventas (Producto vendido en una venta)
    public function ventas()
    {
        return $this->belongsToMany(Ventas::class, 'detalle_ventas', 'id_product', 'id_venta')
            ->withPivot('cantidad', 'p_unitario', 'total');
    }

    // Relación con DetalleVenta (Detalles de una venta)
    public function detalleVentas()
    {
        return $this->hasMany(detalle_venta::class, 'id_product');
    }
    public function vaccine()
    {
        return $this->hasMany(Vaccine::class);
    }
}
