<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use Auth;

class UserController extends AdminController
{
    public function index(){
    	$item = Auth::user();
    	return view('backend.users.index')->with([
    		'com' => 'user',
    		'com_type' => 'user_detail',
            'title_bar' => 'Cập nhật thông tin cá nhân - ',
    		'item' => $item,
    		]);
    }
    public function saveDetail(){
    	
    }
}
