<?php

namespace App\App\Repositories;

use App\App\Entities\Alineacion;
use App\App\Entities\Persona;

class AlineacionRepo extends BaseRepo{

	public function getModel()
	{
		return new Alineacion;
	}

	public function getTecnico($partidoId, $equipoId)
	{
		$alineacion = Alineacion::where('partido_id','=',$partidoId)
								->where('equipo_id',$equipoId)
								->whereHas('persona',function($q)
								{
									$q->where('rol',['D']);
								})
								->first();
		if(isset($alineacion)){
			return $alineacion->persona;
		}
		return null;
	}

	public function getByPartidoByEquipo($partidoId, $equipoId)
	{

		$alineacion = Alineacion::where('partido_id','=',$partidoId)
							->where('equipo_id','=',$equipoId)
							->with('persona')
							->whereHas('persona',function($q)
							{
								$q->where('rol',['J']);
							})
							->get();							
		$alineacion = $alineacion->sortBy(function ($jugador) { return strtolower(utf8_encode($jugador->persona->nombre_completo)); });
		return $alineacion;
	}

	public function getAlineacionByEstado($partidoId, $equipoId, $inicia)
	{

		$alineacion = Alineacion::where('partido_id','=',$partidoId)
							->where('equipo_id','=',$equipoId)
							->whereHas('persona',function($q)
							{
								$q->where('rol',['J']);
							})
							->get();

		$alineacion = $alineacion->sortBy(function ($jugador) { return strtolower(utf8_encode($jugador->persona->nombreCompletoApellidos)); });
		return $alineacion;
	}

	public function getByPartido($partidoId, $jugadorId)
	{
		return Alineacion::where('partido_id','=',$partidoId)
							->where('persona_id','=',$jugadorId)->first();
	}

	/*public function getListAlineacion($partidoId, $equipoId)
	{
		$ids = \DB::table('alineacion')
					->where('partido_id', '=', $partidoId)
					->where('equipo_id', '=', $equipoId)
					->lists('persona_id');
    	return Persona::whereIn('id', $ids)
    			->select('id',\DB::raw("
    				IF(portero = 0,
						CONCAT(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre),
						CONCAT(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' (P)')) as nombre"))
    			->orderBy('nombre')
    			->lists('nombre','id');
	}

	public function getListAlineacionByRol($partidoId, $equipoId, $rolId)
	{
		$ids = \DB::table('alineacion')
					->where('partido_id', '=', $partidoId)
					->where('equipo_id', '=', $equipoId)
					->lists('persona_id');
    	return Persona::whereIn('id', $ids)
    			->select('id',\DB::raw("
    				IF(portero = 0,
						CONCAT(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre),
						CONCAT(primer_apellido,' ',segundo_apellido,' ',primer_nombre,' ',segundo_nombre,' (P)')) as nombre"))
    			->where('rol_id','=',$rolId)
    			->orderBy('nombre')
    			->lists('nombre','id');
	}	

	public function getPartidosByJugadorByLiga($ligaId, $jugadorId)
	{
		return Alineacion::whereHas('partido',function($q) use ($ligaId){
					$q->whereHas('campeonato', function($q) use($ligaId){
						$q->where('liga_id',$ligaId);
					});
				})
				->where('persona_id','=',$jugadorId)
				->get();
	}

	public function getPartidosByJugadorByCampeonato($campeonatoId, $jugadorId)
	{
		return Alineacion::whereHas('partido',function($q) use ($campeonatoId){
					$q->where('campeonato_id','=',$campeonatoId);
				})
				->where('persona_id','=',$jugadorId)
				->where('minutos_jugados','>',0)
				->get();
	}

	public function getPartidosByJugadorByRival($ligaId, $rivalId, $jugadorId)
	{
		return Alineacion::whereHas('partido',function($q) use ($ligaId, $rivalId){
					$q->whereRaw('( equipo_local_id = '.$rivalId.' OR equipo_visita_id = '.$rivalId.' )')
						->whereHas('campeonato',function($q) use ($ligaId){
							$q->where('liga_id','=',$ligaId);
						});
				})
				->where('persona_id','=',$jugadorId)
				->where('minutos_jugados','>',0)
				->where('equipo_id','<>',$rivalId)
				->get();
	}

	public function getPartidosByJugadorByEquipo($ligaId, $equipoId, $jugadorId)
	{
		return Alineacion::whereHas('partido',function($q) use ($ligaId, $equipoId){
					$q->whereRaw('( equipo_local_id = '.$equipoId.' OR equipo_visita_id = '.$equipoId.' )')
						->whereHas('campeonato',function($q) use ($ligaId){
							$q->where('liga_id','=',$ligaId);
						});
				})
				->where('persona_id','=',$jugadorId)
				->where('minutos_jugados','>',0)
				->where('equipo_id','=',$equipoId)
				->get();
	}*/

}
