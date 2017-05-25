<?php

namespace App\Http\Controllers;

use App\App\Repositories\PlantillaRepo;
use App\App\Managers\PlantillaManager;
use App\App\Entities\Plantilla;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Repositories\CampeonatoEquipoRepo;

class PlantillaController extends BaseController {

	protected $campeonatoEquipoRepo;
	protected $plantillaRepo;

	public function __construct(PlantillaRepo $plantillaRepo, CampeonatoEquipoRepo $campeonatoEquipoRepo)
	{
		$this->plantillaRepo = $plantillaRepo;
		$this->campeonatoEquipoRepo = $campeonatoEquipoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado($campeonatoEquipoId)
	{
		$campeonatoEquipo = $this->campeonatoEquipoRepo->find($campeonatoEquipoId);
		$personas = $this->plantillaRepo->getByCampeonatoByEquipo($campeonatoEquipo->campeonato_id, $campeonatoEquipo->equipo_id);		
		return view('administracion/plantillas/listado', compact('campeonatoEquipo','personas'));
	}

	public function mostrarAgregar($campeonatoEquipoId)
	{
		$campeonatoEquipo = $this->campeonatoEquipoRepo->find($campeonatoEquipoId);
		$personas = $this->plantillaRepo->getPersonasNotInCampeonatoByRol($campeonatoEquipo->campeonato_id,['J','DT']);
		return view('administracion/plantillas/agregar', compact('campeonatoEquipo','personas'));
	}

	public function agregar($campeonatoEquipoId)
	{
		$campeonatoEquipo = $this->campeonatoEquipoRepo->find($campeonatoEquipoId);
		$data = Input::all();
		$manager = new PlantillaManager(new Plantilla(), $data);
		$manager->agregarPersonas($campeonatoEquipo->campeonato_id, $campeonatoEquipo->equipo_id);
		Session::flash('success', 'Se agregaron las personas al equipo '.$campeonatoEquipo->equipo->descripcion.' del campeonato '.$campeonatoEquipo->campeonato->descripcion.' con éxito.');
		return redirect(route('plantillas',$campeonatoEquipo->id));
	}

	public function mostrarEditar($plantillaId)
	{
		$plantilla = $this->plantillaRepo->find($plantillaId);
		$estados = Variable::getEstadosGenerales();
		return view('administracion/plantillas/editar', compact('plantilla','estados'));
	}

	public function editar($plantillaId)
	{
		$plantilla = $this->plantillaRepo->find($plantillaId);
		$data = Input::all();
		$manager = new PlantillaManager($plantilla, $data);
		$manager->save();
		Session::flash('success', 'Se editó la persona '.$plantilla->persona->nombre_completo.' del equipo '.$plantilla->equipo->descripcion.' del campeonato '.$plantilla->campeonato->descripcion.' con éxito.');
		$campeonatoEquipo = $this->campeonatoEquipoRepo->getEquipoByCampeonato($plantilla->campeonato_id,$plantilla->equipo_id);
		return redirect()->route('plantillas', $campeonatoEquipo->id);
	}

	public function eliminar($campeonatoEquipoId)
	{
		$campeonatoEquipo = $this->campeonatoEquipoRepo->find($campeonatoEquipoId);
		$data = Input::all();
		$manager = new PlantillaManager(null, $data);
		$manager->eliminarPersonas();
		Session::flash('success', 'Se eliminaron las personas del equipo '.$campeonatoEquipo->equipo->descripcion.' del campeonato '.$campeonatoEquipo->campeonato->descripcion.' con éxito.');
		return redirect(route('plantillas', $campeonatoEquipo->id));
	}


}