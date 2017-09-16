<?php

namespace App\Http\Controllers;

use App\App\Repositories\CampeonatoEquipoRepo;
use App\App\Managers\CampeonatoEquipoManager;
use App\App\Entities\CampeonatoEquipo;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Repositories\CampeonatoRepo;

class CampeonatoEquipoController extends BaseController {

	protected $campeonatoEquipoRepo;
	protected $campeonatoRepo;

	public function __construct(CampeonatoEquipoRepo $campeonatoEquipoRepo, CampeonatoRepo $campeonatoRepo)
	{
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
		$this->campeonatoRepo = $campeonatoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado($campeonatoId)
	{
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$equipos = $this->campeonatoEquipoRepo->getEquiposByCampeonato($campeonatoId);
		return view('administracion/campeonatos_equipos/listado', compact('campeonato','equipos'));
	}

	public function mostrarAgregar($campeonatoId)
	{
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$equipos = $this->campeonatoEquipoRepo->getEquiposNotInCampeonato($campeonatoId);
		$grupos = Variable::getGrupos();
		return view('administracion/campeonatos_equipos/agregar', compact('campeonato','equipos','grupos'));
	}

	public function agregar($campeonatoId)
	{
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$data = Input::all();
		$manager = new CampeonatoEquipoManager(new CampeonatoEquipo(), $data);
		$manager->agregarEquipos($campeonatoId);
		Session::flash('success', 'Se agregaron los equipos al campeonato '.$campeonato->descripcion.' con éxito.');
		return redirect(route('campeonatos_equipos',$campeonato->id));
	}

	public function editar($campeonatoId)
	{
		$campeonato = $this->campeonatoRepo->find($campeonatoId);
		$data = Input::all();
		$manager = new CampeonatoEquipoManager(null, $data);
		$manager->eliminarEquipos();
		Session::flash('success', 'Se eliminaron los equipos del campeonato '.$campeonato->descripcion.' con éxito.');
		return redirect(route('campeonatos_equipos', $campeonato->id));
	}

	public function mostrarTrasladarEquipos($campeonatoNuevo, $campeonatoAntiguo)
	{
		$campeonato = $this->campeonatoRepo->find($campeonatoNuevo);
		$campeonatos = $this->campeonatoRepo->getByLiga($campeonato->liga_id)->pluck('descripcion','id')->toArray();
		$equipos = $this->campeonatoEquipoRepo->getEquiposByCampeonato($campeonatoAntiguo);
		return view('administracion/campeonatos_equipos/trasladar_equipos', compact('campeonato','campeonatos','equipos','campeonatoAntiguo'));
	}

	public function trasladarEquipos($campeonatoNuevo, $campeonatoAntiguo)
	{
		$campeonato = $this->campeonatoRepo->find($campeonatoNuevo);
		$data = Input::all();
		$manager = new CampeonatoEquipoManager(null, $data);
		$manager->trasladarEquipos($campeonatoNuevo, $campeonatoAntiguo);
		Session::flash('success', 'Se eliminaron los equipos del campeonato con éxito.');
		return redirect(route('campeonatos_equipos', $campeonato->id));
	}


}