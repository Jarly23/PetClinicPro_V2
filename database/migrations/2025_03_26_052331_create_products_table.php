<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_product'); // BIGINT UNSIGNED AUTO_INCREMENT
            $table->string('name');
            $table->text('description');
            $table->unsignedBigInteger('id_category'); // Clave foránea
            $table->unsignedBigInteger('id_supplier'); // Clave foránea
            $table->decimal('purchase_price', 8, 2);
            $table->decimal('sale_price', 8, 2);
            $table->integer('current_stock');
            $table->integer('minimum_stock');
            $table->timestamps();

            // Claves foráneas correctamente referenciadas
            $table->foreign('id_category')->references('id_category')->on('categories')->onDelete('cascade');
            $table->foreign('id_supplier')->references('id_supplier')->on('suppliers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
