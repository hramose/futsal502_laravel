<?php

namespace App\Http\Controllers;

use Controller, Redirect, Input, Auth, View, Socialize;
use Facebook\Facebook as Facebook;

class TwitterController extends BaseController {

	public function twitter_redirect() {
		return \Socialize::driver('twitter')->redirect();
	}

  	public function twitter() {
  		try{
    		$twitter_user = \Socialize::driver('twitter')->user();
            /*$loginUser = Auth::user();
            $loginUser->twitter_user = $twitter_user->getNickname();
            $loginUser->save();*/
            \Session::flash('success','Se conectó correctamente a Twitter');
            return Redirect::route('dashboard');
    	}
    	catch (\Exception $e) {
    		\Session::flash('error', 'No se autorizó el registro vía twitter');
            $loginUser = Auth::user();
            $loginUser->twitter_user = null;
            $loginUser->save();
    		return Redirect::route('dashboard');
    	}
  	}
}