<?php

date_default_timezone_set('America/Guatemala');
header('Access-Control-Allow-Headers:Origin, Content-Type, X-XSRF-TOKEN, Authorization');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
//header('Access-Control-Allow-Headers: Authorization,Content-Type');

	/*if("OPTIONS" == $_SERVER['REQUEST_METHOD']) {
	    http_response_code(200);
	    exit(0);
	}*/

Route::group(['middleware' => 'auth'], function(){

Route::get('dashboard','AuthController@mostrarDashboard')->name('dashboard');

/* NOTIFICACIONES */
Route::group(['prefix' => 'notificaciones'], function () {
	Route::get('listado','NotificacionController@listado')->name('notificaciones');
	Route::get('agregar-articulo','NotificacionController@mostrarAgregarArticulo')->name('agregar_notificacion_articulo');
	Route::post('agregar-articulo','NotificacionController@agregarArticulo')->name('agregar_notificacion_articulo');
	Route::get('agregar-tabla-posiciones/{liga}','NotificacionController@mostrarAgregarTablaPosiciones')->name('agregar_notificacion_tabla_posiciones');
	Route::post('agregar-tabla-posiciones/{liga}','NotificacionController@agregarTablaPosiciones')->name('agregar_notificacion_tabla_posiciones');
	Route::get('agregar-calendario/{liga}','NotificacionController@mostrarAgregarCalendario')->name('agregar_notificacion_calendario');
	Route::post('agregar-calendario/{liga}','NotificacionController@agregarCalendario')->name('agregar_notificacion_calendario');
});

/* CATEGORIAS */
Route::group(['prefix' => 'categorias'], function () {
	Route::get('listado','CategoriaController@listado')->name('categorias');
	Route::get('agregar','CategoriaController@mostrarAgregar')->name('agregar_categoria');
	Route::post('agregar','CategoriaController@agregar')->name('agregar_categoria');
	Route::get('editar/{categoria}','CategoriaController@mostrarEditar')->name('editar_categoria');
	Route::put('editar/{categoria}','CategoriaController@editar')->name('editar_categoria');
});

/* ARTICULOS */
Route::group(['prefix' => 'articulos'], function () {
	Route::get('listado','ArticuloController@listado')->name('articulos');
	Route::get('agregar','ArticuloController@mostrarAgregar')->name('agregar_articulo');
	Route::post('agregar','ArticuloController@agregar')->name('agregar_articulo');
	Route::get('editar/{articulo}','ArticuloController@mostrarEditar')->name('editar_articulo');
	Route::put('editar/{articulo}','ArticuloController@editar')->name('editar_articulo');
});

/* MEDIAS ARTICULOS */
Route::group(['prefix' => 'medias-articulos'], function () {
	Route::get('listado/{articulo}','MediaArticuloController@listado')->name('medias_articulos');
	Route::get('agregar-imagen/{articulo}','MediaArticuloController@mostrarAgregarImagen')->name('agregar_imagen_articulo');
	Route::post('agregar-imagen/{articulo}','MediaArticuloController@agregarImagen')->name('agregar_imagen_articulo');
	Route::get('agregar-video/{articulo}','MediaArticuloController@mostrarAgregarVideo')->name('agregar_video_articulo');
	Route::post('agregar-video/{articulo}','MediaArticuloController@agregarVideo')->name('agregar_video_articulo');
	Route::delete('eliminar','MediaArticuloController@eliminar')->name('eliminar_media_articulo');
});

/* MEDIAS ARTICULOS */
Route::group(['prefix' => 'comentarios-articulos'], function () {
	Route::get('listado/{articulo}','ComentarioArticuloController@listado')->name('comentarios_articulo');
	Route::get('editar/{articulo}','ComentarioArticuloController@mostrarEditar')->name('editar_comentario_articulo');
	Route::post('editar/{articulo}','ComentarioArticuloController@editar')->name('editar_comentario_articulo');
});

/* ALINEACIONES */
Route::group(['prefix' => 'alineaciones'], function () {
	Route::get('editar/{partido}/{evento}/{jornada}','AlineacionController@mostrarEditar')->name('editar_alineacion');
	Route::post('editar/{partido}/{evento}/{jornada}','AlineacionController@editar')->name('editar_alineacion');
});


/* CAMPEONATOS */
Route::group(['prefix' => 'campeonatos'], function () {
	Route::get('listado/{liga}','CampeonatoController@listado')->name('campeonatos');
	Route::get('agregar/{liga}','CampeonatoController@mostrarAgregar')->name('agregar_campeonato');
	Route::post('agregar/{liga}','CampeonatoController@agregar')->name('agregar_campeonato');
	Route::get('editar/{campeonato}','CampeonatoController@mostrarEditar')->name('editar_campeonato');
	Route::post('editar/{campeonato}','CampeonatoController@editar')->name('editar_campeonato');
	Route::get('posiciones/{campeonato}','CampeonatoController@mostrarPosiciones')->name('posiciones_campeonato');
	Route::get('posiciones-grupos/{campeonato}','CampeonatoController@mostrarPosiciones')->name('posiciones_grupos_campeonato');
});
/*CAMPEONATOS EQUIPOS*/
Route::group(['prefix' => 'campeonatos-equipos'], function () {
	Route::get('/{campeonato}','CampeonatoEquipoController@listado')->name('campeonatos_equipos');
	Route::get('agregar/{campeonato}','CampeonatoEquipoController@mostrarAgregar')->name('agregar_equipos_campeonato');
	Route::post('agregar/{campeonato}','CampeonatoEquipoController@agregar')->name('agregar_equipos_campeonato');
	Route::post('editar/{campeonato}', 'CampeonatoEquipoController@editar')->name('editar_equipos_campeonato');
	Route::get('trasladar-equipos/{campeonato}/{campeonatoAntiguoId}', 'CampeonatoEquipoController@mostrarTrasladarEquipos')->name('trasladar_equipos_campeonato');
	Route::post('trasladar-equipos/{campeonato}/{campeonatoAntiguoId}', 'CampeonatoEquipoController@trasladarEquipos')->name('trasladar_equipos_campeonato');
});

/*PLANTILLAS*/
Route::group(['prefix' => 'plantillas'], function () {
	Route::get('{campeonato}', ['as' => 'plantillas', 'uses' => 'PlantillaController@listado']);
	Route::get('agregar/{campeonato}', ['as' => 'agregar_plantilla', 'uses' => 'PlantillaController@mostrarAgregar']);
	Route::post('agregar/{campeonato}', ['as' => 'agregar_plantilla', 'uses' => 'PlantillaController@agregar']);
	Route::get('editar/{campeoanto}', ['as' => 'editar_plantilla', 'uses' => 'PlantillaController@mostrarEditar']);
	Route::post('editar/{campeoanto}', ['as' => 'editar_plantilla', 'uses' => 'PlantillaController@editar']);
	Route::post('eliminar/{campeoanto}', ['as' => 'eliminar_plantilla', 'uses' => 'PlantillaController@eliminar']);
});

/* DOMOS */
Route::group(['prefix' => 'domos'], function () {
	Route::get('listado','DomoController@listado')->name('domos');
	Route::get('agregar','DomoController@mostrarAgregar')->name('agregar_domo');
	Route::post('agregar','DomoController@agregar')->name('agregar_domo');
	Route::get('editar/{domo}','DomoController@mostrarEditar')->name('editar_domo');
	Route::post('editar/{domo}','DomoController@editar')->name('editar_domo');
});

Route::group(['prefix' => 'equipos'], function () {
	Route::get('listado','EquipoController@listado')->name('equipos');
	Route::get('agregar','EquipoController@mostrarAgregar')->name('agregar_equipo');
	Route::post('agregar','EquipoController@agregar')->name('agregar_equipo');
	Route::get('editar/{equipo}','EquipoController@mostrarEditar')->name('editar_equipo');
	Route::post('editar/{equipo}','EquipoController@editar')->name('editar_equipo');
});

Route::group(['prefix' => 'eventos'], function () {
	Route::get('listado','EventoController@listado')->name('eventos');
	Route::get('agregar','EventoController@mostrarAgregar')->name('agregar_evento');
	Route::post('agregar','EventoController@agregar')->name('agregar_evento');
	Route::get('editar/{evento}','EventoController@mostrarEditar')->name('editar_evento');
	Route::post('editar/{evento}','EventoController@editar')->name('editar_evento');
});

	/* EVENTOS PARTIDO */
	Route::get('eventos-partido/{partidoId}', ['as' => 'eventos_partido', 'uses' => 'EventoPartidoController@listado']);
		//eventos sin persona
	Route::get('eventos-partido/agregar/{partidoId}/{eventoId}/{jornadaId}', ['as' => 'agregar_evento_partido', 'uses' => 'EventoPartidoController@mostrarAgregar']);
	Route::post('eventos-partido/agregar/{partidoId}/{eventoId}/{jornadaId}', ['as' => 'agregar_evento_partido', 'uses' => 'EventoPartidoController@agregar']);
	Route::get('eventos-partido/editar/{id}', ['as' => 'editar_evento_partido', 'uses' => 'EventoPartidoController@mostrarEditar']);
	Route::post('eventos-partido/editar/{id}', ['as' => 'editar_evento_partido', 'uses' => 'EventoPartidoController@editar']);
		//eventos con persona
	Route::get('eventos-partido/agregar-persona/{partidoId}/{eventoId}/{jornadaId}', ['as' => 'agregar_evento_partido_persona', 'uses' => 'EventoPartidoController@mostrarAgregarPersona']);
	Route::post('eventos-partido/agregar-persona/{partidoId}/{eventoId}/{jornadaId}', ['as' => 'agregar_evento_partido_persona', 'uses' => 'EventoPartidoController@agregarPersona']);
	Route::get('eventos-partido/editar-persona/{id}', ['as' => 'editar_evento_partido_persona', 'uses' => 'EventoPartidoController@mostrarEditarPersona']);
	Route::post('eventos-partido/editar-persona/{id}', ['as' => 'editar_evento_partido_persona', 'uses' => 'EventoPartidoController@editarPersona']);
		//evento de falta
	Route::get('eventos-partido/agregar-falta/{partidoId}/{eventoId}/{jornadaId}', ['as' => 'agregar_evento_falta', 'uses' => 'EventoPartidoController@mostrarAgregar']);
	Route::post('eventos-partido/agregar-falta/{partidoId}/{eventoId}/{jornadaId}', ['as' => 'agregar_evento_falta', 'uses' => 'EventoPartidoController@agregar']);
	Route::get('eventos-partido/editar-falta/{id}', ['as' => 'editar_evento_falta', 'uses' => 'EventoPartidoController@mostrarEditar']);
	Route::post('eventos-partido/editar-falta/{id}', ['as' => 'editar_evento_falta', 'uses' => 'EventoPartidoController@editar']);

	Route::post('eventos-partido/eliminar/{id}', ['as' => 'eliminar_evento_partido', 'uses' => 'EventoPartidoController@eliminar']);
	Route::get('eventos-partido/editar-resultado-partido/{partido}', ['as' => 'editar_resultado_partido', 'uses' => 'EventoPartidoController@mostrarEditarResultadoPartido']);
	Route::post('eventos-partido/editar-resultado-partido/{partido}', ['as' => 'editar_resultado_partido', 'uses' => 'EventoPartidoController@editarResultadoPartido']);

Route::group(['prefix' => 'jornadas'], function () {
	Route::get('listado','JornadaController@listado')->name('jornadas');
	Route::get('agregar','JornadaController@mostrarAgregar')->name('agregar_jornada');
	Route::post('agregar','JornadaController@agregar')->name('agregar_jornada');
	Route::get('editar/{jornada}','JornadaController@mostrarEditar')->name('editar_jornada');
	Route::post('editar/{jornada}','JornadaController@editar')->name('editar_jornada');
});

Route::group(['prefix' => 'ligas'], function () {
	Route::get('listado','LigaController@listado')->name('ligas');
	Route::get('agregar','LigaController@mostrarAgregar')->name('agregar_liga');
	Route::post('agregar','LigaController@agregar')->name('agregar_liga');
	Route::get('editar/{liga}','LigaController@mostrarEditar')->name('editar_liga');
	Route::post('editar/{liga}','LigaController@editar')->name('editar_liga');
});

Route::group(['prefix' => 'paises'], function () {
	Route::get('listado','PaisController@listado')->name('paises');
	Route::get('agregar','PaisController@mostrarAgregar')->name('agregar_pais');
	Route::post('agregar','PaisController@agregar')->name('agregar_pais');
	Route::get('editar/{pais}','PaisController@mostrarEditar')->name('editar_pais');
	Route::post('editar/{pais}','PaisController@editar')->name('editar_pais');
});

/* PARTIDOS */
Route::group(['prefix' => 'partidos'], function () {
	Route::get('listado/{campeonato}','PartidoController@listado')->name('partidos');
	Route::get('agregar/{campeonato}','PartidoController@mostrarAgregar')->name('agregar_partido');
	Route::post('agregar/{campeonato}','PartidoController@agregar')->name('agregar_partido');
	Route::get('editar/{partido}','PartidoController@mostrarEditar')->name('editar_partido');
	Route::post('editar/{partido}','PartidoController@editar')->name('editar_partido');

	Route::get('agregar-jornada/{campeonato}/{numeroPartidos}','PartidoController@mostrarAgregarJornada')->name('agregar_partido_jornada');
	Route::post('agregar-jornada/{campeonato}/{numeroPartidos}','PartidoController@agregarJornada')->name('agregar_partido_jornada');
	Route::get('editar-jornada/{campeonato}/{jornada}','PartidoController@mostrarEditarJornada')->name('editar_partido_jornada');
	Route::post('editar-jornada/{campeonato}/{jornada}','PartidoController@editarJornada')->name('editar_partido_jornada');

	Route::get('monitorear/{liga}/{campeonato}/{jornada}/{partido}/{equipo}','PartidoController@mostrarMonitorear')->name('monitorear_partido');
	Route::get('editar-monitoreo/{partido}','PartidoController@mostrarEditarMonitoreo')->name('editar_partido_monitoreo');
	Route::post('editar-monitoreo/{partido}','PartidoController@editarMonitoreo')->name('editar_partido_monitoreo');
});
Route::group(['prefix' => 'personas'], function () {
	Route::get('listado','PersonaController@listado')->name('personas');
	Route::get('agregar','PersonaController@mostrarAgregar')->name('agregar_persona');
	Route::post('agregar','PersonaController@agregar')->name('agregar_persona');
	Route::get('editar/{persona}','PersonaController@mostrarEditar')->name('editar_persona');
	Route::post('editar/{persona}','PersonaController@editar')->name('editar_persona');
});

/* USUARIOS */
Route::group(['prefix' => 'usuarios'], function () {
	Route::get('listado','UsuarioController@listado')->name('usuarios');
	Route::get('agregar','UsuarioController@mostrarAgregar')->name('agregar_usuario');
	Route::post('agregar','UsuarioController@agregar')->name('agregar_usuario');
	Route::get('editar/{user}','UsuarioController@mostrarEditar')->name('editar_usuario');
	Route::put('editar/{user}','UsuarioController@editar')->name('editar_usuario');
	Route::get('reset-password/{user}','UsuarioController@resetPassword')->name('reset_password');
	Route::get('inactivar/{user}','UsuarioController@inactivarUsuario')->name('inactivar_usuario');
	Route::get('cambiar-password/{user}','UsuarioController@mostrarCambiarPassword')->name('cambiar_password');
	Route::put('cambiar-password/{user}','UsuarioController@cambiarPassword')->name('cambiar_password');
});

/* NOTIFICACIONES USUARIO */
Route::group(['prefix' => 'notificaciones-usuarios'], function () {
	Route::get('listado','NotificacionUsuarioController@listado')->name('notificaciones_usuarios');
	Route::get('enviar-todos','NotificacionUsuarioController@enviarATodos')->name('enviar_notificaciones_a_todos');
});

});

