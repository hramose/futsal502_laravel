<?php

namespace Blog\Repositories;

class CalendarioRepo {

	public function __construct (ConfiguracionRepo $configuracionRepo)
	{
		$this->configuracionRepo = $configuracionRepo;
	}

	public function getCalendario($campeonato, $completo)
	{
		
	}

	public function groupByJornada($partidos){
		$jornadas = array();
		$i = 0;
		$jornada = '';
		$partidosByJornada = array();
		$newkey = 0;
		foreach($partidos as $partido){

			if($jornada == '')
			{
				$partidosByJornada[] = $partido;
				$jornada = $partido->jornada;
			}
			else
			{
				if($jornada != $partido->jornada){
					$jornadas[$i]['jornada'] = $jornada;
					$jornadas[$i]['partidos'] = $partidosByJornada;
					$i++;
					$jornada = $partido->jornada;
					$partidosByJornada = array();
					$partidosByJornada[] = $partido;
				}
				else
				{
					$jornada = $partido->jornada;
					$partidosByJornada[] = $partido;
				}
			}
		}
		$jornadas[$i]['jornada'] = $jornada;
		$jornadas[$i]['partidos'] = $partidosByJornada;
		return $jornadas;
	}

	public function getFechaSegunDia($diasSumados)
	{
		$today = date('Y-m-d');
		$nuevafecha = strtotime ( $diasSumados . ' day' , strtotime ( $today ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		return $nuevafecha;
	}

}