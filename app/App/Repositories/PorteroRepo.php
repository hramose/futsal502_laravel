<?php

namespace App\App\Repositories;

class PorteroRepo {

	public function getPorteros($campeonatoId){
		$porteros = $this->getPorterosWithMinutosJugados($campeonatoId);
		$golesEncajados = $this->getGolesEncajados($campeonatoId);
		//dd($golesEncajados);
		$today = time();
		foreach($porteros as $portero)
		{
			$edad = intval(( $today - strtotime($portero->fecha_nacimiento) ) / 60 / 60 / 24 / 365);
			$portero->edad = $edad;
		}

		foreach($golesEncajados as $gol)
		{
			$idJugador = $gol->jugador1_id;
			$fechaNacimiento = $gol->fecha_nacimiento;
			$fechaPartido = $gol->fecha;
			$edad = intval(( strtotime($fechaPartido) - strtotime($fechaNacimiento) ) / 60 / 60 / 24 / 365);
			$persona = $this->getPortero($porteros, $idJugador);
			if(!is_null($persona))
			{
				$persona->edad = $edad;
				$persona->goles = $persona->goles + 1;
			}
		}
		
		foreach($porteros as $portero)
		{
			$equipoId = $portero->equipoId;
			$numeroJornada = $this->getPartidosJugadosByEquipoByCampeonatoByFase($campeonatoId, $equipoId, 2);
			$minutosJugados = $portero->minutos_jugados;
			$partidosJugados = $minutosJugados / 90.00 ;
			$porcentaje = ( $partidosJugados * 100 ) / $numeroJornada ;
			$promedioGoles = $portero->goles / $partidosJugados;
			$portero->partidosJugados = number_format($partidosJugados,2);
			$portero->porcentaje = number_format($porcentaje,2);
			$portero->promedio = number_format($promedioGoles,2);
		}
		$size = sizeof($porteros);
		for($i=0; $i < $size; $i++)
		{
  			$portero = $porteros[$i];
    		if($portero->porcentaje < 70.00){
         		unset($porteros[$i]);
      		}
    	}
		usort($porteros, array('App\App\Repositories\PorteroRepo','cmp'));
		return $porteros;
	}

	public function getGolesEncajados($campeonatoId)
	{
		$golesEncajados = \DB::table('evento_partido')
			->join('partido','evento_partido.partido_id','=','partido.id')
			->join('jornada','jornada.id','=','partido.jornada_id')
			->join('evento','evento.id','=','evento_partido.evento_id')
			->join('persona','persona.id','=','evento_partido.jugador1_id')
			->where('partido.campeonato_id','=',$campeonatoId)
			->where('jornada.fase_id','=','2')
			->where('evento.id','=','20')->get();
		return $golesEncajados;
	}

	public function getPorterosWithMinutosJugados($campeonatoId)
	{
		$sql = "
			SELECT persona.id as personaId, 
				CONCAT(persona.primer_apellido,' ',persona.segundo_apellido,' ',persona.primer_nombre,' ',persona.segundo_nombre) as persona,
				persona.primer_nombre primernombre, persona.primer_apellido primerapellido,
				E.id equipoId, E.nombre as equipo, E.imagen as imagen_equipo, 0 as edad, persona.fecha_nacimiento,
				SUM(A.minutos_jugados) as minutos_jugados, 0 as goles,
				0 as partidosJugados, 0 as porcentaje, 0 as promedio
          	FROM alineacion A, partido P, persona, jornada J, equipo E
			WHERE A.partido_id = P.id
				AND A.equipo_id = E.id
				AND A.persona_id = persona.id
				AND P.jornada_id = J.id
				AND J.fase_id = 2
				AND persona.portero = 1
				AND P.campeonato_id = ".$campeonatoId."
				AND minutos_jugados != 0
			GROUP BY persona.id
		";
		$porteros = \DB::select(\DB::raw($sql));
		return $porteros;
	}

	public function getMinutosJugados($campeonatoId, $personaId, $fasesId)
	{
		$sql = "
			SELECT SUM(minutos_jugados) minutos
			FROM partido p, alineacion a, jornada j
			WHERE p.campeonato_id = " . $campeonatoId . "
				AND p.jornada_id = j.id
				AND a.partido_id = p.id
				AND j.fase_id IN (".$fasesId.")
				AND a.persona_id = " . $personaId
		;
		$minutos = \DB::select(\DB::raw($sql));
		return intval($minutos[0]->minutos);
	}

	public function &getPortero($porteros, $personaId)
	{
		foreach($porteros as $portero)
		{
			if($portero->personaId == $personaId){
				return $portero;
			}
		}
		dd($personaId);
		return null;
	}

	public function getPartidosJugadosByEquipoByCampeonatoByFase($campeonatoId, $equipoId, $faseId)
	{
		$sql = '
				SELECT *
				FROM partido P, jornada J
				WHERE P.campeonato_id = ' . $campeonatoId . '
				AND J.fase_id= '.$faseId.'
				AND (P.equipo_local_id = '.$equipoId.' OR P.equipo_visita_id = '.$equipoId.')
				AND P.estado_id != 1
				AND J.id = P.jornada_id
		';
		$jornadas = \DB::select(\DB::raw($sql));
		return sizeof($jornadas);
	}

	function cmp( $a, $b ) {
    if ($a->promedio == $b->promedio) {
      	return strcmp($a->persona, $b->persona);
    }
    return $a->promedio < $b->promedio ? -1 : 1;
	}

}
