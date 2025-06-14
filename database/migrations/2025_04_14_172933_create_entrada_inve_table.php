<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('entradas_inve', function (Blueprint $table) {
            $table->id('id_entrada');
            $table->unsignedBigInteger('id_product'); // debe coincidir con el nombre de la PK en "products"
            $table->integer('cantidad');
            $table->dateTime('fecha');
            $table->decimal('precio_u', 8, 2);
            $table->date('expiration_date')->nullable();
            $table->timestamps();

            // Relación correcta con tabla products
            $table->foreign('id_product')
                  ->references('id_product')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('entradas_inve');
    }
};
