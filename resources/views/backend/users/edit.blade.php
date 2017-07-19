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
        <li class="active">Thành viên</li>
    </ul>
</div><!--breadcrumbs-->
<div class="pagetitle animate4 fadeInUp"><h1>{!! $title !!}</h1> <span>{!! $description !!}</span></div><!--pagetitle-->
<div class="contentinner content-editprofile animate5 fadeInUp">
	<div class="row-fluid">
		<div class="span12">
			<h4 class="widgettitle nomargin shadowed"></h4>
			@if($updateForm)
			{{ Form::open(['route' => ['backend.user.update', $user->id]]) }}
			@endif
				<div class="widgetcontent bordered editprofileform">
					<div class="row-fluid">
						<div class="span3">
							<h4>Ảnh đại diện</h4>
							<div class="profilethumb">
								<a href="">Change Thumbnail</a>
                                <img src="/themes/katniss/img/profilethumb.png" alt="" class="img-polaroid">
							</div>
		    				<div class="row-fluid">
                                <div class="fileupload fileupload-new span12" data-provides="fileupload">
                                	<div class="input-append">
                                		<div class="uneditable-input span12{{ ($disabled)?' disabled':'' }}">
                                			<i class="icon-file fileupload-exists"></i>
                                			<span class="fileupload-preview"></span>
                                		</div>
                                		<span class="btn btn-file{{ ($disabled)?' disabled':'' }}">
                                			<span class="fileupload-new">Select file</span>
	                                		<span class="fileupload-exists">Change</span>
	                                		{{ Form::file('photo', ['id'=>'photo', 'disabled'=>$disabled]) }}
	                                	</span>
                                		<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                	</div>
                                </div>
                            </div>
						</div>
						<div class="span9">
							<div class="row-fluid">
								<div class="span6">
									<h4>Thông tin đăng nhập</h4>
									<p class="row-fluid">
										<span class="span4"><label for="username" style="padding:0px">Tài khoản</label></span>
										<span class="span8"><span>{{ $user->username }}</span></span>
									</p>
									<p class="row-fluid">
										<span class="span4"><label for="name">Họ và tên <span class="text-error">*</span></label></span>
										<span class="span8{{ $errors->has('name') ? ' error' : '' }}">
											{{ Form::text('name', $user->name, ['id'=>'name', 'class'=>'span12', 'autofocus'=>true, 'required'=>true, 'disabled'=>$disabled]) }}
											@if ($errors->has('name'))
											<span class="help-inline">{!! $errors->first('name') !!}</span>
											@endif
										</span>
									</p>
									<p class="row-fluid">
										<span class="span4"><label for="email">Địa chỉ Email <span class="text-error">*</span></label></span>
										<span class="span8{{ $errors->has('email') ? ' error' : '' }}">
											{{ Form::email('email', $user->email, ['id'=>'email', 'class'=>'span12', 'required'=>true, 'disabled'=>$disabled]) }}
											@if ($errors->has('email'))
											<span class="help-inline">{!! $errors->first('email') !!}</span>
											@endif
										</span>
									</p>
									<p class="row-fluid">
										<span class="span4"><label for="telephone">Số điện thoại</label></span>
										<span class="span8{{ $errors->has('telephone') ? ' error' : '' }}">
											{{ Form::text('telephone', $user->telephone, ['id'=>'telephone', 'class'=>'span12', 'disabled'=>$disabled]) }}
											@if ($errors->has('telephone'))
											<span class="help-inline">{!! $errors->first('telephone') !!}</span>
											@endif
										</span>
									</p>
									<p class="row-fluid">
										<span class="span4"><label for="birthday">Ngày sinh</label></span>
										<span class="span8">
											<span class="input-append">
												{{ Form::text('birthday', $user->birthday, ['id'=>'birthday', 'class'=>'one-item with-btn-icon', 'readonly'=>true, 'title'=>'Click để chọn ngày', 'data-toggle'=>'tooltip', 'disabled'=>$disabled]) }}
												<button type="button" class="btn btn-icon disabled"><span class="iconfa-calendar"></span></button>
											</span>
										</span>
									</p>
									<p class="row-fluid">
										<span class="span4"><label for="sex" style="padding:0px">Giới tính</label></span>
										<span class="span8">
											@if(count($sexs))
											@foreach($sexs as $k => $val)
											<label class="uniform-label">{!! Form::radio('sex', $val->id_type, (($user->sex == $val->id_type)?1:0), ['id'=>'sex-'.$val->id_type, 'class'=>'span12', 'disabled'=>$disabled]) !!} {!! $val->value_type !!}</label>
											@endforeach
											@endif
										</span>
									</p>
								</div>
								<div class="span6">
									<div class="row-fluid">
										<div class="span12">
											<h4>Quan trọng</h4>
											<p class="row-fluid">
												<span class="span4">
													<label for="role" style="padding:0px">Nhóm</label>
												</span>
												<span class="span8">--</span>
											</p>
											<p class="row-fluid">
												<span class="span4">
													<label for="status" style="padding:0px">Trạng thái</label>
												</span>
												<span class="span8">
													@if(count($actives))
													@foreach($actives as $k => $val)
													<label class="uniform-label">{!! Form::radio('active', $val->id_type, (($user->active == $val->id_type)?1:0), ['id'=>'active-'.$val->id_type, 'class'=>'span12', 'disabled'=>$disabled]) !!} {!! $val->value_type !!}</label>
													@endforeach
													@endif
												</span>
											</p>
											<div class="alert alert-info">- Điền thông tin vào 2 ô bên dưới để cập nhật mật khẩu. <br/>- Để trống khi không muốn thay đổi.</div>
											<p class="row-fluid">
												<span class="span4"><label for="password">Mật khẩu</label></span>
												<span class="span8{{ $errors->has('password') ? ' error' : '' }}">
													<span class="input-append">
														{{ Form::password('password', ['id'=>'password', 'class'=>'one-item with-btn-icon password_result', 'disabled'=>$disabled]) }}
														<button type="button" class="btn btn-icon {{ ($disabled)?'disabled':'btn-generate-password' }}" rel-class="password_result" title="Tạo ngẫu nhiên" data-toggle="tooltip"><span class="iconfa-random"></span></button>
													</span>
													@if ($errors->has('password'))
													<span class="help-inline">{!! $errors->first('password') !!}</span>
													@endif
												</span>
											</p>
											<p class="row-fluid">
												<span class="span4"><label for="password_confirmation">Nhắc lại mật khẩu</label></span>
												<span class="span8">
													<span class="input-append">
														{{ Form::password('password_confirmation', ['id'=>'password_confirmation', 'class'=>'one-item with-btn-icon password_result', 'disabled'=>$disabled]) }}
														<button type="button" class="btn btn-icon {{ ($disabled)?'disabled':'btn-show-password' }}" rel-class="password_result" title="Click xem mật khẩu" data-toggle="tooltip"><span class="iconfa-eye-close"></span></button>
													</span>
												</span>
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row-fluid">
						<h4>Tự giới thiệu</h4>
						<p>{{ Form::textarea('content', $user->content, ['id'=>'content_user', 'class'=>'span12 ckeditor', 'disabled'=>$disabled]) }}</p>
					</div>					
					<p class="stdformbutton">
						@if(isset($item['id']))
						{{ Form::hidden('id', $item['id']) }}
						@endif
						@if($updateForm)
						{{ Form::button('<span class="iconfa-save"></span> Lưu', ['class' => 'btn btn-primary', 'type' => 'submit']) }} - Or -
						@endif
						<a href="{!! route('backend.user.list') !!}" title="Thoát" class="btn"><span class="iconfa-off"></span> Thoát</a>
					</p>
				</div>
			@if($updateForm)
			{{ Form::close() }}
			@endif
		</div>
	</div><!--row-fluid-->
</div><!--contentinner-->
@endsection