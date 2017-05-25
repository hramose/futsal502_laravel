<?php

use Illuminate\Http\Request;

Route::group(['middleware' => 'api'], function(){

	Route::get('posiciones/{liga}/{campeonato}','APIController@posiciones')->name('api.posiciones');

});
