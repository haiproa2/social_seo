<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;

use Auth, View, Image, App\Page, App\Post, App\CatePost, App\Option;

class PostController extends AdminController
{
    public function __construct(Request $request){
        parent::__construct($request);
        $cates = Page::select('id', 'id_parent', 'title')->where([['type', $this->prefix], ['active', 1]])->orderby('no', 'ASC')->orderby('id', 'DESC')->get();
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

        // Chưa lấy theo id member login
        if($cate && $keyword){ // Theo danh mục, danh mục con và có từ khóa tìm kiếm
            $items = Post::select('posts.*')->join('cate_post', 'posts.id', '=', 'cate_post.post_id')->where([['title', 'LIKE', '%'.$keyword.'%'], ['type', $this->prefix]])->whereIN('cate_id', $idCates)->orderBy('no', 'ASC')->orderBy('id','DESC')->paginate($limit);
        } else if($cate && $keyword == ''){ // Theo danh mục nhưng không có từ khóa
            $items = Post::select('posts.*')->join('cate_post', 'posts.id', '=', 'cate_post.post_id')->where([['type', $this->prefix]])->whereIN('cate_id', $idCates)->orderBy('no', 'ASC')->orderBy('id','DESC')->paginate($limit);
        } else if($cate == '' && $keyword){ // Không có danh mục nhưng có từ khóa
        	$items = Post::where([['title', 'LIKE', '%'.$keyword.'%'], ['type', $this->prefix]])->orderBy('no', 'ASC')->orderBy('id','DESC')->paginate($limit);
        } else{ // Lấy tất cả bài viết
        	$items = Post::where([['type', $this->prefix]])->orderBy('no', 'ASC')->orderBy('id','DESC')->paginate($limit);
        }

        if($cate)
            $items->appends(['cate' => $cate]);
        if($keyword)
            $items->appends(['keyword' => $keyword]);
        if($request->limit)
            $items->appends(['limit' => $limit]);

        if($cate || $keyword || ($limit && $limit != 20)){
            $flash_type = 'info animate3 fadeInUp';
            $flash_messager = 'Danh sách bài viết đã được lọc.';
        }
        return view('backend.posts.list')->with([
            'title' => 'Danh sách bài viết',
            'description' => 'Xem, thêm, sửa hoặc xóa bài viết.',
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
                $item = Post::findOrFail($positions['id'][$i]);
                if($item->id && $item->no != $positions['no'][$i]){
                    $titles .= '<b>- '.$item->title.'</b><br/>';
                    Post::where("id", $item->id)->update(['no' => $positions['no'][$i], 'updated_by' => Auth::user()->id]);
                }
            }
            if($titles){
                $flash_messager = 'Đã cập nhật lại STT cho bài viết<br/><b>'.rtrim($titles).'</b>';
                $flash_type = 'success animate3 fadeInUp';
            } else {
                $flash_messager = 'Không có bài viết nào được cập nhật.';
                $flash_type = 'info animate3 fadeInUp';
            }
        } else {
            $flash_messager = 'Không tìm thấy bài viết.';
            $flash_type = 'warning animate3 swing';         
        }
        return redirect()->route('backend.'.$this->prefix)->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function activeStatus($id){
        $item = Post::findOrFail($id);
        if($id!=89){
            if($item->active==0)
                $item->active = 1;
            else
                $item->active = 0;
            $status = Option::select('value_type')->where([['type', 'active'], ['id_type', $item->active]])->first();
            $flash_messager = 'Cập nhật trạng thái thành <b>'.strip_tags($status->value_type).'</b> cho bài viết<br/><b>'.$item->title.'</b>';
            $flash_type = 'success animate3 fadeInUp';
            $item->save();
        } else {
            $flash_messager = 'Không tìm thấy thông tin bài viết';
            $flash_type = 'info animate3 fadeInUp';
        }
        return redirect()->route('backend.'.$this->prefix)->with(['flash_messager'=>$flash_messager, 'flash_type'=>$flash_type]);
    }
    public function view($id){
    	$item = Post::where([['id', $id]])->firstOrFail();
    	$cates = Page::where([['type', $this->prefix]])->orderBy('no', 'ASC')->orderBy('id','DESC')->get();
        recursive($cates, $categorys);
        $checked = CatePost::where('post_id', $id)->get();
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.posts.edit')->with([
            'title' => 'Chi tiết bài viết',
            'description' => 'Xem tất cả thông tin của bài viết.',
    		'disabled'=>true,
            'categorys'=>$categorys,
            'checked'=>$checked,
            'actives'=>$actives,
            'item'=>$item,
    		]);
    }
    public function create(){
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.posts.create')->with([
            'title' => 'Thêm mới bài viết',
            'description' => 'Thêm mới dữ liệu cho một bài viết.',
            'actives' => $actives,
    		]);
    }
    public function store(Request $request){
    	$item = new Post;
        $this->validate($request, [
                'title' => 'required',
                'slug' => 'required|unique:mysql_data.posts,slug',
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
            $pathImage = 'posts/';
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
        $item->title = $request->title;
        $item->slug = $request->slug;
        $item->content = $request->content;
        $item->seo_title = $request->seo_title;
        $item->seo_keywords = $request->seo_keywords;
        $item->seo_description = $request->seo_description;
        $item->view = rand(2010, 2020);
        $item->no = $request->no;
        $item->created_by = Auth::user()->id;
        $item->updated_by = Auth::user()->id;
        $item->active = $request->active;
        $item->save();

        if(isset($_POST['cate_id']) && count($_POST['cate_id'])){
			foreach ($_POST['cate_id'] as $key => $value) {
				$CatePost = new CatePost;
				$CatePost->cate_id = $value;
				$CatePost->post_id = $item->id;
				$CatePost->save();
			}
		} else {
			$CatePost = new CatePost;
			$CatePost->cate_id = 0;
			$CatePost->post_id = $item->id;
			$CatePost->save();
		}

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Đã thêm mới bài viết <br/><b>'.$item->title.'</b>';

        return redirect()->route('backend.'.$this->prefix)->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function edit($id){
    	$item = Post::where([['id', $id]])->firstOrFail();
    	$cates = Page::where([['type', $this->prefix]])->orderBy('no', 'ASC')->orderBy('id','DESC')->get();
        recursive($cates, $categorys);
        $checked = CatePost::where('post_id', $id)->get();
        $actives = Option::select('value_type', 'id_type')->where([['type', 'active'], ['active', 1]])->orderby('id_type', 'DESC')->get();
    	return view('backend.posts.edit')->with([
            'title' => 'Cập nhật bài viết',
            'description' => 'Chỉnh sửa tất cả thông tin của bài viết.',
            'categorys'=>$categorys,
    		'checked'=>$checked,
    		'actives'=>$actives,
    		'item'=>$item
    		]);
    }
    public function update(Request $request){
        $id = $request->id;
        $item = Post::where([['id', $id]])->firstOrFail();
        $this->validate($request, [
                'title' => 'required',
                'slug' => 'required|unique:mysql_data.posts,slug,'.$id,
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
            $pathImage = 'posts/';
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

        CatePost::where('post_id', $id)->delete();

        if(isset($_POST['cate_id']) && count($_POST['cate_id'])){
			foreach ($_POST['cate_id'] as $key => $value) {
				$CatePost = new CatePost;
				$CatePost->cate_id = $value;
				$CatePost->post_id = $item->id;
				$CatePost->save();
			}
		} else {
			$CatePost = new CatePost;
			$CatePost->cate_id = 0;
			$CatePost->post_id = $item->id;
			$CatePost->save();
		}

        $flash_type = 'success animate3 fadeInUp';
        $flash_messager = 'Đã cập nhật dữ liệu bài viết <br/><b>'.$item->title.'</b>';

        return redirect()->route('backend.'.$this->prefix)->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
    public function destroy(Request $request){
    	$router = $request->route()->getName();
    	if($router == 'backend.'.$this->prefix.'.delete'){ // Xóa 1 phần tử
    		$item = Post::where([['id', $request->id]])->firstOrFail();
            CatePost::where('post_id', $item->id)->delete();
    		Image::delete('uploads/'.$item->photo);
    		$item->delete();
    		$flash_type = 'success animate3 fadeInUp';
    		$flash_messager = 'Đã xóa bài viết <br/><b>'.$item->title.'</b>';
    	} elseif($router == 'backend.'.$this->prefix.'.deletes'){ // Xóa nhiều phần tử
    		$listid = $request->listid;
    		if($listid){
    			$listids = explode("-", $listid);
				$titles = '';
				foreach ($listids as $key => $id) {
					$item = Post::where([['id', $id]])->first();
					if($item){
						$titles .= '<b>- '.$item->title.'</b><br/>';
                        CatePost::where('post_id', $item->id)->delete();
						Image::delete('uploads/'.$item->photo);
						$item->delete();
					}
				}
				if($titles){
		    		$flash_type = 'success animate3 fadeInUp';
		    		$flash_messager = 'Đã xóa bài viết<br/>'.rtrim($titles, ', ');
		    	} else {
		    		$flash_type = 'info animate3 fadeInUp';
		    		$flash_messager = 'Không xóa được bài viết.';
		    	}
    		} else {
	    		$flash_type = 'info animate3 fadeInUp';
	    		$flash_messager = 'Không nhận được dữ liệu.';
    		}

    	} else { // Không tìm thấy phần tử
    		$flash_type = 'error animate3 swing';
    		$flash_messager = 'Đường dẫn không tồn tại.';
    	}
    	return redirect()->route('backend.'.$this->prefix)->with(['flash_type'=>$flash_type, 'flash_messager'=>$flash_messager]);
    }
}
