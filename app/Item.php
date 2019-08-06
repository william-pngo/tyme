<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function genre(){
		return $this->belongsTo("\App\Genre");
	}

	public function country(){
		return $this->belongsTo("\App\Country");
	}

	public function itemstatus(){
        return $this->belongsTo("\App\ItemStatus");
    }

    public function orders(){
		return $this->hasMany("\App\Order");
	}
}
