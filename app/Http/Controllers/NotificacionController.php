<?php

namespace App\Http\Controllers;

use App\App\Repositories\NotificacionRepo;
use App\App\Managers\NotificacionManager;
use App\App\Entities\Notificacion;
use Controller, Redirect, Input, View, Session, Variable;

use App\App\Entities\Liga;
use App\App\Repositories\LigaRepo;
use App\App\Repositories\NotificacionUsuarioRepo;

class NotificacionController extends BaseController {

	protected $notificacionRepo;
	protected $notificacionUsuarioRepo;
	protected $ligaRepo;

	public function __construct(NotificacionRepo $notificacionRepo, NotificacionUsuarioRepo $notificacionUsuarioRepo, LigaRepo $ligaRepo)
	{
		$this->notificacionRepo = $notificacionRepo;
		$this->notificacionUsuarioRepo = $notificacionUsuarioRepo;
		$this->ligaRepo = $ligaRepo;

		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$notificaciones = $this->notificacionRepo->all('created_at');
		$ligas = $this->ligaRepo->getByEstado(['A'],'descripcion');
		return view('administracion/notificaciones/listado', compact('notificaciones','ligas'));
	}

	public function mostrarAgregarArticulo()
	{
    $tipos = Variable::getTiposNotificacion();
		return view('administracion/notificaciones/agregar_articulo',compact('tipos'));
	}

	public function agregarArticulo()
	{
		$data = Input::all();
		$dataSend = $data;

		unset($dataSend['_token']);
		$data['data'] = json_encode($dataSend);

		$usuarios = $this->notificacionUsuarioRepo->getAllForSendByState(['A']);
		$data['cantidad_usuarios'] = count($usuarios);
		$data['estado'] = 'A';

		$manager = new NotificacionManager(new Notificacion(), $data);
		$notificacion = $manager->saveArticulo($usuarios);
		Session::flash('success', 'Se agregó la notificacion de articulo con éxito.');
		return redirect()->route('notificaciones');
	}

	public function mostrarAgregarTablaPosiciones(Liga $liga)
	{
		return view('administracion/notificaciones/agregar_tabla_posiciones',compact('liga'));
	}

	public function agregarTablaPosiciones(Liga $liga)
	{
		$data = Input::all();
		$dataSend = $data;

		unset($dataSend['_token']);
		$dataSend['liga'] = [
			'id' => $liga->id,
			'descripcion' => 'descripcion'
		];
		$data['liga'] = $dataSend['liga'];
		$data['data'] = json_encode($dataSend);

		$usuarios = $this->notificacionUsuarioRepo->getAllForSendByState(['A']);
		$data['cantidad_usuarios'] = count($usuarios);
		$data['estado'] = 'A';

		$manager = new NotificacionManager(new Notificacion(), $data);
		$notificacion = $manager->saveTablaPosiciones($usuarios);
		Session::flash('success', 'Se agregó la notificacion de tabla de posiciones con éxito.');
		return redirect()->route('notificaciones');
	}

	public function mostrarAgregarCalendario(Liga $liga)
	{
		return view('administracion/notificaciones/agregar_calendario',compact('liga'));
	}

	public function agregarCalendario(Liga $liga)
	{
		$data = Input::all();
		$dataSend = $data;

		unset($dataSend['_token']);
		$dataSend['liga'] = [
			'id' => $liga->id,
			'descripcion' => 'descripcion'
		];
		$data['liga'] = $dataSend['liga'];
		$data['data'] = json_encode($dataSend);

		$usuarios = $this->notificacionUsuarioRepo->getAllForSendByState(['A']);
		$data['cantidad_usuarios'] = count($usuarios);
		$data['estado'] = 'A';

		$manager = new NotificacionManager(new Notificacion(), $data);
		$notificacion = $manager->saveCalendario($usuarios);
		Session::flash('success', 'Se agregó la notificacion de calendario con éxito.');
		return redirect()->route('notificaciones');
	}


}
