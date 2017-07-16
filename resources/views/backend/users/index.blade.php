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
<div class="pagetitle animate5 fadeInUp">
    <h1>Thông tin cá nhân</h1> <span>Xem chi tiết và cập nhật tất cả thông tin cá nhân.</span>
</div><!--pagetitle-->
<div class="contentinner content-editprofile animate7 fadeInUp">
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
							<div class="text-center hidden" id="area-photo">
								<span class="area-photos" id-img="image" id-thumb="thumb" id-photo="photo" data-width="200" data-height="200" data-type="background" data-startup-path="members/">
									<span class="area-photo">
										<span class="profilethumb">
											<img src="/themes/katniss/img/preview/image.png" alt="Chưa có hình" title="Chọn hình khác" class="chooseFile" id="image">
											<span id="link-upload-image" class="chooseFile" style="display: none;">Chọn hình khác</span>
										</span>
										<small>Click hình ảnh để thay đổi hoặc chỉnh sửa.</small>
										<input id="thumb" name="thumb" type="hidden" value="/uploads/images/members/admin-small(200x200-crop).jpg">
										<input id="photo" name="photo" type="hidden" value="members/admin.jpg">
									</span>
									<a href="choose-photo" class="chooseFile" title="Chọn hình ảnh">Chọn hình ảnh</a> /
									<a href="remove-photo" class="btn-remove-file" title="Loại bỏ ảnh">Loại bỏ ảnh</a>
								</span>
							</div>
						</div>
						<div class="span3">
							<h4>Quan trọng</h4>
						</div>
						<div class="span6"></div>
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div><!--row-fluid-->
</div><!--contentinner-->
@endsection