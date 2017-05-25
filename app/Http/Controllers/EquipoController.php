<?php

namespace App\Http\Controllers;

use App\App\Repositories\EquipoRepo;
use App\App\Managers\EquipoManager;
use App\App\Entities\Equipo;
use Controller, Redirect, Input, View, Session, Variable;

class EquipoController extends BaseController {

	protected $equipoRepo;

	public function __construct(EquipoRepo $equipoRepo)
	{
		$this->equipoRepo = $equipoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$equipos = $this->equipoRepo->all('descripcion');
		return view('administracion/equipos/listado', compact('equipos'));
	}

	public function mostrarAgregar()
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/equipos/agregar', compact('estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new EquipoManager(new Equipo(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el equipo '.$data['descripcion'].' con éxito.');
		return redirect(route('equipos'));
	}

	public function mostrarEditar(Equipo $equipo)
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/equipos/editar', compact('equipo','estados'));
	}

	public function editar(Equipo $equipo)
	{
		$data = Input::all();
		$manager = new EquipoManager($equipo, $data);
		$manager->save();
		Session::flash('success', 'Se editó el equipo '.$equipo->descripcion.' con éxito.');
		return redirect(route('equipos'));
	}


}