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
        <li class="active">Thông tin công ty</li>
    </ul>
</div><!--breadcrumbs-->
<div class="pagetitle animate5 fadeInUp"><h1>{!! $title !!}</h1> <span>{!! $description !!}</span></div><!--pagetitle-->
<div class="contentinner content-charts animate7 fadeInUp">
	<div class="row-fluid">
		@if($updateForm)
		{{ Form::open(['route' => ['backend.config.update'], 'enctype'=>'multipart/form-data', 'disabled'=>$disabled]) }}
		@endif
			<div class="stdform stdform2">
				<div id="tabs" class="tab-company">
					<ul>
						<li><a href="#tabs-1">Thông tin công ty</a></li>
						<li><a href="#tabs-2">Thông tin SEO</a></li>
						<li><a href="#tabs-3">Cấu hình website</a></li>
						<li><a href="#tabs-4">Mạng xã hội</a></li>
						<li><a href="#tabs-5">Cấu hình email</a></li>
						<li><a href="#tabs-6">Nội dung footer</a></li>
					</ul>
					<div class="clear"></div>
					<div id="tabs-1">
						<p class="control-group">
							<label for="title">Tên công ty/Tổ chức <span class="text-error">*</span></label>
							<span class="field">
								{!! Form::text('details[title]', (!empty($item['title']))?$item['title']:'', [
									'id'=>'title', 'class'=>'span8', 'autofocus'=>true, 'required'=>true, 'disabled'=>$disabled,
								]) !!}
							</span>
						</p>
						<p class="control-group">
							<label for="address">Địa chỉ</label>
							<span class="field">
								{!! Form::textarea('details[address]', (!empty($item['address']))?$item['address']:'', [
									'id'=>'address', 'class'=>'span8', 'rows'=>3, 'disabled'=>$disabled,
								]) !!}
							</span>
						</p>
						<p class="control-group">
							<label for="google_map">google_map</label>
							<span class="field">
								{!! Form::text('details[google_map]', (!empty($item['google_map']))?$item['google_map']:'', [
									'id'=>'google_map', 'class'=>'span8', 'disabled'=>$disabled,
								]) !!}
							</span>
						</p>
						<p class="control-group">
							<label for="email">Địa chỉ Email <span class="text-error">*</span></label>
							<span class="field">
								{!! Form::email('details[email]', (!empty($item['email']))?$item['email']:'', [
									'id'=>'email', 'class'=>'span8', 'required'=>true, 'disabled'=>$disabled,
								]) !!}
							</span>
						</p>
						<p class="control-group">
							<label for="telephone">Điện thoại</label>
							<span class="field">
								{!! Form::text('details[telephone]', (!empty($item['telephone']))?$item['telephone']:'', [
									'id'=>'telephone', 'class'=>'span8', 'disabled'=>$disabled,
								]) !!}
							</span>
						</p>
						<p class="control-group">
							<label for="hotline">Hotline</label>
							<span class="field">
								{!! Form::text('details[hotline]', (!empty($item['hotline']))?$item['hotline']:'', [
									'id'=>'hotline', 'class'=>'span8', 'disabled'=>$disabled,
								]) !!}
							</span>
						</p>
						<p class="control-group">
							<label for="fax">Fax</label>
							<span class="field">
								{!! Form::text('details[fax]', (!empty($item['fax']))?$item['fax']:'', [
									'id'=>'fax', 'class'=>'span8', 'disabled'=>$disabled,
								]) !!}
							</span>
						</p>
					</div>
					<div id="tabs-2">
						<p class="control-group">
							<label for="seo_title_one">SEO Title</label>
							<span class="field">
								{{ Form::text('details[seo_title_one]', (!empty($item['seo_title_one'])) ? $item['seo_title_one'] : '', ['id' => 'seo_title_one', 'class' => 'span8', 'disabled'=>$disabled]) }}
							</span>
						</p>
						<p class="control-group">
							<label for="seo_keywords_one">SEO Keywords<br>
								<small> 
									<a href="https://laptrinh-website.com/cach-su-dung-the-meta-keywords/" target="_blank"> Xem hướng dẫn cách khai báo từ khóa trong seo</a> tối đa 200 ký tự.
								</small>
							</label>
							<span class="field">
								{{ Form::textarea('details[seo_keywords_one]', (!empty($item['seo_keywords_one'])) ? $item['seo_keywords_one'] : '', ['id' => 'seo_keywords_one', 'class' => 'span8', 'rows' => '3', 'disabled'=>$disabled]) }}
							</span>
						</p>
						<p class="control-group">
							<label for="seo_description_one">SEO Description<br>
								<small>
									<a href="https://laptrinh-website.com/cach-su-dung-the-meta-description/" target="_blank"> Xem hướng dẫn cách khai báo mô tả trong seo</a> tối đa 200 ký tự.
								</small>
							</label>
							<span class="field">
								{{ Form::textarea('details[seo_description_one]', (!empty($item['seo_description_one'])) ? $item['seo_description_one'] : '', ['id' => 'seo_description_one', 'class' => 'span8', 'rows' => '3', 'disabled'=>$disabled]) }}
							</span>
						</p>
						<p class="control-group">
							<label for="seo_script_head">Script Head</label>
							<span class="field">
								{{ Form::textarea('details[seo_script_head]', (!empty($item['seo_script_head'])) ? $item['seo_script_head'] : '', ['id' => 'seo_script_head', 'class' => 'span8', 'rows' => '7', 'disabled'=>$disabled]) }}
							</span>
						</p>
						<p class="control-group">
							<label for="seo_script_body">Script Body</label>
							<span class="field">
								{{ Form::textarea('details[seo_script_body]', (!empty($item['seo_script_body'])) ? $item['seo_script_body'] : '', ['id' => 'seo_script_body', 'class' => 'span8', 'rows' => '7', 'disabled'=>$disabled]) }}
							</span>
						</p>
					</div>
					<div id="tabs-3">
						<p class="control-group">
							<label for="website">Favicon</label>
							<span class="field">
								<?php /*?>
								<span class="area-photos" 
									id-img="favicon_img" id-thumb="favicon_thumb" id-photo="favicon_photo" 
									data-width="30" data-height="30" data-type="background" data-startup-path="">
									<span class="area-photo {{ (!empty($item['favicon']) || old('favicon_thumb')) ?'':'hidden' }}">
										<span class="profilethumb">
											<img src="{{ (old('favicon_thumb')) ? old('favicon_thumb') : Image::url('uploads/images/'.((isset($item['favicon']) && $item['favicon'])?$item['favicon']:''), 30, 30, array('crop')) }}" alt="Chưa có hình" title="Chọn hình khác" class="chooseFile" id="favicon_img">
										</span>
										<small>Click hình ảnh để thay đổi hoặc chỉnh sửa.</small>
										{{ Form::hidden('favicon_thumb', Image::url('uploads/images/'.((isset($item['favicon']) && $item['favicon'])?$item['favicon']:''), 30, 30, array('crop')), ['id' => 'favicon_thumb']) }}
										{{ Form::hidden('details[favicon]', (!empty($item['favicon']))?$item['favicon']:'', ['id' => 'favicon_photo']) }}
									</span>
									<a href="choose-photo" class="chooseFile" title="Chọn hình ảnh">Chọn hình ảnh</a> / 
									<a href="remove-photo" class="btn-remove-file" title="Loại bỏ ảnh">Loại bỏ ảnh</a>
								</span>
								<?php */ ?>
							</span>
						</p>
						<p class="control-group">
							<label for="website">Địa chỉ Website</label>
							<span class="field">
								{{ Form::text('details[website]', (!empty($item['website'])) ? $item['website'] : '', ['id' => 'website', 'class' => 'span8']) }}
							</span>
						</p>
						<p class="control-group">
							<label for="online_count">Số người online thêm</label>
							<span class="field">
								{{ Form::text('details[online_count]', (!empty($item['online_count'])) ? $item['online_count'] : '', ['id' => 'online_count', 'class' => 'span8']) }}
							</span>
						</p>
						<p class="control-group">
							<label for="per_page_news">Số bài viết / Trang</label>
							<span class="field">
								{{ Form::text('details[per_page_news]', (!empty($item['per_page_news'])) ? $item['per_page_news'] : '', ['id' => 'per_page_news', 'class' => 'span8']) }}
							</span>
						</p>
						<p class="control-group">
							<label for="per_page_news">Copy nội dung</label>
							<span class="field">
								<label for="copywriter-0">
									{{ Form::radio('details[copywriter]', 0, (empty($item['copywriter']) || @$item['copywriter'] == 0) ? 'true' : '', ['id' => 'copywriter-0']) }} Được phép copy
								</label>
								<label for="copywriter-1">
									{{ Form::radio('details[copywriter]', 1, (!empty($item['copywriter']) && $item['copywriter'] == 1) ? 'true' : '', ['id' => 'copywriter-1']) }} Không được copy
								</label>
							</span>
						</p>
					</div>
					<div id="tabs-4">
						<p class="control-group">
							<label for="facebook">Fanpage</label>
							<span class="field">
								{{ Form::text('details[facebook]', (!empty($item['facebook'])) ? $item['facebook'] : '', ['id' => 'facebook', 'class' => 'span8']) }}
							</span>
						</p>
						<p class="control-group">
							<label for="youtube">Youtube Channel</label>
							<span class="field">
								{{ Form::text('details[youtube]', (!empty($item['youtube'])) ? $item['youtube'] : '', ['id' => 'youtube', 'class' => 'span8']) }}
							</span>
						</p>
						<p class="control-group">
							<label for="google_plus">Google plus</label>
							<span class="field">
								{{ Form::text('details[google_plus]', (!empty($item['google_plus'])) ? $item['google_plus'] : '', ['id' => 'google_plus', 'class' => 'span8']) }}
							</span>
						</p>
						<p class="control-group">
							<label for="twitter">Twitter</label>
							<span class="field">
								{{ Form::text('details[twitter]', (!empty($item['twitter'])) ? $item['twitter'] : '', ['id' => 'twitter', 'class' => 'span8']) }}
							</span>
						</p>
					</div>
					<div id="tabs-5">
						<div class="alert alert-info">
							Đây là khu vực cấu hình các thông số để có thể <b>gửi dữ liệu từ các form</b> trong website cho email người quản trị website: {{(!empty($item['email'])) ? $item['email'] : ''}}.
						</div>
						<div>
							<p class="control-group">
								<label for="email_title_one">Tên hiển thị</label>
								<span class="field">
									{{ Form::text('details[email_title_one]', (!empty($item['email_title_one'])) ? $item['email_title_one'] : '', ['id' => 'email_title_one', 'class' => 'span5']) }}
								</span>
							</p>
							<p class="control-group">
								<label for="email_host">Server / IP Send mail</label>
								<span class="field">
									{{ Form::text('details[email_host]', (!empty($item['email_host'])) ? $item['email_host'] : '', ['id' => 'email_host', 'class' => 'span5']) }}
								</span>
							</p>
							<p class="control-group">
								<label for="email_account">Account email</label>
								<span class="field">
									{{ Form::text('details[email_account]', (!empty($item['email_account'])) ? $item['email_account'] : '', ['id' => 'email_account', 'class' => 'span5']) }}
								</span>
							</p>
							<p class="control-group">
								<label for="email_password">Password email</label>
								<span class="field">
									{{ Form::text('details[email_password]', (!empty($item['email_password'])) ? $item['email_password'] : '', ['id' => 'email_password', 'class' => 'span5']) }}
								</span>
							</p>
						</div>
					</div>
					<div id="tabs-6">
						{{ Form::textarea('details[footer_one]', (!empty($item['footer_one'])) ? $item['footer_one'] : '', ['id' => 'footer_one', 'class' => 'ckeditor', 'rows' => '20']) }}
					</div>
				</div>
			</div>
			<p class="stdformbutton">
				@if($updateForm)
				{{ Form::button('<span class="iconfa-save"></span> Lưu', ['class' => 'btn btn-primary', 'type' => 'submit']) }} - Or -
				@endif
				{{ Form::button('<span class="iconfa-off"></span> Thoát', ['class' => 'btn', 'onclick' => "javascript:window.location='".route('backend.index')."'"]) }}
			</p>
		@if($updateForm)
		{!! Form::close() !!}
		@endif
	</div><!--row-fluid-->
</div><!--contentinner-->
@endsection