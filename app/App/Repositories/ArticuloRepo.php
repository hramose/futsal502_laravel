<?php

namespace App\App\Repositories;

use App\App\Entities\Articulo;

class ArticuloRepo extends BaseRepo{

	public function getModel()
	{
		return new Articulo;
	}

	public function all($orderBy)
	{
		return Articulo::with('autor')->with('categoria')->orderBy($orderBy)->get();
	}

	public function getByCategoria($categoriaId)
	{
		return Articulo::where('categoria_id',$categoriaId)
						->with('categoria')->with('autor')
						->orderBy('created_at','DESC')->get();
	}

	public function getByAutor($autorId)
	{
		return Articulo::where('autor_id',$autorId)
						->with('categoria')->with('autor')
						->orderBy('created_at','DESC')->get();
	}

	public function getByEstado($estados, $orderBy)
	{
		$fecha = date('Y-m-d H:i');
		return Articulo::whereIn('estado',$estados)
						->where('fecha_publicacion','<=', $fecha)
						->with('categoria')->with('autor')
						->orderBy('fecha_publicacion','DESC')->get();
	}

	/*PARA BLOG*/

	public function getPublicadas()
	{
		$fecha = date('Y-m-d H:i');
		return Articulo::whereIn('estado',['A'])
						->where('fecha_publicacion','<=', $fecha)
						->with('categoria')->with('autor')
						->orderBy('fecha_publicacion','DESC')->paginate(10);
	}

	public function getBetweenFechasByEstado($fechaInicio, $fechaFin, $estados)
	{
		$fecha = date('Y-m-d H:i');
		return Articulo::whereIn('estado',$estados)
						->where('fecha_publicacion','<=', $fechaFin)
						->where('fecha_publicacion','>=', $fechaInicio)
						->with('categoria')->with('autor')
						->orderBy('fecha_publicacion','DESC')->get();
	}

	public function getByAutorByCategoriaByEstado($autorId, $categoriaId, $estados)
	{
		$fecha = date('Y-m-d H:i');
		return Articulo::where('categoria_id',$categoriaId)
						->where('autorId',$autorId)
						->whereIn('estado',$estados)
						->where('fecha_publicacion','<=', $fecha)
						->with('categoria')->with('autor')
						->orderBy('fecha_publicacion','DESC')->paginate(10);
	}

	public function getByCategoriaByEstado($categoriaId, $estados)
	{
		$fecha = date('Y-m-d H:i');
		return Articulo::where('categoria_id',$categoriaId)
						->whereIn('estado',$estados)
						->where('fecha_publicacion','<=', $fecha)
						->with('categoria')->with('autor')
						->orderBy('fecha_publicacion','DESC')->paginate(10);
	}

	public function getByAutorByEstado($autorId, $estados)
	{
		$fecha = date('Y-m-d H:i');
		return Articulo::where('autor_id',$autorId)
						->whereIn('estado',$estados)
						->where('fecha_publicacion','<=', $fecha)
						->with('categoria')->with('autor')
						->orderBy('fecha_publicacion','DESC')->paginate(10);
	}

	public function getPopulares($limite)
	{
		$fecha = date('Y-m-d H:i');
		return Articulo::where('fecha_publicacion','<=', $fecha)
						->with('categoria')->with('autor')
						->orderBy('vistas','DESC')
						->orderBy('fecha_publicacion','DESC')
						->limit($limite)
						->get();
	}

	public function getUltimas($limite)
	{
		$fecha = date('Y-m-d H:i');
		return Articulo::where('fecha_publicacion','<=', $fecha)
						->with('categoria')->with('autor')
						->orderBy('fecha_publicacion','DESC')
						->limit($limite)
						->get();
	}

}