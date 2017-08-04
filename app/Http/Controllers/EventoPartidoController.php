<?php

namespace App\Http\Controllers;

use App\App\Repositories\EventoPartidoRepo;
use App\App\Managers\EventoPartidoManager;
use App\App\Entities\EventoPartido;
use Controller, Redirect, Input, View, Session;

use App\App\Repositories\PartidoRepo;
use App\App\Repositories\EventoRepo;
use App\App\Repositories\PlantillaRepo;
use App\App\Repositories\NotificacionEquipoRepo;
use App\App\Repositories\AlineacionRepo;

use App\App\Entities\Partido;

class EventoPartidoController extends BaseController {

	protected $eventoPartidoRepo;
	protected $partidoRepo;
	protected $eventoRepo;
	protected $alineacionRepo;
	protected $plantillaRepo;
	protected $notificacionEquipoRepo;

	public function __construct(EventoPartidoRepo $eventoPartidoRepo, PartidoRepo $partidoRepo, EventoRepo $eventoRepo, 
		PlantillaRepo $plantillaRepo, AlineacionRepo $alineacionRepo,
		NotificacionEquipoRepo $notificacionEquipoRepo)
	{
		$this->eventoPartidoRepo = $eventoPartidoRepo;
		$this->partidoRepo = $partidoRepo;
		$this->eventoRepo = $eventoRepo;
		$this->alineacionRepo = $alineacionRepo;
		$this->plantillaRepo = $plantillaRepo;
		$this->notificacionEquipoRepo = $notificacionEquipoRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado($partidoId)
	{
		$eventos = $this->eventoPartidoRepo->getByPartido($partidoId);
		$partido = $this->partidoRepo->find($partidoId);
		return view('administracion/eventos_partido/listado', compact('eventos','partido'));
	}

	public function mostrarAgregar($partidoId,$eventoId,$equipoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$evento = $this->eventoRepo->find($eventoId);
		$minuto = '';
		$segundo = '';
		switch ($eventoId) {
			case 2: //inicioPartido 
				$minuto = 0; $segundo = 0; break;
			case 3: //inicioPartido 
				$minuto = 20; $segundo = 0; break;
			case 4: //inicioPartido 
				$minuto = 20; $segundo = 0; break;
			case 5: //inicioPartido 
				$minuto = 40; $segundo = 0; break;
		}
		return view('administracion/eventos_partido/agregar', compact('partido','partidoId','evento','equipoId','minuto','segundo'));
	}

	public function agregar($partidoId,$eventoId,$equipoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$evento = $this->eventoRepo->find($eventoId);
		$data = Input::all();
		$data['evento_id'] = $eventoId;
		$data['partido_id'] = $partidoId;
		$manager = new EventoPartidoManager(new EventoPartido(), $data);
		$comentario = $manager->agregar($partido);
		Session::flash('success', 'Se agregó el evento '.$evento->descripcion.' con éxito.');
		/*if($evento->enviar_notificacion)
		{

			$users = $this->notificacionEquipoRepo->getByEquipos(array($partido->equipo_local_id,$partido->equipo_visita_id));
			$usuarios = [];
			foreach($users as $u)
			{
				$usuarios[] = $u->usuario->user;
			}

			$yourApiSecret = "1a42841e796e0cd928ee8c16f68430f6884536feda4cec3e";
			$appId = "b00a4692";
			$data = array(
			  "user_ids" => $usuarios,
               "notification" => [
               		"alert"=>$comentario,
               		"ios"=>[
               			"payload"=>[
               				"\$state"=>"app.tabs.partido", 
               				"\$stateParams"=> [
               					"liga"=> 1, 
               					"id"=> 19
               				]
               			]
               		],
               		"android"=>[
               			"payload"=>[
               				"\$state"=>"app.tabs.partido", 
               				"\$stateParams"=> [
               					"liga"=> 1, 
               					"id"=> 19
               				]
               			]
               		]
               	]
			);
			$data_string = json_encode($data);
			//dd($data_string);
            //dd($data_string);
			$ch = curl_init('https://push.ionic.io/api/v1/push');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			    'Content-Type: application/json',
			    'X-Ionic-Application-Id: '.$appId,
			    'Content-Length: ' . strlen($data_string),
			    'Authorization: Basic '.base64_encode($yourApiSecret)
			    )
			);
			$result = curl_exec($ch);
		}*/
		return redirect(route('monitorear_partido',[$partido->campeonato->liga_id, $partido->campeonato_id,$partido->jornada_id,$partido->id,$equipoId]));
	}

	public function mostrarAgregarPersona($partidoId,$eventoId,$equipoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$evento = $this->eventoRepo->find($eventoId);
		if($equipoId == $partido->equipo_local_id) {
			$equipo = $partido->equipo_local;
			$equipoContrario = $partido->equipo_visita;
		}
		else {
			$equipo = $partido->equipo_visita;
			$equipoContrario = $partido->equipo_local;
		}

		if($eventoId == 7) //autogol
		{
			$personas = $this->alineacionRepo->getByPartidoByEquipo($partido->id, $equipoContrario->id);
			$personasContrarias = $this->alineacionRepo->getByPartidoByEquipo($partido->id, $equipoContrario->id);
		}
		else
		{
			$personas = $this->alineacionRepo->getByPartidoByEquipo($partido->id, $equipo->id);
			$personasContrarias = $this->alineacionRepo->getByPartidoByEquipo($partido->id, $equipoContrario->id);
		}

		$personas = $personas->pluck('persona.nombre_completo','persona_id')->toArray();
		$personasContrarias = $personasContrarias->pluck('persona.nombre_completo','persona_id')->toArray();

		return view('administracion/eventos_partido/agregar_persona', compact('partido','partidoId','personas','evento','equipo','personasContrarias'));
	}

	

	public function agregarPersona($partidoId,$eventoId,$equipoId)
	{
		$partido = $this->partidoRepo->find($partidoId);
		$evento = $this->eventoRepo->find($eventoId);
		$data = Input::all();
		$data['evento_id'] = $eventoId;
		$data['partido_id'] = $partidoId;
		$data['equipo_id'] = $equipoId;
		$manager = new EventoPartidoManager(new EventoPartido(), $data);
		$comentario = $manager->agregarPersona($partido,$equipoId);
		Session::flash('success', 'Se agregó el evento '.$evento->descripcion.' con éxito.');
		/*if($evento->enviar_notificacion)
		{
			//Obtener usuarios a quienes enviar notificaciones
			$users = $this->notificacionEquipoRepo->getByEquipos(array($partido->equipo_local_id,$partido->equipo_visita_id));
			$usuarios = [];
			foreach($users as $u)
			{
				$usuarios[] = $u->usuario->user;
			}

			//POST REQUEST para enviar las notificaciones

			$yourApiSecret = "1a42841e796e0cd928ee8c16f68430f6884536feda4cec3e";
			$appId = "b00a4692";
			$data = array(
			  "user_ids" => $usuarios,
			  "notification" => ["alert"=>$comentario]
			);
			$data_string = json_encode($data);
			$ch = curl_init('https://push.ionic.io/api/v1/push');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			    'Content-Type: application/json',
			    'X-Ionic-Application-Id: '.$appId,
			    'Content-Length: ' . strlen($data_string),
			    'Authorization: Basic '.base64_encode($yourApiSecret)
			    )
			);
			$result = curl_exec($ch);
		}*/
		return redirect(route('monitorear_partido',[$partido->campeonato->liga_id, $partido->campeonato_id,$partido->jornada_id,$partido->id,$equipoId]));
	}

	public function mostrarEditar($id)
	{
		$evento = $this->eventoPartidoRepo->find($id);
		$partido = $this->partidoRepo->find($evento->partido_id);		
		return view('administracion/eventos_partido/editar', compact('evento','partido'));
	}

	public function editar($id)
	{
		$evento = $this->eventoPartidoRepo->find($id);
		$partido = $this->partidoRepo->find($evento->partido_id);
		$data = Input::all();
		$data['evento_id'] = $evento->evento_id;
		$data['partido_id'] = $evento->partido_id;
		$manager = new EventoPartidoManager($evento, $data);
		$manager->save();
		Session::flash('success', 'Se editó el evento con éxito.');
		return redirect(route('eventos_partido', $evento->partido_id));
	}

	public function mostrarEditarPersona($id)
	{
		$evento = $this->eventoPartidoRepo->find($id);
		$partido = $this->partidoRepo->find($evento->partido_id);
		if($partido->equipo_local_id == $evento->equipo_id)
		{
			$equipo = $partido->equipoLocal;
		}
		else
		{
			$equipo = $partido->equipoVisita;
		}
		if($eventoId == 7) //autogol
		{
			if($equipoId == $partido->equipo_local_id)
			{
				$jugadores = $this->alineacionRepo->getListAlineacion($partido->id, $partido->equipo_visita_id);
			}
			else
			{
				$jugadores = $this->alineacionRepo->getListAlineacion($partido->id, $partido->equipo_local_id);
			}
		}
		else
		{
			$jugadores = $this->alineacionRepo->getListAlineacion($partido->id, $equipoId);
		}
		$jugadores = $jugadores->toArray();
		return view('administracion/eventos_partido/editar_persona', compact('evento','partido','jugadores','equipo'));
	}

	public function editarPersona($id)
	{
		$evento = $this->eventoPartidoRepo->find($id);
		$partido = $this->partidoRepo->find($evento->partido_id);
		$data = Input::all();
		$data['evento_id'] = $evento->evento_id;
		$data['partido_id'] = $evento->partido_id;
		$data['equipo_id'] = $evento->equipo_id;
		$manager = new EventoPartidoManager($evento, $data);
		$manager->save();
		Session::flash('success', 'Se editó el evento con éxito.');
		return redirect(route('eventos_partido', $evento->partido_id));
	}

}