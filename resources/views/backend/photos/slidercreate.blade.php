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
	{{ Form::open(['route' => ['backend.slider.store'], 'enctype'=>'multipart/form-data']) }}
		<div class="row-fluid">
			<div class="span8 offset2">
				<h4 class="widgettitle nomargin shadowed"></h4>
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
								{!! Form::text('title', '', [ 'id'=>'title', 'class'=>'span12', 'autofocus'=>true, 'required'=>true ]) !!}
								@if ($errors->has('title'))
								<span class="help-inline">{!! $errors->first('title') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="slug">Liên kết URL</label>
							<span class="field{{ $errors->has('slug') ? ' error' : '' }}">
								{!! Form::text('slug', '', [ 'id'=>'slug', 'class'=>'span12' ]) !!}
								@if ($errors->has('slug'))
								<span class="help-inline">{!! $errors->first('slug') !!}</span>
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
						<p class="control-group">
							<label>&nbsp;</label>
							<span class="field">
								{{ Form::button('<span class="iconfa-save"></span> Lưu', ['class' => 'btn btn-primary', 'type' => 'submit']) }} - Or -
								<a href="{!! route('backend.slider') !!}" title="Thoát" class="btn"><span class="iconfa-off"></span> Thoát</a>
							</span>
						</p>
					</div>
				</div>
			</div>
		</div><!--row-fluid-->
	{{ Form::close() }}
</div><!--contentinner-->
@endsection