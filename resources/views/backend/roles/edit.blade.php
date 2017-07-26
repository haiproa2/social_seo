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
			@if($updateForm)
			{{ Form::open(['route' => ['backend.role.update', $item->id], 'enctype'=>'multipart/form-data']) }}
			@endif
				<div class="widgetcontent bordered shadowed nopadding">
					<div class="stdform stdform2">
						<p class="control-group">
							<label for="name" style="padding-top: 5px;">Tên nhóm</label>
							<span class="field"><span>{{ $item->name }}</span></span>
						</p>
						<p class="control-group">
							<label for="name" style="padding-top: 10px;">Tên hiển thị</label>
							<span class="field"><span>{!! $item->display_name !!}</span></span>
						</p>
						<p class="control-group">
							<label for="display_name">Tên chi tiết <span class="text-error">*</span></label>
							<span class="field{{ $errors->has('display_name') ? ' error' : '' }}">
								{!! Form::text('display_name', $item->display_name, [
									'id'=>'display_name', 'class'=>'span12', 'autofocus'=>true, 'required'=>true, 'disabled'=>$disabled,
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
								{{ Form::textarea('description', $item->description, ['id'=>'description', 'class'=>'span12', 'rows'=>5, 'disabled'=>$disabled]) }}
								@if ($errors->has('description'))
								<span class="help-inline">{!! $errors->first('description') !!}</span>
								@endif
							</span>
						</p>
						@ability('root,admin', 'v_user')
						<div class="par">
							<label style="padding-top:10px">Danh sách thành viên</label>
							<div class="field">
								@if(count($item->users))
								<ol class="list-ordered">
									@foreach($item->users as $k => $val)
									<li>{!! $val->name !!} ({!! $val->email !!})</li>
									@endforeach
								</ol>
								@else
								Chưa có tài khoản nào.
								@endif
							</div>
						</div>
						@endability
						@if($item->name=='admin')
						<p class="control-group">
							<label style="padding-top: 5px;">Quyền quản trị</label>
							<span class="field">
								<span class="text-success">Toàn quyền quản trị</span>
							</span>
						</p>
						@elseif($item->name=='member')
						<p class="control-group">
							<label style="padding-top: 5px;">Quyền quản trị</label>
							<span class="field">
								<span class="text-info">Chỉ có quền trên tài khoản cá nhân.</span>
							</span>
						</p>
						@elseif(Entrust::ability('root,admin', 'v_permission'))
						{!! showSelectTable($permissions, $permission_role, ($disabled)?'disabled':'') !!}
						@endif
						<p class="stdformbutton">
							@if(isset($item->id))
							{{ Form::hidden('id', $item->id) }}
							@endif
							@if($updateForm)
							{{ Form::button('<span class="iconfa-save"></span> Lưu', ['class' => 'btn btn-primary', 'type' => 'submit']) }} - Or -
							@endif
							<a href="{!! route('backend.role') !!}" title="Thoát" class="btn"><span class="iconfa-off"></span> Thoát</a>
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