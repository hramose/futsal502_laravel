<?php

namespace App\App\Entities;
use Variable;

class ComentarioArticulo extends \Eloquent {

	use UserStamps;

	protected $fillable = ['nombre','comentario','articulo_id','estado'];

	protected $table = 'comentario_articulo';

	public function articulo()
	{
		return $this->belongsTo(Articulo::class);
	}

	public function getDiaCreacionAttribute()
    {
    	return date('d',strtotime($this->created_at));
    }

    public function getMesCreacionAttribute()
    {
    	return Variable::getMesCorto( intval(date('m',strtotime($this->created_at))));
    }

    public function getAnioCreacionAttribute()
    {
    	return date('Y',strtotime($this->created_at));
    }

	public function getFechaCreacionLetrasAttribute()
    {
    	return $this->dia_creacion . ' ' . $this->mes_creacion . ' ' . $this->anio_creacion;
    }

}