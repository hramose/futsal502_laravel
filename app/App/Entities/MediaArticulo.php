<?php

namespace App\App\Entities;
use Variable;

class MediaArticulo extends \Eloquent {

	protected $fillable = ['ruta','articulo_id','tipo'];

	protected $table = 'media_articulo';

	public function articulo()
	{
		return $this->belongsTo(Articulo::class);
	}

	public function getRutaAttribute($ruta)
    {
    	if($this->tipo == 'I')
    		return \Storage::disk('public')->url($ruta);
    	else 
    		return $ruta;
    }

}