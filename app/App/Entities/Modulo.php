<?php

namespace App\App\Entities;

class Modulo extends \Eloquent {

	use UserStamps;

	protected $fillable = ['descripcion'];

	protected $table = 'modulo';

}