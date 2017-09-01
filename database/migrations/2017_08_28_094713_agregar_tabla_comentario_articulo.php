<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarTablaComentarioArticulo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentario_articulo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->longText('comentario');
            $table->integer('articulo_id')->unsigned();
            $table->string('estado',1);
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
        Schema::dropIfExists('comentario_articulo');
    }
}
