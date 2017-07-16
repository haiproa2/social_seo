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
            <li{!! ($com=='index')?' class="active"':'' !!}><a href="{{ route('backend.index') }}"><span class="icon-align-justify"></span> Dashboard</a></li>
            <li class="dropdown{!! ($com=='user')?' active':'' !!}"><a href="{{ route('backend.user') }}"><span class="icon-user"></span> Thành viên</a>
            	<ul{!! ($com=='user')?' style="display:block"':'' !!}>
                	<li{!! ($com_type=='user_detail')?' class="active"':'' !!}><a href="{{ route('backend.user') }}">Thông tin cá nhân</a></li>
                </ul>
            </li>
        </ul>
    </div><!--leftmenu-->
    
</div>