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
            $table->date('birth_date'); // Fecha de nacimiento
            $table->enum('sex', ['Macho', 'Hembra']); // Sexo
            $table->string('color')->nullable(); // Color
            $table->boolean('sterilized')->default(false); // Esterilizado
            $table->string('photo')->nullable(); // Foto (ruta)
            $table->foreignId('owner_id')->constrained('customers')->onDelete('cascade');
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
