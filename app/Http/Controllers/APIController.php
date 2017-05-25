<?php

namespace App\Http\Controllers;

use App\App\Repositories\PosicionesRepo;
use App\App\Repositories\CampeonatoRepo;
use App\App\Repositories\ConfiguracionRepo;
use App\App\Repositories\PartidoRepo;
use App\App\Repositories\CampeonatoEquipoRepo;
use App\App\Repositories\PlantillaRepo;
use App\App\Repositories\GoleadorRepo;
use App\App\Repositories\PorteroRepo;
use App\App\Repositories\EventoPartidoRepo;
use App\App\Repositories\AlineacionRepo;
use App\App\Repositories\LigaRepo;
use App\App\Repositories\DomoRepo;
use App\App\Repositories\EquipoRepo;

use App\App\ExtraEntities\FichaPartido;

use App\App\Entities\Domo;

use View, Input;

class APIController extends BaseController {

	protected $posicionesRepo;
	protected $campeonatoRepo;
	protected $configuracionRepo;
	protected $partidoRepo;
	protected $campeonatoEquipoRepo;
	protected $plantillaRepo;
	protected $goleadorRepo;
	protected $eventoPartidoRepo;
	protected $alineacionRepo;
	protected $ligaRepo;
	protected $domoRepo;
	protected $equipoRepo;

	public function __construct(PosicionesRepo $posicionesRepo, ConfiguracionRepo $configuracionRepo, CampeonatoRepo $campeonatoRepo, 
		PartidoRepo $partidoRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo, GoleadorRepo $goleadorRepo, EventoPartidoRepo $eventoPartidoRepo,
		AlineacionRepo $alineacionRepo, LigaRepo $ligaRepo, DomoRepo $domoRepo, EquipoRepo $equipoRepo, 
		PlantillaRepo $plantillaRepo)
	{
		$this->posicionesRepo = $posicionesRepo;
		$this->campeonatoRepo = $campeonatoRepo;
		$this->partidoRepo = $partidoRepo;
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
		$this->plantillaRepo = $plantillaRepo;
		$this->goleadorRepo = $goleadorRepo;
		$this->configuracionRepo = $configuracionRepo;
		$this->eventoPartidoRepo = $eventoPartidoRepo;
		$this->alineacionRepo = $alineacionRepo;
		$this->ligaRepo = $ligaRepo;
		$this->domoRepo = $domoRepo;
		$this->equipoRepo = $equipoRepo;

		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
		header('Access-Control-Allow-Headers: Authorization,Content-Type');

	   	if("OPTIONS" == $_SERVER['REQUEST_METHOD']) {
		    http_response_code(200);
		    exit(0);
		}
	}

	public function posiciones($ligaId, $campeonatoId)
	{
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$partidos = $this->partidoRepo->getByCampeonatoByFaseByEstado($campeonato->id, ['R'], ['J','F']);
		$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
		$posiciones = $this->posicionesRepo->getTabla($campeonato->id, $partidos, $equipos);

		$data['posiciones'] = $posiciones;
		$data['campeonato'] = $campeonato;
		return json_encode($data);
	}

	public function goleadores($ligaId, $campeonatoId)
	{
		$campeonatos = $this->campeonatoRepo->getByLiga($ligaId)->pluck('descripcion','id')->toArray();
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$goleadores = $this->goleadorRepo->getGoleadores($campeonato);
		
		$data['goleadores'] = $goleadores;
		$data['campeonato'] = $campeonato;
		return json_encode($data);
	}

	public function plantilla($ligaId, $campeonatoId, $equipoId)
	{
		//$campeonatos = $this->campeonatoRepo->getCampeonatos($ligaId);
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->getCampeonato($campeonatoId);
		}
		$equipo = null;
		if($equipoId != 0){
			$equipo = $this->equipoRepo->find($equipoId);
		}
		//$equipos = $this->campeonatoEquipoRepo->getEquipos($campeonato->id);
		$personas = $this->campeonatoEquipoPersonaRepo->getPersonasByRol($campeonato->id, $equipoId, 1);
		$plantilla = [];
		foreach($personas as $persona)
		{
			$j['id'] = $persona->persona->id;
			$j['jugador'] = $persona->persona->nombreCompleto;
			$j['goles'] = 0;
			$j['amarillas'] = 0;
			$j['dobles_amarillas'] = 0;
			$j['rojas'] = 0;
			$plantilla[$persona->persona->id] = $j;
		}

