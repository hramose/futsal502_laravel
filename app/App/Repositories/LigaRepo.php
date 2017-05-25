<?php

namespace App\App\Repositories;

use App\App\Entities\Liga;

class LigaRepo extends BaseRepo{

	public function getModel()
	{
		return new Liga;
	}

}