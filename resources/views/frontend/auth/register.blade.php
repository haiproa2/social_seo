@extends('frontend.auth.layouts.master')

@section('content')

<div class="loginwrapper">
    <div class="loginwrap zindex100 animate2 bounceInDown">
        <h1 class="logintitle"><span class="iconfa-edit"></span> Register <span class="subtitle">Hello! Get new a account!</span></h1>
        @if (session('status'))
        <div class="alert alert-success">
            {!! session('status') !!}
        </div>
        @endif
        <div class="loginwrapperinner">
            {{ Form::open(['route' => 'auth.postRegister']) }}
                <div class="control-group animate4 bounceIn{{ $errors->has('name') ? ' error' : '' }}">
                    {{ Form::text('name', null, ['id'=>'name', 'placeholder'=>trans('auth.placeholder_name'), 'autofocus'=>true]) }}
                    @if ($errors->has('name'))
                    <span class="help-inline">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="control-group animate5 bounceIn{{ $errors->has('username') ? ' error' : '' }}">
                    {{ Form::text('username', null, ['id'=>'username', 'placeholder'=>trans('auth.placeholder_username')]) }}
                    @if ($errors->has('username'))
                    <span class="help-inline">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="control-group animate6 bounceIn{{ $errors->has('email') ? ' error' : '' }}">
                    {{ Form::text('email', null, ['id'=>'email', 'placeholder'=>trans('auth.placeholder_email')]) }}
                    @if ($errors->has('email'))
                    <span class="help-inline">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="control-group animate7 bounceIn{{ $errors->has('password') ? ' error' : '' }}">
                    {{ Form::password('password', ['id'=>'password', 'placeholder'=>trans('auth.placeholder_password')]) }}
                    @if ($errors->has('password'))
                    <span class="help-inline">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="control-group animate8 bounceIn">
                    {{ Form::password('password_confirmation', ['id'=>'password-confirm', 'placeholder'=>trans('auth.placeholder_password_confirm')]) }}
                </div>
                <div class="control-group animate10 bounceIn">
                    <button class="btn btn-default btn-block">{{ trans('auth.btn_register') }}</button>
                </div>
                <div class="control-group animate11 fadeIn row-fluid">
                    <a href="{{ route('auth.getLogin') }}" class="span6"><span class="icon-arrow-left icon-white"></span> {{ trans('auth.anchor_login') }}</a>
                    <a href="{{ route('auth.getFormForget') }}" class="span6 text-right"><span class="icon-question-sign icon-white"></span> {{ trans('auth.anchor_forgot_pass') }}</a>
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
});
</script>
@endsection
