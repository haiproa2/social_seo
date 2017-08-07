<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Auth, View, Image, App\Page, App\CatePost, App\Option, App\Cronjob;

class CronjobController extends AdminController
{
    public function __construct(Request $request){
        parent::__construct($request);
        $cates = Page::select('id', 'id_parent', 'title')->where([['type', 'news'], ['active', 1]])->orderby('no', 'ASC')->orderby('id', 'DESC')->get();
        recursive($cates, $categorys);
        view::share([
            'categorys'=>$categorys,
        ]);
    }

    public function index(Request $request){
        $limits = Option::where([['type', 'limit'], ['active', '1']])->orderby('id_type', 'ASC')->pluck('value_type', 'id_type')->toArray();

        $cate = $request->cate ? $request->cate : '';
        $limit = $request->limit ? $request->limit : 20;
        $keyword = $request->keyword ? $request->keyword : '';

        $flash_type = $flash_messager = '';

        if($cate){
            $idCates[] = $cate;
            $this->getIdChilds($cate, $idCates);
        }

        if($keyword){ // Không có danh mục nhưng có từ khóa
            $items = Cronjob::where([['title', 'LIKE', '%'.$keyword.'%']])->orwhere([['url_topic', 'LIKE', '%'.$keyword.'%']])->orderBy('no', 'ASC')->orderBy('id','DESC')->paginate($limit);
        } else{ // Lấy tất cả bài viết
            $items = Cronjob::orderBy('no', 'ASC')->orderBy('id','DESC')->paginate($limit);
        }

        if($cate)
            $items->appends(['cate' => $cate]);
        if($keyword)
            $items->appends(['keyword' => $keyword]);
        if($request->limit)
            $items->appends(['limit' => $limit]);

        if($cate || $keyword || ($limit && $limit != 20)){
            $flash_type = 'info animate3 fadeInUp';
            $flash_messager = 'Danh sách cronjob đã được lọc.';
        }
        return view('backend.cronjobs.list')->with([
            'title' => 'Danh sách cronjob',
            'description' => 'Xem, thêm, sửa hoặc xóa cronjob.',
            'items' => $items,
            'limits' => $limits,
            'flash_type' => $flash_type,
            'flash_messager' => $flash_messager
            ]);
    }

    public function updatePosition(Request $request){
        $positions = $request->no;
        if(count($positions['id'])){
            $titles = '';
            for ($i=0; $i < count($positions['id']); $i++) {
                $item = Cronjob::findOrFail($positions['id'][$i]);
                if($item->id && $item->no != $positions['no'][$i]){
                    $titles .= '<b>- '.$item->title.'</b><br/>';
                    Cronjob::where("id", $item->id)->update(['no' => $positions['no'][$i], 'updated_by' => Auth::user()->id]);
                }
            }
            if($titles){
                $flash_messager = 'Đã cập nhật lại STT cho cronjob<br/><b>'.rtrim($titles).'</b>';
                $flash_type = 'success animate3 fadeInUp';
            } else {
                $flash_messager = 'Không có cronjob nào được cập nhật.';
                $flash_type = 'info animate3 fadeInUp';
            }
        } else {
            $flash_messager = 'Không tìm thấy cronjob.';
            $flash_type = 'warning animate3 swing';         
        }
        return redirect()->route('backend.cronjob')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }

    public function create(){
        $getfroms = Option::where([['type', 'cronjob'], ['active', '1']])->orderby('id_type', 'ASC')->pluck('value_type', 'id_type')->toArray();
        return view('backend.cronjobs.create')->with([
            'title' => 'Thêm mới cronjob',
            'description' => 'Thêm mới dữ liệu cho một cronjob.',
            'getfroms' => $getfroms,
            ]);
    }

    public function store(Request $request){
        $item = new Cronjob;
        $this->validate($request, [
                'title' => 'required',
                'url_topic' => 'required',
                'tag_list' => 'required',
                'tag_link' => 'required',
                'tag_title' => 'required',
                'tag_photo' => 'required',
                'tag_content' => 'required',
            ], [
                'title.required' => trans('admin.required'),
                'url_topic.required' => trans('admin.required'),
                'tag_list.required' => trans('admin.required'),
                'tag_link.required' => trans('admin.required'),
                'tag_title.required' => trans('admin.required'),
                'tag_photo.required' => trans('admin.required'),
                'tag_content.required' => trans('admin.required'),
            ]
        );

        $domain = parse_url($request->url_topic);
        
        $item->cate_id = $request->cate_id;
        $item->title = $request->title;
        $item->domain = $domain['scheme'].'://'.$domain['host'];
        $item->url_topic = $request->url_topic;
        $item->url_page = $request->url_page;
        $item->count_page = $request->count_page;
        $item->tag_list = $request->tag_list;
        $item->tag_link = $request->tag_link;
        $item->tag_title = $request->tag_title;
        $item->tag_desc = $request->tag_desc;
        $item->where_desc = $request->where_desc;
        $item->tag_content = $request->tag_content;
        $item->tag_photo = $request->tag_photo;
        $item->where_photo = $request->where_photo;
        $item->tag_remove = $request->tag_remove;
        $item->no = $request->no;
        $item->created_by = Auth::user()->id;
        $item->updated_by = Auth::user()->id;
        $item->save();

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Đã thêm mới cronjob <br/><b>'.$item->title.'</b>';

        return redirect()->route('backend.cronjob')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }

