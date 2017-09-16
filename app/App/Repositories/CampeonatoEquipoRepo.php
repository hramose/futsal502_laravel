<?php

namespace App\App\Repositories;

use App\App\Entities\CampeonatoEquipo;
use App\App\Entities\Equipo;
use App\App\Entities\Campeonato;
use App\App\ExtraEntities\EquipoPosicion;

class CampeonatoEquipoRepo extends BaseRepo{

	public function getModel()
	{
		return new CampeonatoEquipo;
	}

	public function getEquiposByCampeonato($campeonatoId)
	{
		return CampeonatoEquipo::where('campeonato_id',$campeonatoId)
								->with('equipo')
								->get();
	}

	public function getEquipoByCampeonato($campeonatoId, $equipoId)
	{
		return CampeonatoEquipo::where('campeonato_id',$campeonatoId)
								->where('equipo_id',$equipoId)->first();
	}

	public function getEquiposNotInCampeonato($campeonatoId)
	{
		$ids = \DB::table('campeonato_equipo')
					->where('campeonato_id', '=', $campeonatoId)
					->pluck('equipo_id');
    	return Equipo::whereNotIn('id', $ids)->get();
	}

	public function getEquiposWithPosiciones($campeonatoId)
	{
		 $equiposCampeonato = CampeonatoEquipo::where('campeonato_id',$campeonatoId)
		 										->with('equipo')
		 										->get();
		 $equipos = array();
		 foreach($equiposCampeonato as $equipo)
		 {
		 	$e = new EquipoPosicion($equipo->equipo, $equipo->grupo);
		 	$equipos[] = $e;
		 }
		 return $equipos;
	}

}