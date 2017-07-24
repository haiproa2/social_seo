<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
	protected $connection = "mysql_data";

    protected $table = 'details';
}
