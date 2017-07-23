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
		<div class="span12">
			<h4 class="widgettitle nomargin shadowed"></h4>
			{{ Form::open(['route' => ['backend.permission.store'], 'enctype'=>'multipart/form-data']) }}
				<div class="widgetcontent bordered">
					<div class="row-fluid">
						<div class="span2">&nbsp;</div>
						<div class="span7">
							<p class="row-fluid">
								<span class="span4"><label for="name">Tên quyền <span class="text-error">*</span></label></span>
								<span class="span8{{ $errors->has('name') ? ' error' : '' }}">
									{!! Form::text('name', '', [
										'id'=>'name', 'class'=>'span12', 'autofocus'=>true, 'required'=>true, 'disabled'=>$disabled,
										'data-toggle'=>'popfocus', 'title'=>'Hướng dẫn', 'data-content'=>'Tên quyền<br/>- Cần nhập đầy đủ, tiện việc theo giõi<br/>- Chỉ chứa các ký tự thường, không dấu.<br/>- Mỗi lần tạo sẽ tạo ra 4 loại quyền: <br/>&nbsp;&nbsp;<span class="iconfa-eye-open" style="color: #00c0ef"></span> Xem, <span class="iconfa-plus text-success"></span> Tạo mới, <span class="iconfa-edit text-warning"></span> Cập nhật, <span class="iconfa-trash text-error"></span> Xóa<br/>- <span class="text-error"> Yêu cầu bắt buộc.</span>', 'data-html'=>'true'
									]) !!}
									@if ($errors->has('name'))
									<span class="help-inline">{!! $errors->first('name') !!}</span>
									@endif
								</span>
							</p>
							<p class="row-fluid">
								<span class="span4"><label for="display_name">Tên hiển thị <span class="text-error">*</span></label></span>
								<span class="span8{{ $errors->has('display_name') ? ' error' : '' }}">
									{!! Form::text('display_name', '', [
										'id'=>'display_name', 'class'=>'span12', 'autofocus'=>true, 'required'=>true, 'disabled'=>$disabled,
										'data-toggle'=>'popfocus', 'title'=>'Hướng dẫn', 'data-content'=>'Tên hiển thị nhóm<br/>- Cần nhập đầy đủ, tiện việc theo giõi<br/>- <span class="text-error"> Yêu cầu bắt buộc.</span>', 'data-html'=>'true'
									]) !!}
									@if ($errors->has('display_name'))
									<span class="help-inline">{!! $errors->first('display_name') !!}</span>
									@endif
								</span>
							</p>
							<p class="row-fluid">
								<span class="span4"><label for="description">Mô tả chi tiết</label></span>
								<span class="span8{{ $errors->has('description') ? ' error' : '' }}">
									{{ Form::textarea('description', '', ['id'=>'description', 'class'=>'span12', 'rows'=>5, 'disabled'=>$disabled]) }}
									@if ($errors->has('description'))
									<span class="help-inline">{!! $errors->first('description') !!}</span>
									@endif
								</span>
							</p>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span2">&nbsp;</div>
						<div class="span7">
							<div class="row-fluid">
								<div class="span4">&nbsp;</div>
								<div class="span8">
									<p class="stdformbutton">
										{{ Form::button('<span class="iconfa-save"></span> Lưu', ['class' => 'btn btn-primary', 'type' => 'submit']) }} - Or -
										<a href="{!! route('backend.permission') !!}" title="Thoát" class="btn"><span class="iconfa-off"></span> Thoát</a>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div><!--row-fluid-->
</div><!--contentinner-->
@endsection