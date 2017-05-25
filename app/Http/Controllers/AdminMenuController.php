<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection; 
use Auth;

class AdminMenuController {

	public function __construct(){	}

    public function compose($view)
    {        

        $menu = new Collection();

		$menu->push((object)['title' => 'Dashboard', 'url' => route('dashboard'), 'class' => '' ,'icon' => 'fa fa-dashboard']);
		$menu->push((object)['title' => 'Domo', 'url' => route('domos'), 'class' => '' ,'icon' => 'fa fa-location-arrow']);
		$menu->push((object)['title' => 'Equipos', 'url' => route('equipos'), 'class' => '' ,'icon' => 'fa fa-users']);
		$menu->push((object)['title' => 'Jornadas', 'url' => route('jornadas'), 'class' => '' ,'icon' => 'fa fa-list']);
		$menu->push((object)['title' => 'Monitorear', 'url' => route('monitorear_partido',[1,0,0,0,0]), 'class' => '' ,'icon' => 'fa fa-gear']);
		$menu->push((object)['title' => 'Ligas', 'url' => route('ligas'), 'class' => '' ,'icon' => 'fa fa-futbol-o']);
		$menu->push((object)['title' => 'Paises', 'url' => route('paises'), 'class' => '' ,'icon' => 'fa fa-flag']);
		$menu->push((object)['title' => 'Personas', 'url' => route('personas'), 'class' => '' ,'icon' => 'fa fa-user']);
				
		$view->menu = $menu;
		/* GET USUARIO */
		$view->usuario = Auth::user();

    }

}