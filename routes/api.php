<?php

use Illuminate\Http\Request;

date_default_timezone_set('America/Guatemala');
header('Access-Control-Allow-Headers:Origin, Content-Type, X-XSRF-TOKEN, Authorization');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

Route::group(['middleware' => 'api'], function(){

	Route::get('posiciones/{liga}/{campeonato}','APIController@posiciones')->name('api.posiciones');

});


