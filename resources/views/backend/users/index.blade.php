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
<div class="pagetitle animate4 fadeInUp">
    <h1>Trang cá nhân</h1> <span>Quản lý và cập nhật tất cả thông tin cá nhân.</span>
</div><!--pagetitle-->
<div class="contentinner content-editprofile animate5 fadeInUp">
	<div class="row-fluid">
		<div class="span12">
			<h4 class="widgettitle nomargin shadowed"></h4>
			{{ Form::open(['route' => 'backend.user.saveDetail']) }}
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
                                		<div class="uneditable-input span12">
                                			<i class="icon-file fileupload-exists"></i>
                                			<span class="fileupload-preview"></span>
                                		</div>
                                		<span class="btn btn-file">
                                			<span class="fileupload-new">Select file</span>
	                                		<span class="fileupload-exists">Change</span>
	                                		<input type="file" />
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
										<span class="span8"><span>{{ Auth::user()->username }}</span></span>
									</p>
									<p class="row-fluid">
										<span class="span4"><label for="name">Họ và tên <span class="text-error">*</span></label></span>
										<span class="span8">{{ Form::text('name', Auth::user()->name, ['id'=>'name', 'class'=>'span12', 'autofocus'=>true, 'required'=>true]) }}</span>
									</p>
									<p class="row-fluid">
										<span class="span4"><label for="email">Địa chỉ Email <span class="text-error">*</span></label></span>
										<span class="span8">{{ Form::email('email', Auth::user()->email, ['id'=>'email', 'class'=>'span12', 'required'=>true]) }}</span>
									</p>
									<p class="row-fluid">
										<span class="span4"><label for="phone">Số điện thoại</label></span>
										<span class="span8">{{ Form::text('phone', Auth::user()->phone, ['id'=>'phone', 'class'=>'span12']) }}</span>
									</p>
									<p class="row-fluid">
										<span class="span4"><label for="birthday">Ngày sinh</label></span>
										<span class="span8">{{ Form::text('birthday', Auth::user()->birthday, ['id'=>'birthday', 'class'=>'span12']) }}</span>
									</p>
									<p class="row-fluid">
										<span class="span4"><label for="sex">Giới tính</label></span>
										<span class="span8">
											<label class="uniform-label">{{ Form::radio('sex', 1, Auth::user()->sex, ['id'=>'sex-1', 'class'=>'span12']) }} Nam</label>
											<label class="uniform-label">{{ Form::radio('sex', 0, Auth::user()->sex, ['id'=>'sex-0', 'class'=>'span12']) }} Nữ</label>
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
												<span class="span8">Đang hoạt động</span>
											</p>
										</div>
									</div>
									<div class="row-fluid">
										<div class="span12">
											<h4>Thay đổi mật khẩu</h4>
											<p class="row-fluid">
												<span class="span4"><label for="new_password">Mật khẩu mới</label></span>
												<span class="span8">{{ Form::password('new_password', ['id'=>'new_password', 'class'=>'span12']) }}</span>
											</p>
											<p class="row-fluid">
												<span class="span4"><label for="comfirm_password">Nhắc lại mật khẩu</label></span>
												<span class="span8">{{ Form::password('comfirm_password', ['id'=>'comfirm_password', 'class'=>'span12']) }}</span>
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
				</div>
			{{ Form::close() }}
		</div>
	</div><!--row-fluid-->
</div><!--contentinner-->
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#birthday").datepicker({
			dateFormat: 'd MM, yy',
			changeMonth: true,
			changeYear: true,
			maxDate: '-12Y'
		});
	});
</script>
@endsection