<?php

namespace App\App\Entities;
use Variable;

class Plantilla extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['equipo_id','campeonato_id','persona_id','dorsal','estado'];

	protected $table = 'plantilla';

	public function persona()
	{
		return $this->belongsTo(Persona::class);
	}

	public function campeonato()
	{
		return $this->belongsTo(Campeonato::class);
	}

	public function equipo()
	{
		return $this->belongsTo(Equipo::class);
	}

	public function getDescripcionEstadoAttribute()
	{
		return Variable::getEstadoGeneral($this->estado);
	}

	public function getDescripcionPosicionAttribute()
	{
		return Variable::getPosicion($this->posicion);
	}

}