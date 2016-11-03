<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
	protected $guarded = [];

	public function Cameras()
    {
       return $this->hasMany('App\Camera');
    }
}
