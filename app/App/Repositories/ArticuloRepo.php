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

	/*PARA BLOG*/

	public function getByEstado($estados, $orderBy)
	{
		$fecha = date('Y-m-d');
		return Articulo::whereIn('estado',$estados)
						->where('fecha_publicacion','<=', $fecha)
						->with('categoria')->with('autor')
						->orderBy('created_at','DESC')->get();
	}

	public function getBetweenFechasByEstado($fechaInicio, $fechaFin, $estados)
	{
		$fecha = date('Y-m-d');
		return Articulo::whereIn('estado',$estados)
						->where('fecha_publicacion','<=', $fechaFin)
						->where('fecha_publicacion','>=', $fechaInicio)
						->with('categoria')->with('autor')
						->orderBy('created_at','DESC')->get();
	}

	public function getByCategoriaByPublicadoByPublico($categoriaId, $publicado, $publico)
	{
		$fecha = date('Y-m-d');
		return Articulo::where('categoria_id',$categoriaId)
						->whereIn('publicado',$publicado)
						->whereIn('publico',$publico)
						->where('fecha_publicacion','<=', $fecha)
						->with('categoria')->with('autor')
						->orderBy('created_at','DESC')->paginate(10);
	}

	public function getByAutorByPublicadoByPublico($autorId, $publicado, $publico)
	{
		$fecha = date('Y-m-d');
		return Articulo::where('autor_id',$autorId)
						->whereIn('publicado',$publicado)
						->whereIn('publico',$publico)
						->where('fecha_publicacion','<=', $fecha)
						->with('categoria')->with('autor')
						->orderBy('created_at','DESC')->paginate(10);
	}



}