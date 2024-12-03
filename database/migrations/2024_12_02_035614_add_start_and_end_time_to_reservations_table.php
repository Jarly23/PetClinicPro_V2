<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Añadir las columnas start_time y end_time
            $table->time('start_time')->after('reservation_date'); // Hora de inicio
            $table->time('end_time')->after('start_time'); // Hora de fin
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Eliminar las columnas start_time y end_time en caso de rollback
            $table->dropColumn(['start_time', 'end_time']);
        });
    }
};
