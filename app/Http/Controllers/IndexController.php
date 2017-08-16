<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;

use Image, App\Page, App\Post, App\Detail;

class IndexController extends FrontController
{
    public function __construct(Request $request){
        parent::__construct($request);
    }
    public function index(Request $request){
    	$limit = $request->limit ? $request->limit : $this->company['per_page_news'];
        $sliders = Page::select('id', 'title', 'slug', 'photo', 'updated_at')->where([['type', 'slider'], ['active', 1]])->orderBy('no', 'asc')->orderBy('id','desc')->get();
        $items = Post::select('id', 'slug', 'title', 'photo', 'seo_description', 'updated_at')->where([['type', 'news'], ['active', 1]])->orderBy('no', 'asc')->orderBy('id','desc')->paginate($limit);
        return view('frontend.index')->with([
            'title' => $this->company['seo_title'],
            'keywords' => $this->company['seo_keywords'],
            'description' => $this->company['seo_description'],
            'image' => '',
        	'slider'=>$sliders, 
        	'items'=>$items
        ]);
    }
}
