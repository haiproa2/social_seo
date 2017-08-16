<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use View, Image, App\Page, App\Post, App\Detail;

class FrontController extends Controller
{
	protected $company;

    public function __construct(Request $request){
    	setlocale(LC_TIME, 'vi_VN');
        $favicon = Page::select('photo')->where([['type', 'favicon'], ['active', 1]])->orderby('no', 'asc')->orderby('id', 'desc')->first();
        $banner = Page::select('photo')->where([['type', 'logo'], ['active', 1]])->orderby('no', 'asc')->orderby('id', 'desc')->first();
        $cates = Page::select('id', 'id_parent', 'title', 'slug')->where([['type', 'news'], ['active', 1]])->orderby('no', 'asc')->orderby('id', 'desc')->get();
        recursive($cates, $categorys);
        $news_top_view = Post::select('id', 'title', 'slug')->where([['type', 'news'], ['active', 1]])->orderby('view', 'desc')->orderby('no', 'asc')->orderby('id', 'desc')->paginate(6);
        $companys = Detail::where('table_name', 'config')->where('id_column', 1)->get()->toArray();
        if(count($companys)){
            foreach ($companys as $key => $value) {
                $this->company[$value['keyword_column']] = $value['value_column'];
            }
        } 
        view::share([
            'title' => '',
            'keywords' => '',
            'description' => '',
            'image' => '',
            'favicon' => $favicon->photo,
            'banner' => $banner->photo,
            'company' => $this->company,
            'categorys' => $categorys,
            'news_top_view' => $news_top_view
        ]);
    }
}
