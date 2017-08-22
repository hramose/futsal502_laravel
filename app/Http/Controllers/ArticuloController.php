<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session, Variable;

use App\App\Entities\Articulo;
use App\App\Repositories\ArticuloRepo;
use App\App\Managers\ArticuloManager;
use Illuminate\Http\Request;

use App\App\Repositories\CategoriaRepo;

class ArticuloController extends BaseController {

	protected $articuloRepo;
	protected $categoriaRepo;

	public function __construct(ArticuloRepo $articuloRepo, CategoriaRepo $categoriaRepo)
	{
		$this->articuloRepo = $articuloRepo;
		$this->categoriaRepo = $categoriaRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		
		$articulos = $this->articuloRepo->all('fecha_publicacion');
		return View::make('administracion/articulos/listado', compact('articulos'));
	}

	public function mostrarAgregar(){
		$estados = Variable::getEstadosGenerales();
		$categorias = $this->categoriaRepo->getByEstado(['A'],'descripcion')->pluck('descripcion','id')->toArray();
		return View::make('administracion/articulos/agregar', compact('categorias','estados'));
	}

	public function agregar()
	{
		$data = Input::all();
		$data['autor_id'] = \Auth::user()->id;
		$data['vistas'] = 0;
		$manager = new ArticuloManager(new Articulo(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el articulo '.$data['titulo'].' con éxito.');
		return redirect()->route('articulos');
	}

	public function mostrarEditar(Articulo $articulo){
		$estados = Variable::getEstadosGenerales();
		$categorias = $this->categoriaRepo->getByEstado(['A'],'descripcion')->pluck('descripcion','id')->toArray();
		return View::make('administracion/articulos/editar', compact('articulo','categorias','estados'));
	}

	public function editar(Request $request, Articulo $articulo)
	{
		$data = Input::all();
		$data['autor_id'] = $articulo->autor_id;
		$manager = new ArticuloManager($articulo, $data);
		$manager->save();
		Session::flash('success', 'Se editó el articulo '.$articulo->titulo.' con éxito.');
		return redirect()->route('articulos');
	}

	public function ver(Articulo $articulo){
		return View::make('administracion/articulos/ver', compact('articulo'));
	}
}
