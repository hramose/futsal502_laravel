<?php

namespace App\App\Repositories;

use App\App\Repositories\EventoPartidoRepo;
use App\App\ExtraEntities\Goleador;

class GoleadorRepo {

	protected $goleadores;

	public function getGoleadores($campeonato)
	{		
		$this->goleadores = array();
		$eventoPartidoRepo = new EventoPartidoRepo();

		$goles = $eventoPartidoRepo->getByCampeonato($campeonato->id, array(6,8));
		
		foreach($goles as $gol)
		{
			if($gol->partido->jornada->fase_id == 2)
			{
				$goleador = $this->getGoleador($gol->jugador1, $gol->equipo);
				$goleador->goles = $goleador->goles + 1;
			}
		}

		foreach($this->goleadores as $goleador){
			if(strtotime($campeonato->fecha_fin) > strtotime(date('Y-m-d H:i:s')))
			{
				$diff = abs(strtotime($campeonato->fecha_fin) - strtotime($goleador->jugador->fecha_nacimiento));	
				$goleador->jugador->fecha_nacimiento = intval($diff/60/60/24/365);
			}
			else
			{
				$diff = abs(strtotime(date("Y-m-d H:i:s")) - strtotime($goleador->jugador->fecha_nacimiento));	
				$goleador->jugador->fecha_nacimiento = intval($diff/60/60/24/365);
			}
			$goleador->minutos = $this->getMinutosJugados($campeonato->id, $goleador->jugador->id, 2);
			
		}

		usort($this->goleadores, array('App\App\Repositories\GoleadorRepo','cmp'));		
		
		return $this->goleadores;
	}

	function cmp( $a, $b ) {
		if ($a->goles == $b->goles) {

			if($a->minutos == $b->minutos)
	  			return strcmp($a->jugador->nombre_completo, $b->jugador->nombre_completo);
	  		return $a->minutos < $b->minutos ? -1 : 1;
   		}
		return $a->goles > $b->goles ? -1 : 1;
	}

	public function getGoleador($jugador, $equipo)
	{
		foreach($this->goleadores as $goleador)
		{
			if($goleador->jugador->id == $jugador->id)
			{
				return $goleador;
			}
		}
		$g = new Goleador($jugador, $equipo);
		$this->goleadores[] = $g;
		return $g;
	}

}
