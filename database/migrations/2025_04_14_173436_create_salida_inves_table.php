<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalidaInvesTable extends Migration
{
    public function up()
    {
        Schema::create('salida_inves', function (Blueprint $table) {
            $table->id('id_salida');
            $table->unsignedBigInteger('id_product');
            $table->integer('cantidad');
            $table->dateTime('fecha');
            $table->string('razon');
            $table->timestamps();

            $table->foreign('id_product')->references('id_product')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('salida_inves');
    }
}

