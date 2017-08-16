<?php

namespace App\App\Entities;
use Variable;

class Articulo extends \Eloquent {

    use UserStamps;

	protected $fillable = ['titulo','descripcion_corta','descripcion','imagen_portada','autor_id','categoria_id','estado','fecha_publicacion','vistas'];

	protected $table = 'articulo';

	public function autor()
	{
		return $this->belongsTo(User::class,'autor_id');
	}

	public function categoria()
	{
		return $this->belongsTo(Categoria::class);
	}

	public function getDescripcionEstadoAttribute()
	{
		if($this->estado == 'S')
			return '<i class="fa fa-check square bg-green text-white"></i>';
		return '<i class="fa fa-times square bg-red text-white"></i>';
	}

	public function getImagenPortadaAttribute($imagen_portada){
		if(!is_null($imagen_portada))
    		return \Storage::disk('public')->url($imagen_portada);
    	return null;
    }

    public function getDiaPublicacionAttribute()
    {
    	return date('d',strtotime($this->fecha_publicacion));
    }

    public function getMesPublicacionAttribute()
    {
    	return Variable::getMesCorto( intval(date('m',strtotime($this->fecha_publicacion))));
    }

    public function getAnioPublicacionAttribute()
    {
    	return date('Y',strtotime($this->fecha_publicacion));
    }

    public function getFechaPublicacionCortaAttribute()
    {
    	return date('d/m/Y', strtotime($this->fecha_publicacion));
    }

    public function getFechaPublicacionLetrasAttribute()
    {
    	return $this->dia_publicacion . ' ' . $this->mes_publicacion . ' ' . $this->anio_publicacion;
    }

}