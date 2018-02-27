<?php

namespace App\Http\Controllers;

use App\App\Repositories\NotificacionUsuarioRepo;
use App\App\Managers\NotificacionUsuarioManager;
use App\App\Entities\NotificacionUsuario;
use Controller, Redirect, Input, View, Session, Variable;

class NotificacionUsuarioController extends BaseController {

	protected $notificacionUsuarioRepo;

	public function __construct(NotificacionUsuarioRepo $notificacionUsuarioRepo)
	{
		$this->notificacionUsuarioRepo = $notificacionUsuarioRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$usuarios = $this->notificacionUsuarioRepo->all('usuario');
		return view('administracion/notificaciones_usuarios/listado', compact('usuarios'));
	}

	public function activar($usuarioId)
	{
		$usuario = $this->notificacionUsuarioRepo->getByUsuario($usuarioId);
		if(is_null($usuario)){
			$data['usuario'] = $usuarioId;
			$data['estado'] = 'A';
			$manager = new NotificacionUsuarioManager(new NotificacionUsuario(), $data);
			if($manager->save()){
				$response = ['result' => true, 'message' => 'Se activaron las notificaciones.'];
			}
			else{
				$response = ['result' => false, 'message' => 'No se pudo activar las notificaciones.'];
			}
		}
		else{
			$data['usuario'] = $usuario->usuario;
			$data['estado'] = 'A';
			$manager = new NotificacionUsuarioManager($usuario, $data);
			if($manager->save()){
				$response = ['result' => true, 'message' => 'Se activaron las notificaciones.'];
			}
			else{
				$response = ['result' => false, 'message' => 'No se pudo activar las notificaciones.'];
			}
		}

		return json_encode($response);
	}

	public function inactivar($usuarioId)
	{
		$usuario = $this->notificacionUsuarioRepo->getByUsuario($usuarioId);
		if(is_null($usuario)){
			$data['usuario'] = $usuarioId;
			$data['estado'] = 'I';
			$manager = new NotificacionUsuarioManager(new NotificacionUsuario(), $data);
			if($manager->save()){
				$response = ['result' => true, 'message' => 'Se inactivaron las notificaciones.'];
			}
			else{
				$response = ['result' => false, 'message' => 'No se pudo inactivar las notificaciones.'];
			}
		}
		else{
			$data['usuario'] = $usuario->usuario;
			$data['estado'] = 'I';
			$manager = new NotificacionUsuarioManager($usuario, $data);
			if($manager->save()){
				$response = ['result' => true, 'message' => 'Se inactivaron las notificaciones.'];
			}
			else{
				$response = ['result' => false, 'message' => 'No se pudo inactivar las notificaciones.'];
			}
		}
		return json_encode($response);
	}

	public function crear($usuarioId)
	{
		$usuario = $this->notificacionUsuarioRepo->getByUsuario($usuarioId);
		if(is_null($usuario))
		{
			$data['usuario'] = $usuarioId;
			$data['estado'] = 'A';
			$manager = new NotificacionUsuarioManager(new NotificacionUsuario(), $data);
			if($manager->save()){
				$response = ['result' => true, 'message' => 'Se activaron las notificaciones.'];
			}
			else{
				$response = ['result' => false, 'message' => 'No se pudo activar las notificaciones.'];
			}
		}
		else{
			$response = ['result'=>true,'message'=>'Existe el usuario.','usuario'=>$usuario];
		}
		return json_encode($response);
	}

	public function usuario($usuarioId)
	{
		$usuario = $this->notificacionUsuarioRepo->getByUsuario($usuarioId);
		if(is_null($usuario))
		{
			return json_encode(['result'=>false,'message'=>'No existe el usuario.']);
		}
		else{
			return json_encode(['result'=>true,'message'=>'Existe el usuario.','usuario'=>$usuario]);
		}
	}


}
