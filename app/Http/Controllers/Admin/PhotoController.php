<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use App\Option, App\Page, Image, Auth;

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

    public function favicon(Request $request){
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	if(Auth::user()->ability('root,admin', 'u_photo')){
    		$updateForm = true;
    		$disabled = false;
    	} else {
    		$updateForm = false;
    		$disabled = true;
    	}
    	$item = Page::where('type', 'favicon')->first();
    	if(!isset($item->id)){
    		$item = new Page;
    		$item->title = 'Favicon';
	        $item->type = 'favicon';
	        $item->no = 10;
	        $item->created_by = Auth::user()->id;
	        $item->updated_by = Auth::user()->id;
	        $item->active = 1;
	        $item->save();
    	}
    	return view('backend.photos.favicon')->with([
            'title' => 'Favicon',
            'description' => 'Xem, cập nhật favicon của website.',
            'updateForm' => $updateForm,
            'disabled' => $disabled,
            'actives' => $actives,
            'item' => $item
    	]);
    }
    public function faviconUpdate(Request $request){
        $id = $request->id;
        $item = Page::where([['id', $id]])->firstOrFail();

        if($request->photo){
            $file = $request->photo;
            $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getClientOriginalName());
            $ext = $file->getClientOriginalExtension();
            $pathImage = 'photos/';
            $image = Image::make($file);
            $newFilename = 'favicon-'.date('YdmHis', time()).'.'.$ext;

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
        $item->updated_by = Auth::user()->id;
        $item->active = $request->active;
        $item->save();

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Favicon đã được cập nhật.';

        return redirect()->route('backend.favicon')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }

    public function logo(Request $request){
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	if(Auth::user()->ability('root,admin', 'u_photo')){
    		$updateForm = true;
    		$disabled = false;
    	} else {
    		$updateForm = false;
    		$disabled = true;
    	}
    	$item = Page::where('type', 'logo')->first();
    	if(!isset($item->id)){
    		$item = new Page;
    		$item->title = 'Logo';
	        $item->type = 'logo';
	        $item->no = 10;
	        $item->created_by = Auth::user()->id;
	        $item->updated_by = Auth::user()->id;
	        $item->active = 1;
	        $item->save();
    	}
    	return view('backend.photos.logo')->with([
            'title' => 'Logo',
            'description' => 'Xem, cập nhật logo của website.',
            'updateForm' => $updateForm,
            'disabled' => $disabled,
            'actives' => $actives,
            'item' => $item
    	]);
    }
    public function logoUpdate(Request $request){
        $id = $request->id;
        $item = Page::where([['id', $id]])->firstOrFail();

        if($request->photo){
            $file = $request->photo;
            $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getClientOriginalName());
            $ext = $file->getClientOriginalExtension();
            $pathImage = 'photos/';
            $image = Image::make($file);
            $newFilename = 'logo-'.date('YdmHis', time()).'.'.$ext;

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
        $item->updated_by = Auth::user()->id;
        $item->active = $request->active;
        $item->save();

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Logo đã được cập nhật.';

        return redirect()->route('backend.logo')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }

    public function banner(Request $request){
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	if(Auth::user()->ability('root,admin', 'u_photo')){
    		$updateForm = true;
    		$disabled = false;
    	} else {
    		$updateForm = false;
    		$disabled = true;
    	}
    	$item = Page::where('type', 'banner')->first();
    	if(!isset($item->id)){
    		$item = new Page;
    		$item->title = 'Banner';
	        $item->type = 'banner';
	        $item->no = 10;
	        $item->created_by = Auth::user()->id;
	        $item->updated_by = Auth::user()->id;
	        $item->active = 1;
	        $item->save();
    	}
    	return view('backend.photos.banner')->with([
            'title' => 'Banner',
            'description' => 'Xem, cập nhật banner của website.',
            'updateForm' => $updateForm,
            'disabled' => $disabled,
            'actives' => $actives,
            'item' => $item
    	]);
    }
    public function bannerUpdate(Request $request){
        $id = $request->id;
        $item = Page::where([['id', $id]])->firstOrFail();

        if($request->photo){
            $file = $request->photo;
            $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getClientOriginalName());
            $ext = $file->getClientOriginalExtension();
            $pathImage = 'photos/';
            $image = Image::make($file);
            $newFilename = 'banner-'.date('YdmHis', time()).'.'.$ext;

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
        $item->updated_by = Auth::user()->id;
        $item->active = $request->active;
        $item->save();

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Banner đã được cập nhật.';

        return redirect()->route('backend.banner')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }

    public function sliderIndex(Request $request){
    	$limits = Option::where([['type', 'limit'], ['active', '1']])->orderby('id_type', 'ASC')->pluck('value_type', 'id_type')->toArray();

        $template = $request->cate ? $request->cate : '';
        $limit = $request->limit ? $request->limit : 10;
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

        if($keyword || ($limit && $limit != 10)){
            $flash_type = 'info animate3 fadeInUp';
            $flash_messager = 'Danh sách slider đã được lọc.';
        }
        return view('backend.photos.sliderlist')->with([
            'action' => 'list',
            'title' => 'Danh sách slider',
            'description' => 'Xem, thêm, sửa hoặc xóa slider.',
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
                    $titles .= '<b>'.$item->title.'</b><br/>';
                    Page::where("id", $item->id)->update(['no' => $positions['no'][$i], 'updated_by' => Auth::user()->id]);
                }
            }
            if($titles){
                $flash_messager = 'Slider <br/>'.rtrim($titles, ' ').'Đã được cập nhật lại STT.';
                $flash_type = 'success animate3 fadeInUp';
            } else {
                $flash_messager = 'Không có slider nào được cập nhật.';
                $flash_type = 'info animate3 fadeInUp';
            }
        } else {
            $flash_messager = 'Không tìm thấy dữ liệu.';
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
        $flash_messager = 'Slider [<b>'.$item->title.'</b>] được cập nhật trạng thái thành <b>'.strip_tags($status->value_type).'</b>';
        $flash_type = 'success animate3 fadeInUp';
        $item->save();
        return redirect()->route('backend.slider')->with(['flash_messager'=>$flash_messager, 'flash_type'=>$flash_type]);
    }
    public function sliderView($id){
    	$item = Page::where([['id', $id]])->firstOrFail();
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.photos.slideredit')->with([
            'title' => 'Chi tiết slider',
            'description' => 'Xem tất cả thông tin của slider.',
    		'disabled'=>true,
            'actives'=>$actives,
            'item'=>$item,
    		]);
    }
    public function sliderCreate(){
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.photos.slidercreate')->with([
            'title' => 'Thêm mới slider',
            'description' => 'Thêm mới dữ liệu cho slider.',
            'actives' => $actives,
    		]);
    }
    public function sliderStore(Request $request){
    	
        $this->validate($request, [
                'photo' => 'required',
                'title' => 'required',
            ], [
                'photo.required' => trans('admin.required'),
                'title.required' => trans('admin.required'),
            ]
        );
        if($request->photo){
            $file = $request->photo;
            $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getClientOriginalName());
            $ext = $file->getClientOriginalExtension();
            $pathImage = 'photos/';
            $image = Image::make($file);
            $newFilename = str_slug($request->title).date('-YdmHis', time()).'.'.$ext;

            $uploadSuccess = $file->move('uploads/'.$pathImage, $newFilename);
            if($uploadSuccess){
            	$item = new Page;
                $item->photo = $pathImage.$newFilename;
		        $item->type = $this->prefix;
		        $item->title = $request->title;
		        $item->slug = $request->slug;
		        $item->no = $request->no;
		        $item->created_by = Auth::user()->id;
		        $item->updated_by = Auth::user()->id;
		        $item->active = $request->active;
		        $item->save();

		        $flash_type = 'success animate3 fadeInUp';
		        $flash_messager = 'Đã thêm mới slider [<b>'.$item->title.'</b>]';
            }
        }

        return redirect()->route('backend.slider')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function sliderEdit($id){
    	$item = Page::where([['id', $id]])->firstOrFail();
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.photos.slideredit')->with([
            'title' => 'Cập nhật slider',
            'description' => 'Chỉnh sửa tất cả thông tin của slider.',
    		'actives'=>$actives,
    		'item'=>$item
    		]);
    }
    public function sliderUpdate(Request $request){
        $id = $request->id;
        $item = Page::where([['id', $id]])->firstOrFail();
        $this->validate($request, [
                'title' => 'required'
            ], [
                'title.required' => trans('admin.required')
            ]
        );

        if($request->photo){
            $file = $request->photo;
            $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getClientOriginalName());
            $ext = $file->getClientOriginalExtension();
            $pathImage = 'photos/'.$this->prefix.'s/';
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
        $item->no = $request->no;
        $item->updated_by = Auth::user()->id;
        $item->active = $request->active;
        $item->save();

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Slider [<b>'.$item->title.'</b>]<br/>đã được cập nhật dữ liệu.';

        return redirect()->route('backend.slider')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function sliderDestroy(Request $request){
    	$router = $request->route()->getName();
    	if($router == 'backend.slider.delete'){ // Xóa 1 phần tử
    		$item = Page::where([['id', $request->id]])->firstOrFail();
            Image::delete('uploads/'.$item->photo);
    		$item->delete();
    		$flash_type = 'success animate3 fadeInUp';
    		$flash_messager = 'Slider [<b>'.$item->title.'</b>]<br/>đã bị xóa.';
    	} elseif($router == 'backend.slider.deletes'){ // Xóa nhiều phần tử
    		$listid = $request->listid;
    		if($listid){
    			$listids = explode("-", $listid);
				$titles = '';
				foreach ($listids as $key => $id) {
					$item = Page::where([['id', $id]])->first();
					if($item){
						$titles .= '<b>'.$item->title.'</b><br/>';
                        Image::delete('uploads/'.$item->photo);
						$item->delete();
					}
				}
				if($titles){
		    		$flash_type = 'success animate3 fadeInUp';
		    		$flash_messager = 'Slider<br/>'.rtrim($titles, ', ').'đã bị xóa.';
		    	} else {
		    		$flash_type = 'info animate3 fadeInUp';
		    		$flash_messager = 'Không xóa được slider.';
		    	}
    		} else {
	    		$flash_type = 'info animate3 fadeInUp';
	    		$flash_messager = 'Không nhận được dữ liệu.';
    		}

    	} else { // Không tìm thấy phần tử
    		$flash_type = 'error animate3 swing';
    		$flash_messager = 'Đường dẫn không tồn tại.';
    	}
    	return redirect()->route('backend.slider')->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
}
