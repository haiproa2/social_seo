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

    public function categorys(){
        return $this->belongsToMany('App\Page', 'cate_post', 'post_id', 'cate_id');
    }
}
