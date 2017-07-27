<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Auth, View, Image, App\Page, App\Option;

class CategoryController extends AdminController
{
    public function __construct(Request $request){
        parent::__construct($request);
        $prefix_title = 'Bài viết';
        $this->action = 'category';
        view::share([
            'prefix_title'=>$prefix_title,
            'action'=>$this->action,
        ]);
    }

    public function index(Request $request){
    	$items = Page::where([['type', $this->prefix]])->orderBy('no', 'ASC')->orderBy('id','DESC')->get();

        return view('backend.categorys.list')->with([
            'title' => 'Danh sách danh mục',
            'description' => 'Xem, thêm, sửa hoặc xóa danh mục.',
            'items' => $items,
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
                $flash_messager = 'Danh mục ['.substr($mess, 0, -2).'].<br/>Đã được cập nhật lại STT.';
                $flash_type = 'success animate3 fadeInUp';
            } else {
                $flash_messager = 'Không có danh mục nào được cập nhật.';
                $flash_type = 'info animate3 fadeInUp';
            }
        } else {
            $flash_messager = 'Không tìm thấy danh mục.';
            $flash_type = 'warning animate3 swing';         
        }
        return redirect()->route('backend.'.$this->prefix.'.category')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function activeStatus($id){
        $item = Page::findOrFail($id);
        if($id!=89){
            if($item->active==0)
                $item->active = 1;
            else
                $item->active = 0;
            $status = Option::select('value_type')->where([['type', 'active'], ['id_type', $item->active]])->first();
            $flash_messager = 'Danh mục [<b>'.$item->title.'</b>] được cập nhật trạng thái thành <b>'.strip_tags($status->value_type).'</b>';
            $flash_type = 'success animate3 fadeInUp';
            $item->save();
        } else {
            $flash_messager = 'Không tìm thấy thông tin danh mục';
            $flash_type = 'info animate3 fadeInUp';
        }
        return redirect()->route('backend.'.$this->prefix.'.category')->with(['flash_messager'=>$flash_messager, 'flash_type'=>$flash_type]);
    }
    public function view($id){
    	$item = Page::where([['id', $id]])->firstOrFail();
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.categorys.edit')->with([
            'title' => 'Chi tiết danh mục',
            'description' => 'Xem tất cả thông tin của danh mục.',
    		'disabled'=>true,
            'actives'=>$actives,
            'item'=>$item,
    		]);
    }
    public function create(){
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.categorys.create')->with([
            'title' => 'Thêm mới danh mục',
            'description' => 'Thêm mới dữ liệu cho một danh mục.',
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
                'slug.required' => trans('admin.required'),
                'slug.unique' => trans('admin.slug_unique'),
            ]
        );
        if($request->photo){
            $file = $request->photo;
            $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getClientOriginalName());
            $ext = $file->getClientOriginalExtension();
            $pathImage = $this->prefix.'/categorys/';
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
        $item->type = $this->prefix;
        $item->template = $request->template;
        $item->title = $request->title;
        $item->slug = $request->slug;
        $item->content = $request->content;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->no = $request->no;
        $item->created_by = Auth::user()->id;
        $item->updated_by = Auth::user()->id;
        $item->active = $request->active;
        $item->save();

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Đã thêm mới danh mục<br/>[<b>'.$item->title.'</b>]';

        return redirect()->route('backend.'.$this->prefix.'.category')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function edit($id){
    	$item = Page::where([['id', $id]])->firstOrFail();
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.pages.edit')->with([
            'title' => 'Cập nhật danh mục',
            'description' => 'Chỉnh sửa tất cả thông tin của danh mục.',
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
                'slug.required' => trans('admin.required'),
                'slug.unique' => trans('admin.slug_unique'),
            ]
        );

        if($request->photo){
            $file = $request->photo;
            $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getClientOriginalName());
            $ext = $file->getClientOriginalExtension();
            $pathImage = $this->prefix.'/categorys/';
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

        $item->title = $request->title;
        $item->slug = $request->slug;
        $item->content = $request->content;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->no = $request->no;
        $item->updated_by = Auth::user()->id;
        $item->active = $request->active;
        $item->save();

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Danh mục [<b>'.$item->title.'</b>]<br/>đã được cập nhật dữ liệu.';

        return redirect()->route('backend.'.$this->prefix.'.category')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function destroy(Request $request){
    	$router = $request->route()->getName();
    	if($router == 'backend.'.$this->prefix.'.delete'){ // Xóa 1 phần tử
    		$item = Page::where([['id', $request->id]])->firstOrFail();
    		Image::delete('uploads/'.$item->photo);
    		$item->delete();
    		$flash_type = 'success animate3 fadeInUp';
    		$flash_messager = 'Danh mục [<b>'.$item->title.'</b>]<br/>đã bị xóa.';
    	} elseif($router == 'backend.'.$this->prefix.'.deletes'){ // Xóa nhiều phần tử
    		$listid = $request->listid;
    		if($listid){
    			$listids = explode("-", $listid);
				$names = '';
				foreach ($listids as $key => $id) {
					$item = Page::where([['id', $id]])->first();
					if($item){
						$names .= '[<strong>'.$item->title.'</strong>], ';
						Image::delete('uploads/'.$item->photo);
						$item->delete();
					}
				}
				if($names){
		    		$flash_type = 'success animate3 fadeInUp';
		    		$flash_messager = 'Danh mục '.rtrim($names, ', ').'<br/>đã bị xóa.';
		    	} else {
		    		$flash_type = 'info animate3 fadeInUp';
		    		$flash_messager = 'Không xóa được danh mục.';
		    	}
    		} else {
	    		$flash_type = 'info animate3 fadeInUp';
	    		$flash_messager = 'Không nhận được dữ liệu.';
    		}

    	} else { // Không tìm thấy phần tử
    		$flash_type = 'error animate3 swing';
    		$flash_messager = 'Đường dẫn không tồn tại.';
    	}
    	return redirect()->route('backend.'.$this->prefix.'.category')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
}
