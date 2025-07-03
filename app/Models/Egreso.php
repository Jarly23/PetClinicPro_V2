<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Egreso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'monto',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    // Scope para filtrar por mes y año
    public function scopePorMes($query, $mes, $año = null)
    {
        if (!$año) {
            $año = now()->year;
        }
        
        return $query->whereMonth('fecha', $mes)
                    ->whereYear('fecha', $año);
    }

    // Scope para obtener egresos del mes actual
    public function scopeMesActual($query)
    {
        return $query->whereMonth('fecha', now()->month)
                    ->whereYear('fecha', now()->year);
    }

    // Método para obtener el total de egresos de un período
    public static function totalPorPeriodo($mes = null, $año = null)
    {
        if (!$mes) $mes = now()->month;
        if (!$año) $año = now()->year;
        
        return static::porMes($mes, $año)->sum('monto');
    }

    // Método para obtener estadísticas mensuales
    public static function estadisticasMensuales($año = null)
    {
        if (!$año) $año = now()->year;
        
        return static::whereYear('fecha', $año)
                    ->selectRaw('MONTH(fecha) as mes, SUM(monto) as total')
                    ->groupBy('mes')
                    ->orderBy('mes')
                    ->get();
    }
}
