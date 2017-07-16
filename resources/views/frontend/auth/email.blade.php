@extends('frontend.auth.layouts.master')

@section('content')

<div class="loginwrapper">
    <div class="loginwrap zindex100 animate2 bounceInDown">
        <h1 class="logintitle"><span class="iconfa-refresh"></span> Reset Password <span class="subtitle">Hello! Callback password!</span></h1>
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="loginwrapperinner">
            <form id="loginform" action="{{ route('auth.postFormForget') }}" method="post">
                {{ csrf_field() }}
                <div class="control-group animate4 bounceIn{{ $errors->has('email') ? ' error' : '' }}">
                    <input type="text" id="email" name="email" value="{{ old('email') }}" placeholder="{{ trans('auth.placeholder_email') }}" required autofocus />
                    @if ($errors->has('email'))
                    <span class="help-inline">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="control-group animate5 bounceIn">
                    <button class="btn btn-default btn-block">{{ trans('auth.btn_foget_password') }}</button>
                </div>
                <div class="control-group animate6 fadeIn row-fluid">
                    <a href="{{ route('auth.getLogin') }}" class="span6"><span class="icon-arrow-left icon-white"></span> {{ trans('auth.anchor_login') }}</a>
                    <a href="{{ route('auth.getRegister') }}" class="span6 text-right"><span class="icon-pencil icon-white"></span> {{ trans('auth.anchor_register') }}</a>
                </div>
            </form>
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
    
    jQuery('#login,#password').focus(function(){
        if(jQuery(this).hasClass('error')) jQuery(this).removeClass('error');
    });
    
    jQuery('#loginform button').click(function(){
        if(!jQuery.browser.msie) {
            if(jQuery('#login').val() == '' || jQuery('#password').val() == '') {
                if(jQuery('#login').val() == '') jQuery('#login').addClass('error'); else jQuery('#login').removeClass('error');
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
