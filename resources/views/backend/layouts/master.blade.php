<?php
session_start();
    $_SESSION['ckfinder']['isLogged'] = Auth::user()->active;

    $_SESSION['ckfinder']['canView'] = Auth::user()->active;
    $_SESSION['ckfinder']['canCreate'] = Auth::user()->active;
    $_SESSION['ckfinder']['canEdit'] = Auth::user()->active;
    $_SESSION['ckfinder']['canDelete'] = Auth::user()->active;
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title_bar }} {{ config('app.name', 'Laravel') }} [ADMIN AREA]</title>

    <!-- Styles -->
    <link href="{{ asset('themes/katniss/css/style.default.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/katniss/prettify/prettify.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/katniss/css/bootstrap-fileupload.min.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/katniss/css/bootstrap-timepicker.min.css') }}" rel="stylesheet">
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

    <script type="text/javascript">
        var base = "{{ route('fontend.index') }}";
    </script>

    <script type="text/javascript" src="{{ asset('plugins/ckeditor_4.6.0/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/ckfinder_2.6.2.1/ckfinder.js') }}"></script>

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
</body>
</html>