<?php

namespace App\Http\Controllers;

use App\App\Repositories\PartidoRepo;
use App\App\Managers\PartidoManager;
use App\App\Entities\Partido;
use Controller, Redirect, Input, View, Session;

use App\App\Repositories\LigaRepo;
use App\App\Repositories\PersonaRepo;
use App\App\Repositories\DomoRepo;
use App\App\Repositories\JornadaRepo;
use App\App\Repositories\CampeonatoRepo;
use App\App\Repositories\CampeonatoEquipoRepo;
use App\App\Repositories\EventoRepo;

use App\App\Entities\Campeonato;
use App\App\Entities\Jornada;

class PartidoController extends BaseController {

	protected $ligaRepo;
	protected $partidoRepo;
	protected $personaRepo;
	protected $domoRepo;
	protected $jornadaRepo;
	protected $campeonatoRepo;
	protected $campeonatoEquipoRepo;
	protected $eventoRepo;

	public function __construct(PartidoRepo $partidoRepo, PersonaRepo $personaRepo, DomoRepo $domoRepo, JornadaRepo $jornadaRepo,
		CampeonatoRepo $campeonatoRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo, EventoRepo $eventoRepo, LigaRepo $ligaRepo)
	{
		$this->partidoRepo = $partidoRepo;
		$this->personaRepo = $personaRepo;
		$this->domoRepo = $domoRepo;
		$this->jornadaRepo = $jornadaRepo;
		$this->campeonatoRepo = $campeonatoRepo;
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
		$this->eventoRepo = $eventoRepo;
		$this->ligaRepo = $ligaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado($campeonatoId)
	{
		$jornadas = $this->jornadaRepo->lists('descripcion','id');
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$partidos = $this->partidoRepo->getByCampeonato($campeonatoId);
		return view('administracion/partidos/listado', compact('partidos','campeonato','jornadas'));
	}

	public function mostrarAgregar($campeonatoId)
	{
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$arbitros = array();
		$domos = $this->domoRepo->lists('descripcion','id');
		$jornadas = $this->jornadaRepo->lists('descripcion','id');
		$equipos = $campeonato->equipos->pluck('descripcion','id')->toArray();
		return view('administracion/partidos/agregar',compact('arbitros','domos','jornadas','campeonato','equipos'));
	}

	public function agregar($campeonatoId)
	{
		$data = Input::all();
		$data['campeonato_id'] = $campeonatoId;
		$data['estado_id'] = 1;
		$manager = new PartidoManager(new Partido(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el partido con éxito.');
		return redirect(route('agregar_partido_campeonato',$campeonatoId));
	}

	public function mostrarEditar($id)
	{
		$partido = $this->partidoRepo->find($id);
		$campeonato = $this->campeonatoRepo->find($partido->campeonato_id);
		$arbitros = array();
		$domos = $this->domoRepo->lists('descripcion','id');
		$jornadas = $this->jornadaRepo->lists('descripcion','id');
		$equipos = $campeonato->equipos->pluck('descripcion','id')->toArray();
		return view('administracion/partidos/editar', compact('partido','campeonato','arbitros','domos','jornadas','campeonato','equipos'));
	}

	public function editar($id)
	{
		$partido = $this->partidoRepo->find($id);
		$data = Input::all();
		$data['campeonato_id'] = $partido->campeonato_id;
		$data['estado_id'] = $partido->estado_id;
		$manager = new PartidoManager($partido, $data);
		$manager->save();
		Session::flash('success', 'Se editó el partido con éxito.');
		return redirect(route('partidos_campeonato',$partido->campeonato_id));
	}

	public function mostrarAgregarJornada($campeonatoId, $numeroPartidos)
	{
		$jornadas = $this->jornadaRepo->lists('descripcion','id');
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$equipos = $campeonato->equipos;
		$arbitros = $this->personaRepo->getByRol(['A']);
		$domos = $this->domoRepo->getByEstado(['A'], 'descripcion');
		return view('administracion/partidos/agregar_jornada', compact('arbitros','campeonato','jornadas', 'numeroPartidos','equipos','domos'));
	}

	public function agregarJornada($campeonatoId, $numeroPartidos){
		$data = Input::all();
		$manager = new PartidoManager(null, $data);
		$manager->agregarJornada($campeonatoId, $data);
		Session::flash('success', 'Se agregó la jornada con éxito.');
		return Redirect::back();
	}

	public function mostrarEditarJornada(Campeonato $campeonato, $jornadaId)
	{
		$jornada = $this->jornadaRepo->find($jornadaId);
		$jornadas = $this->jornadaRepo->lists('descripcion','id');
		$partidos = $this->partidoRepo->getByJornada($campeonato->id,$jornadaId);
		$arbitros = $this->personaRepo->getByRolByEstado(['A'],['A']);
		$domos = $this->domoRepo->getByEstado(['A'],'descripcion');
		return view('administracion/partidos/editar_jornada', compact('partidos','arbitros','jornada','campeonato','jornadas','jornadaId','domos'));
	}

	public function editarJornada($campeoantoId, $jornadaId){
		$data = Input::all();
		$manager = new PartidoManager(null, $data);
		$manager->editarJornada($data);
		Session::flash('success', 'Se editó la jornada con éxito.');
		return Redirect::back();
	}

	public function mostrarMonitorear($ligaId, $campeonatoId, $jornadaId, $partidoId, $equipoId)
	{
		$ligas = $this->ligaRepo->lists('descripcion','id');
		$jornadas = $this->jornadaRepo->lists('descripcion','id');
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
			$campeonatoId = $campeonato->id;
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}

		$campeonatos = $this->campeonatoRepo->getByLiga($ligaId)->pluck('descripcion','id')->toArray();
		$partidos = $this->partidoRepo->getByJornada($campeonatoId, $jornadaId);
		$partido = $this->partidoRepo->find($partidoId);
		$eventos = $this->eventoRepo->all('id');
		return view('administracion/partidos/monitorear', compact('partido','eventos','jornadas','ligas','campeonatos','partidos','ligaId','campeonatoId','jornadaId','equipoId'));
	}

	public function mostrarEditarMonitoreo(Partido $partido)
	{
		return view('administracion/partidos/editar_monitoreo', compact('partido'));
	}

	public function editarMonitoreo(Partido $partido)
	{
		$data = Input::all();
		$data['campeonato_id'] = $partido->campeonato_id;
		$data['estado'] = $partido->estado;
		$data['equipo_local_id'] = $partido->equipo_local_id;
		$data['equipo_visita_id'] = $partido->equipo_visita_id;
		$data['fecha'] = $partido->fecha;
		$data['jornada_id'] = $partido->jornada_id;
		$data['arbitro_central_id'] = $partido->arbitro_central_id;
		$manager = new PartidoManager($partido, $data);
		$manager->save();
		Session::flash('success', 'Se editó el partido con éxito.');
		return redirect()->route('monitorear_partido',[$partido->campeonato->liga_id, $partido->campeonato_id, $partido->jornada_id, $partido->id, $partido->equipo_local_id]);
	}


}