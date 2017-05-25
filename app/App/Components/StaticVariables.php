<?php

namespace App\App\Components;

class StaticVariables {

	protected $estadosGenerales = [
		'A' => 'Activo',
		'I' => 'Inactivo',
	];

	protected $generos = [
		'M' => 'Masculino',
		'F' => 'Femenino'
	];

	protected $roles = [
		'J' => 'Jugador',
		'DT' => 'Director Técnico',
		'A' => 'Arbitro',
	];

	protected $posiciones = [
		'AI' => 'Ala Izquierda',
		'AD' => 'Ala Derecha',
		'PO' => 'Portero',
		'PI' => 'Pivot',
		'CI' => 'Cierre',
		'DT' => 'Director Técnico',
		'AT' => 'Asistente Técnico',
		'PF' => 'Preparador Físico',
		'AR' => 'Arbitro',
	];

	protected $fases = [
		'R' => 'Fase Regular',
		'F' => 'Fase Final'
	];

	public function getEstadosGenerales(){ return $this->estadosGenerales; }
	public function getEstadoGeneral($key){ return $this->estadosGenerales[$key]; }

	public function getGeneros(){ return $this->generos; }
	public function getGenero($key){ return $this->generos[$key]; }

	public function getPosiciones(){ return $this->posiciones; }
	public function getPosicion($key){ return $this->posiciones[$key]; }

	public function getRoles(){ return $this->roles; }
	public function getRol($key){ return $this->roles[$key]; }

	public function getFases(){ return $this->fases; }
	public function getFase($key){ return $this->fases[$key]; }

	public function quitarTildes($cadena)
	{
		$cadena = str_replace('á', 'a', $cadena);
		$cadena = str_replace('é', 'e', $cadena);
		$cadena = str_replace('í', 'i', $cadena);
		$cadena = str_replace('ó', 'o', $cadena);
		$cadena = str_replace('ú', 'u', $cadena);
		$cadena = str_replace('Á', 'A', $cadena);
		$cadena = str_replace('É', 'E', $cadena);
		$cadena = str_replace('Í', 'I', $cadena);
		$cadena = str_replace('Ó', 'O', $cadena);
		$cadena = str_replace('Ú', 'U', $cadena);
		$cadena = str_replace('ñ', 'n', $cadena);
		$cadena = str_replace('Ñ', 'N', $cadena);
		return $cadena;
	}

}