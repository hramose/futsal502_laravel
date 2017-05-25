<?php

namespace App\Http\Controllers;

use App\App\Repositories\LigaRepo;
use App\App\Managers\LigaManager;
use App\App\Entities\Liga;
use Controller, Redirect, Input, View, Session, Variable;

class LigaController extends BaseController {

	protected $ligaRepo;

	public function __construct(LigaRepo $ligaRepo)
	{
		$this->ligaRepo = $ligaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$ligas = $this->ligaRepo->all('descripcion');
		return view('administracion/ligas/listado', compact('ligas'));
	}

	public function mostrarAgregar()
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/ligas/agregar',compact('estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new LigaManager(new Liga(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la liga '.$data['descripcion'].' con éxito.');
		return redirect(route('ligas'));
	}

	public function mostrarEditar(Liga $liga)
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/ligas/editar', compact('liga','estados'));
	}

	public function editar(Liga $liga)
	{
		$data = Input::all();
		$manager = new LigaManager($liga, $data);
		$manager->save();
		Session::flash('success', 'Se editó la liga '.$liga->descripcion.' con éxito.');
		return redirect(route('ligas'));
	}


}