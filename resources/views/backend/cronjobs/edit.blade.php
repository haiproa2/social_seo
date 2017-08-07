@extends('backend.layouts.master')

@section('content')
<div class="breadcrumbwidget animate3 fadeInUp">
    <ul class="skins">
        <li><a href="default" class="skin-color default"></a></li>
        <li><a href="orange" class="skin-color orange"></a></li>
        <li><a href="dark" class="skin-color dark"></a></li>
        <li>&nbsp;</li>
        <li class="fixed"><a href="" class="skin-layout fixed"></a></li>
        <li class="wide"><a href="" class="skin-layout wide"></a></li>
    </ul><!--skins-->
    <ul class="breadcrumb">
        <li><a href="{{ route('backend.index') }}">Admin Area</a> <span class="divider">/</span></li>
        <li><a href="{{ route('backend.news') }}">Bài viết</a> <span class="divider">/</span></li>
        <li class="active">Lấy tin tự động</li>
    </ul>
</div><!--breadcrumbs-->
<div class="pagetitle animate4 fadeInUp"><h1>{!! $title !!}</h1> <span>{!! $description !!}</span></div><!--pagetitle-->
<div class="contentinner content-editprofile animate5 fadeInUp">
	@if($updateForm)
	{{ Form::open(['route' => ['backend.cronjob.update', $item->id], 'enctype'=>'multipart/form-data']) }}
	@endif
		<div class="row-fluid">
			<div class="span7">
				<h4 class="widgettitle nomargin shadowed">Thông tin nguồn</h4>
				<div class="widgetcontent bordered shadowed nopadding">
					<div class="stdform stdform2 stdformsmall">
						<p class="control-group">
							<label for="title">Tiêu đề <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('title') ? ' error' : '' }}">
								{!! Form::text('title', $item->title, [
									'id'=>'title', 'class'=>'span12', 'autofocus'=>true, 'required'=>true, 'disabled'=>$disabled, 
									'placeholder'=>'VD: Văn hóa ẩm thực - blogamthuc.vn'
								]) !!}
								@if ($errors->has('title'))
								<span class="help-inline">{!! $errors->first('title') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="url_topic">Liên kết lấy tin <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('url_topic') ? ' error' : '' }}">
								{!! Form::text('url_topic', $item->url_topic, [
									'id'=>'url_topic', 'class'=>'span12', 'required'=>true, 'disabled'=>$disabled, 
									'placeholder'=>'VD: http://www.blogamthuc.com/cat/tin-tuc-am-thuc/van-hoa-am-thuc'
								]) !!}
								@if ($errors->has('url_topic'))
								<span class="help-inline">{!! $errors->first('url_topic') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="url_page">Link phân trang</label>
							<span class="field">
								{!! Form::text('url_page', $item->url_page, [
									'id'=>'url_page', 'class'=>'span6', 'disabled'=>$disabled, 
									'placeholder'=>'VD: /page/ hoặc /?page='
								]) !!}
								<small class="help-inline">/page/ hoặc /?page=</small>
								@if ($errors->has('url_page'))
								<span class="help-inline">{!! $errors->first('url_page') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="count_page">Tổng số trang</label>
							<span class="field">
								{!! Form::number('count_page', $item->count_page, [
									'id'=>'count_page', 'class'=>'span6', 'min'=>1, 'max'=>999, 'disabled'=>$disabled,
									'placeholder'=>'VD: 9'
								]) !!}
								<small class="help-inline">Điền khi các trang có số trang nằm cuối url</small>
								@if ($errors->has('count_page'))
								<span class="help-inline">{!! $errors->first('count_page') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="tag_list">Thẻ danh sách <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('tag_list') ? ' error' : '' }}">
								{!! Form::text('tag_list', $item->tag_list, [
									'id'=>'tag_list', 'class'=>'span12', 'required'=>true, 'disabled'=>$disabled,
									'placeholder'=>'VD: #content .post'
								]) !!}
								@if ($errors->has('tag_list'))
								<span class="help-inline">{!! $errors->first('tag_list') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="tag_link">Thẻ liên kết <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('tag_link') ? ' error' : '' }}">
								{!! Form::text('tag_link', $item->tag_link, [
									'id'=>'tag_link', 'class'=>'span12', 'required'=>true, 'disabled'=>$disabled,
									'placeholder'=>'VD: .readmore a'
								]) !!}
								@if ($errors->has('tag_link'))
								<span class="help-inline">{!! $errors->first('tag_link') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="tag_title">Thẻ tiêu đề <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('tag_title') ? ' error' : '' }}">
								{!! Form::text('tag_title', $item->tag_title, [
									'id'=>'tag_title', 'class'=>'span12', 'required'=>true, 'disabled'=>$disabled,
									'placeholder'=>'VD: h2.title a'
								]) !!}
								@if ($errors->has('tag_title'))
								<span class="help-inline">{!! $errors->first('tag_title') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="tag_desc">Thẻ mô tả</label>
							<span class="field{{ $errors->has('tag_desc') ? ' error' : '' }}">
								{!! Form::text('tag_desc', $item->tag_desc, [
									'id'=>'tag_desc', 'class'=>'span12', 'required'=>true, 'disabled'=>$disabled,
									'placeholder'=>'VD: .entry'
								]) !!}
								@if ($errors->has('tag_desc'))
								<span class="help-inline">{!! $errors->first('tag_desc') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label>Noi lấy mô tả</label>
							<span class="field">
								@if(count($getfroms))
								{!! Form::select('where_desc', $getfroms, $item->where_desc, ['id'=>'where_desc', 'class'=>'span12 SumoSelect', 'disabled'=>$disabled]) !!}
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="tag_photo">Thẻ ảnh <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('tag_photo') ? ' error' : '' }}">
								{!! Form::text('tag_photo', $item->tag_photo, [
									'id'=>'tag_photo', 'class'=>'span12', 'required'=>true, 'disabled'=>$disabled,
									'placeholder'=>'VD: #content .entry img'
								]) !!}
								@if ($errors->has('tag_photo'))
								<span class="help-inline">{!! $errors->first('tag_photo') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label>Nơi lấy ảnh đại diện</label>
							<span class="field">
								@if(count($getfroms))
								{!! Form::select('where_photo', $getfroms, $item->where_photo, ['id'=>'where_photo', 'class'=>'span12 SumoSelect', 'disabled'=>$disabled]) !!}
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="tag_content">Thẻ chi tiết <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('tag_content') ? ' error' : '' }}">
								{!! Form::text('tag_content', $item->tag_content, [
									'id'=>'tag_content', 'class'=>'span12', 'required'=>true, 'disabled'=>$disabled,
									'placeholder'=>'VD: #content .entry'
								]) !!}
								@if ($errors->has('tag_content'))
								<span class="help-inline">{!! $errors->first('tag_content') !!}</span>
								@endif
							</span>
						</p>
					</div>
				</div>
			</div>
			<div class="span5">
				<h4 class="widgettitle nomargin shadowed">Thông tin lưu trữ</h4>
				<div class="widgetcontent bordered shadowed nopadding">
					<div class="stdform stdform2 stdformsmall">
						<div class="control-group">
							<label>Danh mục</label>
							<div class="field">
								{!! showTrees($categorys, $item->cate_id, 'cate_id', 'radio', 'Không chọn danh mục', $disabled) !!}
							</div>
						</div>
						<p class="control-group">
							<label for="tag_remove">Loại bỏ thẻ</label>
							<span class="field">
								{!! Form::textarea('tag_remove', $item->tag_remove, [
									'id'=>'tag_remove', 'class'=>'span12', 'rows'=>4, 'disabled'=>$disabled,
									'placeholder'=>'VD: .adv-area; .row-more'
								]) !!}
								<span class="help-inline">Các thẻ (tags) cách nhau bởi dấu ;</span>
							</span>
						</p>
						<p class="control-group">
							<label for="no">Số thứ tự</label>
							<span class="field{{ $errors->has('no') ? ' error' : '' }}">
								{{ Form::number('no', $item->no, ['id'=>'no', 'class'=>'span4', 'min'=>0, 'max'=>999, 'disabled'=>$disabled]) }}
								@if ($errors->has('no'))
								<span class="help-inline">{!! $errors->first('no') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label>Mã cronjob</label>
							<span class="field">
								{!! Form::textarea('tag_remove', '/usr/local/bin/php -q '.dirname(dirname($_SERVER['SCRIPT_FILENAME'])).'/cronjob?source=6&limit=5', [
									'class'=>'span12', 'rows'=>4, 'disabled'=>true
								]) !!}
							</span>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<h4 class="widgettitle nomargin shadowed"></h4>
				<div class="widgetcontent bordered shadowed nopadding">
					<div class="stdform stdform2">
						<p class="stdformbutton">
							@if($updateForm)
							{{ Form::button('<span class="iconfa-save"></span> Lưu', ['class' => 'btn btn-primary', 'type' => 'submit']) }} - Or -
							@else
							<button data-target="#runcron" title="Lấy bài viết" class="btn btn-primary" data-toggle="modal" data-backdrop="static" data-keyboard="false"><span class="iconfa-truck"></span> Lấy bài viết</button> - Or -
							@endif
							<a href="{!! route('backend.cronjob') !!}" title="Thoát" class="btn"><span class="iconfa-off"></span> Thoát</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	@if($updateForm)
	{{ Form::close() }}
	@endif
</div><!--contentinner-->

<div aria-hidden="false" role="dialog" tabindex="-1" class="modal hide fade in" id="runcron">
	<div class="modal-header">
		<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
		<h3>Đang lấy bài viết <span class="loading hidden"></span></h3>
	</div>
	<div class="modal-body">
		<div class="result-cron">
		</div>
	</div>
	<div class="modal-footer">
		<div class="area-result">
			<ul>
				<li>Đã lấy được <span class="text-success">0</span> bài viết</li>
				<li>Bị lỗi <span class="text-error">0</span> bài viết</li>
				<li>Bỏ qua <span class="muted">0</span> bài viết</li>
			</ul>
		</div>
		<button data-dismiss="modal" class="btn">Close</button>
	</div>
</div><!--#myModal-->
<script>
	var dots = 0;
	var number = 0;
	var success = 0;
	var error = 0;
	var skip = 0;
	var CSRF_TOKEN = jQuery('input[name="_token"]').attr('value');
	function loading(){
		if(dots < 3){
			jQuery(".loading").append('.');
			dots++;
		} else {
			jQuery(".loading").html('');
			dots = 0;
		}
	}
	jQuery(window).ready(function(){
		setInterval(loading, 600);
		jQuery('#runcron').on('show.bs.modal', function (event) {
			jQuery.ajax({
				headers: {
					'X-CSRF-TOKEN': CSRF_TOKEN
				},
				url: "{!! route('backend.cronjob.run', $item->id) !!}",
				method: "POST",
				data: {
					"_token": CSRF_TOKEN, 
					"source": "source", 
					"link": "link"
				},
				success: function (data) {
					dots = 0;
					jQuery(".modal-header .loading").removeClass("hidden").html('');
					var data = jQuery.parseJSON(data);
					if(data.status == 'success'){
						jQuery.each(data.items, function(key, item) {
							jQuery.ajax({
								headers: {
									'X-CSRF-TOKEN': CSRF_TOKEN
								},
								url: "{!! route('backend.cronjob.run', $item->id) !!}",
								method: "POST",
								data: {
									"_token": CSRF_TOKEN,
									"link": item.link
								},
								success: function (data) {
									number++;
									jQuery(".result-cron .loading").addClass('hidden');
									var data = jQuery.parseJSON(data);
									if(data.status=='success'){
										success++;
										jQuery(".area-result .text-success").html(success);
										jQuery(".result-cron").append('<p>'+number+' - '+item.title+' - <span class="text-success">Done</span></p>');
									} else if(data.status=='skip'){
										skip++;
										jQuery(".area-result .muted").html(skip);
										jQuery(".result-cron").append('<p>'+number+' - '+item.title+' - <span class="muted">Skip</span></p>');
									} else {
										error++;
										jQuery(".area-result .text-error").html(error);
										jQuery(".result-cron").append('<p>'+number+' - '+item.title+' - <span class="text-error">Error</span></p>');
									}
									jQuery(".modal-body").animate({ scrollTop: jQuery(".result-cron").height() }, 500);
								},
								error: function (data) {
									success++;
									jQuery(".area-result .text-success").html(success);
								}
							});
						});
					}
				},
				error: function (data) {
				}
			});
		});
		jQuery('#runcron').on('hidden.bs.modal', function (event) {
			jQuery(".loading").addClass('hidden');
		});
		if(window.location.hash) {
			var hash = window.location.hash;
			jQuery(hash).modal({
				show: true,
				backdrop: 'static',
				keyboard: false
			});
		}
	});
</script>
@endsection