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
        <li class="active">Option</li>
    </ul>
</div><!--breadcrumbs-->
<div class="pagetitle animate4 fadeInUp"><h1>{!! $title !!}</h1> <span>{!! $description !!}</span></div><!--pagetitle-->
<div class="contentinner content-editprofile animate5 fadeInUp">
	<div class="row-fluid">
		<div class="span8 offset2">
			<h4 class="widgettitle nomargin shadowed"></h4>
			@if($updateForm)
			{{ Form::open(['route' => ['backend.option.update', $item->id], 'enctype'=>'multipart/form-data']) }}
			@endif
				<div class="widgetcontent bordered shadowed nopadding">
					<div class="stdform stdform2">
						<p class="control-group">
							<label for="name" style="padding-top: 5px;">Loại</label>
							<span class="field"><span>{{ $item->type }}</span></span>
						</p>
						<p class="control-group">
							<label for="id_type">ID <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('id_type') ? ' error' : '' }}">
								{!! Form::text('id_type', $item->id_type, [
									'id'=>'id_type', 'class'=>'span12', 'autofocus'=>true, 'required'=>true, 'disabled'=>$disabled,
									'data-toggle'=>'popfocus', 'title'=>'Hướng dẫn', 'data-content'=>'Tên hiển thị nhóm<br/>- Cần nhập đầy đủ, tiện việc theo giõi<br/>- Nên sử dụng các span class như: <br/><span class="label">label</span> <span class="label label-info">label-info</span> <span class="label label-success">label-success</span> <br/><span class="label label-warning">label-warning</span> <span class="label label-important">label-important</span><br/>- <span class="text-error"> Yêu cầu bắt buộc.</span>', 'data-placement'=>'bottom', 'data-html'=>'true'
								]) !!}
								@if ($errors->has('id_type'))
								<span class="help-inline">{!! $errors->first('id_type') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="value_type">Giá trị <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('value_type') ? ' error' : '' }}">
								{{ Form::text('value_type', $item->value_type, ['id'=>'value_type', 'class'=>'span12', 'disabled'=>$disabled]) }}
								@if ($errors->has('value_type'))
								<span class="help-inline">{!! $errors->first('value_type') !!}</span>
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
							<span class="field">
								@if(isset($item->id))
								{{ Form::hidden('id', $item->id) }}
								@endif
								@if($updateForm)
								{{ Form::button('<span class="iconfa-save"></span> Lưu', ['class' => 'btn btn-primary', 'type' => 'submit']) }} - Or -
								@endif
								<a href="{!! route('backend.option') !!}" title="Thoát" class="btn"><span class="iconfa-off"></span> Thoát</a>
							</span>
						</p>
					</div>
				</div>
			@if($updateForm)
			{{ Form::close() }}
			@endif
		</div>
	</div><!--row-fluid-->
</div><!--contentinner-->
@endsection