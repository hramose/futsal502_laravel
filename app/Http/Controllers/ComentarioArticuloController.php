<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session, Variable;

use App\App\Entities\ComentarioArticulo;
use App\App\Repositories\ComentarioArticuloRepo;
use App\App\Managers\ComentarioArticuloManager;

use App\App\Entities\Articulo;

class ComentarioArticuloController extends BaseController {

	protected $comentarioArticuloRepo;

	public function __construct(ComentarioArticuloRepo $comentarioArticuloRepo)
	{
		$this->comentarioArticuloRepo = $comentarioArticuloRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(Articulo $articulo)
	{		
		$comentarios = $this->comentarioArticuloRepo->getByArticulo($articulo->id);
		return View::make('administracion/comentarios_articulos/listado', compact('comentarios','articulo'));
	}

	public function mostrarAgregar(Articulo $articulo){
		return View::make('administracion/comentarios_articulos/agregar_imagen', compact('articulo'));
	}

	public function agregar(Articulo $articulo)
	{
		$data = Input::all();
		$data['articulo_id'] = $articulo->id;
		$data['estado'] = 'A';
		$manager = new ComentarioArticuloManager(new ComentarioArticulo(), $data);
		$manager->save();
		Session::flash('success', 'Gracias por compartir tu opinión con nosotros.');
		$ruta = route('ver_articulo', [$articulo->id, str_slug($articulo->titulo)]) . '#comments';
		return redirect()->to($ruta);
	}

	public function eliminar()
	{
		$id = Input::get('comentario_articulo_id');
		$comentario = $this->comentarioArticuloRepo->find($id);
		$articulo = $comentario->articulo;
		$manager = new ComentarioArticuloManager($comentario, null);
		$manager->delete();
		Session::flash('success', 'Se eliminó la comentario del articulo '.$articulo->titulo.' con éxito.');
		return redirect()->route('comentarios_articulos', $articulo->id);
	}
}
