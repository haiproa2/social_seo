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
        <li><a href="{{ route('backend.'.$prefix) }}">{!! $prefix_title !!}</a> <span class="divider">/</span></li>
        <li class="active">Danh mục</li>
    </ul>
</div><!--breadcrumbs-->
<div class="pagetitle animate4 fadeInUp"><h1>{!! $title !!}</h1> <span>{!! $description !!}</span></div><!--pagetitle-->
<div class="contentinner content-editprofile animate5 fadeInUp">
	{{ Form::open(['route' => ['backend.'.$prefix.'.category.store'], 'enctype'=>'multipart/form-data']) }}
		<div class="row-fluid">
			<div class="span8">
				<h4 class="widgettitle nomargin shadowed">Thông tin chính</h4>
				<div class="widgetcontent bordered shadowed nopadding">
					<div class="stdform stdform2">
						<p class="control-group">
							<label for="title">Tiêu đề <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('title') ? ' error' : '' }}">
								{!! Form::text('title', '', [
									'id'=>'title', 'class'=>'span12 slug_source', 'autofocus'=>true, 'required'=>true
								]) !!}
								@if ($errors->has('title'))
								<span class="help-inline">{!! $errors->first('title') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="slug">Liên kết URL <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('slug') ? ' error' : '' }}">
								<span class="input-append">
									{!! Form::text('slug', '', [
										'id'=>'slug', 'class'=>'one-item with-btn-icon slug_result', 'required'=>true
									]) !!}
									<button type="button" class="btn btn-icon btn-generate-slug" data-table="page" data-id="" data-result="slug_result" data-source="slug_source" title="Tạo liên kết URL tự động theo Tiêu đề" data-toggle="tooltip" data-placement="left"><span class="iconfa-refresh"></span></button>
								</span>
								@if ($errors->has('slug'))
								<span class="help-inline">{!! $errors->first('slug') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="seo_title">SEO Title</label>
							<span class="field{{ $errors->has('seo_title') ? ' error' : '' }}">
								{{ Form::text('seo_title', '', ['id'=>'seo_title', 'class'=>'span12']) }}
								@if ($errors->has('seo_title'))
								<span class="help-inline">{!! $errors->first('seo_title') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="seo_keywords">
								SEO Keywords<br/>
								<small> 
									<a href="https://laptrinh-website.com/cach-su-dung-the-meta-keywords/" target="_blank"> Xem hướng dẫn cách khai báo keywords trong seo</a> tối đa 200 ký tự.
								</small>
							</label>
							<span class="field{{ $errors->has('seo_keywords') ? ' error' : '' }}">
								{{ Form::textarea('seo_keywords', '', ['id'=>'seo_keywords', 'class'=>'span12', 'rows'=>4]) }}
								@if ($errors->has('seo_keywords'))
								<span class="help-inline">{!! $errors->first('seo_keywords') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="seo_description">
								SEO Description<br/>
								<small> 
									<a href="https://laptrinh-website.com/cach-su-dung-the-meta-description/" target="_blank"> Xem hướng dẫn cách khai báo description trong seo</a> tối đa 200 ký tự.
								</small>
							</label>
							<span class="field{{ $errors->has('seo_description') ? ' error' : '' }}">
								{{ Form::textarea('seo_description', '', ['id'=>'seo_description', 'class'=>'span12', 'rows'=>4]) }}
								@if ($errors->has('seo_description'))
								<span class="help-inline">{!! $errors->first('seo_description') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="no">Số thứ tự</label>
							<span class="field{{ $errors->has('no') ? ' error' : '' }}">
								{{ Form::number('no', 10, ['id'=>'no', 'class'=>'span6', 'min'=>0, 'max'=>999]) }}
								@if ($errors->has('no'))
								<span class="help-inline">{!! $errors->first('no') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="status" style="padding-top:5px">Trạng thái</label>
							<span class="field">
								@if(count($actives))
								@foreach($actives as $k => $val)
								<label class="uniform-label">{!! Form::radio('active', $val->id_type, (($val->id_type == 1)?1:0), ['id'=>'active-'.$val->id_type, 'class'=>'span12']) !!} {!! $val->value_type !!}</label>
								@endforeach
								@endif
							</span>
						</p>
					</div>
				</div>
			</div>
			<div class="span4">
				<h4 class="widgettitle nomargin shadowed">Danh mục cha</h4>
				<div class="widgetcontent widgetsmall bordered shadowed">
					<div class="{{ $errors->has('template') ? ' error' : '' }}">
					</div>
				</div>
				<h4 class="widgettitle nomargin shadowed">Ảnh đại diện</h4>
				<div class="widgetcontent widgetsmall widgetphoto bordered shadowed">
					<img src="{!! Image::url(('images/no-image-available.jpg'), 230, 230, array('crop')) !!}" alt="Ảnh đại diện" id="thumb" class="thumb">
                    <div class="fileupload fileupload-new {{ $errors->has('photo') ? ' error' : '' }}" data-provides="fileupload">
                    	<div class="input-append">
                    		<div class="uneditable-input span12">
                    			<i class="icon-file fileupload-exists"></i>
                    			<span class="fileupload-preview"></span>
                    		</div>
                    		<span class="btn btn-file{!! ($disabled)?' disabled':'' !!}">
                    			<span class="fileupload-new">Chọn ảnh</span>
                        		<span class="fileupload-exists">Đổi</span>
                        		{{ Form::file('photo', ['id'=>'photo', 'disabled'=>$disabled]) }}
                        	</span>
                    		<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Hủy</a>
                    	</div>
						@if ($errors->has('photo'))
						<span class="help-inline">{!! $errors->first('photo') !!}</span>
						@endif
                    	<small class="help-inline">(Chỉ tải hình ảnh, dung lượng tối đa 3Mb)</small>
                    </div>
				</div>
			</div>
		</div><!--row-fluid-->
		<div class="row-fluid">
			<h4 class="widgettitle nomargin shadowed">Nội dung chi tiết</h4>
			<div class="widgetcontent bordered shadowed nopadding">
				<div class="stdform stdform2">
					{{ Form::textarea('content', '', ['id'=>'content_category', 'class'=>'span12 ckeditor']) }}
					<p class="stdformbutton">
						{{ Form::hidden('template', 1) }}
						{{ Form::button('<span class="iconfa-save"></span> Lưu', ['class' => 'btn btn-primary', 'type' => 'submit']) }} - Or -
						<a href="{!! route('backend.'.$prefix.'.category') !!}" title="Thoát" class="btn"><span class="iconfa-off"></span> Thoát</a>
					</p>
				</div>
			</div>
		</div>
	{{ Form::close() }}
</div><!--contentinner-->
@endsection