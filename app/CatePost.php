<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatePost extends Model
{
	protected $connection = "mysql_data";
	
    protected $table = 'cate_post';

    public $timestamps = false;
}