Route::get('/','AuthController@mostrarLogin')->name('inicio');
Route::get('posiciones/{liga}/{campeonato}','PublicController@posiciones')->name('posiciones');
Route::get('goleadores/{liga}/{campeonato}','PublicController@goleadores')->name('goleadores');
Route::get('calendario/{liga}/{campeonato}','PublicController@calendario')->name('calendario');
Route::get('plantilla/{liga}/{campeonato}/{equipo}','PublicController@plantilla')->name('plantilla');
Route::get('previa/{partido}','PublicController@previa')->name('previa');
Route::get('ficha/{partido}','PublicController@ficha')->name('ficha');
Route::get('en-vivo/{partido}','PublicController@enVivo')->name('en_vivo');
Route::get('lugares','PublicController@domos')->name('lugares');
Route::get('ver-articulos/{autorId}/{categoriaId}','PublicController@verArticulos')->name('ver_articulos');
Route::get('ver-articulo/{articulo}/{slug}','PublicController@verArticulo')->name('ver_articulo');
Route::get('agregar/{articulo}','ComentarioArticuloController@mostrarAgregar')->name('agregar_comentario_articulo');
Route::post('agregar/{articulo}','ComentarioArticuloController@agregar')->name('agregar_comentario_articulo');

Route::get('login','AuthController@mostrarLogin')->name('login');
Route::post('login','AuthController@login')->name('login');
Route::get('logout','AuthController@logout')->name('logout');

