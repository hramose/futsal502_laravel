<?php

namespace App\Http\Controllers;

use App\App\Repositories\JornadaRepo;
use App\App\Managers\JornadaManager;
use App\App\Entities\Jornada;
use Controller, Redirect, Input, View, Session, Variable;

class JornadaController extends BaseController {

	protected $jornadaRepo;

	public function __construct(JornadaRepo $jornadaRepo)
	{
		$this->jornadaRepo = $jornadaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$jornadas = $this->jornadaRepo->all('numero');
		return view('administracion/jornadas/listado', compact('jornadas'));
	}

	public function mostrarAgregar()
	{
		$fases = Variable::getFases();
		$estados = Variable::getEstadosGenerales();
		return view('administracion/jornadas/agregar',compact('fases','estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new JornadaManager(new Jornada(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la jornada '.$data['descripcion'].' con éxito.');
		return redirect(route('jornadas'));
	}

	public function mostrarEditar($id)
	{
		$jornada = $this->jornadaRepo->find($id);
		$fases = Variable::getFases();
		$estados = Variable::getEstadosGenerales();
		return view('administracion/jornadas/editar', compact('jornada','fases','estados'));
	}

	public function editar($id)
	{
		$jornada = $this->jornadaRepo->find($id);
		$data = Input::all();
		$manager = new JornadaManager($jornada, $data);
		$manager->save();
		Session::flash('success', 'Se editó la jornada '.$jornada->descripcion.' con éxito.');
		return redirect(route('jornadas'));
	}


}