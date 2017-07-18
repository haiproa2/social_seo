<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Auth, Hash, App\Option, App\User;

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
    	$user = User::findOrFail(Auth::user()->id);
        $this->validate($request, [
                'name' => 'required',
                'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
                'telephone' => 'nullable|min:10|max:11|unique:users,telephone,'.$user->id,
                'password' => 'nullable|min:6|same:password_confirmation',
            ], [
                'name.required' => trans('admin.required'),
                'email.required' => trans('admin.required'),
                'email.email' => trans('admin.email'),
                'email.max' => trans('admin.max.string'),
                'email.unique' => trans('admin.email_unique'),
                'telephone.min' => trans('admin.telephone_min'),
                'telephone.max' => trans('admin.telephone_max'),
                'telephone.unique' => trans('admin.telephone_unique'),
                'password.min' => trans('admin.min.string'),
                'password.same' => trans('auth.same_password'),
            ]
        );

        $user->name = $request->name;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->birthday = $request->birthday;
        $user->sex = $request->sex;
        $user->content = $request->content;

        if($request->password && $request->password_confirmation){
        	$user->password = Hash::make(strval($request->password_confirmation));
        }

        /*
		Còn thiếu photo.
		- Các trường # trong bảng detail.
		- Ghi log những thay đổi.
        */

        $user->save();
        return redirect()->route('backend.user')->with(['flash_type'=>'success', 'flash_messager'=>'<b>Chúc Mừng</b><br/>Dữ liệu đã được cập nhật.']);
    }
}
