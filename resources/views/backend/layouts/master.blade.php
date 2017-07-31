<?php
session_start();
$_SESSION['ckfinder']['isLogged'] = Auth::user()->active;

$_SESSION['ckfinder']['canView'] = true;
$_SESSION['ckfinder']['canCreate'] = true;
$_SESSION['ckfinder']['canEdit'] = Auth::user()->ability('root,admin', 'u_photo');
$_SESSION['ckfinder']['canDelete'] = Auth::user()->ability('root,admin', 'd_photo');
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - {{ config('app.name', 'Laravel') }} [ADMIN AREA]</title>

    <meta name="description" content="{{ $description }}" />

    <link rel="shortcut icon" href="{{ asset('images/admin_favicon.ico') }}" />

    <!-- Styles -->
    <link href="//fonts.googleapis.com/css?family=Roboto:400,700,700i" rel="stylesheet">
    <link href="{{ asset('themes/katniss/css/style.default.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/katniss/prettify/prettify.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/katniss/css/bootstrap-fileupload.min.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/katniss/css/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/sumoselect/sumoselect.min.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/katniss/css/style.custom.css?v='.time()) }}" rel="stylesheet">

    <script type="text/javascript" src="{{ asset('themes/katniss/prettify/prettify.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/katniss/js/jquery-1.9.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/katniss/js/jquery-migrate-1.1.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/katniss/js/jquery-ui-1.9.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/katniss/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/katniss/js/bootstrap-fileupload.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/katniss/js/bootstrap-timepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/katniss/js/jquery.cookie.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/katniss/js/jquery.jgrowl.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/katniss/js/jquery.alerts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/katniss/js/jquery.uniform.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/katniss/js/jquery.flot.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/katniss/js/jquery.flot.pie.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/katniss/js/jquery.flot.resize.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/katniss/js/custom.js?v='.time()) }}"></script>
    @if (session('redirect'))
    <meta http-equiv="refresh" content="{!! session('redirect_second') !!}; url={!! session('redirect') !!}" />
    @endif

    <script type="text/javascript" src="{{ asset('plugins/ckeditor_4.6.0/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/ckfinder_2.6.2.1/ckfinder.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/sumoselect/jquery.sumoselect.min.js') }}"></script>

    <script type="text/javascript">
        var base = "{{ route('fontend.index') }}";
        var route_delete_image = "{{ route('backend.ajax.deleteImage') }}";
        var route_get_slug = "{{ route('backend.ajax.getSlug') }}";
        CKEDITOR.dtd.$removeEmpty['span'] = false;
    </script>

</head>
<body>
	<div class="mainwrapper fullwrapper">
		@include('backend.layouts.menu')

		<div class="rightpanel">
			@include('backend.layouts.header')
            
			@yield('content')
        </div>

        <div class="clearfix"></div>

        @include('backend.layouts.footer')
    </div>
    
    <script type="text/javascript">
        var msg = type = '';
        <?php if (!$errors->isEmpty()){ ?>
        msg = "Đã xảy ra một vài lỗi.<br/>Vui lòng xem lại các trường dữ liệu."; 
        type = "error"; 
        <?php } if (Session::has('flash_type')){ ?>
        msg = '{!! Session::get("flash_messager") !!}'; 
        type = '{{ Session::get("flash_type") }}'; 
        <?php } ?>
    </script>
</body>
</html>