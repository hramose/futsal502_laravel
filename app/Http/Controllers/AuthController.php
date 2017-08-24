<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, Auth, View,Session;

class AuthController extends BaseController {

	public function __construct()
	{
		
	}

	public function mostrarLogin()
	{
		return view('administracion/login');
	}

	public function login()
	{
		$data = Input::only('username','password','remember_token');

		$credentials = [
			'username' => $data['username'],
			'password' => $data['password']
		];

		if(Auth::attempt($credentials))
		{
			if(Auth::user()->estado == 'A')
				return Redirect::route('dashboard');
			else{
				Session::flash('error','El usuario esta inactivo. Contacte al administrador.');
				return redirect()->route('login');
			}

		}		
		Session::flash('error','Credenciales inválidas.');
		return redirect()->route('login');
	}

	public function mostrarDashboard()
	{
		View::composer('layouts.admin', 'App\Http\Controllers\AdminMenuController');
		return view('administracion/dashboard');
	}

	public function logout()
	{
		Auth::logout();
		return Redirect::route('login');
	}

}