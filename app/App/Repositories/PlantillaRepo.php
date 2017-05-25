<?php

namespace App\App\Repositories;

use App\App\Entities\Plantilla;
use App\App\Entities\Persona;
use App\App\Entities\Campeonato;
use App\App\Repositories\AlineacionRepo;
use App\App\Repositories\EventoPartidoRepo;

class PlantillaRepo extends BaseRepo{

	public function getModel()
	{
		return new Plantilla;
	}

	public function getByCampeonatoByEquipo($campeonatoId, $equipoId)
	{
		$personas = Plantilla::where('campeonato_id','=',$campeonatoId)
						->where('equipo_id',$equipoId)
						->with('persona')
						->get();
		$personas = $personas->sortBy(function ($persona) { return strtolower(utf8_encode($persona->persona->nombreCompletoApellidos)); });
		return $personas;
	}

	public function getByCampeonatoByEquipoByRol($campeonatoId, $equipoId, $roles)
	{
		return Plantilla::where('campeonato_id','=',$campeonatoId)
						->where('equipo_id',$equipoId)
						->with('persona')
						->whereHas('persona', function($q) use ($roles){
							$q->whereIn('rol',$roles);
						})
						->get();
	}

	public function getPersonasByCampeonatoByEquipoByRol($campeonatoId, $equipoId, $roles)
	{	
		$personasIds = Plantilla::where('campeonato_id','=',$campeonatoId)
						->where('equipo_id',$equipoId)
						->pluck('persona_id');
		return Persona::whereIn('id', $personasIds)
    			->whereIn('rol',$roles)
    			->orderBy('primer_apellido')
    			->orderBy('segundo_apellido')
    			->orderBy('primer_nombre')
    			->orderBy('segundo_nombre')
    			->get();
	}

	public function getByCampeonatoByEquipoByRolByEstado($campeonatoId, $equipoId, $roles, $estados)
	{
		return Plantilla::where('campeonato_id','=',$campeonatoId)
						->where('equipo_id',$equipoId)
						->whereIn('estado',$estados)
						->with('persona')
						->with('persona.pais')
						->whereHas('persona', function($q) use ($roles){
							$q->whereIn('rol',$roles);
						})
						->get();
	}

	public function getPersonasNotInCampeonato($campeonatoId)
	{
		$ids = \DB::table('plantilla')
					->where('campeonato_id', '=', $campeonatoId)
					->pluck('persona_id');
    	return Persona::whereNotIn('id', $ids)->get();
	}

	public function getPersonasNotInCampeonatoByRol($campeonatoId, $roles)
	{
		$ids = \DB::table('plantilla')
					->where('campeonato_id', '=', $campeonatoId)
					->pluck('persona_id');
    	return Persona::whereNotIn('id', $ids)
    					->whereIn('rol',$roles)
    					->get();
	}

	public function getPlantilla($campeonato, $equipoId)
	{
		$alineacionRepo = new AlineacionRepo();
		$jugadores = $this->getPersonasByRol($campeonato->id, $equipoId, 2);

		$alineacionRepo = new AlineacionRepo();
		$eventoPartidoRepo = new eventoPartidoRepo();
		foreach($jugadores as $jugador){
			$jugador->minutos_jugados = $alineacionRepo->getMinutosJugados($campeonato->id, $jugador->id, [1,2]);

			$jugador->apariciones = $alineacionRepo->getApariciones($campeonato->id, $jugador->id, [1,2]);
			$eventos = $eventoPartidoRepo->getByPersonaByCampeonato($campeonato->id, $jugador->id, [6,8,10,11]);
			$goles = 0; $amarillas = 0; $doblesamarillas = 0; $rojas = 0;
			//$jugador->lugar_nacimiento = $this->getLugarNacimiento($jugador->departamento, $jugador->pais);
			foreach($eventos as $evento)
			{
				if($evento->evento_id == 6 || $evento->evento_id == 8) $goles++;
				if($evento->evento_id == 10) $amarillas++;
				if($evento->evento_id == 11){
					if($evento->doble_amarilla){ $doblesamarillas++; $amarillas--; }
					else $rojas++;
				}
			}
			$jugador->goles = $goles;
			$jugador->amarillas = $amarillas;
			$jugador->rojas = $rojas;
			$jugador->doblesamarillas = $doblesamarillas;

			if(strtotime($campeonato->fecha_fin) > time() ){
				$jugador->edad = intval( (time() - strtotime($jugador->fecha_nacimiento))/60/60/24/365 );
			}
			else{
				$jugador->edad = intval( (strtotime($campeonato->fecha_fin) - strtotime($jugador->fecha_nacimiento))/60/60/24/365 );
			}
		}
		return $jugadores;
	}

	public function getAutocompletePersonas($ligaId, $nombre, $roles)
	{
		$ids = CampeonatoEquipoPersona::whereHas('campeonato',function($q) use($ligaId)
									{
										$q->where('liga_id','=',$ligaId);
									})
								->lists('persona_id')->toArray();
		$personas = Persona::whereIn('id',$ids)->whereIn('rol_id',$roles)
							->Select(\DB::raw('id, CONCAT(primer_nombre," ",segundo_nombre," ",primer_apellido," ",segundo_apellido) as value'))
							->whereRaw('CONCAT(primer_nombre," ",segundo_nombre," ",primer_apellido," ",segundo_apellido) LIKE \'%'.$nombre.'%\'')
							->take(10)
							->get();
		return $personas;
	}


}