<?php

namespace App\Http\Controllers;

use App\App\Repositories\CampeonatoRepo;
use App\App\Managers\CampeonatoManager;
use App\App\Entities\Campeonato;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Entities\Liga;
use App\App\Repositories\LigaRepo;
use App\App\Repositories\PartidoRepo;
use App\App\Repositories\CampeonatoEquipoRepo;
use App\App\Repositories\PosicionesRepo;

class CampeonatoController extends BaseController {

	protected $campeonatoRepo;
	protected $ligaRepo;
	protected $partidoRepo;
	protected $campeonatoEquipoRepo;
	protected $posicionesRepo;

	public function __construct(CampeonatoRepo $campeonatoRepo, LigaRepo $ligaRepo, PartidoRepo $partidoRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo, PosicionesRepo $posicionesRepo)
	{
		$this->campeonatoRepo = $campeonatoRepo;
		$this->ligaRepo = $ligaRepo;
		$this->partidoRepo = $partidoRepo;
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
		$this->posicionesRepo = $posicionesRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado(Liga $liga)
	{
		$campeonatos = $this->campeonatoRepo->getByLiga($liga->id);
		return view('administracion/campeonatos/listado', compact('campeonatos','liga'));
	}

	public function mostrarAgregar(Liga $liga)
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/campeonatos/agregar', compact('liga','estados'));
	}

	public function agregar(Liga $liga)
	{
		$data = Input::all();
		$data['liga_id'] = $liga->id;
		$manager = new CampeonatoManager(new Campeonato(), $data);
		$manager->save();
		Session::flash('success', 'Se agregó el campeonato '.$data['descripcion'].' con éxito.');
		return redirect(route('campeonatos',$liga->id));
	}

	public function mostrarEditar(Campeonato $campeonato)
	{
		$estados = Variable::getEstadosGenerales();
		return view('administracion/campeonatos/editar', compact('campeonato','estados'));
	}

	public function editar(Campeonato $campeonato)
	{
		$data = Input::all();
		$data['liga_id'] = $campeonato->liga_id;
		$manager = new CampeonatoManager($campeonato, $data);
		$manager->save();
		Session::flash('success', 'Se editó el campeonato '.$campeonato->descripcion.' con éxito.');
		return redirect(route('campeonatos', $campeonato->liga_id));
	}

	public function mostrarPosiciones(Campeonato $campeonato)
	{
		$partidos = $this->partidoRepo->getByCampeonatoByFaseByEstado($campeonato->id, ['R'], ['J','F']);
		$equipos = $this->campeonatoEquipoRepo->getEquiposWithPosiciones($campeonato->id);

		$grupos = null;
		$posiciones = [];
		if($campeonato->grupos)
		{
			$grupos = $this->posicionesRepo->getTablaGrupos($campeonato->id, $partidos, $equipos);
		}
		else
		{
			$posiciones = $this->posicionesRepo->getTabla($campeonato->id, $partidos, $equipos);
		}

		return View::make('administracion/campeonatos/posiciones', compact('posiciones','campeonato','grupos'));
	}

	function cmp( $a, $b ) {
        if ($a->PTS == $b->PTS) {
            if ($a->DIF == $b->DIF) {
                if($a->GF == $b->GF){
                    if($a->GC == $b->GC)
                    	return strcmp($a->equipo->descripcion, $b->equipo->descripcion);
                    else
                        return $a->GC > $b->GC ? -1 : 1;
                }
                else{
                    return $a->GF > $b->GF ? -1 : 1;
                }
            }
            return $a->DIF > $b->DIF ? -1 : 1;
        }
        return $a->PTS > $b->PTS ? -1 : 1;
	}


}