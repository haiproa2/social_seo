<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	protected $connection = "mysql_data";

    protected $table = 'pages';

    public function option_actives(){
        return $this->hasOne('App\Option', 'id_type', 'active')->where('type', 'active');
    }

    public function option_templates(){
        return $this->hasOne('App\Option', 'id_type', 'template')->where('type', 'template');
    }

    public function posts(){
        return $this->belongsToMany('App\Post');
    }
}
