<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Auth, View, Image, App\Page, App\CatePost, App\Option;

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
    	$cates = Page::where([['type', $this->prefix]])->orderBy('no', 'ASC')->orderBy('id','DESC')->get();
        recursive($cates, $items);
        return view('backend.categorys.list')->with([
            'title' => 'Danh sách danh mục',
            'description' => 'Xem, thêm, sửa hoặc xóa danh mục.',
            'items' => $items,
            ]);
    }
    public function updatePosition(Request $request){
        $positions = $request->no;
        if(count($positions['id'])){
            $titles = '';
            for ($i=0; $i < count($positions['id']); $i++) {
                $item = Page::findOrFail($positions['id'][$i]);
                if($item->id && $item->no != $positions['no'][$i]){
                    $titles .= '<b>'.$item->title.'</b>, ';
                    Page::where("id", $item->id)->update(['no' => $positions['no'][$i], 'updated_by' => Auth::user()->id]);
                }
            }
            if($titles){
                $flash_messager = 'Danh mục ['.rtrim($titles, ', ').'].<br/>Đã được cập nhật lại STT.';
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
        $parents = Page::select('title', 'id_parent', 'id')->where([['id', '<>', $id], ['type', $this->prefix], ['active', 1]])->orderby('no', 'ASC')->orderby('id', 'DESC')->get();
        recursive($parents, $categorys);
    	$item = Page::where([['id', $id]])->firstOrFail();
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.categorys.edit')->with([
            'title' => 'Chi tiết danh mục',
            'description' => 'Xem tất cả thông tin của danh mục.',
    		'disabled'=>true,
            'actives'=>$actives,
            'categorys'=>$categorys,
            'item'=>$item,
    		]);
    }
    public function create(){
        $parents = Page::select('title', 'id_parent', 'id')->where([['type', $this->prefix], ['active', 1]])->orderby('no', 'ASC')->orderby('id', 'DESC')->get();
        recursive($parents, $categorys);
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.categorys.create')->with([
            'title' => 'Thêm mới danh mục',
            'description' => 'Thêm mới dữ liệu cho một danh mục.',
            'categorys' => $categorys,
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
            $pathImage = 'posts/categorys/';
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
        $item->id_parent = $request->id_parent;
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
        $parents = Page::select('title', 'id_parent', 'id')->where([['id', '<>', $id], ['type', $this->prefix], ['active', 1]])->orderby('no', 'ASC')->orderby('id', 'DESC')->get();
        recursive($parents, $categorys);
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.categorys.edit')->with([
            'title' => 'Cập nhật danh mục',
            'description' => 'Chỉnh sửa tất cả thông tin của danh mục.',
    		'actives'=>$actives,
            'categorys'=>$categorys,
            'updateForm'=>true,
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
            $pathImage = 'posts/categorys/';
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

        $item->id_parent = $request->id_parent;
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
        $flash_messager = 'Danh mục <br/><b>'.$item->title.'</b><br/>đã được cập nhật dữ liệu.';

        return redirect()->route('backend.'.$this->prefix.'.category')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function destroy(Request $request){
    	$router = $request->route()->getName();
    	if($router == 'backend.'.$this->prefix.'.category.delete'){ // Xóa 1 phần tử
    		$item = Page::where([['id', $request->id]])->firstOrFail();
            Page::where("id_parent", $item->id)->update(["id_parent" => $item->id_parent]);
            CatePost::where('cate_id', $item->id)->delete();
    		Image::delete('uploads/'.$item->photo);
    		$item->delete();
    		$flash_type = 'success animate3 fadeInUp';
    		$flash_messager = 'Danh mục <br/>[<b>'.$item->title.'</b>]<br/>đã bị xóa.';
    	} elseif($router == 'backend.'.$this->prefix.'.category.deletes'){ // Xóa nhiều phần tử
    		$listid = $request->listid;
    		if($listid){
    			$listids = explode("-", $listid);
				$titles = '';
				foreach ($listids as $key => $id) {
					$item = Page::where([['id', $id]])->first();
					if($item){
						$titles .= '<b>- '.$item->title.'</b><br/>';
                        Page::where("id_parent", $item->id)->update(["id_parent" => $item->id_parent]);
                        CatePost::where('cate_id', $item->id)->delete();
						Image::delete('uploads/'.$item->photo);
						$item->delete();
					}
				}
				if($titles){
		    		$flash_type = 'success animate3 fadeInUp';
		    		$flash_messager = 'Đã xóa danh mục<br/>'.rtrim($names, ', ');
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
