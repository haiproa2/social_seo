<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session, Auth, Image, App\Option, App\Post, App\Page, App\CatePost, App\Cronjob;

class CronjobController extends Controller
{
    public function index(Request $request){

    	if(empty($request->source))
    		return false;

    	$item = Cronjob::findOrFail($request->source)->toArray();

    	$items = array();
    	$items[1] = $item;
    	$newItem = $item;

    	if($item['count_page']){
    		$item['count_page'] = ($item['count_page'] <= 10)?intval($item['count_page']):10;
    		for ($i=2; $i <= $item['count_page']; $i++) {
    			$topic = $item['url_topic'].$item['url_page'].$i;
    			$newItem['url_topic'] = $topic;
    			$items[$i] = $newItem;
    		}
    	}

    	$total = $linkNumber = 0;

    	if(count($items)) foreach($items as $key => $item){

			$tag_title = ($item['where_title']==1)?$item['tag_title']:'';
			$tag_photo = ($item['where_photo']==1)?$item['tag_photo']:'';
			$tag_desc = ($item['where_desc']==1)?$item['tag_desc']:'';

	    	$infos = $this->getInfos($item);

    		$total += ($request->limit)?(count($infos) * count($items)):0;

	    	krsort($infos);
	    	if(count($infos)) foreach($infos as $k => $info){
	    		$linkNumber ++;
	    		/*$news_title = $news_photo = $news_desc = $news_content = '';

	    		$link = trim($info['link']);
	    		$link = isValidURL($info['link'])?$link:$item['domain'].$link;

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
	    		}*/
	    		if($request->limit && $linkNumber == $request->limit) break;
	    	}
	    	if($request->limit && $linkNumber == $request->limit) break;
	    }
    	echo '<p>Tống số trang: '.count($items).' - '.$item['count_page'].'</p>';
    	echo '<p>Tống số link: '.$linkNumber.'</p>';
    	echo '<p>Tống số lấy: '.$request->limit.'</p>';
    	echo '<p><a href="./">Quay về trang chủ</a></p>';
    }

    public function runCron(Request $request){
    	$id = $request->id;
    	$item = Cronjob::findOrFail($id)->toArray();

    	$items = array();
    	$items[1] = $item;

    	if($item['count_page']){
    		$item['count_page'] = ($item['count_page'] <= 10)?intval($item['count_page']):10;
    		for ($i=2; $i <= $item['count_page']; $i++) {
    			$topic = $item['url_topic'].$item['url_page'].$i;
    			$items[$i] = $item;
    			$items[$i]['url_topic'] = $topic;
    		}
    	}

    	return json_encode([
            'token' => Session::token(),
            'status' => 'success',
            'messager' => 'Lấy danh sách bài viết thành công.',
            'items' => $this->getInfos($items)
            ]);
    }

    public function getInfos($sources, $limit = 0){
		$infos = array();
		
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
					$infos[$key+$k]['link'] = ($href_)?$href_->href:'';
				}

				$title_ = $value->find($source['tag_title'], 0);
				$infos[$key+$k]['title'] = trim(($title_)?$title_->plaintext:'');

				if($tag_photo){
					$infos[$key+$k]['photo'] = trim($value->find($tag_photo, 0)->src);
				}
				else
					$infos[$key+$k]['photo'] = '';

				if($tag_desc){
					$desc_ = $value->find($tag_desc, 0);
					$infos[$key+$k]['desc'] = trim(($desc_)?$desc_->plaintext:'');
				}
				else
					$infos[$key+$k]['desc'] = '';

				if($limit > 0 && $key >= $limit-1) break;
			}
			krsort($infos);
		}
		return $infos;
    }

    public function getContent($id_source, $link){
    	$item = Cronjob::findOrFail($id_source)->toArray();

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
				if($news_title && $news_content){
					/*$post->type = 'news';
					$post->title = $news_title;
					$post->slug = str_slug($news_title).'-'.time();
			        $post->content = $news_content;
			        $post->seo_title = '';
			        $post->seo_keywords = '';
			        $post->seo_description = $news_desc;
			        $post->view = rand(2010, 2020);
			        $post->no = 10;
			        $post->active = 1;
			        if($post->save()){
						$CatePost = new CatePost;
						$CatePost->cate_id = $item['cate_id'];
						$CatePost->post_id = $post->id;
						$CatePost->save();

					}*/
					echo $k.' - '.$post->title.' - Done<br/>';
				} else
					echo $k.' - '.$post->title.' - Title or Content empty. <br/>';
				
			}
		}
    }
}
