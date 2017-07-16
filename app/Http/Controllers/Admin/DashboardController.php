<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Auth;

class DashboardController extends AdminController
{
    public function index(){
    	return view('backend.index')->with([
    		'com' => 'index',
    		]);
    }
}
