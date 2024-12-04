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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); // Campo id
            $table->unsignedBigInteger('customer_id'); // Campo id_cliente
            $table->date('date'); // Campo fecha
            $table->string('details'); // Campo detalles
            $table->decimal('total', 10, 2); // Campo total
            $table->string('invoice_number'); // Campo número_de_factura
            $table->string('ruc'); // Campo ruc
            $table->timestamps(); // Campos de marcas de tiempo

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade'); // Relación con la tabla customers
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
