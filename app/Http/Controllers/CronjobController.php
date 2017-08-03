<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth, Image, App\Option, App\Post, App\Page, App\CatePost, App\Cronjob;

class CronjobController extends Controller
{
    public function index(Request $request){
    	$notice = ($request->source)?'':'Không nhận được source cần chạy<br/>';

    	$item = Cronjob::findOrFail($request->source)->toArray();
    	//dump($item);
    	//
    	$items = array();
    	$items[1] = $item;
    	$newItem = $item;

    	if($item['count_page']){
    		$item['count_page'] = ($item['count_page'] <= 10)?intval($item['count_page']):10;
    		$notice .= $item['url_topic']."<br/>";
    		for ($i=2; $i <= $item['count_page']; $i++) {
    			$topic = $item['url_topic'].$item['url_page'].$i;
    			$notice .= "{$topic}<br/>";
    			$newItem['url_topic'] = $topic;
    			$items[$i] = $newItem;
    		}
    	}

    	if(count($items)) foreach($items as $key => $item){
    		$tag_title = $tag_photo = $tag_desc = '';
    		if($item['where_title']) // [1] Lấy tiêu đề từ danh sách
    			$tag_title = $item['tag_title'];
    		if($item['where_photo']) // [1] Lấy ảnh đại diện từ danh sách
    			$tag_photo = $item['tag_photo'];
    		if($item['where_desc']) // [1] Lấy mô tả từ danh sách
    			$tag_desc = $item['tag_desc'];

	    	$infos = $this->getInfos($item);

	    	// krsort($infos);
	    	if(count($infos)) foreach($infos as $k => $info){
	    		$news_title = $news_photo = $news_desc = $news_content = '';

	    		$link = trim($info['link']);
	    		$link = isValidURL($info['link'])?$link:$item['domain'].$link;

	    		if(!empty($link)){
	    			$html_news = file_get_html($link);
	    			if($html_news){
						$tag_removes = explode(";", $item['tag_remove']);
						foreach($tag_removes as $tag){
							foreach ($html_news->find($tag) as $node){
								$node->outertext = '';
							}
						}
						$content_ = $html_news->find($item['tag_content'], 0);
						if($content_){
							$news_content = trim(strip_tags($content_->innertext, '<div><ul><li><p><img><h2><h3><h4><br>'));
						}
						else $news_content = '';

						$title_ = $html_news->find($tag_title, 0);
						if($tag_title && $item['where_title'] == 1) $news_title = $info['title'];
						else if($tag_title && $title_) $news_title = trim($title_->plaintext);

						$desc_ = $html_news->find($tag_desc, 0);
						if($tag_desc && $item['where_desc'] == 1) $news_desc = str_limit(strip_tags($info['desc']), 240, ' ...');
						else if($tag_desc && $item['where_desc'] == 2 && $desc_) $news_desc = str_limit((strip_tags(trim($desc_->plaintext))), 240, ' ...');
						else $news_desc = str_limit(strip_tags($news_content), 240, ' ...');

						$photo_ = $html_news->find($item['tag_photo'], 0);
						if($tag_photo && $item['where_photo'] == 1) $news_photo = $info['photo'];
						else if($tag_photo && $item['where_photo'] == 2 && $photo_) $news_photo = trim($photo_->src);
												
						$post = new Post;
						
						if($news_photo){
							$news_photo = isValidURL($news_photo)?$news_photo:$item['domain'].$news_photo;
				            $ext = pathinfo($news_photo, PATHINFO_EXTENSION);
				            $filename = 'posts/'.str_slug($news_title).date('-His', time()).'.'.$ext;
				            $photos = file_get_contents($news_photo);
				            $save = file_put_contents('uploads/'.$filename, $photos);
				            if($save) $post->photo = $filename;
						}
						if($content_){
							foreach ($content_->find('img') as $img) {
						        $old_src = '';
						        $old_src = $img->getAttribute('src');
						        $old_src = isValidURL($old_src)?$old_src:$item['domain'].$old_src;

					            $ext = pathinfo($old_src, PATHINFO_EXTENSION);
					            $filename = 'posts/'.str_slug(basename($old_src, $ext)).date('-His', time()).'.'.$ext;
					            $photos = file_get_contents($old_src);
					            $save = file_put_contents('uploads/'.$filename, $photos);
					            if($save){
						        	$new_src_url = '/uploads/'.$filename;
						        	$img->setAttribute('src', $new_src_url);
					            }
						    }
						}
						if($news_title && $news_content){
							$post->type = 'news';
							$post->title = $news_title;
							$post->slug = str_slug($news_title).'-'.time();
					        $post->content = $news_content;
					        $post->seo_title = '';
					        $post->seo_keywords = '';
					        $post->seo_description = $news_desc;
					        $post->view = rand(2010, 2020);
					        $post->no = 10;
					        $post->created_by = Auth::user()->id;
					        $post->updated_by = Auth::user()->id;
					        $post->active = 1;
					        if($post->save()){
								$CatePost = new CatePost;
								$CatePost->cate_id = $item['cate_id'];
								$CatePost->post_id = $post->id;
								$CatePost->save();

							}
							echo $k.' - '.$post->title.' - Done<br/>';
						} 
						else
							echo $k.' - '.$post->title.' - Title or Content empty. <br/>';
						
					}
	    		}
	    	}
	    }
    	echo '<p><a href="./">Quay về trang chủ</a></p>';
    }

    public function getInfos($array, $quantity = 0){
		$tag_title = $tag_photo = $tag_desc = '';
		if($array['where_title']) // [1] Lấy tiêu đề từ danh sách
			$tag_title = $array['tag_title'];
		if($array['where_photo']) // [1] Lấy ảnh đại diện từ danh sách
			$tag_photo = $array['tag_photo'];
		if($array['where_desc']) // [1] Lấy mô tả từ danh sách
			$tag_desc = $array['tag_desc'];

		$html = file_get_html($array['url_topic']);
		$infos = array();
		
		foreach($html->find($array['tag_list']) as $key => $value){
			if($array['tag_link']){
				$href_ = $value->find($array['tag_link'], 0);
				$infos[$key]['link'] = ($href_)?$href_->href:'';
			}

			if($tag_title&&$array['where_title']==1){
				$title_ = $value->find($tag_title, 0);
				$infos[$key]['title'] = trim(($title_)?$title_->plaintext:'');
			}
			else
				$infos[$key]['title'] = '';

			if($tag_photo&&$array['where_photo']==1){
				$infos[$key]['photo'] = trim($value->find($tag_photo, 0)->src);
			}
			else
				$infos[$key]['photo'] = '';

			if($tag_desc&&$array['where_desc']==1){
				$desc_ = $value->find($tag_desc, 0);
				$infos[$key]['desc'] = trim(($desc_)?$desc_->plaintext:'');
			}
			else
				$infos[$key]['desc'] = '';

			if($quantity > 0 && $key >= $quantity-1) break;
		}
		return $infos;

    }
}
