<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Auth, App\Option;

class UserController extends AdminController
{
    public function index(){
    	$item = Auth::user();
        $item->active = Option::where([['type', 'active'], ['active', 1], ['id_type', $item->active]])->pluck('value_type')->first();
    	return view('backend.users.index')->with([
    		'action' => 'detail',
            'title_bar' => 'Cập nhật thông tin cá nhân - ',
    		'user' => $item,
    		]);
    }
    public function saveDetail(Request $request){
        $id = Auth::user()->id;
        $this->validate($request, [
                'name' => 'required',
                'email' => 'required|string|email|max:255|unique:users,email,'.$id,
                'phone' => 'min:10|max:11|unique:users,phone,'.$id,
                'password' => 'min:6|same:password_confirmation',
            ], [
                'name.required' => trans('admin.required'),
                'email.required' => trans('admin.required'),
                'email.email' => trans('admin.email'),
                'email.max' => trans('admin.max.string'),
                'email.unique' => trans('admin.email_unique'),
                'phone.min' => trans('admin.min.string'),
                'phone.max' => trans('admin.min.string'),
                'phone.unique' => trans('admin.phone_unique'),
                'password.min' => trans('admin.min.string'),
                'password.same' => trans('auth.same_password'),
            ]
        );

    }
}
