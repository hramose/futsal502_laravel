<?php

namespace App\Http\Controllers;

use App\App\Repositories\CampeonatoRepo;
use App\App\Managers\CampeonatoManager;
use App\App\Entities\Campeonato;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Entities\Liga;
use App\App\Repositories\LigaRepo;

class CampeonatoController extends BaseController {

	protected $campeonatoRepo;
	protected $ligaRepo;

	public function __construct(CampeonatoRepo $campeonatoRepo, LigaRepo $ligaRepo)
	{
		$this->campeonatoRepo = $campeonatoRepo;
		$this->ligaRepo = $ligaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(Liga $liga)
	{
		$campeonatos = $this->campeonatoRepo->getByLiga($liga->id);
		return view('administracion/campeonatos/listado', compact('campeonatos','liga'));
	}

	public function mostrarAgregar(Liga $liga)
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/campeonatos/agregar', compact('liga','estados'));
	}

	public function agregar(Liga $liga)
	{
		$data = Input::all();
		$data['liga_id'] = $liga->id;
		$manager = new CampeonatoManager(new Campeonato(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el campeonato '.$data['descripcion'].' con éxito.');
		return redirect(route('campeonatos',$liga->id));
	}

	public function mostrarEditar(Campeonato $campeonato)
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/campeonatos/editar', compact('campeonato','estados'));
	}

	public function editar(Campeonato $campeonato)
	{
		$data = Input::all();
		$data['liga_id'] = $campeonato->liga_id;
		$manager = new CampeonatoManager($campeonato, $data);
		$manager->save();
		Session::flash('success', 'Se editó el campeonato '.$campeonato->descripcion.' con éxito.');
		return redirect(route('campeonatos', $campeonato->liga_id));
	}


}