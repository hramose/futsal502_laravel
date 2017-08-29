<?php

namespace App\App\Repositories;

use App\App\Entities\ComentarioArticulo;

class ComentarioArticuloRepo extends BaseRepo{

	public function getModel()
	{
		return new ComentarioArticulo;
	}

	public function getByArticulo($articuloId)
	{
		return ComentarioArticulo::where('articulo_id',$articuloId)
							->get();
	}

	public function getByArticuloByEstado($articuloId, $estados)
	{
		return ComentarioArticulo::where('articulo_id',$articuloId)
							->whereIn('estado',$estados)
							->get();	
	}

}