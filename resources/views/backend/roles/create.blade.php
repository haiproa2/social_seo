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
        <li class="active">Phân quyền</li>
    </ul>
</div><!--breadcrumbs-->
<div class="pagetitle animate4 fadeInUp"><h1>{!! $title !!}</h1> <span>{!! $description !!}</span></div><!--pagetitle-->
<div class="contentinner content-editprofile animate5 fadeInUp">
	<div class="row-fluid">
		<div class="span8 offset2">
			<h4 class="widgettitle nomargin shadowed"></h4>
			{{ Form::open(['route' => ['backend.role.store'], 'enctype'=>'multipart/form-data']) }}
				<div class="widgetcontent bordered shadowed nopadding">
					<div class="stdform stdform2">
						<p class="control-group">
							<label for="name">Tên nhóm <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('name') ? ' error' : '' }}">
								{!! Form::text('name', '', [
									'id'=>'name', 'class'=>'span12', 'autofocus'=>true, 'required'=>true,
									'data-toggle'=>'popfocus', 'title'=>'Hướng dẫn', 'data-content'=>'Tên nhóm<br/>- Cần nhập đầy đủ, tiện việc theo giõi<br/>- Chỉ chứa các ký tự thường, không dấu.<br/>- <span class="text-error"> Yêu cầu bắt buộc.</span>', 'data-placement'=>'bottom', 'data-html'=>'true'
								]) !!}
								@if ($errors->has('name'))
								<span class="help-inline">{!! $errors->first('name') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="display_name">Tên hiển thị <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('display_name') ? ' error' : '' }}">
								{!! Form::text('display_name', '', [
									'id'=>'display_name', 'class'=>'span12', 'autofocus'=>true, 'required'=>true,
									'data-toggle'=>'popfocus', 'title'=>'Hướng dẫn', 'data-content'=>'Tên hiển thị nhóm<br/>- Cần nhập đầy đủ, tiện việc theo giõi<br/>- Nên sử dụng các span class như: <br/><span class="label">label</span> <span class="label label-info">label-info</span> <span class="label label-success">label-success</span> <br/><span class="label label-warning">label-warning</span> <span class="label label-important">label-important</span><br/>- <span class="text-error"> Yêu cầu bắt buộc.</span>', 'data-placement'=>'bottom', 'data-html'=>'true'
								]) !!}
								@if ($errors->has('display_name'))
								<span class="help-inline">{!! $errors->first('display_name') !!}</span>
								@endif
							</span>
						</p>
						<p class="control-group">
							<label for="description">Mô tả chi tiết</label>
							<span class="field{{ $errors->has('description') ? ' error' : '' }}">
								{{ Form::textarea('description', '', ['id'=>'description', 'class'=>'span12', 'rows'=>5, 'disabled'=>$disabled]) }}
								@if ($errors->has('description'))
								<span class="help-inline">{!! $errors->first('description') !!}</span>
								@endif
							</span>
						</p>
						{!! showSelectTable($permissions, $permission_role) !!}
						<p class="stdformbutton">
							{{ Form::button('<span class="iconfa-save"></span> Lưu', ['class' => 'btn btn-primary', 'type' => 'submit']) }} - Or -
							<a href="{!! route('backend.role') !!}" title="Thoát" class="btn"><span class="iconfa-off"></span> Thoát</a>
						</p>
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div><!--row-fluid-->
</div><!--contentinner-->
@endsection