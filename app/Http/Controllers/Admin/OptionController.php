<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use App\Option;

class OptionController extends AdminController
{
    public function __construct(Request $request){
        parent::__construct($request);
    }

    public function index(Request $request){
    	$limits = Option::where([['type', 'limit'], ['active', '1']])->orderby('id_type', 'ASC')->pluck('value_type', 'id_type')->toArray();

        $limit = $request->limit ? $request->limit : 10;
        $keyword = $request->keyword ? $request->keyword : '';

        $flash_type = $flash_messager = '';

        if($keyword)
        	$items = Option::orwhere([['type', 'LIKE', '%'.$keyword.'%']])->orwhere([['id_type', 'LIKE', '%'.$keyword.'%']])->orwhere([['value_type', 'LIKE', '%'.$keyword.'%']])->orderBy('type', 'ASC')->orderBy('id_type','ASC')->paginate($limit);
        else
        	$items = Option::orderBy('type', 'ASC')->orderBy('id_type','ASC')->paginate($limit);

        if($keyword)
            $items->appends(['keyword' => $keyword]);
        if($request->limit)
            $items->appends(['limit' => $limit]);

        if($keyword || ($limit && $limit != 10)){
            $flash_type = 'info animate3 fadeInUp';
            $flash_messager = 'Danh sách option đã được lọc.';
        }
        return view('backend.options.list')->with([
            'action' => 'list',
            'title' => 'Danh sách option',
            'description' => 'Xem, thêm, sửa hoặc xóa option.',
            'items' => $items,
            'limits' => $limits,
            'flash_type' => $flash_type,
            'flash_messager' => $flash_messager
            ]);
    }
    public function activeStatus($id){
        $item = Option::findOrFail($id);
        if($item->active==0)
            $item->active = 1;
        else
            $item->active = 0;
        $status = Option::select('value_type')->where([['type', 'active'], ['id_type', $item->active]])->first();
        $flash_messager = '[<b>Option: '.$item->type.', Key: '.$item->id_type.', value: '.$item->value_type.'</b>] được cập nhật trạng thái thành <b>'.strip_tags($status->value_type).'</b>';
        $flash_type = 'success animate3 fadeInUp';
        $item->save();
        return redirect()->route('backend.option')->with(['flash_messager'=>$flash_messager, 'flash_type'=>$flash_type]);
    }
    public function view($id){
    	$item = Option::where([['id', $id]])->firstOrFail();
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.options.edit')->with([
            'title' => 'Chi tiết option',
            'description' => 'Xem tất cả thông tin của option.',
    		'disabled'=>true,
            'actives'=>$actives,
            'item'=>$item,
    		]);
    }
    public function create(){
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.options.create')->with([
            'title' => 'Thêm mới option',
            'description' => 'Thêm mới dữ liệu cho một option.',
            'actives' => $actives,
    		]);
    }
    public function store(Request $request){
    	$item = new Option;
        $this->validate($request, [
                'type' => 'required',
                'id_type' => 'required|integer',
                'value_type' => 'required',
            ], [
                'type.required' => trans('admin.required'),
                'id_type.required' => trans('admin.required'),
                'id_type.integer' => trans('admin.numeric'),
                'value_type.required' => trans('admin.required'),
            ]
        );
        $item->type = $request->type;
        $item->id_type = $request->id_type;
        $item->value_type = $request->value_type;
        $item->active = $request->active;
        $item->save();

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Đã thêm mới option [<b>'.$item->type.' có giá trị: '.$item->value_type.'</b>]';

        return redirect()->route('backend.option')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function edit($id){
    	$item = Option::where([['id', $id]])->firstOrFail();
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.options.edit')->with([
            'title' => 'Cập nhật option',
            'description' => 'Chỉnh sửa tất cả thông tin của option.',
    		'actives'=>$actives,
    		'item'=>$item
    		]);
    }
    public function update(Request $request){
        $id = $request->id;
        $item = Option::where([['id', $id]])->firstOrFail();
        $this->validate($request, [
                'id_type' => 'required|integer',
                'value_type' => 'required',
            ], [
                'id_type.required' => trans('admin.required'),
                'id_type.integer' => trans('admin.numeric'),
                'value_type.required' => trans('admin.required'),
            ]
        );

        $item->id_type = $request->id_type;
        $item->value_type = $request->value_type;
        $item->active = $request->active;
        $item->save();

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Option [<b>'.$item->type.' có giá trị:'.$item->value_type.'</b>]<br/>đã được cập nhật dữ liệu.';

        return redirect()->route('backend.option')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function destroy(Request $request){
    	$router = $request->route()->getName();
    	if($router == 'backend.option.delete'){ // Xóa 1 phần tử
    		$item = Option::where([['id', $request->id]])->firstOrFail();
    		$item->delete();
    		$flash_type = 'success animate3 fadeInUp';
    		$flash_messager = '[<b>Option '.$item->type.' có id: '.$item->id_type.'</b>]<br/>đã bị xóa.';
    	} elseif($router == 'backend.option.deletes'){ // Xóa nhiều phần tử
    		$listid = $request->listid;
    		if($listid){
    			$listids = explode("-", $listid);
				$names = '';
				foreach ($listids as $key => $id) {
					$item = Option::where([['id', $id]])->first();
					if($item){
						$names .= '[<strong>'.$item->type.' có id: '.$item->id_type.'</strong>], ';
						$item->delete();
					}
				}
				if($names){
		    		$flash_type = 'success animate3 fadeInUp';
		    		$flash_messager = 'Option '.rtrim($names, ', ').' đã bị xóa.';
		    	} else {
		    		$flash_type = 'info animate3 fadeInUp';
		    		$flash_messager = 'Không được xóa option.';
		    	}
    		} else {
	    		$flash_type = 'info animate3 fadeInUp';
	    		$flash_messager = 'Không nhận được dữ liệu.';
    		}

    	} else { // Không tìm thấy phần tử
    		$flash_type = 'error animate3 swing';
    		$flash_messager = 'Đường dẫn không tồn tại.';
    	}
    	return redirect()->route('backend.option')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
}
