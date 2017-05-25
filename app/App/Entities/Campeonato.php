<?php

namespace App\App\Entities;
use Variable;

class Campeonato extends \Eloquent {

	protected $fillable = ['descripcion','liga_id','fecha_inicio','fecha_fin','hashtag','actual','grupos','mostrar_app','estado'];

	protected $table = 'campeonato';
	
	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function liga()
	{
		return $this->belongsTo(Liga::class);
	}

	public function equipos()
	{
		return $this->belongsToMany(Equipo::class, 'campeonato_equipo');
	}

}