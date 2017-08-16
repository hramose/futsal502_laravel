<?php

namespace App\Http\Controllers;
use Controller, Redirect, Input, Auth, View, Session, Variable;

use App\App\Entities\MediaArticulo;
use App\App\Repositories\MediaArticuloRepo;
use App\App\Managers\MediaArticuloManager;
use Illuminate\Http\Request;

use App\App\Entities\Articulo;

class MediaArticuloController extends BaseController {

	protected $mediaArticuloRepo;

	public function __construct(MediaArticuloRepo $mediaArticuloRepo)
	{
		$this->mediaArticuloRepo = $mediaArticuloRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(Articulo $articulo)
	{		
		$medias = $this->mediaArticuloRepo->all('created_at');
		return View::make('administracion/medias_articulos/listado', compact('medias','articulo'));
	}

	public function mostrarAgregarImagen(Articulo $articulo){
		return View::make('administracion/medias_articulos/agregar_imagen', compact('articulo'));
	}

	public function agregarImagen(Articulo $articulo)
	{
		$data = Input::all();
		$data['articulo_id'] = $articulo->id;
		$data['tipo'] = 'I';
		$manager = new MediaArticuloManager(new MediaArticulo(), $data);
		$manager->agregarImagen();
		Session::flash('success', 'Se agregaron las imagenes al articulo '.$articulo->titulo.' con éxito.');
		return redirect()->route('medias_articulos', $articulo->id);
	}

	public function mostrarAgregarVideo(Articulo $articulo){
		return View::make('administracion/medias_articulos/agregar_video', compact('articulo'));
	}

	public function agregarVideo(Articulo $articulo)
	{
		$data = Input::all();
		$data['articulo_id'] = $articulo->id;
		$data['tipo'] = 'V';
		$manager = new MediaArticuloManager(new MediaArticulo(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el video al articulo '.$articulo->titulo.' con éxito.');
		return redirect()->route('medias_articulos', $articulo->id);
	}

	public function eliminar()
	{
		$id = Input::get('media_articulo_id');
		$media = $this->mediaArticuloRepo->find($id);
		$articulo = $media->articulo;
		$manager = new MediaArticuloManager($media, null);
		$manager->delete();
		Session::flash('success', 'Se eliminó la media del articulo '.$articulo->titulo.' con éxito.');
		return redirect()->route('medias_articulos', $articulo->id);
	}
}
