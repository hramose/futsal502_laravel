<?php

namespace App\App\Entities;

class Perfil extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['nombre'];

	protected $table = 'perfil';

}