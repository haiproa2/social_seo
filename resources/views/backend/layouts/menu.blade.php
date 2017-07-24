<div class="leftpanel">
    	
    <div class="logopanel animate0 fadeInUp">
    	<h1><a href="{{ route('backend.index') }}">{{ config('app.name', 'Laravel') }} <span>{{ config('app.version', 'v1.0') }}</span></a></h1>
    </div><!--logopanel-->
    
    <div class="datewidget animate2 fadeInUp">Today is {{ date('l, M d, Y H:j:s A', time()) }}</div>

	<div class="searchwidget animate4 fadeInUp">
    	<form action="" method="post">
        	<div class="input-append">
                <input type="text" class="span2 search-query" placeholder="Tìm kiếm menu ...">
                <button type="submit" class="btn"><span class="icon-search"></span></button>
            </div>
        </form>
    </div><!--searchwidget-->
    
    <div class="plainwidget animate6 fadeInUp">
    	<small>Using 16.8 GB of your 51.7 GB </small>
    	<div class="progress progress-info">
            <div class="bar" style="width: 20%"></div>
        </div>
        <small><strong>38% full</strong></small>
    </div><!--plainwidget-->
    <div class="leftmenu animate8 fadeInUp">        
        <ul class="nav nav-tabs nav-stacked">
        	<li class="nav-header">Menu Administrator</li>
            <li{!! ($prefix=='index')?' class="active"':'' !!}><a href="{{ route('backend.index') }}"><span class="icon-home"></span> Trang chủ</a></li>
            @ability('root,admin', 'v_config,u_config')
            <li{!! ($prefix=='config')?' class="active"':'' !!}><a href="{{ route('backend.config') }}"><span class="icon-wrench"></span> Thông tin công ty</a></li>
            @endability
            @ability('root,admin', 'v_permission')
            <li class="{!! (Auth::user()->ability('root,admin', 'v_permission'))?'dropdown':''!!}{!! ($prefix=='role'||$prefix=='permission')?' active':'' !!}"><a href="{{ route('backend.role') }}"><span class="icon-check"></span> Phân quyền</a>
                <ul{!! ($prefix=='role'||$prefix=='permission')?' style="display:block"':'' !!}>
                    <li{!! ($prefix=='permission')?' class="active"':'' !!}><a href="{{ route('backend.permission') }}">Danh sách quyền</a></li>
                    <li{!! ($prefix=='role')?' class="active"':'' !!}><a href="{{ route('backend.role') }}">Danh sách nhóm</a></li>
                </ul>
            </li>
            @endability
            <li class="{!! (Auth::user()->ability('root,admin', 'v_user'))?'dropdown':''!!}{!! ($prefix=='user')?' active':'' !!}"><a href="{{ route('backend.user') }}"><span class="icon-user"></span> Thành viên</a>
                @ability('root,admin', 'v_user')
                <ul{!! ($prefix=='user')?' style="display:block"':'' !!}>
                    <li{!! ($prefix=='user'&&$prefix.$action!='userdetail')?' class="active"':'' !!}><a href="{{ route('backend.user.list') }}">Danh sách thành viên</a></li>
                	<li{!! ($prefix.$action=='userdetail')?' class="active"':'' !!}><a href="{{ route('backend.user') }}">Thông tin cá nhân</a></li>
                </ul>
                @endability
            </li>
        </ul>
    </div><!--leftmenu-->
    
</div>