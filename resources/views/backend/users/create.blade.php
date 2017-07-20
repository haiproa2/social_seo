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
			{{ Form::open(['route' => 'backend.user.store', 'enctype'=>'multipart/form-data', 'file'=>true]) }}
				<div class="widgetcontent bordered editprofileform">
					<div class="row-fluid">
						<div class="span3">
							<h4>Ảnh đại diện</h4>
							<div class="profilethumb">
								{!! Form::image(Image::url(('/themes/katniss/img/profilethumb.png'), 230, 230, array('crop')), 'img-polaroid', ['id'=>'img-polaroid', 'class'=>'img-polaroid', 'onclick'=>'return false']) !!}
							</div>
		    				<div class="row-fluid">
                                <div class="fileupload fileupload-new span12{{ $errors->has('photo') ? ' error' : '' }}" data-provides="fileupload">
                                	<div class="input-append">
                                		<div class="uneditable-input span12">
                                			<i class="icon-file fileupload-exists"></i>
                                			<span class="fileupload-preview"></span>
                                		</div>
                                		<span class="btn btn-file">
                                			<span class="fileupload-new">Select file</span>
	                                		<span class="fileupload-exists">Change</span>
	                                		{{ Form::file('photo', ['id'=>'photo']) }}
	                                	</span>
                                		<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                	</div>
									@if ($errors->has('photo'))
									<span class="help-inline">{!! $errors->first('photo') !!}</span>
									@endif
                                	<small class="help-inline">(Chỉ tải hình ảnh, dung lượng tối đa 3Mb)</small>
                                </div>
                            </div>
						</div>
						<div class="span9">
							<div class="row-fluid">
								<div class="span6">
									<h4>Thông tin cá nhân</h4>
									<p class="row-fluid">
										<span class="span4"><label for="name">Họ và tên <span class="text-error">*</span></label></span>
										<span class="span8{{ $errors->has('name') ? ' error' : '' }}">
											{{ Form::text('name', '', [
												'id'=>'name', 'class'=>'span12', 'autofocus'=>true, 'required'=>true, 
												'data-toggle'=>'popfocus', 'title'=>'Hướng dẫn', 'data-content'=>'Họ và tên thành viên<br/>- Cần nhập đầy đủ, tiện việc liên hệ<br/>- <span class="text-error"> Yêu cầu bắt buộc.</span>', 'data-html'=>'true'
											]) }}
											@if ($errors->has('name'))
											<span class="help-inline">{!! $errors->first('name') !!}</span>
											@endif
										</span>
									</p>
									<p class="row-fluid">
										<span class="span4"><label for="telephone">Số điện thoại</label></span>
										<span class="span8{{ $errors->has('telephone') ? ' error' : '' }}">
											{{ Form::text('telephone', '', ['id'=>'telephone', 'class'=>'span12']) }}
											@if ($errors->has('telephone'))
											<span class="help-inline">{!! $errors->first('telephone') !!}</span>
											@endif
										</span>
									</p>
									<p class="row-fluid">
										<span class="span4"><label for="birthday">Ngày sinh</label></span>
										<span class="span8">
											<span class="input-append">
												{{ Form::text('birthday', '', ['id'=>'birthday', 'class'=>'one-item with-btn-icon input-datepicker', 'readonly'=>true]) }}
												<button type="button" class="btn btn-icon btn-datepicker" title="Click để chọn ngày" data-toggle="tooltip" data-placement="left"><span class="iconfa-calendar"></span></button>
											</span>
										</span>
									</p>
									<p class="row-fluid">
										<span class="span4"><label for="sex" style="padding:0px">Giới tính</label></span>
										<span class="span8">
											@if(count($sexs))
											@foreach($sexs as $k => $val)
											<label class="uniform-label">{!! Form::radio('sex', $val->id_type, (($val->id_type==1)?1:0), ['id'=>'sex-'.$val->id_type, 'class'=>'span12']) !!} {!! $val->value_type !!}</label>
											@endforeach
											@endif
										</span>
									</p>
									<p class="row-fluid">
										<span class="span4"><label for="no">Số thứ tự</label></span>
										<span class="span8{{ $errors->has('no') ? ' error' : '' }}">
											{{ Form::number('no', 1, ['id'=>'no', 'class'=>'span6', 'min'=>0, 'max'=>999]) }}
											@if ($errors->has('no'))
											<span class="help-inline">{!! $errors->first('no') !!}</span>
											@endif
										</span>
									</p>
									<p class="row-fluid">
										<span class="span4">
											<label for="status" style="padding:0px">Trạng thái</label>
										</span>
										<span class="span8">
											@if(count($actives))
											@foreach($actives as $k => $val)
											<label class="uniform-label">{!! Form::radio('active', $val->id_type, (($val->id_type == 1)?1:0), ['id'=>'active-'.$val->id_type, 'class'=>'span12']) !!} {!! $val->value_type !!}</label>
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
													<label for="role">Nhóm</label>
												</span>
												<span class="span8{{ $errors->has('role') ? ' error' : '' }}">
													{{ Form::text('role', '--', ['id'=>'role', 'class'=>'span12', 'required'=>true]) }}
													@if ($errors->has('role'))
													<span class="help-inline">{!! $errors->first('role') !!}</span>
													@endif
												</span>
											</p>
											<p class="row-fluid">
												<span class="span4"><label for="username">Tài khoản <span class="text-error">*</span></label></span>
												<span class="span8{{ $errors->has('username') ? ' error' : '' }}">
													{{ Form::text('username', '', [
														'id'=>'username', 'class'=>'span12', 'required'=>true,
														'data-toggle'=>'popfocus', 'title'=>'Hướng dẫn', 'data-content'=>'Tài khoản đăng nhập website<br/>- Không chứa các ký tự đặc biệt, chỉ bao gồm các ký tự thường hoặc số, viết liền và không có dấu.<br/>- Ví dụ: taikhoandangnhap<br/>- <span class="text-error"> Yêu cầu bắt buộc.</span>', 'data-placement'=>'left', 'data-html'=>'true'
													]) }}
													@if ($errors->has('username'))
													<span class="help-inline">{!! $errors->first('username') !!}</span>
													@endif
												</span>
											</p>
											<p class="row-fluid">
												<span class="span4"><label for="email">Địa chỉ Email <span class="text-error">*</span></label></span>
												<span class="span8{{ $errors->has('email') ? ' error' : '' }}">
													{{ Form::email('email', '', [
														'id'=>'email', 'class'=>'span12', 'required'=>true, 
														'data-toggle'=>'popfocus', 'title'=>'Hướng dẫn', 'data-content'=>'Địa chỉ Email thành viên<br/>- Nhập đúng Email đang được sử dụng.<br/>- Email này có thể dùng để gửi yêu cầu tạo mật khẩu mới khi quên mật khẩu cũ.<br/>- Có thể dùng Email để đăng nhập website thay cho tài khoản.<br/>- <span class="text-error"> Yêu cầu bắt buộc.</span>', 'data-placement'=>'left', 'data-html'=>'true'
													]) }}
													@if ($errors->has('email'))
													<span class="help-inline">{!! $errors->first('email') !!}</span>
													@endif
												</span>
											</p>
											<p class="row-fluid">
												<span class="span4"><label for="password">Mật khẩu <span class="text-error">*</span></label></span>
												<span class="span8{{ $errors->has('password') ? ' error' : '' }}">
													<span class="input-append">
														{{ Form::password('password', [
															'id'=>'password', 'class'=>'one-item with-btn-icon password_result', 'required'=>true,
															'data-toggle'=>'popfocus', 'title'=>'Hướng dẫn', 'data-content'=>'Mật khẩu đăng nhập website<br/>- Cần tối thiểu 6 ký tự.<br/>- Bao gồm các ký tự thường, Hoa, số và các ký tự đặc biệt như: ~!@#$%^&*<br/>- Click <span class="iconfa-random"></span> kế bên để tạo mật khẩu đúng yêu cầu và đảm bảo độ bảo mật cao.<br/>- <span class="text-error"> Yêu cầu bắt buộc.</span>', 'data-placement'=>'left', 'data-html'=>'true'
														]) }}
														<button type="button" class="btn btn-icon {{ ($disabled)?'disabled':'btn-generate-password' }}" rel-class="password_result" title="Click tạo mật khẩu ngẫu nhiên" data-toggle="tooltip" data-placement="left"><span class="iconfa-random"></span></button>
													</span>
													@if ($errors->has('password'))
													<span class="help-inline">{!! $errors->first('password') !!}</span>
													@endif
												</span>
											</p>
											<p class="row-fluid">
												<span class="span4"><label for="password_confirmation">Nhắc lại mật khẩu <span class="text-error">*</span></label></span>
												<span class="span8">
													<span class="input-append">
														{{ Form::password('password_confirmation', [
															'id'=>'password_confirmation', 'class'=>'one-item with-btn-icon password_result', 'required'=>true,
															'data-toggle'=>'popfocus', 'title'=>'Hướng dẫn', 'data-content'=>'Nhắc lại mật khẩu<br/>- Cần trùng khớp với mật khẩu bên trên<br/>- Click <span class="iconfa-eye-close"></span> kế bên để Xem/Ẩn mật khẩu.<br/>- <span class="text-error"> Yêu cầu bắt buộc.</span>', 'data-placement'=>'left', 'data-html'=>'true'
														]) }}
														<button type="button" class="btn btn-icon {{ ($disabled)?'disabled':'btn-show-password' }}" rel-class="password_result" title="Click xem mật khẩu" data-toggle="tooltip" data-placement="left"><span class="iconfa-eye-close"></span></button>
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
						<p>{{ Form::textarea('content', '', ['id'=>'content_user', 'class'=>'span12 ckeditor']) }}</p>
					</div>					
					<p class="stdformbutton">
						{{ Form::button('<span class="iconfa-save"></span> Lưu', ['class' => 'btn btn-primary', 'type' => 'submit']) }} - Or -
						<a href="{!! route('backend.user.list') !!}" title="Thoát" class="btn"><span class="iconfa-off"></span> Thoát</a>
					</p>
				</div>
			{{ Form::close() }}
		</div>
	</div><!--row-fluid-->
</div><!--contentinner-->
@endsection