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
use App\App\Repositories\ArticuloRepo;
use App\App\Repositories\VwPartidoRepo;

use App\App\ExtraEntities\FichaPartido;

use App\App\Entities\Domo;

use View, Input, Variable;

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
	protected $articuloRepo;
	protected $vwPartidoRepo;

	public function __construct(PosicionesRepo $posicionesRepo, ConfiguracionRepo $configuracionRepo, CampeonatoRepo $campeonatoRepo,
		PartidoRepo $partidoRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo, GoleadorRepo $goleadorRepo, EventoPartidoRepo $eventoPartidoRepo,
		AlineacionRepo $alineacionRepo, LigaRepo $ligaRepo, DomoRepo $domoRepo, EquipoRepo $equipoRepo,
		PlantillaRepo $plantillaRepo, ArticuloRepo $articuloRepo, VwPartidoRepo $vwPartidoRepo)
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
		$this->articuloRepo = $articuloRepo;
		$this->vwPartidoRepo = $vwPartidoRepo;

		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
		header('Access-Control-Allow-Headers: Authorization,Content-Type');

	   	if("OPTIONS" == $_SERVER['REQUEST_METHOD']) {
		    http_response_code(200);
		    exit(0);
		}

	}

	public function ligas()
	{
		$ligas = $this->ligaRepo->getForApp();
		return json_encode($ligas);
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

		$equiposDB = $this->campeonatoEquipoRepo->getEquiposByCampeonato($campeonato->id);
		$equipos = [];
		foreach($equiposDB as $equipo)
		{
			$e['id'] = $equipo->equipo->id;
			$e['logo'] = $equipo->equipo->logo;
			$e['descripcion'] = $equipo->equipo->descripcion;
			$equipos[] = $e;
		}
		usort($equipos,function($a,$b){
			return strcmp($a['descripcion'],$b['descripcion']);
		});
		return json_encode($equipos);
	}

	public function plantilla($ligaId, $campeonatoId, $equipoId)
	{
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$equipo = $this->equipoRepo->find($equipoId);
		$jugadoresDB = $this->plantillaRepo->getByCampeonatoByEquipoByRol($campeonato->id, $equipoId, ['J']);
		$cuerpoTecnicoDB = $this->plantillaRepo->getByCampeonatoByEquipoByRol($campeonato->id, $equipoId, ['DT']);

		$cuerpoTecnico = [];
		$jugadores = [];
		foreach($cuerpoTecnicoDB as $ct)
		{
			$p['dorsal'] = '';
			$p['nombre_completo'] = $ct->persona->nombre_completo;
			$p['posicion'] = $ct->persona->descripcion_posicion;
			$p['imagen'] = $ct->persona->imagen;
			$cuerpoTecnico[] = $p;
		}
		foreach($jugadoresDB as $j)
		{
			$p['dorsal'] = $j->dorsal;
			$p['nombre_completo'] = $j->persona->nombre_completo;
			$p['posicion'] = $j->persona->descripcion_posicion;
			$p['imagen'] = $j->persona->imagen;
			$jugadores[] = $p;
		}

		$data['equipo'] = $equipo;
		$data['cuerpo_tecnico'] = $cuerpoTecnico;
		$data['jugadores'] = $jugadores;

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

		$partidos = $this->vwPartidoRepo->getByCampeonato($campeonato->id, 'DESC');
		//dd($partidos);
		$jornadas = array();

		foreach($partidos as $partido){
			$jornadas[$partido->jornada_id]['jornada'] = $partido->jornada;
			$jornadas[$partido->jornada_id]['jornada_id'] = $partido->jornada_id;
			$jornadas[$partido->jornada_id]['fechas'][date('Ymd',strtotime($partido->fecha))]['fecha'] = date('d/m',strtotime($partido->fecha));
			$jornadas[$partido->jornada_id]['fechas'][date('Ymd',strtotime($partido->fecha))]['dia'] = Variable::getDiaLetras(date('w', strtotime($partido->fecha)));

			$p = new \App\App\Entities\Partido;
			$p->id = $partido->id;
			$p->equipo_local = [
				'descripcion'=> $partido->descripcion_equipo_local,
				'descripcion_corta'=> $partido->descripcion_corta_equipo_local,
				'descripcion_corta'=> $partido->descripcion_corta_equipo_local,
				'siglas'=> $partido->siglas_equipo_local,
				'logo'=> $partido->logo_equipo_local,
			];
			$p->equipo_visita = [
				'descripcion'=> $partido->descripcion_equipo_visita,
				'descripcion_corta'=> $partido->descripcion_corta_equipo_visita,
				'descripcion_corta'=> $partido->descripcion_corta_equipo_visita,
				'siglas'=> $partido->siglas_equipo_visita,
				'logo'=> $partido->logo_equipo_visita,
			];
			$p->goles_local = $partido->goles_local;
			$p->goles_visita = $partido->goles_visita;
			$p->dia_semana = Variable::getDiaLetras(date('w', strtotime($partido->fecha)));
			$p->fecha = date('d/m',strtotime($partido->fecha));
			$p->hora = date('H:i',strtotime($partido->fecha));
			$p->domo = $partido->domo;
			//$p->descripcion_estado = $partido->descripcion_estado;
			$p->estado = $partido->estado;

			$jornadas[$partido->jornada_id]['fechas'][date('Ymd',strtotime($partido->fecha))]['partidos'][] = $p;
		}
		foreach($jornadas as $index => $jornada)
		{
			foreach($jornada['fechas'] as $fecha)
			{
				$fechas[] = $fecha;
			}
			$jornada['fechas'] = $fechas;
			$fechas = [];
			$data['jornadas'][] = $jornada;
		}

		$c = new \App\App\Entities\Campeonato;
		$c->id = $campeonato->id;
		$c->nombre = $campeonato->descripcion;
		$data['campeonato'] = $c;

		return $data;
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

	public function equipos2($ligaId, $campeonatoId)
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
