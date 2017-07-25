<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Auth, View, Image, App\Page, App\Option;

class PageController extends AdminController
{
    public function __construct(Request $request){
        parent::__construct($request);
        $templates = Option::where([['type', 'template'], ['active', 1]])->orderby('id_type', 'ASC')->pluck('value_type', 'id_type')->toArray();
        view::share([
            'templates'=>$templates,
        ]);
    }

    public function index(Request $request){
    	$limits = Option::where([['type', 'limit'], ['active', '1']])->orderby('id_type', 'ASC')->pluck('value_type', 'id_type')->toArray();

        $template = $request->cate ? $request->cate : '';
        $limit = $request->limit ? $request->limit : 20;
        $keyword = $request->keyword ? $request->keyword : '';

        $flash_type = $flash_messager = '';

        if($template && $keyword)
            $items = Page::where([['title', 'LIKE', '%'.$keyword.'%'], ['template', $template]])->orderBy('no', 'ASC')->orderBy('id','DESC')->paginate($limit);
        else if($template && $keyword == '')
            $items = Page::where([['template', $template]])->orderBy('no', 'ASC')->orderBy('id','DESC')->paginate($limit);
        else if($template == '' && $keyword)
        	$items = Page::where([['title', 'LIKE', '%'.$keyword.'%']])->orderBy('no', 'ASC')->orderBy('id','DESC')->paginate($limit);
        else
        	$items = Page::orderBy('no', 'ASC')->orderBy('id','DESC')->paginate($limit);

        if($keyword)
            $items->appends(['keyword' => $keyword]);
        if($request->limit)
            $items->appends(['limit' => $limit]);

        if($keyword || ($limit && $limit != 20)){
            $flash_type = 'info animate3 fadeInUp';
            $flash_messager = 'Danh sách trang đã được lọc.';
        }
        return view('backend.pages.list')->with([
            'action' => 'list',
            'title' => 'Danh sách trang',
            'description' => 'Xem, thêm, sửa hoặc xóa trang tĩnh.',
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
                $item = Page::findOrFail($positions['id'][$i]);
                if($item->id && $item->no != $positions['no'][$i]){
                    $mess .= '<b>'.$item->name.'</b>, ';
                    Page::where("id", $item->id)->update(['no' => $positions['no'][$i], 'updated_by' => Auth::user()->id]);
                }
            }
            if($mess){
                $flash_messager = 'trang ['.substr($mess, 0, -2).'].<br/>Đã được cập nhật lại STT.';
                $flash_type = 'success animate3 fadeInUp';
            } else {
                $flash_messager = 'Không có trang nào được cập nhật.';
                $flash_type = 'info animate3 fadeInUp';
            }
        } else {
            $flash_messager = 'Không tìm thấy trang.';
            $flash_type = 'warning animate3 swing';         
        }
        return redirect()->route('backend.page')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function activeStatus($id){
        $item = Page::findOrFail($id);
        if($id!=89){
            if($item->active==0)
                $item->active = 1;
            else
                $item->active = 0;
            $status = Option::select('value_type')->where([['type', 'active'], ['id_type', $item->active]])->first();
            $flash_messager = '[<b>trang tĩnh: '.$item->title.'</b>] được cập nhật trạng thái thành <b>'.strip_tags($status->value_type).'</b>';
            $flash_type = 'success animate3 fadeInUp';
            $item->save();
        } else {
            $flash_messager = 'Không tìm thấy thông tin trang tĩnh';
            $flash_type = 'info animate3 fadeInUp';
        }
        return redirect()->route('backend.page')->with(['flash_messager'=>$flash_messager, 'flash_type'=>$flash_type]);
    }
    public function view($id){
    	$item = Page::where([['id', $id]])->firstOrFail();
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.pages.edit')->with([
            'title' => 'Chi tiết trang tĩnh',
            'description' => 'Xem tất cả thông tin của trang tĩnh.',
    		'disabled'=>true,
            'actives'=>$actives,
            'item'=>$item,
    		]);
    }
    public function create(){
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.pages.create')->with([
            'title' => 'Thêm mới trang',
            'description' => 'Thêm mới dữ liệu cho một trang tĩnh.',
            'actives' => $actives,
    		]);
    }
    public function store(Request $request){
    	$item = new Page;
        $this->validate($request, [
                'title' => 'required',
                'slug' => 'required|unique:mysql_data.pages,slug',
            ], [
                'title.required' => trans('admin.required'),
                'slig.required' => trans('admin.required'),
                'slug.unique' => trans('admin.slug_unique'),
            ]
        );
        if($request->photo){
            $file = $request->photo;
            $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getClientOriginalName());
            $ext = $file->getClientOriginalExtension();
            $pathImage = 'pages/';
            $image = Image::make($file);
            $newFilename = str_slug($request->title).date('-YdmHis', time()).'.'.$ext;

            $uploadSuccess = $file->move('uploads/'.$pathImage, $newFilename);
            if(!$uploadSuccess){
                $flash_type = 'error animate3 swing';
                $flash_messager = 'Không thể upload hình ảnh.';

                return back()->withInput()->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
            } else
                $item->photo = $pathImage.$newFilename;
        }
        $item->type = 'page';
        $item->template = $request->template;
        $item->title = $request->title;
        $item->slug = str_slug($request->slug);
        $item->content = $request->content;
        $item->seo_title = $request->seo_title;
        $item->seo_keyword = $request->seo_keyword;
        $item->seo_description = $request->seo_description;
        $item->no = $request->no;
        $item->created_by = Auth::user()->id;
        $item->updated_by = Auth::user()->id;
        $item->active = $request->active;
        $item->save();

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Đã thêm mới trang tĩnh [<b>'.$item->title.'</b>]';

        return redirect()->route('backend.page')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function edit($id){
    	$item = Page::where([['id', $id]])->firstOrFail();
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.pages.edit')->with([
            'title' => 'Cập nhật trang tĩnh',
            'description' => 'Chỉnh sửa tất cả thông tin của trang tĩnh.',
    		'actives'=>$actives,
    		'item'=>$item
    		]);
    }
    public function update(Request $request){
        $id = $request->id;
        $item = Page::where([['id', $id]])->firstOrFail();
        $this->validate($request, [
                'title' => 'required',
                'slug' => 'required|unique:mysql_data.pages,slug,'.$id,
            ], [
                'title.required' => trans('admin.required'),
                'slig.required' => trans('admin.required'),
                'slug.unique' => trans('admin.slug_unique'),
            ]
        );

        if($request->photo){
            $file = $request->photo;
            $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getClientOriginalName());
            $ext = $file->getClientOriginalExtension();
            $pathImage = 'pages/';
            $image = Image::make($file);
            $newFilename = str_slug($request->title).date('-YdmHis', time()).'.'.$ext;

            $uploadSuccess = $file->move('uploads/'.$pathImage, $newFilename);
            if(!$uploadSuccess){
                $flash_type = 'error animate3 swing';
                $flash_messager = 'Không thể upload hình ảnh.';

                return back()->withInput()->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
            } else{
                Image::delete('uploads/'.$item->photo);
                $item->photo = $pathImage.$newFilename;
            }
        }

        $item->template = $request->template;
        $item->title = $request->title;
        $item->slug = ($request->slug)?$request->slug:$this->checkSlug($request->title, 'pages', $id);
        $item->content = $request->content;
        $item->seo_title = $request->seo_title;
        $item->seo_keyword = $request->seo_keyword;
        $item->seo_description = $request->seo_description;
        $item->no = $request->no;
        $item->updated_by = Auth::user()->id;
        $item->active = $request->active;
        $item->save();

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Trang tĩnh [<b>'.$item->title.'</b>]<br/>đã được cập nhật dữ liệu.';

        return redirect()->route('backend.page')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function destroy(Request $request){
    	$router = $request->route()->getName();
    	if($router == 'backend.page.delete'){ // Xóa 1 phần tử
    		$item = Page::where([['id', $request->id]])->firstOrFail();
    		$item->delete();
    		$flash_type = 'success animate3 fadeInUp';
    		$flash_messager = 'Trang [<b>'.$item->title.'</b>]<br/>đã bị xóa.';
    	} elseif($router == 'backend.page.deletes'){ // Xóa nhiều phần tử
    		$listid = $request->listid;
    		if($listid){
    			$listids = explode("-", $listid);
				$names = '';
				foreach ($listids as $key => $id) {
					$item = Page::where([['id', $id]])->first();
					if($item){
						$names .= '[<strong>'.$item->title.'</strong>], ';
						$item->delete();
					}
				}
				if($names){
		    		$flash_type = 'success animate3 fadeInUp';
		    		$flash_messager = 'Trang '.rtrim($names, ', ').'<br/>đã bị xóa.';
		    	} else {
		    		$flash_type = 'info animate3 fadeInUp';
		    		$flash_messager = 'Không xóa được trang.';
		    	}
    		} else {
	    		$flash_type = 'info animate3 fadeInUp';
	    		$flash_messager = 'Không nhận được dữ liệu.';
    		}

    	} else { // Không tìm thấy phần tử
    		$flash_type = 'error animate3 swing';
    		$flash_messager = 'Đường dẫn không tồn tại.';
    	}
    	return redirect()->route('backend.page')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
}
