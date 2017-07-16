@extends('frontend.auth.layouts.master')

@section('content')

<div class="loginwrapper">
    <div class="loginwrap zindex100 animate2 bounceInDown">
    <h1 class="logintitle"><span class="iconfa-magic"></span> Reset password <span class="subtitle">Hello! Get new a account!</span></h1>
        <div class="loginwrapperinner">
            <form id="loginform" action="{{ route('auth.postRequest') }}" method="post">
                {{ csrf_field() }}
                <div class="control-group animate4 bounceIn{{ $errors->has('name') ? ' error' : '' }}">
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="{{ trans('auth.placeholder_name') }}" required autofocus />
                    @if ($errors->has('name'))
                    <span class="help-inline">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="control-group animate5 bounceIn">
                    <input type="password" id="password" name="password" placeholder="{{ trans('auth.placeholder_password') }}" required />
                    @if ($errors->has('password'))
                    <span class="help-inline">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="control-group animate6 bounceIn">
                    <input type="password" id="password-confirm" name="password_confirmation" placeholder="{{ trans('auth.placeholder_password_confirm') }}" required />
                </div>
                <div class="control-group animate7 bounceIn">
                    <button class="btn btn-default btn-block">{{ trans('auth.btn_create_password') }}</button>
                </div>
                <?php /*
                <div class="control-group animate11 fadeIn row-fluid">
                    <a href="{{ route('auth.getLogin') }}" class="span6"><span class="icon-arrow-left icon-white"></span> {{ trans('auth.anchor_login') }}</a>
                    <a href="{{ route('auth.getFormForget') }}" class="span6 text-right"><span class="icon-question-sign icon-white"></span> {{ trans('auth.anchor_forgot_pass') }}</a>
                </div>
                */ ?>
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
