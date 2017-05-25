<?php

namespace App\Http\Controllers;

use App\App\Repositories\AlineacionRepo;
use App\App\Managers\AlineacionManager;
use App\App\Entities\Alineacion;
use Controller, Redirect, Input, View, Session;

use App\App\Repositories\PartidoRepo;
use App\App\Repositories\EquipoRepo;
use App\App\Repositories\PlantillaRepo;

class AlineacionController extends BaseController {

	protected $alineacionRepo;
	protected $partidoRepo;
	protected $equipoRepo;
	protected $plantillaRepo;

	public function __construct(AlineacionRepo $alineacionRepo, PartidoRepo $partidoRepo, EquipoRepo $equipoRepo, PlantillaRepo $plantillaRepo)
	{
		$this->alineacionRepo = $alineacionRepo;
		$this->partidoRepo = $partidoRepo;
		$this->equipoRepo = $equipoRepo;
		$this->plantillaRepo = $plantillaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function mostrarEditar($partidoId, $eventoId, $equipoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$equipo = $this->equipoRepo->find($equipoId);
		$tecnico = $this->alineacionRepo->getTecnico($partidoId, $equipoId);
		$alineacion = $this->alineacionRepo->getByPartidoByEquipo($partidoId, $equipoId);
		$tecnicos = $this->plantillaRepo->getPersonasByCampeonatoByEquipoByRol($partido->campeonato_id, $equipoId, ['DT'])->pluck('nombre_completo','id')->toArray();
		$jugadores = $this->plantillaRepo->getPersonasByCampeonatoByEquipoByRol($partido->campeonato_id, $equipoId, ['J']);
		foreach($alineacion as $a)
		{
			foreach($jugadores as $index => $jugador)
			{
				if($jugador->id == $a->persona_id)
				{
					if($a->inicia)
					{
						$jugadores[$index]->inicia = true;
					}
					else{
						$jugadores[$index]->suplente = true;
					}
				}
			}
		}

		$tecnicoId = 0;
		if(!is_null($tecnico)){
			$tecnicoId = $tecnico->id;
		}
		return view('administracion/alineaciones/editar', compact('tecnicos','jugadores','tecnicoId','partidoId','equipoId','equipo','eventoId','partido'));
	}

	public function editar($partidoId, $eventoId, $equipoId)
	{
		$data = Input::all();
		$alineacionManager = new AlineacionManager(null, $data);
		$alineacionManager->agregar($partidoId, $equipoId);
		Session::flash('success', 'Se agregó la alineación con éxito.');
		return redirect(route('editar_alineacion',[$partidoId, $eventoId, $equipoId]));
	}


}