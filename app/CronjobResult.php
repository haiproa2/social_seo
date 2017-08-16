<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronjobResult extends Model
{
	protected $connection = "mysql_data";
	
    protected $table = 'cronjob_results';

    public function post(){
        return $this->hasOne('App\Post', 'id');
    }
}
