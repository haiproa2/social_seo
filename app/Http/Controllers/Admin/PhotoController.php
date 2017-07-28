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
}
