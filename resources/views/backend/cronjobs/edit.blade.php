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
									'id'=>'url_page', 'class'=>'span4', 'disabled'=>$disabled, 
									'placeholder'=>'VD: /page/_ hoặc /?page=_ hoặc /page/_.html'
								]) !!}
								<small class="help-inline">Dấu _ sẽ được thay bằng số trang</small>
								@if ($errors->has('url_page'))
								<span class="help-inline">{!! $errors->first('url_page') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="count_page">Số trang cần duyệt</label>
							<span class="field">
								{!! Form::number('count_page', $item->count_page, [
									'id'=>'count_page', 'class'=>'span4', 'min'=>1, 'max'=>100, 'disabled'=>$disabled,
									'placeholder'=>'VD: 9'
								]) !!}
								@if ($errors->has('count_page'))
								<span class="help-inline">{!! $errors->first('count_page') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="count_post">Số bài cần lấy</label>
							<span class="field">
								{!! Form::number('count_post', $item->count_post, [
									'id'=>'count_post', 'class'=>'span4', 'min'=>0, 'max'=>100, 'disabled'=>$disabled,
									'placeholder'=>'VD: 10'
								]) !!}
								<small class="help-inline">Lấy từ cuối danh sách; Để số 0 nếu muốn lấy tất cả.</small>
								@if ($errors->has('count_post'))
								<span class="help-inline">{!! $errors->first('count_post') !!}</span>
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
									'id'=>'tag_title', 'class'=>'span12', 'disabled'=>$disabled,
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
									'id'=>'tag_desc', 'class'=>'span12', 'disabled'=>$disabled,
									'placeholder'=>'VD: .entry'
								]) !!}
								@if ($errors->has('tag_desc'))
								<span class="help-inline">{!! $errors->first('tag_desc') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label>Nơi lấy mô tả</label>
							<span class="field">
								@if(count($getfroms))
								{!! Form::select('where_desc', $getfroms, $item->where_desc, ['id'=>'where_desc', 'class'=>'span12 SumoSelect', 'disabled'=>$disabled]) !!}
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="tag_photo">Thẻ ảnh</label>
							<span class="field{{ $errors->has('tag_photo') ? ' error' : '' }}">
								{!! Form::text('tag_photo', $item->tag_photo, [
									'id'=>'tag_photo', 'class'=>'span12', 'disabled'=>$disabled,
									'placeholder'=>'VD: #content .entry img'
								]) !!}
								@if ($errors->has('tag_photo'))
								<span class="help-inline">{!! $errors->first('tag_photo') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="remove_text_photo">Text loại bỏ khỏi ảnh</label>
							<span class="field{{ $errors->has('remove_text_photo') ? ' error' : '' }}">
								{!! Form::text('remove_text_photo', $item->remove_text_photo, [
									'id'=>'remove_text_photo', 'class'=>'span12', 'disabled'=>$disabled,
									'placeholder'=>'VD: _180x108', 'data-toggle'=>'popfocus', 'title'=>'Hướng dẫn', 'data-content'=>'- Nếu ảnh cần lấy chỉ là thumb và muốn lấy ảnh gốc, cần thêm đoạn ký tự cần loại bỏ để lấy ảnh gốc.<br/>- Ví dụ:<br/>&nbsp;&nbsp;&nbsp;+ Thumb:<br/><span class="text-warning">/images/no-image-available<span class="text-success">-thumb(1110x130-crop)</span>.jpg</span><br/>&nbsp;&nbsp;&nbsp;+ Gốc là:<br/><span class="text-warning">/images/no-image-available.jpg</span><br/>&nbsp;&nbsp;&nbsp;+ Đoạn ký tự cần ghi là:<br/><span class="text-error">-thumb(1110x130-crop)</span>', 'data-placement'=>'top', 'data-html'=>'true'
								]) !!}
								@if ($errors->has('remove_text_photo'))
								<span class="help-inline">{!! $errors->first('remove_text_photo') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label>Nơi lấy ảnh</label>
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
								{!! Form::textarea('tag_remove', '/usr/local/bin/php -q '.dirname(dirname($_SERVER['SCRIPT_FILENAME'])).'/get-post?source='.$item->id.'&limit='.$item->count_post, [
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
		<h3>Loading <span class="loading hidden"></span></h3>
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
				<li>Bỏ qua <span class="text-warning">0</span> bài viết</li>
			</ul>
		</div>
		<button data-dismiss="modal" class="btn">Close</button>
	</div>
</div><!--#myModal-->
<script>
	var dots = 0;
	var success = 0;
	var error = 0;
	var number = 0;
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
			dots = 0;
			number = 0;
			jQuery(".loading").html('');
			jQuery(".modal-header h3").html('Loading <span class="loading"></span>');
			jQuery(".result-cron").html('');
			jQuery(".area-result .text-success").html('0');
			jQuery(".area-result .text-error").html('0');
			jQuery(".area-result .text-warning").html('0');
			jQuery.ajax({
				headers: {
					'X-CSRF-TOKEN': CSRF_TOKEN
				},
				url: "{!! route('backend.cronjob.getList', $item->id) !!}",
				method: "POST",
				data: {
					"_token": CSRF_TOKEN,
					"id": {{ $item->id }}
				},
				success: function (datas) {
					var data = jQuery.parseJSON(datas);
					var length = Object.keys(data.items).length;
					var limit = data.limit;
					if(data.status == 'success' && length){
						jQuery.each(data.items, function(key, item) {
							jQuery.ajax({
								headers: {
									'X-CSRF-TOKEN': CSRF_TOKEN
								},
								url: "{!! route('backend.cronjob.getContent', $item->id) !!}",
								method: "POST",
								data: {
									"_token": CSRF_TOKEN,
									"item": item,
									"id": {{ $item->id }}
								},
								success: function (data_detail) {
									number++;
									jQuery(".result-cron .loading").addClass('hidden');
									var data_detail = jQuery.parseJSON(data_detail);
									if(data_detail.status==2){
										error++;
										jQuery(".area-result .text-error").html(error);
										jQuery(".result-cron").append('<p>'+number+' - '+item.title.substring(0, 60)+' ... <span class="text-error">Can\'t Save</span></p>');
									} else if(data_detail.status==1){
										success++;
										jQuery(".area-result .text-success").html(success);
										jQuery(".result-cron").append('<p>'+number+' - '+item.title.substring(0, 60)+' ... <span class="text-success">Done</span></p>');
									} else if(data_detail.status==0){
										skip++;
										jQuery(".area-result .text-warning").html(skip);
										jQuery(".result-cron").append('<p>'+number+' - '+item.title.substring(0, 60)+' ... <span class="text-warning">Link Unknow</span></p>');
									} else if(data_detail.status==-1){
										skip++;
										jQuery(".area-result .text-warning").html(skip);
										if(item.title=='')jQuery(".result-cron").append('<p>'+number+' - <span class="text-warning">Title Null</span></p>');
										else jQuery(".result-cron").append('<p>'+number+' - '+item.title.substring(0, 60)+' ... <span class="text-warning">Can\'t Get Content</span></p>');
									} else if(data_detail.status==-2){
										skip++;
										jQuery(".area-result .text-warning").html(skip);
										jQuery(".result-cron").append('<p>'+number+' - '+item.title.substring(0, 60)+' ... <span class="text-warning">Post Exist</span></p>');
									} else {
										error++;
										jQuery(".area-result .text-error").html(error);
										jQuery(".result-cron").append('<p>'+number+' - '+item.title.substring(0, 60)+' ... <span class="text-error">ERROR</span></p>');
									}
									jQuery(".modal-body").animate({ scrollTop: jQuery(".result-cron").height() }, 10);
									if(key == length - 1 || (limit > 0 && key == limit - 1)){
										jQuery(".loading").addClass("hidden");
										jQuery(".modal-header h3").html('<p class="text-success text-center">DONE</p>');
									}
								},
								error: function (xhr,err) {
									jQuery(".result-cron").append('<p class="text-error">Server Lỗi, Kiểm tra lại các trường dữ liệu.</p>');
									setTimeout(function () {
										var w = window.open();
										jQuery(w.document.body).html(xhr.responseText);
									}, 1000);
								}
							});
 							if(limit > 0 && key == limit - 1){
								return false;
 							}
						});
					} else if(length === 0) {
						jQuery(".result-cron").append('<p class="text-warning">WARNING - Không lấy được danh sách bài viết.</p>');
					} else {
						jQuery(".result-cron").append('<p class="text-error">ERROR - Lỗi không xác định, vui lòng kiểm tra lại các trường dữ liệu.</p>');
					}
				},
				error: function (xhr,err) {
					jQuery(".result-cron").html('<p class="text-error">Server Lỗi, Kiểm tra lại các trường dữ liệu.</p>');
					setTimeout(function () {
						var w = window.open();
						jQuery(w.document.body).html(xhr.responseText);
						jQuery('#runcron').modal('hide');
					}, 1000);
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