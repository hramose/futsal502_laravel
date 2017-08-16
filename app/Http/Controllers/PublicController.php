<?php

namespace App\Http\Controllers;

use App\App\Repositories\PosicionesRepo;
use App\App\Repositories\CampeonatoRepo;
use App\App\Repositories\ConfiguracionRepo;
use App\App\Repositories\PartidoRepo;
use App\App\Repositories\CampeonatoEquipoRepo;
use App\App\Repositories\GoleadorRepo;
use App\App\Repositories\PorteroRepo;
use App\App\Repositories\EventoPartidoRepo;
use App\App\Repositories\DomoRepo;
use App\App\Repositories\ArticuloRepo;
use App\App\Repositories\MediaArticuloRepo;
use App\App\Repositories\CategoriaRepo;

use App\App\ExtraEntities\FichaPartido;

use App\App\Entities\Articulo;

use App\App\Managers\ArticuloManager;

use View,Redirect, Variable;

class PublicController extends BaseController {

	protected $posicionesRepo;
	protected $campeonatoRepo;
	protected $configuracionRepo;
	protected $partidoRepo;
	protected $campeonatoEquipoRepo;
	protected $goleadorRepo;
	protected $eventoPartidoRepo;
	protected $domoRepo;
	protected $articuloRepo;
	protected $mediaArticuloRepo;
	protected $categoriaRepo;

	public function __construct(PosicionesRepo $posicionesRepo, ConfiguracionRepo $configuracionRepo, CampeonatoRepo $campeonatoRepo, PartidoRepo $partidoRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo, GoleadorRepo $goleadorRepo, EventoPartidoRepo $eventoPartidoRepo, DomoRepo $domoRepo, ArticuloRepo $articuloRepo, MediaArticuloRepo $mediaArticuloRepo, CategoriaRepo $categoriaRepo)
	{
		$this->posicionesRepo = $posicionesRepo;
		$this->campeonatoRepo = $campeonatoRepo;
		$this->partidoRepo = $partidoRepo;
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
		$this->goleadorRepo = $goleadorRepo;
		$this->configuracionRepo = $configuracionRepo;
		$this->eventoPartidoRepo = $eventoPartidoRepo;
		$this->domoRepo = $domoRepo;
		$this->articuloRepo = $articuloRepo;
		$this->mediaArticuloRepo = $mediaArticuloRepo;
		$this->categoriaRepo = $categoriaRepo;

		View::composer('layouts.default', 'App\Http\Controllers\PublicMenuController');
	}

	public function mostrarInicio()
	{
		$ligaId = 1;
		$campeonatoId = 0;
		//$articulosRecientes = $this->articuloRepo->getBetweenFechasByEstado($fechaInicio, $fechaFin, ['S']);
		$campeonatos = $this->campeonatoRepo->getByLigaByEstado($ligaId,['A'])->pluck('descripcion','id')->toArray();
		if($campeonatoId == 0)
		{
			$campeonato = $this->campeonatoRepo->getActual($ligaId);
		}
		else
		{
			$campeonato = $this->campeonatoRepo->find($campeonatoId);
		}
		$campeonatoId = $campeonato->id;

		/*POSICIONES*/
		$partidos = $this->partidoRepo->getByCampeonatoByFaseByEstado($campeonato->id, ['R'], ['J','F']);
		$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);
		$posiciones = $this->posicionesRepo->getTabla($campeonato->id, $partidos, $equipos);

		//* Partidos Siguientes *//
		$proximosPartidos = $this->partidoRepo->getFromFechaByCampeonatoByEstado(date('Y-m-d'), $campeonatoId, ['P'], 5);
		$articulosRecientes = $this->articuloRepo->getUltimas(5);
		$ultimasNoticias = $this->articuloRepo->getUltimas(12);
		
		$followers['twitter'] = Variable::getTwitterFollowers();
		$followers['facebook'] = Variable::getFacebookLikes();

