<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->string("numero_factura");
            $table->string("fecha");
            $table->string("nombre_emisor");
            $table->string("nit_emisor");
            $table->string("nombre_receptor");
            $table->string("nit_receptor");
            $table->string("valor_sin_iva");
            $table->string("iva");
            $table->string("valor_total");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
