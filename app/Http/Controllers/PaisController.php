<?php

namespace App\Http\Controllers;

use App\App\Repositories\PaisRepo;
use App\App\Managers\PaisManager;
use App\App\Entities\Pais;
use Controller, Redirect, Input, View, Session, Variable;

class PaisController extends BaseController {

	protected $paisRepo;

	public function __construct(PaisRepo $paisRepo)
	{
		$this->paisRepo = $paisRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$paises = $this->paisRepo->all('descripcion');
		return view('administracion/paises/listado', compact('paises'));
	}

	public function mostrarAgregar()
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/paises/agregar',compact('estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new PaisManager(new Pais(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el pais '.$data['descripcion'].'con éxito.');
		return redirect(route('paises'));
	}

	public function mostrarEditar(Pais $pais)
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/paises/editar', compact('pais','estados'));
	}

	public function editar(Pais $pais)
	{
		$data = Input::all();
		$manager = new PaisManager($pais, $data);
		$manager->save();
		Session::flash('success', 'Se editó el pais '.$pais->descripcion.' con éxito.');
		return redirect(route('paises'));
	}


}