		return View::make('publico/inicio', compact('articulosRecientes','posiciones','proximosPartidos','ligaId','campeonatoId','ultimasNoticias','followers'));
	}

	public function posiciones($ligaId, $campeonatoId)
	{
		$campeonatos = $this->campeonatoRepo->getByLigaByEstado($ligaId,['A'])->pluck('descripcion','id')->toArray();
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
		$articulosPopulares = $this->articuloRepo->getPopulares(5);
		return View::make('publico/posiciones', compact('posiciones','campeonato','ligaId','campeonatos','articulosPopulares'));
	}

	public function goleadores($ligaId,$campeonatoId)
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
		return View::make('publico/goleadores', compact('goleadores','campeonato','campeonatos','ligaId'));
	}

	public function plantilla($ligaId, $campeonatoId, $equipoId)
	{
		$campeonatos = $this->campeonatoRepo->getCampeonatos($ligaId);
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
			$equipo = $this->campeonatoEquipoRepo->getEquipo($equipoId);
		}
		$equipos = $this->campeonatoEquipoRepo->getEquipos($campeonato->id);
		$plantilla = $this->campeonatoEquipoRepo->getPlantilla($campeonato, $equipoId);
		return View::make('publico/plantilla', compact('plantilla','campeonato','campeonatos','equipos','equipo','equipoId'));
	}

	public function calendario($ligaId, $campeonatoId)
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
		
		$partidos = $this->partidoRepo->getByCampeonato($campeonato->id);

		$jornadas = array();

		foreach($partidos as $partido){
			$jornadas[$partido->jornada_id]['jornada'] = $partido->jornada;
			$jornadas[$partido->jornada_id]['partidos'][] = $partido;	
		}
		$categorias = $this->categoriaRepo->getPopulares(5);
		$articulosPopulares = $this->articuloRepo->getPopulares(5);
		return View::make('publico/calendario', compact('jornadas','campeonato','campeonatos','ligaId','categorias','articulosPopulares'));
	}

	public function ficha($partidoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$ficha = new FichaPartido();
		$eventos = array();
		$ficha->generarEventos($partido, $eventos);
		$partidos = $this->partidoRepo->getOtrosByJornada($partido->campeonato_id,$partido->jornada_id,$partidoId);
		return View::make('publico/ficha', compact('partido','ficha','partidos'));
	}

	public function enVivo($partidoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$partidos = $this->partidoRepo->getOtrosByJornada($partido->campeonato_id,$partido->jornada_id,$partidoId);
		$ficha = new FichaPartido();
		$eventos = array();
		$ficha->generarEventos($partido, $eventos);
		$eventos = $this->eventoPartidoRepo->getByPartido($partidoId);
		return View::make('publico/envivo', compact('partido','eventos','ficha','partidos'));
	}

	public function domos()
	{
		$domos = $this->domoRepo->activos();
		return View::make('publico/lugares',compact('domos'));
	}

	public function verArticulos($autorId, $categoriaId)
	{
		$articulos = [];
		$titulo = '';
		$categoria = $this->categoriaRepo->find($categoriaId);
		if($autorId == 0 && $categoriaId == 0){
			$articulos = $this->articuloRepo->getPublicadas();
			$titulo = 'Noticias';
		}
		elseif($autorId != 0 && $categoriaId != 0){
			$articulos = $this->articuloRepo->getByAutorByCategoriaByEstado($autorId, $categoriaId, ['A']);
			$titulo = 'Noticias de ' . $categoria->descripcion;
		}
		elseif($autorId != 0){
			$articulos = $this->articuloRepo->getByAutorByEstado($autorId, ['A']);
		}
		elseif($categoriaId != 0){
			$articulos = $this->articuloRepo->getByCategoriaByEstado($categoriaId, ['A']);
			$titulo = 'Noticias de ' . $categoria->descripcion;
		}
		$articulosPopulares = $this->articuloRepo->getPopulares(5);
		$categorias = $this->categoriaRepo->getPopulares(5);
		return View::make('publico/articulos',compact('articulos','articulosPopulares','categorias','titulo'));
	}

	public function verArticulo(Articulo $articulo)
	{
		$manager = new ArticuloManager($articulo, null);
		$manager->sumarVista();
		$imagenes = $this->mediaArticuloRepo->getByArticuloByTipo($articulo->id, ['I']);
		$videos = $this->mediaArticuloRepo->getByArticuloByTipo($articulo->id, ['V']);
		$articulosPopulares = $this->articuloRepo->getPopulares(5);
		$categorias = $this->categoriaRepo->getPopulares(5);
		return View::make('publico/articulo',compact('articulo','imagenes','videos','articulosPopulares','categorias'));	
	}


	function getFecha($extraDays){
		$fecha = date('Y-m-d');
		$nuevafecha = strtotime ( $extraDays , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		return $nuevafecha;
	}


}