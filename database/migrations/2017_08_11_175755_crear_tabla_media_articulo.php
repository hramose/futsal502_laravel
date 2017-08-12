<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaMediaArticulo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_articulo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ruta');
            $table->string('tipo',1);
            $table->integer('articulo_id')->unsigned();
            $table->timestamps();
            $table->string('created_by');
            $table->string('updated_by');
            $table->foreign('articulo_id')->references('id')->on('articulo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_articulo');
    }
}
