<?php

namespace App\App\Entities;
use Variable;

class Campeonato extends \Eloquent {

	use UserStamps;

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

	public function getDescripcionActualAttribute()
	{
		if($this->actual)
			return '<i class="fa fa-check square bg-green"></i>';
		else
			return '<i class="fa fa-times square bg-red"></i>';
	}

	public function getDescripcionMostrarAppAttribute()
	{
		if($this->mostrar_app)
			return '<i class="fa fa-check square bg-green"></i>';
		else
			return '<i class="fa fa-times square bg-red"></i>';
	}

	public function getDescripcionGruposAttribute()
	{
		if($this->grupos)
			return '<i class="fa fa-check square bg-green"></i>';
		else
			return '<i class="fa fa-times square bg-red"></i>';
	}

}