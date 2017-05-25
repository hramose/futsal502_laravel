<?php

namespace App\App\Entities;

class Evento extends \Eloquent {
	
	protected $fillable = ['descripcion','imagen','ruta_agregar','ruta_editar','mostrar_en_vivo','estado'];

	protected $table = 'evento';

}