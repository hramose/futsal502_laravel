<?php

namespace App\Http\Controllers;

use App\App\Repositories\UsuarioRepo;
use App\App\Managers\UsuarioManager;
use App\App\Entities\User;

use App\App\Repositories\PerfilRepo;

use Controller, Redirect, Input, View, Session;

class UsuarioController extends BaseController {

	protected $usuarioRepo;
	protected $perfilRepo;

	public function __construct(UsuarioRepo $usuarioRepo, PerfilRepo $perfilRepo)
	{
		$this->usuarioRepo = $usuarioRepo;
		$this->perfilRepo = $perfilRepo;
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
	}

	public function listado()
	{
		$usuarios = $this->usuarioRepo->all('username');
		return view('administracion/usuarios/listado', compact('usuarios'));
	}

	public function mostrarAgregar()
	{
		$perfiles = $this->perfilRepo->lists('nombre','id');
		return view('administracion/usuarios/agregar',compact('perfiles'));
	}

	public function agregar()
	{
		$data = Input::all();
		$manager = new UsuarioManager(new User(), $data);
		$manager->save();
		return redirect(route('usuarios'));
	}

	public function mostrarEditar(User $user)
	{
		$perfiles = $this->perfilRepo->lists('nombre','id');
		$usuario = $user;
		return view('administracion/usuarios/editar', compact('usuario','perfiles'));
	}

	public function editar(User $user)
	{
		$data = Input::all();
		$manager = new UsuarioManager($user, $data);
		$manager->update();
		return redirect(route('usuarios'));
	}

	public function mostrarCambiarPassword(User $user)
	{
		return view('administracion/cambiar_password', compact('user'));
	}

	public function cambiarPassword(User $user)
	{
		$data = Input::all();
		$manager = new UsuarioManager($user, $data);
		$manager->update();
		Session::flash('success', 'Se cambió la contraseña del usuario '.$user->username.' con éxito.');
		return redirect()->route('usuarios');
	}

	public function resetPassword(User $user)
	{
		$data = Input::all();
		$manager = new UsuarioManager($user, $data);
		$manager->resetPassword();
		Session::flash('success', 'Se cambió la contraseña del usuario '.$user->username.' con éxito.');
		return redirect()->route('usuarios');
	}

	public function inactivarUsuario($id)
	{
		$usuario = $this->usuarioRepo->find($id);
		$data = Input::all();
		$manager = new UsuarioManager($usuario, $data);
		$manager->inactivar();
		Session::flash('success', 'Se inactivó el usuario '.$usuario->username.' con éxito.');
		return redirect()->route('usuarios');
	}

	public function activarUsuario($id)
	{
		$usuario = $this->usuarioRepo->find($id);
		$data = Input::all();
		$manager = new UsuarioManager($usuario, $data);
		$manager->activar();
		Session::flash('success', 'Se activó el usuario '.$usuario->username.' con éxito.');
		return redirect()->route('usuarios');
	}


}