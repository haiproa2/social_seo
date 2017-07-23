<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
	protected $connection = "mysql_data";

    protected $table = 'options';

    public function option_actives(){
        return $this->hasOne('App\Option', 'id_type', 'active')->where('type', 'active');
    }

    public function lists($type = 'active', $active = 1){
    	$items = $this::where([['type', 'active'], ['active', '1']]);
    }
}
