<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth, View, Session, DB, Image, App\Page, App\Detail;

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

        $companys = Detail::where('table_name', 'config')->where('id_column', 1)->get()->toArray();
        if(count($companys)){
            foreach ($companys as $key => $value) {
                $company[$value['keyword_column']] = $value['value_column'];
            }
        } 

        view::share([
            'prefix' => $this->prefix,
            'action' => $this->action,
            'title' => $this->title,
        	'description' => $this->description,
            'company' => $company,
            'disabled' => $this->disabled,
            'updateForm' => $this->updateForm,
        ]);
    }

    protected function getIdChilds($id, &$childs) {
        $items = Page::where([['id_parent', $id]])->get();
        if(count($items)) {
            foreach ($items as $key => $value) {
                $childs[] = $value->id;
                $this->getIdChilds($value->id, $childs);
            }
        }
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

    public function ajaxGetSlug(Request $request){
        $_token = $request->_token;
        $title = $request->title_item;
        $slug = str_slug($request->title_item);
        $table = $request->table_item.'s';
        $id = $request->id_item;
        return  json_encode([
            'token' => Session::token(),
            'status' => 'success',
            'messager' => 'Tạo liên kết URL thành công.',
            'slug' => $this->checkSlug($slug, $table, $id)
            ]);
    }

    public function checkSlug($slug, $table, $id = 0, $i = 0){
        if($i)
            $slug = $slug.'-'.$i;

        if($id)
            $item = DB::connection('mysql_data')->table($table)->select('id')->where([['slug', $slug], ['id', '<>', $id]])->get()->first();
        else
            $item = DB::connection('mysql_data')->table($table)->select('id')->where('slug', $slug)->get()->first();
        
        if($item)
            return $this->checkSlug($slug, $table, $id, ++$i);
        else
            return $slug;
    }   
}
