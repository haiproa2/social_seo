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
			@if($updateForm)
			{{ Form::open(['route' => ['backend.permission.update', $item->id], 'enctype'=>'multipart/form-data']) }}
			@endif
				<div class="widgetcontent bordered">
					<div class="row-fluid">
						<div class="span2">&nbsp;</div>
						<div class="span7">
							<p class="row-fluid">
								<span class="span4"><label for="name" style="padding:0px">Tên nhóm</label></span>
								<span class="span8"><span>{{ $item->name }}</span></span>
							</p>
							<p class="row-fluid">
								<span class="span4"><label style="padding:0px">Tên hiển thị</label></span>
								<span class="span8"><span>{!! $item->display_name !!}</span></span>
							</p>
							<p class="row-fluid">
								<span class="span4"><label for="display_name">Tên chi tiết <span class="text-error">*</span></label></span>
								<span class="span8{{ $errors->has('display_name') ? ' error' : '' }}">
									{!! Form::text('display_name', $item->display_name, [
										'id'=>'display_name', 'class'=>'span12', 'autofocus'=>true, 'required'=>true, 'disabled'=>$disabled,
										'data-toggle'=>'popfocus', 'title'=>'Hướng dẫn', 'data-content'=>'Tên hiển thị nhóm<br/>- Cần nhập đầy đủ, tiện việc theo giõi<br/>- Nên sử dụng các span class như: <br/><span class="label">label</span> <span class="label label-info">label-info</span> <span class="label label-success">label-success</span> <br/><span class="label label-warning">label-warning</span> <span class="label label-important">label-important</span><br/>- <span class="text-error"> Yêu cầu bắt buộc.</span>', 'data-html'=>'true'
									]) !!}
									@if ($errors->has('display_name'))
									<span class="help-inline">{!! $errors->first('display_name') !!}</span>
									@endif
								</span>
							</p>
							<p class="row-fluid">
								<span class="span4"><label for="description">Mô tả chi tiết</label></span>
								<span class="span8{{ $errors->has('description') ? ' error' : '' }}">
									{{ Form::textarea('description', $item->description, ['id'=>'description', 'class'=>'span12', 'rows'=>5, 'disabled'=>$disabled]) }}
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
										@if(isset($item->id))
										{{ Form::hidden('id', $item->id) }}
										@endif
										@if($updateForm)
										{{ Form::button('<span class="iconfa-save"></span> Lưu', ['class' => 'btn btn-primary', 'type' => 'submit']) }} - Or -
										@endif
										<a href="{!! route('backend.permission') !!}" title="Thoát" class="btn"><span class="iconfa-off"></span> Thoát</a>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			@if($updateForm)
			{{ Form::close() }}
			@endif
		</div>
	</div><!--row-fluid-->
</div><!--contentinner-->
@endsection