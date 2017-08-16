<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta name="robots" content="noindex, nofollow" />
    <meta charset="UTF-8" />
    <meta name="geo.region" content="VN-SG" />
    <meta name="geo.placename" content="Hồ Chí Minh" />
    <meta name="geo.position" content="10.7765;106.7009" />
    <meta name="ICBM" content="10.7765, 106.7009" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="revisit-after" content="1 days" />
    <base href="{{ route('frontend.index') }}"  />
    <meta property="fb:app_id" content="1438511629777919" />

    <title>{{ $title }}</title>
    
    <meta name="keywords" content="{{ $keywords }}"/>
    <meta name="description" content="{{ $description }}"/>
    <link rel="author" href="{{ route('frontend.index') }}"/>
    <meta name="author" content="{{ route('frontend.index') }}" />
    <meta name="copyright" content="Vũ Minh Hải [minhhai.dw@gmail.com]" />

    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $title }}" />
    <meta property="og:keywords" content="{{ $keywords }}" />
    <meta property="og:description" content="{{ $description }}" />
    <meta property="og:image" content="{{ $image }}" />

    <link href="{!! Image::url(((isset($favicon) && $favicon)?'uploads/'.$favicon:''), 50, 50, array('crop')) !!}" rel="shortcut icon">

    <link href="//fonts.googleapis.com/css?family=Roboto:400,400i,700,700i" rel="stylesheet">

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    {!! $company['seo_script_head'] !!}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        
    <link rel="stylesheet" href="{{ asset('plugins/owl.carousel.2.0.0/assets/owl.carousel.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/owl.carousel.2.0.0/assets/owl.carousel.theme.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/fancybox-2.1.6/source/jquery.fancybox.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/style.css?v='.time()) }}" type="text/css" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <?php /*if($_SERVER['SERVER_NAME']!="localhost"&&$_SESSION[$login_name]['username']!="quanly") { ?>
    <script src="//apis.google.com/js/platform.js" async defer></script>
    <style>
    body{-webkit-touch-callout: none; -webkit-user-select: none;  -moz-user-select: none; -ms-user-select: none;  -o-user-select: none; user-select: none;}
    </style>
    <script language='JavaScript'>
        function disableIE() {if (document.all) {return false;} }
        function disableNS(e) {
            if (document.layers||(document.getElementById&&!document.all)) {
                if (e.which==2||e.which==3) {return false;}
            }
        }
        if (document.layers) {
            document.captureEvents(Event.MOUSEDOWN);document.onmousedown=disableNS;
        } else {
            document.onmouseup=disableNS;document.oncontextmenu=disableIE;
        }
        document.oncontextmenu=new Function("return false");
    </script>
    <?php }*/ ?>
</head>
<body>
    <div id="page">
        <div style="display:none;!important">
            {!! $company['seo_script_body'] !!}
            <!-- facebook -->
            <div id="fb-root"></div>
            <script>
            (function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5&appId=311099908904306";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            </script>
            <!-- google plus -->
            <script src="//apis.google.com/js/platform.js" async defer> {lang: 'vi'} </script>
        </div>
    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')
</body>
</html>