// Redirect to github to authenticate
Route::get('facebook', 'FacebookController@facebook_redirect');
// Get back to redirect url
Route::get('account/facebook', 'FacebookController@facebook');

// Redirect to github to authenticate
Route::get('twitter', ['as' => 'twitter', 'uses' => 'TwitterController@twitter_redirect']);
// Get back to redirect url
Route::get('account/twitter', 'TwitterController@twitter');

Route::get('api/noticias','APIController@articulos')->name('api.articulos');





//*EXTERNO*//
Route::get('externo-posiciones/{liga}/{campeonato}','ExternoController@posiciones')->name('externo.posiciones');
Route::get('externo-goleadores/{liga}/{campeonato}','ExternoController@goleadores')->name('externo.goleadores');
Route::get('externo-calendario/{liga}/{campeonato}','ExternoController@calendario')->name('externo.calendario');
Route::get('externo-plantilla/{liga}/{campeonato}/{equipo}','ExternoController@plantilla')->name('externo.plantilla');
Route::get('externo-previa/{partido}','ExternoController@previa')->name('externo.previa');
Route::get('externo-ficha/{partido}','ExternoController@ficha')->name('externo.ficha');
Route::get('externo-en-vivo/{partido}','ExternoController@enVivo')->name('externo.en_vivo');
Route::get('externo-lugares','ExternoController@domos')->name('externo.lugares');


/* API */
Route::group(['prefix' => 'api'], function () {
	Route::get('ligas','APIController@ligas')->name('api.ligas');
	Route::get('posiciones/{liga}/{campeonato}','APIController@posiciones')->name('api.posiciones');
	Route::get('calendario/{liga}/{campeonato}','APIController@calendario')->name('api.calendario');
	Route::get('equipos/{liga}/{campeonato}','APIController@equipos')->name('api.equipos');
	Route::get('plantilla/{liga}/{campeonato}/{equipo}','APIController@plantilla')->name('api.plantilla');
	Route::get('domos','APIController@domos')->name('api.domos');

	Route::get('crear-usuario-notificacion/{usuario}','NotificacionUsuarioController@crear')->name('crear_notificacion_usuario');
	Route::get('usuario-notificacion/{usuario}','NotificacionUsuarioController@usuario')->name('obtener_notificacion_usuario');
	Route::get('activar-notificaciones/{usuario}','NotificacionUsuarioController@activar')->name('activar_notificacion_usuario');
	Route::get('inactivar-notificaciones/{usuario}','NotificacionUsuarioController@inactivar')->name('inactivar_notificacion_usuario');
});
