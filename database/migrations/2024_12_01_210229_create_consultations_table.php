<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Constraint\Constraint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_id')->constrained('pets');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('user_id')->constrained('users');
            $table->dateTime('consultation_date');

            $table->string('motivo_consulta')->nullable();
            $table->float('peso', 5, 2)->nullable();
            $table->float('temperatura', 4, 1)->nullable();
            $table->string('frecuencia_cardiaca')->nullable();
            $table->string('frecuencia_respiratoria')->nullable();
            $table->string('estado_general')->nullable();

            $table->boolean('desparasitacion')->default(false);
            $table->boolean('vacunado')->default(false);

            $table->text('observations')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('recomendaciones')->nullable();
            $table->text('tratamiento')->nullable();
            $table->foreignId('reservation_id')->nullable()->constrained('reservations');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
