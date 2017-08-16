<?php

namespace App\App\Repositories;

use App\App\Entities\Categoria;
use App\App\Entities\Articulo;

class CategoriaRepo extends BaseRepo{

	public function getModel()
	{
		return new Categoria;
	}

	public function getPopulares($limite)
	{
		$fecha = date('Y-m-d');
		$ids = Articulo::where('fecha_publicacion','<=', $fecha)
						->groupBy('categoria_id')
						->pluck('categoria_id');
		return Categoria::whereIn('id',$ids)->get();
	}

}