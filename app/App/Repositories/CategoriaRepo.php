<?php

namespace App\App\Repositories;

use App\App\Entities\Categoria;

class CategoriaRepo extends BaseRepo{

	public function getModel()
	{
		return new Categoria;
	}

}