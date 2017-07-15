@extends('frontend.layouts.auth')

@section('content')

<div class="loginwrapper">
    <div class="loginwrap zindex100 animate2 bounceInDown">
        <h1 class="logintitle"><span class="iconfa-lock"></span> LOGIN <span class="subtitle">Hello! Sign in to get you started!</span></h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="loginwrapperinner">
            {{ Form::open(['route' => 'frontend.user.postLogin', 'id' => 'loginform']) }}
            <div class="par control-group animate4 bounceIn{{ $errors->has('login') ? ' error' : '' }}">
                {{ Form::text('login', '', ['id'=>'login', 'class'=>'form-control', 'placeholder'=>'Tài khoản hoặc Email', 'required'=>true, 'autofocus'=>true]) }}
                @if ($errors->has('login'))
                    <span class="help-inline">{{ $errors->first('login') }}</span>
                @endif
            </div>
            <div class="par control-group animate5 bounceIn{{ $errors->has('password') ? ' error' : '' }}">
                {{ Form::password('password', ['id'=>'password', 'class'=>'form-control', 'placeholder'=>'Mật khẩu', 'required'=>true]) }}
                @if ($errors->has('password'))
                    <span class="help-block">{{ $errors->first('password') }}</span>
                @endif                    
            </div>
            <div class="par control-group animate6 bounceIn">
                <label>{{ Form::checkbox('remember') }} Tự động đăng nhập lần sau</label>
            </div>
            <div class="par control-group animate7 bounceIn">
                <button class="btn btn-default btn-block">Đăng nhập</button>
            </div>
            <div class="par control-group animate8 fadeIn row-fluid">
                <a href="{{ route('password.request') }}" class="span6"><span class="icon-question-sign icon-white"></span> Quên mật khẩu?</a>
                <a href="{{ route('register') }}" class="span6 text-right"><span class="icon-pencil icon-white"></span> Đăng ký</a>
            </div>
            {{ Form::close() }}
        </div><!--loginwrapperinner-->
    </div>
    <div class="loginshadow animate3 fadeInUp"></div>
</div><!--loginwrapper-->

<script type="text/javascript">
    jQuery.noConflict();

    jQuery(document).ready(function(){
        if(jQuery().uniform)
            jQuery('input:checkbox').uniform();
        
        var anievent = (jQuery.browser.webkit)? 'webkitAnimationEnd' : 'animationend';
        jQuery('.loginwrap').bind(anievent,function(){
            jQuery(this).removeClass('animate2 bounceInDown');
        });
        
        jQuery('#username,#password').focus(function(){
            if(jQuery(this).hasClass('error')) jQuery(this).removeClass('error');
        });
        
        jQuery('#loginform button').click(function(){
            if(!jQuery.browser.msie) {
                if(jQuery('#username').val() == '' || jQuery('#password').val() == '') {
                    if(jQuery('#username').val() == '') jQuery('#username').addClass('error'); else jQuery('#username').removeClass('error');
                    if(jQuery('#password').val() == '') jQuery('#password').addClass('error'); else jQuery('#password').removeClass('error');
                    jQuery('.loginwrap').addClass('animate0 wobble').bind(anievent,function(){
                        jQuery(this).removeClass('animate0 wobble');
                    });
                } else {
                    jQuery('.loginwrapper').addClass('animate0 fadeOutUp').bind(anievent,function(){
                        jQuery('#loginform').submit();
                    });
                }
                return false;
            }
        });
    });
</script>
@endsection
