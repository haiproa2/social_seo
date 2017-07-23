<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

Use App\Option, App\Permission, App\PermissionRole;

class PermissionController extends AdminController
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
        	$items = Permission::orwhere([['display_name', 'LIKE', '%'.$keyword.'%']])->orwhere([['name', 'LIKE', '%'.$keyword.'%']])->orderBy('id','DESC')->paginate($limit);
        else
        	$items = Permission::orderBy('id','DESC')->paginate($limit);

        if($keyword)
            $items->appends(['keyword' => $keyword]);
        if($request->limit)
            $items->appends(['limit' => $limit]);

        if($keyword || ($limit && $limit != 20)){
            $flash_type = 'info';
            $flash_messager = 'Danh sách quyền đã được lọc.';
        }
        return view('backend.permissions.list')->with([
            'action' => 'list',
            'title' => 'Danh sách quyền',
            'description' => 'Xem, thêm, sửa hoặc xóa quyền quản lý dữ liệu.',
            'items' => $items,
            'limits' => $limits,
            'flash_type' => $flash_type,
            'flash_messager' => $flash_messager
            ]);
    }
    public function view(Request $request){
    	$id = $request->id;
    	$item = Permission::where([['id', $id]])->firstOrFail();
    	return view('backend.permissions.edit')->with([
            'title' => 'Chi tiết quyền',
            'description' => 'Xem tất cả thông tin của quyền quản lý dữ liệu.',
    		'disabled'=>true,
    		'item'=>$item,
    		]);
    }
    public function create(){
    	return view('backend.permissions.create')->with([
            'title' => 'Thêm mới quyền',
            'description' => 'Thêm mới dữ liệu cho một quyền quản lý dữ liệu.'
    		]);
    }
    public function store(Request $request){
        $this->validate($request, [
                'name' => 'required|unique:permissions,name',
            ], [
                'name.required' => trans('admin.required'),
                'name.unique' => trans('admin.name_unique')
            ]
        );
        
    	$item_d = new Permission;
        $item_d->name = 'd_'.$request->name;
        $item_d->display_name = 'Deletes '.$request->display_name;
        $item_d->description = 'Xóa '.$request->description;
        $item_d->save();
    	$item_u = new Permission;
        $item_u->name = 'u_'.$request->name;
        $item_u->display_name = 'Update '.$request->display_name;
        $item_u->description = 'Chỉnh sửa '.$request->description;
        $item_u->save();
    	$item_c = new Permission;
        $item_c->name = 'c_'.$request->name;
        $item_c->display_name = 'Create '.$request->display_name;
        $item_c->description = 'Tạo mới '.$request->description;
        $item_c->save();
    	$item_v = new Permission;
        $item_v->name = 'v_'.$request->name;
        $item_v->display_name = 'View '.$request->display_name;
        $item_v->description = 'Xem '.$request->description;
        $item_v->save();

        $flash_type = 'success animate3 fideInUp';
        $flash_messager = 'Đã thêm mới quyền quản lý dữ liệu <br/>Module [<b>'.$request->description.'</b>]';

        return redirect()->route('backend.permission')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function edit($id){
    	$item = Permission::where([['id', '<>', 1], ['id', $id]])->firstOrFail();
    	return view('backend.permissions.edit')->with([
            'title' => 'Cập nhật quyền',
            'description' => 'Chỉnh sửa tất cả thông tin của quyền quản lý dữ liệu.',
    		'item'=>$item
    		]);
    }
    public function update(Request $request){
        $id = $request->id;
        $item = Permission::where([['id', $id]])->firstOrFail();
        $this->validate($request, [
                'display_name' => 'required',
            ], [
                'display_name.required' => trans('admin.required'),
            ]
        );

        $item->display_name = $request->display_name;
        $item->description = $request->description;
        $item->save();

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Quyền quản lý [<b>'.$item->description.'</b>]<br/>đã được cập nhật dữ liệu.';

        return redirect()->route('backend.permission')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function destroy(Request $request){
    	$router = $request->route()->getName();
    	if($router == 'backend.permission.delete'){ // Xóa 1 phần tử
    		$item = Permission::findOrFail($request->id);
    		PermissionRole::where('permission_id', $item->id)->delete();
    		$item->delete();
    		$flash_type = 'success animate3 fadeInUp';
    		$flash_messager = 'Quyền truy cập [<b>'.$item->description.'</b>]<br/>đã bị xóa.';
    	} elseif($router == 'backend.permission.deletes'){ // Xóa nhiều phần tử
    		$listid = $request->listid;
    		if($listid){
    			$listids = explode("-", $listid);
				$names = '';
				foreach ($listids as $key => $id) {
					$item = Permission::findOrFail($id);
					$names .= '- [<strong>'.$item->description.'</strong>]<br/>';
    				PermissionRole::where('permission_id', $item->id)->delete();
					$item->delete();
				}
	    		$flash_type = 'success animate3 fadeInUp';
	    		$flash_messager = 'Đã xóa quyền <br/>'.rtrim($names, ', ');
    		} else {
	    		$flash_type = 'info animate3 fadeInUp';
	    		$flash_messager = 'Không nhận được dữ liệu.';
    		}

    	} else { // Không tìm thấy phần tử
    		$flash_type = 'error animate3 swing';
    		$flash_messager = 'Đường dẫn không tồn tại.';
    	}
    	return redirect()->route('backend.permission')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
}
