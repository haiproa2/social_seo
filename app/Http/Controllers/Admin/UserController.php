<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Auth, Hash, Image, App\Option, App\User;

class UserController extends AdminController
{
    public function __construct(Request $request){
        parent::__construct($request);
    }
    public function index(){
    	$item = Auth::user();
        $item->active = Option::where([['type', 'active'], ['active', 1], ['id_type', $item->active]])->pluck('value_type')->first();
    	return view('backend.users.index')->with([
            'action' => 'detail',
    		'updateForm' => true,
            'title' => 'Thông tin cá nhân',
            'description' => 'Quản lý và cập nhật tất cả thông tin cá nhân.',
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
        return redirect()->route('backend.user')->with(['flash_type'=>'success', 'flash_messager'=>'Thông tin cá nhân đã được cập nhật.']);
    }
    public function listUsers(Request $request){
    	$limits = Option::where([['type', 'limit'], ['active', '1']])->orderby('id_type', 'ASC')->pluck('value_type', 'id_type')->toArray();

        $limit = $request->limit ? $request->limit : 10;
        $keyword = $request->keyword ? $request->keyword : '';

        $flash_type = $flash_messager = '';

        if($keyword)
        	$items = User::orwhere([['username', 'LIKE', '%'.$keyword.'%']])->orwhere([['email', 'LIKE', '%'.$keyword.'%']])->orwhere([['name', 'LIKE', '%'.$keyword.'%']])->where([['id', '<>', Auth::user()->id], ['id', '<>', 89]])->orderBy('id','DESC')->paginate($limit);
        else
        	$items = User::where([['id', '<>', Auth::user()->id], ['id', '<>', 89]])->orderBy('id','DESC')->paginate($limit);
        /*if(Entrust::hasRole('root')){
            $items = User::where([['id', '<>', Auth::user()->id], ['name', 'LIKE', '%'.$keyword.'%']])->orwhere([['username', 'LIKE', '%'.$keyword.'%']])->orwhere([['email', 'LIKE', '%'.$keyword.'%']])->orderBy('id','DESC')->paginate($limit);
        }*/

        if($keyword)
            $items->appends(['keyword' => $keyword]);
        if($request->limit)
            $items->appends(['limit' => $limit]);

        if($keyword){
            $flash_type = 'info';
            $flash_messager = 'Danh sách thành viên đã được lọc.';
        }
        return view('backend.users.list')->with([
            'action' => 'list',
            'title' => 'Danh sách thành viên',
            'description' => 'Xem, thêm, sửa hoặc xóa thành viên.',
            'items' => $items,
            'limits' => $limits,
            'flash_type' => $flash_type,
            'flash_messager' => $flash_messager
            ]);
    }
    public function updatePosition(Request $request){
    	$positions = $request->no;
    	if(count($positions['id'])){
    		$mess = '';
    		for ($i=0; $i < count($positions['id']); $i++) {
    			$item = User::findOrFail($positions['id'][$i]);
    			if($item->id && $item->no != $positions['no'][$i]){
    				$mess .= '<b>'.$item->name.'</b>, ';
    				User::where("id", $item->id)->update(['no' => $positions['no'][$i], 'updated_by' => Auth::user()->id]);
    			}
    		}
    		if($mess){
	    		$flash_messager = 'Thành viên ['.substr($mess, 0, -2).'].<br/>Đã được cập nhật lại STT.';
		        $flash_type = 'success';
		    } else {
		    	$flash_messager = 'Không có thành viên được cập nhật.';
		    	$flash_type = 'info';
		    }
    	} else {
    		$flash_messager = 'Không tìm thấy thành viên nào.';
	        $flash_type = 'warning';    		
    	}
        return redirect()->route('backend.user.list')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function activeStatus($id){
        $user = User::findOrFail($id);
        if($id!=89){
            if($user->active==0)
                $user->active = 1;
            else
                $user->active = 0;
        	$status = Option::select('value_type')->where([['type', 'active'], ['id_type', $user->active]])->first();
	        $flash_messager = 'Thành viên [<b>'.$user->name.'</b>] được cập nhật trạng thái thành <b>'.strip_tags($status->value_type).'</b>';
	        $flash_type = 'success';
            $user->updated_by = Auth::user()->id;
            $user->save();
        } else {
	        $flash_messager = 'Không tìm thấy thông tin thành viên';
	        $flash_type = 'info';
        }
        return redirect()->route('backend.user.list')->with(['flash_messager'=>$flash_messager, 'flash_type'=>$flash_type]);
    }
    public function view(Request $request){
    	$id = $request->id;
    	$sexs = Option::select('value_type', 'id_type')->where([['type', 'sex'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	$actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	$item = User::findOrFail($id);
    	return view('backend.users.edit')->with([
            'title' => 'Xem chi tiết thành viên',
            'description' => 'Xem tất cả thông tin của thành viên.',
    		'disabled'=>true,
    		'sexs'=>$sexs,
    		'actives'=>$actives,
    		'user'=>$item
    		]);
    }
    public function create(){
    	$sexs = Option::select('value_type', 'id_type')->where([['type', 'sex'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	$actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.users.create')->with([
            'title' => 'Thêm mới thành viên',
            'description' => 'Thêm mới dữ liệu cho một thành viên.',
    		'sexs'=>$sexs,
    		'actives'=>$actives,
    		'user'=>''
    		]);
    }
    public function store(Request $request){
    	$user = new User;
        $this->validate($request, [
                'name' => 'required',
                'email' => 'required|string|email|max:255|unique:users,email',
                'telephone' => 'nullable|min:10|max:11|unique:users,telephone',
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
                'password.required' => trans('admin.required'),
                'password.min' => trans('admin.min.string'),
                'password.same' => trans('auth.same_password'),
            ]
        );

        $user->username = $request->username;
        $user->slug = str_slug($request->username).date('-Ymd-His', time());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->birthday = $request->birthday;
        $user->sex = $request->sex;
        $user->content = $request->content;
        $user->no = $request->no;
        $user->active = $request->active;
        $user->created_by = Auth::user()->id;
        $user->updated_by = Auth::user()->id;
		$user->password = Hash::make(strval($request->password_confirmation));

        /*
		- Còn thiếu photo.
		- Các trường # trong bảng detail.
		- Ghi log những thay đổi.
        */

        $user->save();

        $flash_type = 'success';
        $flash_messager = 'Đã thêm mới thành viên [<b>'.$user->name.'</b>]';

        return redirect()->route('backend.user.list')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function edit($id){
    	$item = User::findOrFail($id);
    	$sexs = Option::select('value_type', 'id_type')->where([['type', 'sex'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	$actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.users.edit')->with([
            'title' => 'Cập nhật thành viên',
            'description' => 'Chỉnh sửa tất cả thông tin của thành viên.',
    		'sexs'=>$sexs,
    		'actives'=>$actives,
    		'user'=>$item
    		]);
    }
    public function update(Request $request){
        $id = $request->id;
        $user = User::findOrFail($id);
        $this->validate($request, [
                'photo' => 'nullable|max:3000',
                'name' => 'required',
                'email' => 'required|string|email|max:255|unique:users,email,'.$id,
                'telephone' => 'nullable|min:10|max:11|unique:users,telephone,'.$id,
                'password' => 'nullable|min:6|same:password_confirmation',
            ], [
                'photo.max' => trans('admin.max.file'),
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

        $file = $request->photo;
        $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getClientOriginalName());
        $ext = $file->getClientOriginalExtension();
        $pathImageUser = 'users/';
        $image = Image::make($file);
        $newFilename = str_slug($filename).'.'.$ext;

        $uploadSuccess = $file->move('images/'.$pathImageUser, $newFilename);
        if(!$uploadSuccess){
            $flash_type = 'error';
            $flash_messager = 'Không thể upload hình ảnh.';

            return redirect()->route('backend.user.edit', $id)->withInput()->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->birthday = $request->birthday;
        $user->sex = $request->sex;
        $user->content = $request->content;
        $user->photo = $pathImageUser.$newFilename;
        $user->no = $request->no;
        $user->active = $request->active;
        $user->updated_by = Auth::user()->id;
        if($request->password && $request->password_confirmation){
            $user->password = Hash::make(strval($request->password_confirmation));
        }

        /*
        - Còn thiếu photo.
        - Các trường # trong bảng detail.
        - Ghi log những thay đổi.
        */

        $user->save();

        $flash_type = 'success';
        $flash_messager = 'Thành viên [<b>'.$user->name.'</b>]<br/>đã được cập nhật dữ liệu.';

        return redirect()->route('backend.user.list')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);

    }
}
