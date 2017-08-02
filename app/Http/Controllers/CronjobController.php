<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Image, Auth, App\Option, App\Post, App\Page, App\CatePost, App\Cronjob;

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

    	if(count($items)) foreach($items as $key => $value){
	    	$hrefTitleDesc = getHrefTitleDesc($value['url_topic'], $value['tag_list'], $value['tag_link'], $value['tag_title']);

	    	krsort($hrefTitleDesc);
	    	if(count($hrefTitleDesc)) foreach($hrefTitleDesc as $info){
	    		$link = trim($info['link']);
	    		$link = isValidURL($info['link'])?$link:$info['domain'].$link;

	    		if(!empty($link)){
	    			$html_news = file_get_html($link);
					$tag_removes = explode(";", $value['tag_remove']);
					foreach($tag_removes as $tag){
						foreach ($html_news->find($tag) as $node){
							$node->outertext = '';
						}
					}
					$detail = strip_tags($html_news->find($value['tag_content'], 0)->innertext, '<div><ul><li><p><img><h2><h3><h4><strong><b><br>');
					if($value['where_desc'] == 1) $desc = $info['desc'];
					if($value['where_desc'] == 2) $desc = trim($html_news->find($value['tag_desc'], 0)->plaintext);
					else $desc = str_limit(strip_tags($detail), 200, ' ...');

					echo '- '.$info['title'].'<br/>';
	    		}
	    	}
	    }
    	echo '<p><a href="./">Quay về trang chủ</a></p>';
    }
}
