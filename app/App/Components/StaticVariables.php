<?php

namespace App\App\Components;
//use Twitter;

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
		'PD' => 'Por Definir',
		'AI' => 'Ala Izquierda',
		'AD' => 'Ala Derecha',
		'PO' => 'Portero',
		'PI' => 'Pivot',
		'CI' => 'Cierre',
		'DT' => 'Director Técnico',
		'AT' => 'Asistente Técnico',
		'PF' => 'Preparador Físico',
		'UT' => 'Utilero',
		'KN' => 'Kinesiólogo',
		'PM' => 'Paramédico',
		'AR' => 'Arbitro',
	];

	protected $grupos = [
		'1' => 'Grupo 1',
		'2' => 'Grupo 2',
		'3' => 'Grupo 3',
		'4' => 'Grupo 4',
		'5' => 'Grupo 5',
		'6' => 'Grupo 6',
		'7' => 'Grupo 7',
		'8' => 'Grupo 8',
		'A' => 'Grupo A',
		'B' => 'Grupo B',
		'C' => 'Grupo C',
		'D' => 'Grupo D',
		'E' => 'Grupo E',
		'F' => 'Grupo F',
		'G' => 'Grupo G',
		'H' => 'Grupo H',
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

	public function getGrupos(){ return $this->grupos; }
	public function getGrupo($key){ return $this->grupos[$key]; }

	public function getRoles(){ return $this->roles; }
	public function getRol($key){ return $this->roles[$key]; }

	public function getFases(){ return $this->fases; }
	public function getFase($key){ return $this->fases[$key]; }

	public function getMesCorto($mes)
	{
		switch ($mes) {
    		case 1: return 'Ene';
		    case 2: return 'Feb';
		    case 3: return 'Mar';
		    case 4: return 'Abr';
		    case 5: return 'May';
		    case 6: return 'Jun';
		    case 7: return 'Jul';
		    case 8: return 'Ago';
		    case 9: return 'Sep';
		    case 10: return 'Oct';
		    case 11: return 'Nov';
		    case 12: return 'Dic';
		}
		return 'Mes incorrecto.';
	}

	public function getMesLetras($mesEnNumeros)
	{
		switch ($mesEnNumeros) {
    		case 1: return 'Enero';
		    case 2: return 'Febrero';
		    case 3: return 'Marzo';
		    case 4: return 'Abril';
		    case 5: return 'Mayo';
		    case 6: return 'Junio';
		    case 7: return 'Julio';
		    case 8: return 'Agosto';
		    case 9: return 'Septiembre';
		    case 10: return 'Octubre';
		    case 11: return 'Noviembre';
		    case 12: return 'Diciembre';
		}
		return 'Mes incorrecto.';
	}

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


	/* SOCIAL */

	public function getTwitterFollowers()
	{
		// try{
		// 	$followers = Twitter::getCredentials();
		// 	return $followers->followers_count;
		// }
		// catch(\Exception $ex)
		// {
		// 	return 0;
		// }
		return 1;
	}

	public function getFacebookLikes()
	{
		try{
			$fanpage_id = env('FB_FANPAGE_ID');
			$app_id = env('FB_API_KEY');
			$app_secret = env('FB_API_SECRET');

			$urls = 'https://graph.facebook.com/v2.7/'. $fanpage_id . '?fields=fan_count&access_token='. $app_id . '|' . $app_secret;
			$string = @file_get_contents( $urls );
			if($string) {
				$fan_count = json_decode( $string );
				$get_fan_count = $fan_count->fan_count;
				return $get_fan_count;
			}
			return 0;
		}
		catch(\Exception $ex)
		{
			return 0;
		}
	}

	public function getInstagramFollowers()
	{
		try{
			$instagram_access_token = env('INSTAGRAM_ACCESS_TOKEN');

			$urls = 'https://api.instagram.com/v1/users/self?access_token='. $instagram_access_token;
			$string = @file_get_contents( $urls );
			if($string) {
				$followers_count = json_decode( $string );
				$get_followers_count = $followers_count->data->counts->followed_by;
				return $get_followers_count;
			}
			return 0;
		}
		catch(\Exception $ex)
		{
			return 0;
		}
	}

}
