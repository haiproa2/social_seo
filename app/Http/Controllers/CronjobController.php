<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session, Auth, Image, App\Option, App\Post, App\Page, App\CatePost, App\Cronjob, App\CronjobResult;

class CronjobController extends Controller
{
    public function index(Request $request){
    }

    public function runGetList(Request $request){
    	$id = $request->id;
    	$item = Cronjob::findOrFail($id)->toArray();

    	$items = array();
    	$items[1] = $item;

    	if($item['count_page']){
    		$item['count_page'] = ($item['count_page'] <= 10)?intval($item['count_page']):10;
    		for ($i=2; $i <= $item['count_page']; $i++) {
    			$topic = $item['url_topic'].str_replace('_', $i, $item['url_page']);
    			$items[$i] = $item;
    			$items[$i]['url_topic'] = $topic;
    		}
    	}

    	return json_encode([
            'token' => Session::token(),
            'status' => 'success',
            'messager' => 'Lấy danh sách bài viết thành công.',
            'limit' => $item['count_post'],
            'items' => array_reverse($this->getLists($items))
            ]);
    }

    public function runGetContent(Request $request){

    	$id = $request->id;
    	$item = $request->item;

    	$link = $item['link'];

    	$cronjob = CronjobResult::where('link', $link)->first();

    	if($cronjob && $cronjob->status == '<span class="label label-success">Success</span>'){
	    	return json_encode([
	            'token' => Session::token(),
	            'messager' => 'Bài viết đã tồn tại.',
	            'status' => -2
	        ]);
    	} else {
	    	return json_encode([
	            'token' => Session::token(),
	            'messager' => 'Lấy bài viết thành công.',
	            'status' => $this->getContent($id, $item)
	        ]);
    	}

    }

    public function getLists($sources, $limit = 0){
		$infos = array();

		$i = 1;
		
		foreach ($sources as $k => $source) {
			$tag_photo = $tag_desc = '';
			if($source['where_photo']==1) // [1] Lấy ảnh đại diện từ danh sách
				$tag_photo = $source['tag_photo'];
			if($source['where_desc']==1) // [1] Lấy mô tả từ danh sách
				$tag_desc = $source['tag_desc'];

			$html = file_get_html($source['url_topic']);

			foreach($html->find($source['tag_list']) as $key => $value){
				if($source['tag_link']){
					$href_ = $value->find($source['tag_link'], 0);
					$href_ = ($href_)?$href_->href:'';
					$infos[$i]['link'] = isValidURL($href_)?$href_:$source['domain'].$href_;
				}

				$title_ = $value->find($source['tag_title'], 0);
				$infos[$i]['title'] = trim(($title_)?$title_->plaintext:'');

				if($tag_photo){
					$photo_ = $value->find($tag_photo, 0);
					$infos[$i]['photo'] = trim(($photo_)?$photo_->src:'');
				}
				else
					$infos[$i]['photo'] = '';

				if($tag_desc){
					$desc_ = $value->find($tag_desc, 0);
					$infos[$i]['desc'] = trim(($desc_)?$desc_->plaintext:'');
				}
				else
					$infos[$i]['desc'] = '';
				$i++;
			}
		}
		return $infos;
    }

    public function getContent($id_source, $info){

    	$link = $info['link'];
    	$news_title = $info['title'];

    	$item = Cronjob::findOrFail($id_source)->toArray();

    	$cronjob = new CronjobResult;
		$cronjob->link = $link;
		$cronjob->title = $news_title;
										
		$post = new Post;

		$tag_photo = $tag_desc = '';
		if($item['where_photo']==2) // Lấy ảnh đại diện từ chi tiết
			$tag_photo = $item['tag_photo'];
		if($item['where_desc']==2) // Lấy mô tả từ chi tiết
			$tag_desc = $item['tag_desc'];

		if(!empty($link) && isValidURL($link)){
			$html_news = file_get_html($link);
			if($html_news){
				$tag_removes = explode(";", $item['tag_remove']);
				foreach($tag_removes as $tag){
					foreach ($html_news->find($tag) as $node){
						$node->outertext = '';
					}
				}
				$content_ = $html_news->find($item['tag_content'], 0);
				
				$news_content = ($content_)?trim($content_->innertext, '<div><ol><ul><li><p><img><h2><h3><h4><h5><h6><br><span>'):'';

				if($news_content==''){
					$cronjob->status = '<span class="label label-warning>Can\'t Get Content</san>"';
					$cronjob->save();
					return -1;
				}

				$desc_ = $html_news->find($tag_desc, 0);
				if($item['where_desc'] == 1) $news_desc = str_limit(strip_tags($info['desc']), 240, ' ...');
				else if($tag_desc && $desc_) $news_desc = str_limit((strip_tags(trim($desc_->plaintext))), 240, ' ...');
				else $news_desc = str_limit(strip_tags($news_content), 240, ' ...');

				$photo_ = $html_news->find($item['tag_photo'], 0);
				if($tag_photo && $photo_) $news_photo = trim($photo_->src);
				else $news_photo = $info['photo'];
				
				if($news_photo){
					$news_photo = str_replace($item['remove_text_photo'], '', $news_photo);
					$news_photo = isValidURL($news_photo)?$news_photo:$item['domain'].$news_photo;
		            $ext = pathinfo($news_photo, PATHINFO_EXTENSION);
		            $filename = 'posts/'.str_slug($news_title).date('-His', time()).'.'.$ext;
		            $photos = file_get_contents($news_photo);
		            $save = file_put_contents('uploads/'.$filename, $photos);
		            if($save) $post->photo = $filename;
				}
				if($news_title && $news_content){
					$post->type = 'news';
					$post->title = $news_title;
					$post->slug = str_slug($news_title).date('-dmY', time());
			        $post->content = $news_content;
			        $post->seo_title = '';
			        $post->seo_keywords = '';
			        $post->seo_description = $news_desc;
			        $post->view = rand(2010, 2020);
			        $post->no = 10;
			        $post->active = 1;
			        if($post->save()){
						$catePost = new CatePost;
						$catePost->cate_id = $item['cate_id'];
						$catePost->post_id = $post->id;
						$catePost->save();

					}
					$cronjob->post_id = $post->id;
					$cronjob->status = '<span class="label label-success">Success</span>';
					$cronjob->save();
					return 1;
				} else {
					$cronjob->status = '<span class="label">Can\'t Save</span>';
					$cronjob->save();					
					return 2;
				}				
			}
		} else {
			$cronjob->status = '<span class="label label-important">Link Unknow</span>';
			$cronjob->save();
			return 0;
		}
    }
}
