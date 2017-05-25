<?php

namespace App\App\Entities;

class Alineacion extends \Eloquent {
	
	protected $fillable = ['partido_id','equipo_id','persona_id'];

	protected $table = 'alineacion';

	public function persona()
	{
		return $this->belongsTo(Persona::class);
	}

	public function partido()
	{
		return $this->belongsTo(Partido::class);
	}

	public function equipo()
	{
		return $this->belongsTo(Equipo::class);
	}

}