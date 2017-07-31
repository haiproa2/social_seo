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
        <li class="active">Hình ảnh</li>
    </ul>
</div><!--breadcrumbs-->
<div class="pagetitle animate4 fadeInUp"><h1>{!! $title !!}</h1> <span>{!! $description !!}</span></div><!--pagetitle-->
<div class="contentinner content-editprofile animate5 fadeInUp">
	@if($updateForm)
	{{ Form::open(['route' => ['backend.slider.update', $item->id], 'enctype'=>'multipart/form-data']) }}
	@endif
		<div class="row-fluid">
			<div class="span4">
				<h4 class="widgettitle nomargin shadowed">Ảnh đại diện</h4>
				<div class="widgetcontent widgetsmall widgetphoto bordered shadowed">
					<img src="{!! Image::url(((isset($item->photo) && $item->photo)?'uploads/'.$item->photo:''), 310, 230, array('crop')) !!}" alt="Avatar" class="thumb img-polaroid" onError="this.onerror=null;this.src='{!! Image::url(('images/no-image-available.jpg'), 310, 230, array('crop')) !!}';">
					@if(isset($item->photo) && $item->photo)
					<div class="info-photo">
						<a class="btn btn-small btn-info" href="{!! asset('uploads/'.$item->photo) !!}" target="_blank" title="Xem ảnh"><span class="iconfa-eye-open"></span> Xem ảnh gốc</a>
					</div>
					@endif
				</div>
			</div>
			<div class="span8">
				<h4 class="widgettitle nomargin shadowed">Thông tin chính</h4>
				<div class="widgetcontent bordered shadowed nopadding">
					<div class="stdform stdform2">
						<p class="control-group">
							<label for="photo">Hình ảnh <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('photo') ? ' error' : '' }}">
								<span class="fileupload fileupload-new" data-provides="fileupload">
			                    	<span class="input-append">
			                    		<span class="uneditable-input span12">
			                    			<i class="icon-file fileupload-exists"></i>
			                    			<span class="fileupload-preview"></span>
			                    		</span>
			                    		<span class="btn btn-file{!! ($disabled)?' disabled':'' !!}">
			                    			<span class="fileupload-new">Chọn ảnh</span>
			                        		<span class="fileupload-exists">Đổi</span>
			                        		{{ Form::file('photo', ['id'=>'photo', 'disabled'=>$disabled]) }}
			                        	</span>
			                    		<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Hủy</a>
			                    	</span>
			                    	<small class="help-inline">(Chỉ tải hình ảnh, dung lượng tối đa 3Mb)</small>
									@if ($errors->has('photo'))
									<span class="help-inline">{!! $errors->first('photo') !!}</span>
									@endif
			                    </span>
							</span>
						</p>
						<p class="control-group">
							<label for="title">Tiêu đề <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('title') ? ' error' : '' }}">
								{!! Form::text('title', $item->title, [
									'id'=>'title', 'class'=>'span12 slug_source', 'autofocus'=>true, 'required'=>true, 'disabled'=>$disabled
								]) !!}
								@if ($errors->has('title'))
								<span class="help-inline">{!! $errors->first('title') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="slug">Liên kết URL</label>
							<span class="field{{ $errors->has('slug') ? ' error' : '' }}">
								{!! Form::text('slug', $item->slug, [
									'id'=>'slug', 'class'=>'span12', 'disabled'=>$disabled
								]) !!}
								@if ($errors->has('slug'))
								<span class="help-inline">{!! $errors->first('slug') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="no">Số thứ tự</label>
							<span class="field{{ $errors->has('no') ? ' error' : '' }}">
								{{ Form::number('no', $item->no, ['id'=>'no', 'class'=>'span6', 'min'=>0, 'max'=>999, 'disabled'=>$disabled]) }}
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
								<label class="uniform-label">{!! Form::radio('active', $val->id_type, (($item->active == $val->id_type)?1:0), ['id'=>'active-'.$val->id_type, 'class'=>'span12', 'disabled'=>$disabled]) !!} {!! $val->value_type !!}</label>
								@endforeach
								@endif
							</span>
						</p>
						<p class="control-group">
							<label>&nbsp;</label>
							<span class="field">
								@if($updateForm)
								{{ Form::button('<span class="iconfa-save"></span> Lưu', ['class' => 'btn btn-primary', 'type' => 'submit']) }} - Or -
								@endif
								<a href="{!! route('backend.slider') !!}" title="Thoát" class="btn"><span class="iconfa-off"></span> Thoát</a>
							</span>
						</p>
					</div>
				</div>
			</div>
		</div><!--row-fluid-->
	@if($updateForm)
	{{ Form::close() }}
	@endif
</div><!--contentinner-->
@endsection