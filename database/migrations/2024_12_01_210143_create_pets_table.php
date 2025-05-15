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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('animal_type_id')->constrained()->onDelete('cascade');
            $table->string('breed');
            $table->integer('age'); // Cambiamos de `date` a `integer` para la edad
            $table->foreignId('owner_id')->references('id')->on('customers')->onDelete('cascade'); // Relación con la tabla customers// Propietario
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
