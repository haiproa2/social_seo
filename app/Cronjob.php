<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cronjob extends Model
{
	protected $connection = "mysql_data";
	
    protected $table = 'cronjobs';

    public function option_actives(){
        return $this->hasOne('App\Option', 'id_type', 'active')->where('type', 'active');
    }

    public function category(){
        return $this->hasOne('App\Page', 'id');
    }
}
