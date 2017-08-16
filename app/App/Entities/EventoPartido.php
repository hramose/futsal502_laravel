<?php

namespace App\App\Entities;

class EventoPartido extends \Eloquent {

	use UserStamps;
	
	protected $fillable = ['partido_id','evento_id','minuto','segundo','doble_amarilla','persona_id','equipo_id','comentario'];

	protected $table = 'evento_partido';

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

	public function evento()
	{
		return $this->belongsTo(Evento::class);
	}

}