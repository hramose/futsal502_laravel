<?php

namespace App\App\Repositories;

use App\App\Entities\VwPartido;
use App\App\Entities\Persona;

class VwPartidoRepo extends BaseRepo{

	public function getModel()
	{
		return new VwPartido;
	}

	public function getByCampeonatoByFase($campeonatoId, $fases)
	{
		return VwPartido::where('campeonato_id',$campeonatoId)
					  ->whereIn('fase',$fases)
						->orderBy('fecha')
						->get();
	}

	public function getByCampeonatoByFaseByEstado($campeonatoId, $fases, $estados)
	{
		return VwPartido::where('campeonato_id',$campeonatoId)
						->whereIn('fase',$fases)
						->whereIn('estado',$estados)
						->orderBy('fecha')
						->get();
	}

	public function getByCampeonato($campeonatoId, $orderJornada='ASC')
	{
		return VwPartido::where('campeonato_id',$campeonatoId)
            ->orderBy('numero_jornada',$orderJornada)
						->orderBy('fecha')
						->get();
	}

	/*public function getByCampeonatoByEquipo($campeonatoId, $equipoId)
	{
		return VwPartido::where('campeonato_id',$campeonatoId)
						->whereRaw('(equipo_local_id = '.$equipoId .' OR equipo_visita_id = '.$equipoId.')')
						->orderBy('fecha')
						->get();
	}

	public function getFromFechaByCampeonatoByEstado($fecha, $campeonatoId,  $estados, $numeroVwPartidos)
	{
		return VwPartido::where('campeonato_id',$campeonatoId)
						->where('fecha','>=',$fecha)
						->whereIn('estado',$estados)
						->with('equipo_local')
						->with('equipo_visita')
						->orderBy('fecha','ASC')
						->limit($numeroVwPartidos)
						->get();
	}

	public function getByDia($fecha)
	{
		return VwPartido::whereBetween('fecha',[date('Y-m-d 00:00:00', strtotime($fecha)), date('Y-m-d 23:59:59', strtotime($fecha))])
						->orderBy('fecha')
						->get();
	}

	public function getByJornada($campeonatoId, $jornadaId)
	{
		return VwPartido::where('campeonato_id',$campeonatoId)
						->where('jornada_id',$jornadaId)
						->with('equipo_local')
						->with('equipo_visita')
						->with('domo')
						->orderBy('fecha')
						->get();
	}

	public function getOtrosByJornada($campeonatoId, $jornadaId,$partidoId)
	{
		return VwPartido::where('campeonato_id',$campeonatoId)
						->where('jornada_id',$jornadaId)
						->where('id','!=',$partidoId)
						->orderBy('fecha')
						->get();
	}

	public function getByCampeonatoByFechas($campeonatoId, $fechaInicio, $fechaFin)
	{
		$partidos = VwPartido::where('campeonato_id',$campeonatoId)
						->whereBetween('fecha',[$fechaInicio, $fechaFin])->orderBy('fecha')->get();
		$partidos = $partidos->sortBy(function($partido){
			return $partido->jornada->numero . strtotime($partido->fecha);
		});
		return $partidos;
	}

	public function getBetweenEquiposByEstado($ligaId, $equipo1Id, $equipo2Id, $estados)
	{
		return VwPartido::whereHas('campeonato',function($q) use($ligaId){
							$q->where('liga_id',$ligaId);
						})
						->whereIn('estado_id', $estados)
						->WhereRaw('( ( equipo_local_id = '.$equipo1Id.' AND equipo_visita_id = '.$equipo2Id.' ) OR (
										equipo_local_id = '.$equipo2Id.' AND equipo_visita_id = '.$equipo1Id.') )')
						->orderBy('fecha','DESC')
						->get();
	}

	private function orderByJornada($partidoA, $partidoB)
	{
		if(  $partidoA->jornada->numero ==  $partidoB->jornada->numero ){ return 0 ; }
  		return ($partidoA->jornada->numero < $partidoB->jornada->numero) ? -1 : 1;
	}*/

}