    public function view($id){
        $item = Cronjob::where([['id', $id]])->firstOrFail();
        $getfroms = Option::where([['type', 'cronjob'], ['active', '1']])->orderby('id_type', 'ASC')->pluck('value_type', 'id_type')->toArray();
        return view('backend.cronjobs.edit')->with([
            'title' => 'Chi tiết cronjob',
            'description' => 'Xem tất cả thông tin của cronjob.',
            'disabled'=>true,
            'getfroms' => $getfroms,
            'item' => $item,
            ]);
    }

    public function edit($id){
        $item = Cronjob::where([['id', $id]])->firstOrFail();
        $getfroms = Option::where([['type', 'cronjob'], ['active', '1']])->orderby('id_type', 'ASC')->pluck('value_type', 'id_type')->toArray();
        return view('backend.cronjobs.edit')->with([
            'title' => 'Chỉnh sửa cronjob',
            'description' => 'Cập nhật tất cả thông tin của cronjob.',
            'disabled'=>false,
            'getfroms' => $getfroms,
            'item' => $item,
            ]);
    }

    public function update(Request $request, Cronjob $cronjob){

        $this->validate($request, [
                'title' => 'required',
                'url_topic' => 'required',
                'tag_list' => 'required',
                'tag_link' => 'required',
                'tag_title' => 'required',
                'tag_photo' => 'required',
                'tag_content' => 'required',
            ], [
                'title.required' => trans('admin.required'),
                'url_topic.required' => trans('admin.required'),
                'tag_list.required' => trans('admin.required'),
                'tag_link.required' => trans('admin.required'),
                'tag_title.required' => trans('admin.required'),
                'tag_photo.required' => trans('admin.required'),
                'tag_content.required' => trans('admin.required'),
            ]
        );

        $item = Cronjob::where([['id', $request->id]])->firstOrFail();
        
        $item->cate_id = $request->cate_id;
        $item->title = $request->title;
        $item->url_topic = $request->url_topic;
        $item->url_page = $request->url_page;
        $item->count_page = $request->count_page;
        $item->tag_list = $request->tag_list;
        $item->tag_link = $request->tag_link;
        $item->tag_title = $request->tag_title;
        $item->tag_desc = $request->tag_desc;
        $item->where_desc = $request->where_desc;
        $item->tag_content = $request->tag_content;
        $item->tag_photo = $request->tag_photo;
        $item->where_photo = $request->where_photo;
        $item->tag_remove = $request->tag_remove;
        $item->no = $request->no;
        $item->updated_by = Auth::user()->id;
        $item->save();

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Cronjob <br/><b>'.$item->title.'</b> đã được cập nhật';

        return redirect()->route('backend.cronjob')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }

    public function destroy(Request $request){
        $router = $request->route()->getName();
        if($router == 'backend.cronjob.delete'){ // Xóa 1 phần tử
            $item = Cronjob::where([['id', $request->id]])->firstOrFail();
            $item->delete();
            $flash_type = 'success animate3 fadeInUp';
            $flash_messager = 'Đã xóa cronjob <br/><b>'.$item->title.'</b>';
        } elseif($router == 'backend.cronjob.deletes'){ // Xóa nhiều phần tử
            $listid = $request->listid;
            if($listid){
                $listids = explode("-", $listid);
                $titles = '';
                foreach ($listids as $key => $id) {
                    $item = Cronjob::where([['id', $id]])->first();
                    if($item){
                        $titles .= '<b>- '.$item->title.'</b><br/>';
                        $item->delete();
                    }
                }
                if($titles){
                    $flash_type = 'success animate3 fadeInUp';
                    $flash_messager = 'Đã xóa cronjob<br/>'.rtrim($titles, ', ');
                } else {
                    $flash_type = 'info animate3 fadeInUp';
                    $flash_messager = 'Không xóa được cronjob.';
                }
            } else {
                $flash_type = 'info animate3 fadeInUp';
                $flash_messager = 'Không nhận được dữ liệu.';
            }

        } else { // Không tìm thấy phần tử
            $flash_type = 'error animate3 swing';
            $flash_messager = 'Đường dẫn không tồn tại.';
        }
        return redirect()->route('backend.cronjob')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
}
