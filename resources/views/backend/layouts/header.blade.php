<div class="headerpanel animate1 fadeInUp">
	<a href="{{ route('fontend.index') }}" title="Show/ Hide menu" class="showmenu"><span class="iconfa-arrow-right"></span></a>
    
    <div class="headerright">
    	<div class="dropdown notification">
            <a class="dropdown-toggle" target="_blank" href="{{ route('fontend.index') }}" title="Xem website">
                <span class="iconsweets-globe iconsweets-white"></span>
            </a>
            <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="{{ route('fontend.index') }}" title="Thông báo">
            	<span class="iconsweets-flag iconsweets-white"></span>
                <b class="caret"></b>
                <span class="notifiNumber label label-success">6</span>
            </a>
            <ul class="dropdown-menu">
            	<li class="nav-header text-center">Có (6) thông báo mới</li>
                <li><a href=""><span class="icon-home"></span> New message from <strong>Jack</strong> <small class="muted"> - 19 hours ago</small></a></li>
                <li><a href=""><span class="icon-envelope"></span> New message from <strong>Daniel</strong> <small class="muted"> - 2 days ago</small></a></li>
                <li><a href=""><span class="icon-user"></span> <strong>Bruce</strong> is now following you <small class="muted"> - 2 days ago</small></a></li>
                <li><a href=""><span class="icon-envelope"></span> New message from <strong>Jack</strong> <small class="muted"> - 19 hours ago</small></a></li>
                <li><a href=""><span class="icon-user"></span> <strong>Bruce</strong> is now following you <small class="muted"> - 2 days ago</small></a></li>
                <li class="viewmore"><a href="">Xem tất cả</a></li>
            </ul>
        </div><!--dropdown-->
        
		<div class="dropdown userinfo"> 
            <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">Hi, {{ Auth::user()->name }}! <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('backend.user') }}">{!! Form::image(Image::url(((isset(Auth::user()->photo) && Auth::user()->photo)?'uploads/'.Auth::user()->photo:''), 50, 50, array('crop')), 'img-polaroid', ['id'=>'img-polaroid', 'class'=>'img-polaroid', 'onclick'=>'return false', 'onError'=>"this.onerror=null;this.src='".Image::url(('images/no-image-available.jpg'), 50, 50, array('crop'))."';"]) !!}<br/>Cập nhật thông tin cá nhân</a></li>
                <li class="divider"></li>
                @role('root')
                <li><a href="{{ route('backend.option') }}"><span class="icon-wrench"></span> Options</a></li>
                <li><a href=""><span class="icon-eye-open"></span> Privacy Settings</a></li>
                <li class="divider"></li>
                @endrole
                <li><a href="{{ route('auth.logout') }}"><span class="icon-off"></span> Đăng xuất</a></li>
            </ul>
        </div><!--dropdown-->	
    </div><!--headerright-->    
</div>