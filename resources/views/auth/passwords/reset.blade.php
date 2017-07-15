@extends('frontend.layouts.auth')

@section('content')

<div class="loginwrapper">
    <div class="loginwrap zindex100 animate2 bounceInDown">
        <h1 class="logintitle"><span class="iconfa-random"></span> RESET PASSWORD <span class="subtitle">Request a password reset</span></h1>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="loginwrapperinner">
            {{ Form::open(['route' => 'password.request', 'id' => 'loginform']) }}
            <div class="par control-group animate4 bounceIn{{ $errors->has('email') ? ' error' : '' }}">
                {{ Form::email('email', '', ['id'=>'username', 'class'=>'form-control', 'placeholder'=>'Địa chỉ Email', 'required'=>true, 'autofocus'=>true]) }}
                @if ($errors->has('email'))
                    <span class="help-inline">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="par control-group animate5 bounceIn{{ $errors->has('password') ? ' error' : '' }}">
                {{ Form::password('password', ['id'=>'password', 'class'=>'form-control', 'placeholder'=>'Mật khẩu', 'required'=>true]) }}
                @if ($errors->has('password'))
                    <span class="help-block">{{ $errors->first('password') }}</span>
                @endif                    
            </div>
            <div class="par control-group animate6 bounceIn{{ $errors->has('password_confirmation') ? ' error' : '' }}">
                {{ Form::password('password_confirmation', ['id'=>'password-confirm', 'class'=>'form-control', 'placeholder'=>'Lặp lại mật khẩu', 'required'=>true]) }}
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                @endif                    
            </div>
            <div class="par control-group animate7 bounceIn">
                <button type="submit" class="btn btn-default btn-block">Đổi mật khẩu</button>
            </div>
            <div class="par control-group animate8 fadeIn row-fluid">
                <a href="{{ route('login') }}" class="span6"><span class="icon-circle-arrow-left icon-white"></span> Đăng nhập</a>
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
            jQuery('input:checkbox, input:radio, select.uniformselect').uniform();
        
        var anievent = (jQuery.browser.webkit)? 'webkitAnimationEnd' : 'animationend';
        jQuery('.loginwrap').bind(anievent,function(){
            jQuery(this).removeClass('animate2 bounceInDown');
        });
        
        jQuery('#username,#password,#password-confirm').focus(function(){
            if(jQuery(this).hasClass('error')) jQuery(this).removeClass('error');
        });
        
        jQuery('#loginform button').click(function(){
            if(!jQuery.browser.msie) {
                if(jQuery('#username').val() == '' || jQuery('#password').val() == '' || jQuery('#password-confirm').val() == '') {
                    if(jQuery('#username').val() == '') jQuery('#username').addClass('error'); else jQuery('#username').removeClass('error');
                    if(jQuery('#password').val() == '') jQuery('#password').addClass('error'); else jQuery('#password').removeClass('error');
                    if(jQuery('#password-confirm').val() == '') jQuery('#password-confirm').addClass('error'); else jQuery('#password-confirm').removeClass('error');
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