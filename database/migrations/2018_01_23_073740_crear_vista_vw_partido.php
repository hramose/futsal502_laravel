<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearVistaVwPartido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      \DB::statement("
          CREATE  OR REPLACE VIEW `vw_partido` AS  (
            SELECT p.id, p.fecha, p.goles_local, p.goles_visita, p.faltas_local, p.faltas_visita, p.descripcion_penales, p.estado,
                   el.id equipo_local_id, el.descripcion descripcion_equipo_local, el.descripcion_corta descripcion_corta_equipo_local, el.siglas siglas_equipo_local, el.logo logo_equipo_local,
                   ev.id equipo_visita_id, ev.descripcion descripcion_equipo_visita, ev.descripcion_corta descripcion_corta_equipo_visita, ev.siglas siglas_equipo_visita, ev.logo logo_equipo_visita,
                   j.id jornada_id, j.descripcion jornada, j.fase fase, j.numero numero_jornada,
                   d.id domo_id, d.descripcion domo,
                   c.id campeonato_id, c.descripcion campeonato,
                   l.id liga_id, l.descripcion liga,
                   a.id arbitro_central_id, CONCAT(a.primer_nombre,' ',a.segundo_nombre,' ',a.primer_apellido,' ',a.segundo_apellido) arbitro_central
            FROM partido p
            INNER JOIN equipo el ON (el.id = p.equipo_local_id)
            INNER JOIN equipo ev ON (ev.id = p.equipo_visita_id)
            INNER JOIN jornada j ON (j.id = p.jornada_id)
            INNER JOIN domo d ON (d.id = p.domo_id)
            INNER JOIN campeonato c ON (c.id = p.campeonato_id)
            INNER JOIN liga l ON (l.id = c.liga_id)
            LEFT JOIN persona a ON  (a.id = p.arbitro_central_id)

          )
      ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
