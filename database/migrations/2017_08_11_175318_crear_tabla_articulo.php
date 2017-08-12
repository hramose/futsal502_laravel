<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaArticulo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->text('descripcion_corta')->nullable();
            $table->longtext('descripcion');
            $table->string('imagen_portada')->nullable();
            $table->integer('autor_id')->unsigned();
            $table->integer('categoria_id')->unsigned();
            $table->datetime('fecha_publicacion');
            $table->string('etiquetas')->nullable();
            $table->string('estado',1);
            $table->timestamps();
            $table->string('created_by');
            $table->string('updated_by');

            $table->foreign('autor_id')->references('id')->on('users');
            $table->foreign('categoria_id')->references('id')->on('categoria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulo');
    }
}
