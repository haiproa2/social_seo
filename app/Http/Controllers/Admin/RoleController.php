<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

Use App\Option, App\Role, App\Permission, App\RoleUser, App\PermissionRole;

class RoleController extends AdminController
{
    public function __construct(Request $request){
        parent::__construct($request);
    }

    public function index(Request $request){
    	$limits = Option::where([['type', 'limit'], ['active', '1']])->orderby('id_type', 'ASC')->pluck('value_type', 'id_type')->toArray();

        $limit = $request->limit ? $request->limit : 20;
        $keyword = $request->keyword ? $request->keyword : '';

        $flash_type = $flash_messager = '';

        if($keyword)
        	$items = Role::orwhere([['display_name', 'LIKE', '%'.$keyword.'%']])->orwhere([['name', 'LIKE', '%'.$keyword.'%']])->where([['name', '<>', 'root']])->orderBy('id','DESC')->paginate($limit);
        else
        	$items = Role::where([['name', '<>', 'root']])->orderBy('id','DESC')->paginate($limit);

        if($keyword)
            $items->appends(['keyword' => $keyword]);
        if($request->limit)
            $items->appends(['limit' => $limit]);

        if($keyword || ($limit && $limit != 20)){
            $flash_type = 'info animate3 fadeInUp';
            $flash_messager = 'Danh sách nhóm đã được lọc.';
        }
        return view('backend.roles.list')->with([
            'action' => 'list',
            'title' => 'Danh sách nhóm',
            'description' => 'Xem, thêm, sửa hoặc xóa nhóm thành viên.',
            'items' => $items,
            'limits' => $limits,
            'flash_type' => $flash_type,
            'flash_messager' => $flash_messager
            ]);
    }
    public function view($id){
    	$item = Role::where([['id', '<>', 1], ['id', $id]])->firstOrFail();
    	$permissions = Permission::where('name', 'NOT LIKE', '%-role%')->orderby('id','desc')->get()->toArray();
    	$permission_role = PermissionRole::select('permission_id')->where('role_id', $id)->get()->toArray();
    	$permission_role = array_column($permission_role, 'permission_id');
    	return view('backend.roles.edit')->with([
            'title' => 'Chi tiết nhóm',
            'description' => 'Xem tất cả thông tin của nhóm thành viên.',
    		'disabled'=>true,
    		'permissions'=>$permissions,
    		'permission_role'=>$permission_role,
    		'item'=>$item,
    		]);
    }
    public function create(){
    	$permissions = Permission::orderby('id','desc')->get()->toArray();
    	$permission_role = [];
    	return view('backend.roles.create')->with([
            'title' => 'Thêm mới nhóm',
            'description' => 'Thêm mới dữ liệu cho một thành viên.',
            'permissions' => $permissions,
            'permission_role' => $permission_role,
    		]);
    }
    public function store(Request $request){
    	$item = new Role;
        $this->validate($request, [
                'name' => 'required|unique:roles,name',
            ], [
                'name.required' => trans('admin.required'),
                'name.unique' => trans('admin.name_unique')
            ]
        );
        $item->name = $request->name;
        $item->display_name = $request->display_name;
        $item->description = $request->description;
        $item->save();

        if($request->permissions){
			foreach ($request->permissions as $val) {
				$item->attachPermission($val);
			}
		}

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Đã thêm mới nhóm thành viên [<b>'.$item->name.'</b>]';

        return redirect()->route('backend.role')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function edit($id){
    	$item = Role::where([['id', '<>', 1], ['id', $id]])->firstOrFail();
    	$permissions = Permission::orderby('id','desc')->get()->toArray();
    	$permission_role = PermissionRole::select('permission_id')->where('role_id', $id)->get()->toArray();
    	$permission_role = array_column($permission_role, 'permission_id');
    	return view('backend.roles.edit')->with([
            'title' => 'Cập nhật nhóm thành viên',
            'description' => 'Chỉnh sửa tất cả thông tin của nhóm thành viên.',
    		'permissions'=>$permissions,
    		'permission_role'=>$permission_role,
    		'item'=>$item
    		]);
    }
    public function update(Request $request){
        $id = $request->id;
        $item = Role::where([['id', '<>', 1], ['id', $id]])->firstOrFail();
		PermissionRole::where('role_id', $item->id)->delete();
        $this->validate($request, [
                'display_name' => 'required',
            ], [
                'display_name.required' => trans('admin.required'),
            ]
        );

        $item->display_name = $request->display_name;
        $item->description = $request->description;
        $item->save();

		if($request->permissions){
			foreach ($request->permissions as $val) {
				$item->attachPermission($val);
			}
		}

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Nhóm thành viên [<b>'.$item->name.'</b>]<br/>đã được cập nhật dữ liệu.';

        return redirect()->route('backend.role')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function destroy(Request $request){
    	$router = $request->route()->getName();
    	if($router == 'backend.role.delete'){ // Xóa 1 phần tử
    		$item = Role::where([['id', '>', 4], ['id', $request->id]])->firstOrFail();
    		PermissionRole::where('role_id', $item->id)->delete();
    		RoleUser::where('role_id', $item->id)->delete();
    		$item->delete();
    		$flash_type = 'success animate3 fadeInUp';
    		$flash_messager = 'Nhóm thành viên [<b>'.$item->name.'</b>]<br/>đã bị xóa.';
    	} elseif($router == 'backend.role.deletes'){ // Xóa nhiều phần tử
    		$listid = $request->listid;
    		if($listid){
    			$listids = explode("-", $listid);
				$names = '';
				foreach ($listids as $key => $id) {
					$item = Role::where([['id', '>', 4], ['id', $id]])->first();
					if($item){
						$names .= '[<strong>'.$item->name.'</strong>], ';
	    				PermissionRole::where('role_id', $item->id)->delete();
						RoleUser::where('role_id', $item->id)->delete();
						$item->delete();
					}
				}
				if($names){
		    		$flash_type = 'success animate3 fadeInUp';
		    		$flash_messager = 'Nhóm thành viên '.rtrim($names, ', ').' đã bị xóa.';
		    	} else {
		    		$flash_type = 'info animate3 fadeInUp';
		    		$flash_messager = 'Không được xóa nhóm mặc định.';
		    	}
    		} else {
	    		$flash_type = 'info animate3 fadeInUp';
	    		$flash_messager = 'Không nhận được dữ liệu.';
    		}

    	} else { // Không tìm thấy phần tử
    		$flash_type = 'error animate3 swing';
    		$flash_messager = 'Đường dẫn không tồn tại.';
    	}
    	return redirect()->route('backend.role')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
}
