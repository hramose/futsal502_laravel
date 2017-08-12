<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session, Variable;

use App\App\Entities\Categoria;
use App\App\Repositories\CategoriaRepo;
use App\App\Managers\CategoriaManager;

class CategoriaController extends BaseController {

	protected $categoriaRepo;
	protected $contactoCategoriaRepo;

	public function __construct(CategoriaRepo $categoriaRepo)
	{
		$this->categoriaRepo = $categoriaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$categorias = $this->categoriaRepo->all('descripcion');
		return View::make('administracion/categorias/listado', compact('categorias'));
	}

	public function mostrarAgregar(){
		$estados = Variable::getEstadosGenerales();
		return View::make('administracion/categorias/agregar', compact('estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new CategoriaManager(new Categoria(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó la categoria '.$data['descripcion'].' con éxito.');
		return redirect()->route('categorias');
	}

	public function mostrarEditar(Categoria $categoria){
		$estados = Variable::getEstadosGenerales();
		return View::make('administracion/categorias/editar', compact('categoria','estados'));
	}

	public function editar(Categoria $categoria)
	{
		$data = Input::all();
		$manager = new CategoriaManager($categoria, $data);
		$manager->save();
		Session::flash('success', 'Se editó la categoria '.$categoria->descripcion.' con éxito.');
		return redirect()->route('categorias');
	}
}
