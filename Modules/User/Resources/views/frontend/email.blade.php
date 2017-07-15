@extends('frontend.layouts.auth')

@section('content')

<div class="loginwrapper">
    <div class="loginwrap zindex100 animate2 bounceInDown">
        <h1 class="logintitle"><span class="iconfa-question-sign"></span> PASSWORD RESET <span class="subtitle">Request a password reset!</span></h1>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="loginwrapperinner">
            {{ Form::open(['route' => 'password.email', 'id' => 'loginform']) }}
            <div class="par control-group animate4 bounceIn{{ $errors->has('email') ? ' error' : '' }}">
                {{ Form::email('email', '', ['id'=>'email', 'class'=>'form-control', 'placeholder'=>'Địa chỉ Email', 'required'=>true, 'autofocus'=>true]) }}
                @if ($errors->has('email'))
                    <span class="help-inline">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="par control-group animate5 bounceIn">
                <button class="btn btn-default btn-block">Gửi yêu cầu lấy mật khẩu</button>
            </div>
            <div class="par control-group animate6 fadeIn row-fluid">
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
        
        var anievent = (jQuery.browser.webkit)? 'webkitAnimationEnd' : 'animationend';
        jQuery('.loginwrap').bind(anievent,function(){
            jQuery(this).removeClass('animate2 bounceInDown');
        });
        
        jQuery('#email').focus(function(){
            if(jQuery(this).hasClass('error')) jQuery(this).removeClass('error');
        });
        
        jQuery('#loginform button').click(function(){
            if(!jQuery.browser.msie) {
                if(jQuery('#email').val() == '') {
                    if(jQuery('#email').val() == '') jQuery('#email').addClass('error'); else jQuery('#email').removeClass('error');
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