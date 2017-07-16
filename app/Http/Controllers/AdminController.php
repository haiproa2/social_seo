<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth, View;

class AdminController extends Controller
{
	protected $user;

	public $com = '';

	public function __construct(){
		$this->user = $this->getAuth();
        view::share(['member' => $this->user, 'title_bar' => '', 'com' => '', 'com_type' => '']);
	}

	protected function getAuth(){
		$this->user = Auth::user();
	}
}
