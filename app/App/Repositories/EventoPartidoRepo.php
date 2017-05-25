<?php

namespace App\App\Repositories;

use App\App\Entities\EventoPartido;
use App\App\Entities\Persona;

class EventoPartidoRepo extends BaseRepo{

	public function getModel()
	{
		return new EventoPartido;
	}

	public function getByPartido($partidoId)
	{
		return EventoPartido::where('partido_id',$partidoId)
					->with('partido')
					->with('evento')
					->orderBy('minuto','DESC')
					->orderBy('segundo','DESC')
					->orderBy('id','DESC')
					->get();
	}

	public function getEnVivo($partidoId)
	{
		return EventoPartido::where('partido_id',$partidoId)
					->where('evento_id','!=',20)
					->orderBy('minuto','DESC')
					->orderBy('segundo','DESC')
					->orderBy('id','DESC')
					->get();
	}

	public function getByCampeonato($campeonatoId, $eventos)
	{
		return EventoPartido::whereHas('partido',function($q) use ($campeonatoId)
		{
			$q->where('campeonato_id',$campeonatoId);
		})
		->whereIn('evento_id',$eventos)
		->get();
	}

	public function getByPersonaByCampeonato($campeonatoId, $personaId, $eventos)
	{
		return EventoPartido::whereHas('partido', function($q) use ($campeonatoId)
					{
						$q->where('campeonato_id',$campeonatoId);	
					})
					->whereIn('evento_id',$eventos)
					->where('persona_id','=',$personaId)
					->get();
	}

	public function getByEventos($partidoId, $eventos)
	{
		return EventoPartido::where('partido_id','=',$partidoId)
							->whereIn('evento_id',$eventos)
							->orderBy('minuto','ASC')
							->orderBy('segundo','ASC')
							->get();
	}

	public function getByEventosByPartidos($partidos, $eventos)
	{
		return EventoPartido::whereIn('partido_id',$partidos)
							->whereIn('evento_id',$eventos)
							->get();
	}

	public function getByEventosByEquipo($partidoId, $eventos, $equipoId)
	{
		return EventoPartido::where('partido_id','=',$partidoId)
							->whereIn('evento_id',$eventos)
							->where('equipo_id','=',$equipoId)
							->orderBy('minuto','ASC')
							->orderBy('segundo','ASC')
							->get();
	}

}