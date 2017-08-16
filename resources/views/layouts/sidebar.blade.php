<div id="sidebar">
    <div class="box box-social">
    	<div class="title">
    		<h4>Kết nối với chúng tôi</h4>
    	</div>
    	<div class="body social">
    		<ul>
    			<?php if($company['facebook']){ ?>
    			<li>
    				<a href="{{ $company['facebook'] }}" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a>
    			</li>
    			<?php } if($company['youtube']){ ?>
    			<li>
    				<a href="{{ $company['youtube'] }}" title="Youtube" target="_blank"><i class="fa fa-youtube"></i></a>
    			</li>
    			<?php } if($company['twitter']){ ?>
    			<li>
    				<a href="{{ $company['twitter'] }}" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a>
    			</li>
    			<?php } if($company['google_plus']){ ?>
    			<li>
    				<a href="{{ $company['google_plus'] }}" title="Google Plus" target="_blank"><i class="fa fa-google-plus"></i></a>
    			</li>
    			<?php } ?>
    		</ul>
    	</div>
    </div>
    @if(count($news_top_view))
    <div class="box box-news">
    	<div class="title">
    		<h4>Bài viết được quan tâm</h4>
    	</div>
    	<div class="body posts">
    		<ul>
	    		@foreach($news_top_view as $key => $value)
	    		<li><a href="{{ $value->slug }}" title="{{ $value->title }}">{{ $value->title }}</a></li>
	    		@endforeach
    		</ul>
    	</div>
    </div>
    @endif
    @if(count($slider))
    <div class="box box-image">
        <div class="title">
            <h4>Đối tác</h4>
        </div>
        <div class="body customer">
            <ul>
                @foreach($slider as $key => $value)
                <li>
                    <?php if($value['slug']) { ?>
                    <a href="{{ $value['slug'] }}" title="{{ $value->title }}" {!! (isValidURL($value['slug']))?'target="_blank"':'' !!}>
                        <img src="{!! Image::url((($value->photo)?'uploads/'.$value->photo:''), 265, 160, array('crop')) !!}" alt="{{ $value->title }}" onerror="this.src='{!! Image::url('images/no-image-available.jpg', 265, 160, array('crop')) !!}';">
                    </a>
                    <?php } else { ?>
                    <img src="{!! Image::url((($value->photo)?'uploads/'.$value->photo:''), 265, 160, array('crop')) !!}" alt="{{ $value->title }}" onerror="this.src='{!! Image::url('images/no-image-available.jpg', 265, 160, array('crop')) !!}';">
                    <?php } ?>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>