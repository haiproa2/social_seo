<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Auth, Entrust, App\Detail;

class ConfigController extends AdminController
{
    public function __construct(Request $request){
        parent::__construct($request);
    }

    public function index(Request $request){
    	if(Auth::user()->ability('root,admin', 'u_config')){
    		$updateForm = true;
    		$disabled = false;
    	} else if(Auth::user()->ability('root,admin', 'v_config')){
    		$updateForm = false;
    		$disabled = true;
    	} else
    		return route('backend.index');
    	$items = Detail::where('table_name', 'config')->where('id_column', 1)->get()->toArray();
        if(count($items)){
        	foreach ($items as $key => $value) {
        		$item[$value['keyword_column']] = $value['value_column'];
        	}
        } else {
        	$item = new Detail;
        	$item->table_name = 'config';
        	$item->id_column = 1;
        	$item->keyword_column = 'title';
        	$item->value_column = 'Company title';
        	$item->save();
        	$item = [];
        }
        return view('backend.config.edit')->with([
        	'item'=>$item,
    		'updateForm'=>$updateForm,
    		'disabled'=>$disabled,
            'title' => 'Thông tin công ty',
            'description' => 'Cập nhật tất cả thông tin công ty, cấu hình cho website.',
        ]);
    }
    public function update(Request $request){
    	if(count($request->details)){
            foreach ($request->details as $key => $value) {
                $detail = ''; $detail = Detail::where('table_name', 'config')->where('id_column', 1)->where('keyword_column', $key)->get()->toArray();
                if(isset($detail[0]['id']))
                    Detail::where('table_name', 'config')->where('id_column', 1)->where('keyword_column', $key)->update(['value_column' => $value]);
                else{
                    $detail = new Detail;
                    $detail->table_name = 'config';
                    $detail->id_column = 1;
                    $detail->keyword_column = $key;
                    $detail->value_column = $value;
                    $detail->save();
                }
            }
            $flash_type = 'success animate3 fadeInUp';
            $flash_messager = 'Dữ liệu thông tin công ty đã được cập nhật.';
        } else {
            $flash_type = 'warning animate3 swing';
            $flash_messager = 'Không nhận được dữ liệu.';
        }
        return redirect()->route('backend.config')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
}
