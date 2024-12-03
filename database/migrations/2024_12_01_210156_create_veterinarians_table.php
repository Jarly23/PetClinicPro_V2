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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('pet_id')->constrained('pets');
            $table->foreignId('veterinarian_id')->constrained('veterinarians');
            $table->foreignId('service_id')->constrained('services');
            $table->date('reservation_date'); // Solo fecha
            $table->time('start_time'); // Hora de inicio
            $table->time('end_time'); // Hora de fin
            $table->enum('status', ['Pending', 'Confirmed', 'Canceled'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
