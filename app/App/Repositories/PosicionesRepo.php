<?php

namespace App\App\Repositories;

class PosicionesRepo {

	protected $partidoRepo;

	public function __construct(PartidoRepo $partidoRepo)
	{
		$this->partidoRepo = $partidoRepo;
	}

    public function getTabla($campeonatoId, $partidos, $equipos)
	{
		foreach($partidos as $partido)
		{
            if($partido->estado != 'P')
            {
                $goles_local = $partido->goles_local != null ? $partido->goles_local : 0;
                $goles_visita = $partido->goles_visita != null ? $partido->goles_visita : 0;

                $equipoLocal = $this->obtenerEquipo($equipos, $partido->equipo_local_id);
                $equipoVisita = $this->obtenerEquipo($equipos, $partido->equipo_visita_id);

                $equipoLocal->GV = 0;
                $equipoVisita->GV = 0;

                /*EQUIPO LOCAL*/
                $equipoLocal->JJ += 1;

                if ($goles_local > $goles_visita) {
                    $equipoLocal->JG += 1;
                    $equipoLocal->PTS += 3;
                }
                else if ($goles_local < $goles_visita) {
                    $equipoLocal->JP += 1;
                }
                else {
                    $equipoLocal->JE += 1;
                    $equipoLocal->PTS += 1;
                }
                $equipoLocal->GF += $goles_local;
                $equipoLocal->GC += $goles_visita;
                $equipoLocal->DIF += ($goles_local - $goles_visita);

                /*EQUIPO VISITA*/
                $equipoVisita->JJ += 1;

                if ($goles_local > $goles_visita) {
                    $equipoVisita->JP += 1;
                }
                else if ($goles_local < $goles_visita) {
                    $equipoVisita->JG += 1;
                    $equipoVisita->PTS += 3;
                }
                else {
                    $equipoVisita->JE += 1;
                    $equipoVisita->PTS += 1;
                }
                $equipoVisita->GF += $goles_visita;
                $equipoVisita->GC += $goles_local;
                $equipoVisita->GV += $goles_visita;
                $equipoVisita->DIF += ($goles_visita - $goles_local);
            }
		}
		usort($equipos, array('App\App\Repositories\PosicionesRepo','cmp'));
		return $equipos;
	}

	function cmp( $a, $b ) {
        if ($a->PTS == $b->PTS) {
            if ($a->DIF == $b->DIF) {
                if($a->GF == $b->GF){
                    if($a->GC == $b->GC)
                    	return strcmp($a->equipo->descripcion, $b->equipo->descripcion);
                    else
                        return $a->GC > $b->GC ? -1 : 1;
                }
                else{
                    return $a->GF > $b->GF ? -1 : 1;
                }
            }
            return $a->DIF > $b->DIF ? -1 : 1;
        }
        return $a->PTS > $b->PTS ? -1 : 1;
	}

	public function obtenerEquipo(&$equipos, $equipoId)
	{
		foreach($equipos as $equipo){
			if($equipo->equipo->id == $equipoId)
				return $equipo;
		}
	}

}
