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

        $subMenu = new Collection();
				$subMenu->push((object)['title' => 'Usuarios', 'url' => route('usuarios')]);
				$menu->push((object)['title' => 'Administración', 'url' => '#', 'subMenu'=> $subMenu, 'icon'=>'fa fa-users']);

        $subMenu = new Collection();
        $subMenu->push((object)['title' => 'Categorias', 'url' => route('categorias')]);
				$subMenu->push((object)['title' => 'Domo', 'url' => route('domos')]);
				$subMenu->push((object)['title' => 'Equipos', 'url' => route('equipos')]);
				$subMenu->push((object)['title' => 'Jornadas', 'url' => route('jornadas')]);
				$subMenu->push((object)['title' => 'Paises', 'url' => route('paises')]);
				$subMenu->push((object)['title' => 'Personas', 'url' => route('personas')]);
				$subMenu->push((object)['title' => 'Notificaciones', 'url' => route('notificaciones_usuarios')]);

				$menu->push((object)['title' => 'Catalogos', 'url' => '#', 'subMenu'=> $subMenu, 'icon'=>'fa fa-gear']);

				$menu->push((object)['title' => 'Monitorear', 'url' => route('monitorear_partido',[1,0,0,0,0]), 'class' => '' ,'icon' => 'fa fa-gear']);
				$menu->push((object)['title' => 'Ligas', 'url' => route('ligas'), 'class' => '' ,'icon' => 'fa fa-futbol-o']);

				$menu->push((object)['title' => 'Articulos', 'url' => route('articulos'), 'class' => '' ,'icon' => 'fa fa-user']);


				$view->menu = $menu;
				/* GET USUARIO */
				$view->usuario = Auth::user();

    }

}
