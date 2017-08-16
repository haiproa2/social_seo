<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Auth, View, App\Option, App\Post,  App\Cronjob, App\CronjobResult;

class CronjobLogController extends AdminController
{
    public function __construct(Request $request){
        parent::__construct($request);
        $prefix_title = 'Lấy tin tự động';
        $this->action = 'log';
        view::share([
            'prefix_title'=>$prefix_title,
            'action'=>$this->action,
        ]);
    }
    public function index(Request $request){
    	$limits = Option::where([['type', 'limit'], ['active', '1']])->orderby('id_type', 'ASC')->pluck('value_type', 'id_type')->toArray();
    	
        $limit = $request->limit ? $request->limit : 10;
        $keyword = $request->keyword ? $request->keyword : '';

        $flash_type = $flash_messager = '';

        if($keyword){
        	$items = CronjobResult::where([['link', 'LIKE', '%'.$keyword.'%']])->orwhere([['title', 'LIKE', '%'.$keyword.'%']])->orwhere([['status', 'LIKE', '%'.$keyword.'%']])->orderBy('id','DESC')->paginate($limit);
            $items->appends(['keyword' => $keyword]);
        } else {
            $items = CronjobResult::orderBy('id','DESC')->paginate($limit);
        }
        if($request->limit)
            $items->appends(['limit' => $limit]);

        if($keyword || ($limit && $limit != 10)){
            $flash_type = 'info animate3 fadeInUp';
            $flash_messager = 'Danh sách đã được lọc.';
        }

        return view('backend.cronjobs-results.list')->with([
            'title' => 'Danh sách log',
            'description' => 'Xem, xóa log',
            'items' => $items,
            'limits' => $limits,
            'flash_type' => $flash_type,
            'flash_messager' => $flash_messager
        ]);
    }
    public function destroy(Request $request){
    	$router = $request->route()->getName();
    	if($router == 'backend.'.$this->prefix.'.log.delete'){ // Xóa 1 phần tử
    		$item = CronjobResult::where([['id', $request->id]])->firstOrFail();
    		$item->delete();
    		$flash_type = 'success animate3 fadeInUp';
    		$flash_messager = 'Log <br/>[<b>'.$item->link.'</b>]<br/>đã bị xóa.';
    	} elseif($router == 'backend.'.$this->prefix.'.log.deletes'){ // Xóa nhiều phần tử
    		$listid = $request->listid;
    		if($listid){
    			$listids = explode("-", $listid);
				$titles = '';
				foreach ($listids as $key => $id) {
					$item = CronjobResult::where([['id', $id]])->first();
					if($item){
						$titles .= '<b>- '.$item->title.'</b><br/>';
						$item->delete();
					}
				}
				if($titles && count ($listids) > 5){
                    $flash_type = 'success animate3 fadeInUp';
                    $flash_messager = 'Đã xóa các log<br/>'.rtrim($titles, ', ');
                } else if($titles){
		    		$flash_type = 'success animate3 fadeInUp';
		    		$flash_messager = 'Các log được chọn đã xóa.';
		    	} else {
		    		$flash_type = 'info animate3 fadeInUp';
		    		$flash_messager = 'Không xóa được log.';
		    	}
    		} else {
	    		$flash_type = 'info animate3 fadeInUp';
	    		$flash_messager = 'Không nhận được dữ liệu.';
    		}

    	} else { // Không tìm thấy phần tử
    		$flash_type = 'error animate3 swing';
    		$flash_messager = 'Đường dẫn không tồn tại.';
    	}
    	return redirect()->route('backend.'.$this->prefix.'.log')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
}
