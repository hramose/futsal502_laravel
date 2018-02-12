<?php

namespace App\App\Repositories;

use App\App\Entities\Liga;

class LigaRepo extends BaseRepo{

	public function getModel()
	{
		return new Liga;
	}

	public function getForApp()
	{
		return Liga::where('mostrar_app',1)->orderBy('orden')->select('id','descripcion')->get();
	}

}
