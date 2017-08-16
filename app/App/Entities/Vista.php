<?php

namespace App\App\Entities;

class Vista extends \Eloquent {

	use UserStamps;

	protected $fillable = ['nombre','ruta','icono','menu','modulo_id'];

	protected $table = 'vista';

	public function modulo()
	{
		return $this->belongsTo('App\App\Entities\Modulo');
	}

}