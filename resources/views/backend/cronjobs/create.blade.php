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
	{{ Form::open(['route' => ['backend.cronjob.store'], 'enctype'=>'multipart/form-data']) }}
		<div class="row-fluid">
			<div class="span7">
				<h4 class="widgettitle nomargin shadowed">Thông tin nguồn</h4>
				<div class="widgetcontent bordered shadowed nopadding">
					<div class="stdform stdform2 stdformsmall">
						<p class="control-group">
							<label for="title">Tiêu đề <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('title') ? ' error' : '' }}">
								{!! Form::text('title', '', [
									'id'=>'title', 'class'=>'span12', 'autofocus'=>true, 'required'=>true,
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
								{!! Form::text('url_topic', '', [
									'id'=>'url_topic', 'class'=>'span12', 'required'=>true,
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
								{!! Form::text('url_page', '', [
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
								{!! Form::number('count_page', 1, [
									'id'=>'count_page', 'class'=>'span4', 'min'=>1, 'max'=>100,
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
								{!! Form::number('count_post', 1, [
									'id'=>'count_post', 'class'=>'span4', 'min'=>0, 'max'=>100,
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
								{!! Form::text('tag_list', '', [
									'id'=>'tag_list', 'class'=>'span12', 'required'=>true,
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
								{!! Form::text('tag_link', '', [
									'id'=>'tag_link', 'class'=>'span12', 'required'=>true,
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
								{!! Form::text('tag_title', '', [
									'id'=>'tag_title', 'class'=>'span12', 'required'=>true,
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
								{!! Form::text('tag_desc', '', [
									'id'=>'tag_desc', 'class'=>'span12',
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
								{!! Form::select('where_desc', $getfroms, 1, ['id'=>'where_desc', 'class'=>'span12 SumoSelect']) !!}
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="tag_photo">Thẻ ảnh <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('tag_photo') ? ' error' : '' }}">
								{!! Form::text('tag_photo', '', [
									'id'=>'tag_photo', 'class'=>'span12',
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
								{!! Form::text('remove_text_photo', '', [
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
								{!! Form::select('where_photo', $getfroms, 1, ['id'=>'where_photo', 'class'=>'span12 SumoSelect']) !!}
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="tag_content">Thẻ chi tiết <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('tag_content') ? ' error' : '' }}">
								{!! Form::text('tag_content', '', [
									'id'=>'tag_content', 'class'=>'span12', 'required'=>true,
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
								{!! showTrees($categorys, 1, 'cate_id', 'radio', 'Không chọn danh mục') !!}
							</div>
						</div>
						<p class="control-group">
							<label for="tag_remove">Loại bỏ thẻ</label>
							<span class="field">
								{!! Form::textarea('tag_remove', '', [
									'id'=>'tag_remove', 'class'=>'span12', 'rows'=>4, 
									'placeholder'=>'VD: .adv-area; .row-more'
								]) !!}
								<span class="help-inline">Các thẻ (tags) cách nhau bởi dấu ;</span>
							</span>
						</p>
						<p class="control-group">
							<label for="no">Số thứ tự</label>
							<span class="field{{ $errors->has('no') ? ' error' : '' }}">
								{{ Form::number('no', 10, ['id'=>'no', 'class'=>'span4', 'min'=>0, 'max'=>999]) }}
								@if ($errors->has('no'))
								<span class="help-inline">{!! $errors->first('no') !!}</span>
								@endif
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
							{{ Form::button('<span class="iconfa-save"></span> Lưu', ['class' => 'btn btn-primary', 'type' => 'submit']) }} - Or -
							<a href="{!! route('backend.cronjob') !!}" title="Thoát" class="btn"><span class="iconfa-off"></span> Thoát</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}
</div><!--contentinner-->
@endsection