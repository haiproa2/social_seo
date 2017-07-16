@extends('frontend.auth.layouts.master')

@section('content')

<div class="loginwrapper">
    <div class="loginwrap zindex100 animate2 bounceInDown">
    <h1 class="logintitle"><span class="iconfa-lock"></span> Sign In <span class="subtitle">Hello! Sign in to get you started!</span></h1>
        <div class="loginwrapperinner">
            <form id="loginform" action="{{ route('auth.postLogin') }}" method="post">
                {{ csrf_field() }}
                <div class="control-group animate4 bounceIn{{ $errors->has('login') ? ' error' : '' }}">
                    <input type="text" id="login" name="login" value="{{ old('login') }}" placeholder="{{ trans('auth.placeholder_login') }}" required autofocus />
                    @if ($errors->has('login'))
                    <span class="help-inline">{!! $errors->first('login') !!}</span>
                    @endif
                </div>
                <div class="control-group animate5 bounceIn{{ $errors->has('password') ? ' error' : '' }}">
                    <input type="password" id="password" name="password" placeholder="{{ trans('auth.placeholder_password') }}" required />
                    @if ($errors->has('password'))
                    <span class="help-inline">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="control-group animate6 bounceIn">
                    <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ trans('auth.text_remember') }}</label>
                </div>
                <div class="control-group animate7 bounceIn">
                    <button class="btn btn-default btn-block">{{ trans('auth.btn_login') }}</button>
                </div>
                <div class="control-group animate8 fadeIn row-fluid">
                    <a href="{{ route('auth.getFormForget') }}" class="span6"><span class="icon-question-sign icon-white"></span> {{ trans('auth.anchor_forgot_pass') }}</a>
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
});
</script>
@endsection
