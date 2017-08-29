<?php

namespace App\App\Entities;

use Carbon\Carbon;

trait UserStamps
{

	protected static function boot()
    {
    	parent::boot();

        static::creating(function ($model) {
            $user = \Auth::user();
            if(!is_null($user)){
                $username = $user->username;
            }
            else{
                $username = "publico";
            }
            $model->created_by = $username;
            $model->updated_by = $username;
        });

        static::updating(function ($model) {
            $user = \Auth::user();
            if(!is_null($user)){
                $username = $user->username;
            }
            else{
                $username = "publico";
            }
            $model->updated_by = $username;
        });
    }

}