<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPartido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partido', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campeonato_id')->unsigned();
            $table->datetime('fecha');
            $table->integer('equipo_local_id')->unsigned();
            $table->integer('equipo_visita_id')->unsigned();
            $table->integer('goles_local')->nullable();
            $table->integer('goles_visita')->nullable();
            $table->integer('faltas_local')->nullable();
            $table->integer('faltas_visita')->nullable();
            $table->integer('jornada_id')->unsigned();
            $table->integer('arbitro_central_id')->unsigned()->nullable();
            $table->integer('domo_id')->unsigned();
            $table->string('descripcion_penales')->nullable();
            $table->string('estado',1);
            $table->timestamps();
            $table->string('created_by',45);
            $table->string('updated_by',45);

            $table->foreign('campeonato_id')->references('id')->on('campeonato');
            $table->foreign('equipo_local_id')->references('id')->on('equipo');
            $table->foreign('equipo_visita_id')->references('id')->on('equipo');
            $table->foreign('jornada_id')->references('id')->on('jornada');
            $table->foreign('domo_id')->references('id')->on('domo');
            $table->foreign('arbitro_central_id')->references('id')->on('persona');

            $table->unique(['campeonato_id','equipo_local_id','equipo_visita_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partido');
    }
}