		$eventos = $this->eventoPartidoRepo->getByCampeonatoByEquipo($campeonato->id, $equipoId, array(9,10,11));
		
		foreach($eventos as $evento)
		{
			if($evento->evento_id == 9)
			{
				$plantilla[$evento->jugador_id]['goles'] = $plantilla[$evento->jugador_id]['goles'] + 1;
			}
			if($evento->evento_id == 10)
			{
				$plantilla[$evento->jugador_id]['amarillas'] = $plantilla[$evento->jugador_id]['amarillas'] + 1;
			}
			if($evento->evento_id == 11)
			{
				if($evento->doble_amarilla == 1){
					$plantilla[$evento->jugador_id]['dobles_amarillas'] = $plantilla[$evento->jugador_id]['dobles_amarillas'] + 1;
					$plantilla[$evento->jugador_id]['amarillas'] = $plantilla[$evento->jugador_id]['amarillas'] - 1;
				}
				else{
					$plantilla[$evento->jugador_id]['rojas'] = $plantilla[$evento->jugador_id]['rojas'] + 1;	
				}
				
			}
		}

		usort($plantilla, function($a, $b){
			return strcmp($a['jugador'], $b['jugador']);
		});

		$data['plantilla'] = $plantilla;
		$data['campeonato'] = $campeonato;
		$data['equipo'] = $equipo;
		return json_encode($data);
	}

	public function calendario($ligaId, $campeonatoId)
	{
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		
		$partidos = $this->partidoRepo->getByCampeonato($campeonato->id);

		$jornadas = array();
		$jornadaActual = 1;
		foreach($partidos as $partido){
			$jornadas[$partido->jornada_id]['jornada'] = $partido->jornada->descripcion;
			
			$p = new \App\App\Entities\Partido;
			$p->id = $partido->id;
			$p->equipoLocal = $partido->equipoLocal->descripcion;
			$p->equipoVisita = $partido->equipoVisita->descripcion;
			$p->golesLocal = $partido->goles_local;
			$p->golesVisita = $partido->goles_visita;
			$p->fecha = date('d/m',strtotime($partido->fecha));
			$p->hora = date('H:ia',strtotime($partido->fecha));
			$p->domo = $partido->domo->descripcion;
			$p->estado = $partido->descripcion_estado;

			if($partido->estado_id != 1)
				$jornadaActual = $partido->jornada->numero;

			$jornadas[$partido->jornada_id]['partidos'][] = $p;	
		}

		$data['jornadas'] = $jornadas;
		$data['jornada_actual'] = $jornadaActual;

		$c = new \App\App\Entities\Campeonato;
		$c->id = $campeonato->id;
		$c->nombre = $campeonato->descripcion;
		$data['campeonato'] = $c;
		return json_encode($data);
	}

	public function ficha($partidoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$ficha = new FichaPartido();
		$eventos = array();
		$ficha->generarEventos($partido, $eventos);
		//$partidos = $this->partidoRepo->getOtrosByJornada($partido->campeonato_id,$partido->jornada_id,$partidoId);

		$data['partido'] = $partido;
		$data['ficha'] = $ficha;
		return json_encode($data);
	}

	public function enVivo($partidoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$es = [];
		if($partido->estado_id != 1){

			$eventos = $this->eventoPartidoRepo->getByPartido($partidoId);
		
			$i = 0;
			foreach($eventos as $evento)
			{
				$es[$i]['comentario'] = $evento->comentario;
				$es[$i]['minuto'] = date('i:s',($evento->minuto*60+$evento->segundos));
				$es[$i]['imagen'] = $evento->evento->imagen;
				$i++;
			}
		}
		$data['eventos'] = $es;

		$p = new \App\App\Entities\Partido;
		$p->id = $partido->id;
		$p->equipoLocal = $partido->equipoLocal->descripcion;
		$p->equipoVisita = $partido->equipoVisita->descripcion;
		$p->golesLocal = $partido->goles_local;
		$p->golesVisita = $partido->goles_visita;
		$partido->fecha = strtotime($partido->fecha);
		$p->fecha = date('d/m',$partido->fecha);
		$p->hora = date('H:ia',$partido->fecha);
		$p->domo = $partido->domo->descripcion;
		$p->estado = $partido->descripcion_estado;

		$data['partido'] = $p;
		
		return json_encode($data);
	}

	public function alineaciones($partidoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$alineacionLocal = $this->alineacionRepo->getAlineacion($partidoId, $partido->equipo_local_id);
		$alineacionVisita = $this->alineacionRepo->getAlineacion($partidoId, $partido->equipo_visita_id);
		$dtLocal = $this->alineacionRepo->getTecnico($partidoId, $partido->equipo_local_id);
		$dtVisita = $this->alineacionRepo->getTecnico($partidoId, $partido->equipo_visita_id);

		$alLocal = [];
		$alVisita = [];
		foreach($alineacionLocal as $al)
		{
			$alLocal[]['nombre'] = $al->persona->nombre_completo;
		}
		foreach($alineacionVisita as $av)
		{
			$alVisita[]['nombre'] = $av->persona->nombre_completo;
		}
		$data['alineacionVisita'] = $alVisita;
		$data['alineacionLocal'] = $alLocal;

		$data['dtVisita'] = [];
		$data['dtLocal'] = [];
		if(!is_null($dtVisita))  $data['dtVisita']['nombre'] = $dtVisita->nombre_completo;
		if(!is_null($dtLocal))  $data['dtLocal']['nombre'] = $dtLocal->nombre_completo;
		
		return json_encode($data);
	}

	public function domos()
	{
		$data['domos'] = $this->domoRepo->getByEstado(['A'],'descripcion');
		return json_encode($data);
	}

	public function ligas()
	{
		$data['ligas'] = $this->ligaRepo->getByEstado(['A'],'descripcion');
		return json_encode($data);
	}

	public function equipos($ligaId, $campeonatoId)
	{
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$teams = $this->campeonatoEquipoRepo->getEquipos($campeonato->id);
		$equipos = [];
		$i = 0;
		foreach($teams as $team)
		{
			$e['id'] = $team->equipo->id;
			$e['nombre'] = $team->equipo->descripcion;
			$e['imagen'] = $team->equipo->imagen;
			$equipos[] = $e;
		} 
		usort($equipos,function($a,$b){
			return strcmp($a['nombre'],$b['nombre']);
		});
		$data['equipos'] = $equipos;
		return json_encode($data);
	}

	function token()
	{
		$data = json_encode(\Input::all());
		$domo = new Domo();
		$domo->nombre = $data;
		$domo->latitud = 0;
		$domo->longitud = 0;
		$domo->created_at = '2015-1-1 10:00:00';
		$domo->updated_at = '2015-1-1 10:00:00';
		$domo->save();
	}

	function noticias()
	{
		$news = $this->noticiaRepo->all('fecha_publicacion');
		$noticias = [];
		foreach($news as $noticia)
		{
			$n['id'] = $noticia->id;
			$n['titulo'] = $noticia->titulo;
			$n['imagen'] = 'http://www.solucionesmyc.com/futsal502/noticias/' . $noticia->imagen;
			$n['fecha_publicacion'] = $noticia->fecha_publicacion;
			$noticias[] = $n;
		}
		return json_encode($noticias);
	}

	function noticia($id)
	{
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$new = $this->noticiaRepo->find($id);
		$mes = $meses[date('n', strtotime($new->fecha_publicacion))];
		$noticia['titulo'] = $new->titulo;
		$noticia['descripcion'] = $new['descripcion'];
		$noticia['imagen'] = $new['imagen'];
		$noticia['fecha_publicacion'] = $mes . date(' d, Y', strtotime($new->fecha_publicacion));
		return json_encode($noticia);
	}


	function getFecha($extraDays){
		$fecha = date('Y-m-d');
		$nuevafecha = strtotime ( $extraDays , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		return $nuevafecha;
	}


}