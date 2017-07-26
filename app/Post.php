<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $connection = "mysql_data";

    protected $table = 'posts';

    public function option_actives(){
        return $this->hasOne('App\Option', 'id_type', 'active')->where('type', 'active');
    }
}
