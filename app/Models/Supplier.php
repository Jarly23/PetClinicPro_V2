<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $primaryKey = 'id_supplier';

    protected $fillable = ['name', 'contact', 'phone', 'address', 'document_type', 'document_number'];

    public function products()
{
    return $this->hasMany(Product::class,'id_supplier');
}


}
