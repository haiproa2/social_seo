<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

class PhotoController extends AdminController
{
    public function __construct(Request $request){
        parent::__construct($request);
    }

    public function index(Request $request){
    	return view('backend.photos.index')->with([
            'title' => 'Danh sách hình ảnh',
            'description' => 'Xem, thêm, sửa hoặc xóa hình ảnh.',
    	]);
    }

    public function sliderIndex(Request $request){
    	$limits = Option::where([['type', 'limit'], ['active', '1']])->orderby('id_type', 'ASC')->pluck('value_type', 'id_type')->toArray();

        $template = $request->cate ? $request->cate : '';
        $limit = $request->limit ? $request->limit : 20;
        $keyword = $request->keyword ? $request->keyword : '';

        $flash_type = $flash_messager = '';

        if($template && $keyword)
            $items = Page::where([['title', 'LIKE', '%'.$keyword.'%'], ['template', $template], ['type', $this->prefix]])->orderBy('no', 'ASC')->orderBy('id','DESC')->paginate($limit);
        else if($template && $keyword == '')
            $items = Page::where([['template', $template], ['type', $this->prefix]])->orderBy('no', 'ASC')->orderBy('id','DESC')->paginate($limit);
        else if($template == '' && $keyword)
        	$items = Page::where([['title', 'LIKE', '%'.$keyword.'%'], ['type', $this->prefix]])->orderBy('no', 'ASC')->orderBy('id','DESC')->paginate($limit);
        else
        	$items = Page::where([['type', $this->prefix]])->orderBy('no', 'ASC')->orderBy('id','DESC')->paginate($limit);

        if($keyword)
            $items->appends(['keyword' => $keyword]);
        if($request->limit)
            $items->appends(['limit' => $limit]);

        if($keyword || ($limit && $limit != 20)){
            $flash_type = 'info animate3 fadeInUp';
            $flash_messager = 'Danh sách ảnh slider đã được lọc.';
        }
        return view('backend.photos.sliderlist')->with([
            'action' => 'list',
            'title' => 'Danh sách ảnh slider',
            'description' => 'Xem, thêm, sửa hoặc xóa ảnh slider.',
            'items' => $items,
            'limits' => $limits,
            'flash_type' => $flash_type,
            'flash_messager' => $flash_messager
            ]);
    }
    public function sliderUpdatePosition(Request $request){
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
                $flash_messager = 'Slider ['.rtrim($titles, ', ').'].<br/>Đã được cập nhật lại STT.';
                $flash_type = 'success animate3 fadeInUp';
            } else {
                $flash_messager = 'Không có ảnh nào được cập nhật.';
                $flash_type = 'info animate3 fadeInUp';
            }
        } else {
            $flash_messager = 'Không tìm thấy ảnh.';
            $flash_type = 'warning animate3 swing';         
        }
        return redirect()->route('backend.slider')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function sliderActiveStatus($id){
        $item = Page::findOrFail($id);
        if($item->active==0)
            $item->active = 1;
        else
            $item->active = 0;
        $status = Option::select('value_type')->where([['type', 'active'], ['id_type', $item->active]])->first();
        $flash_messager = 'Hình ảnh [<b>'.$item->title.'</b>] được cập nhật trạng thái thành <b>'.strip_tags($status->value_type).'</b>';
        $flash_type = 'success animate3 fadeInUp';
        $item->save();
        return redirect()->route('backend.slider')->with(['flash_messager'=>$flash_messager, 'flash_type'=>$flash_type]);
    }
    public function sliderView($id){
    	$item = Page::where([['id', $id]])->firstOrFail();
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.photos.slideredit')->with([
            'title' => 'Chi tiết ảnh',
            'description' => 'Xem tất cả thông tin của ảnh.',
    		'disabled'=>true,
            'actives'=>$actives,
            'item'=>$item,
    		]);
    }
    public function sliderCreate(){
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.photos.slidercreate')->with([
            'title' => 'Thêm mới ảnh',
            'description' => 'Thêm mới dữ liệu cho ảnh slider.',
            'actives' => $actives,
    		]);
    }
    public function sliderStore(Request $request){
    	
        $this->validate($request, [
                'title' => 'required',
            ], [
                'title.required' => trans('admin.required'),
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
            if($uploadSuccess){
            	$item = new Page;
                $item->photo = $pathImage.$newFilename;
		        $item->type = $this->prefix;
		        $item->template = 2;
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
		        $flash_messager = 'Đã thêm mới trang tĩnh [<b>'.$item->title.'</b>]';
            }
        }

        return redirect()->route('backend.page')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function sliderEdit($id){
    	$item = Page::where([['id', $id]])->firstOrFail();
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.pages.edit')->with([
            'title' => 'Cập nhật trang',
            'description' => 'Chỉnh sửa tất cả thông tin của trang tĩnh.',
    		'actives'=>$actives,
    		'item'=>$item
    		]);
    }
    public function sliderUpdate(Request $request){
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
        $flash_messager = 'Trang tĩnh [<b>'.$item->title.'</b>]<br/>đã được cập nhật dữ liệu.';

        return redirect()->route('backend.page')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function sliderDestroy(Request $request){
    	$router = $request->route()->getName();
    	if($router == 'backend.page.delete'){ // Xóa 1 phần tử
    		$item = Page::where([['id', $request->id]])->firstOrFail();
            Image::delete('uploads/'.$item->photo);
    		$item->delete();
    		$flash_type = 'success animate3 fadeInUp';
    		$flash_messager = 'Trang [<b>'.$item->title.'</b>]<br/>đã bị xóa.';
    	} elseif($router == 'backend.page.deletes'){ // Xóa nhiều phần tử
    		$listid = $request->listid;
    		if($listid){
    			$listids = explode("-", $listid);
				$titles = '';
				foreach ($listids as $key => $id) {
					$item = Page::where([['id', $id]])->first();
					if($item){
						$titles .= '[<b>'.$item->title.'</b>], ';
                        Image::delete('uploads/'.$item->photo);
						$item->delete();
					}
				}
				if($titles){
		    		$flash_type = 'success animate3 fadeInUp';
		    		$flash_messager = 'Trang '.rtrim($titles, ', ').'<br/>đã bị xóa.';
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
