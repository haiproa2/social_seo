<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth, View, Session, DB, Image;

class AdminController extends Controller
{
    protected $prefix = '';
    protected $action = '';
    protected $title = '';
    protected $description = '';
    protected $disabled = false;
    protected $updateForm = false;

    public function __construct(Request $request){
        $this->prefix = ($request->segment(2))?$request->segment(2):'index';
        $this->action = ($request->segment(3))?(($request->segment(4))?'edit':'add'):'list';
        if($request->segment(3) == 'add' || $request->segment(4) == 'edit')
            $this->updateForm = true;

        view::share([
            'prefix' => $this->prefix, 
            'action' => $this->action,
            'title' => $this->title,
        	'description' => $this->description,
            'disabled' => $this->disabled,
            'updateForm' => $this->updateForm,
        ]);
    }
    public function ajaxDeleteImage(Request $request){
        $_token = $request->_token;
        $table = $request->table_item;
        $table .= 's';
        $id = $request->id_item;
        if($table=='users'){
            $item = DB::table($table)->where('id', $id)->first();
            Image::delete('uploads/'.$item->photo);
            DB::table($table)->where('id', $id)->update(['photo'=>null]);
        }
        else{
            $item = DB::connection('mysql_data')->table($table)->where('id', $id)->first();
            Image::delete('uploads/'.$item->photo);
            DB::connection('mysql_data')->table($table)->where('id', $id)->update(['photo'=>null]);
        }

        
        return json_encode([
            'token' => Session::token(),
            'status' => 'success',
            'messager' => 'Xóa ảnh thành công.',
            'item' => $item
            ]);
    }
}
