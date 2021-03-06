<?php

namespace App\App\Repositories;

use App\App\Entities\MediaArticulo;

class MediaArticuloRepo extends BaseRepo{

	public function getModel()
	{
		return new MediaArticulo;
	}

	public function getByArticulo($articuloId)
	{
		return MediaArticulo::where('articulo_id',$articuloId)
							->get();
	}

	public function getByArticuloByTipo($articuloId, $tipos)
	{
		return MediaArticulo::where('articulo_id',$articuloId)
							->whereIn('tipo',$tipos)
							->get();
	}

}