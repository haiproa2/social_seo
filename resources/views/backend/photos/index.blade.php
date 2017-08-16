@section('content')
<div class="breadcrumbwidget animate3 fadeInUp">
    <ul class="skins">
        <li><a href="default" class="skin-color default"></a></li>
        <li><a href="orange" class="skin-color orange"></a></li>
        <li><a href="dark" class="skin-color dark"></a></li>
        <li>&nbsp;</li>
        <li class="fixed"><a href="" class="skin-layout fixed"></a></li>
        <li class="wide"><a href="" class="skin-layout wide"></a></li>
    </ul><!--skins-->
    <ul class="breadcrumb">
        <li><a href="{{ route('backend.index') }}">Admin Area</a> <span class="divider">/</span></li>
        <li class="active">Hình ảnh</li>
    </ul>
</div><!--breadcrumbs-->
<div class="pagetitle animate4 fadeInUp"><h1>{!! $title !!}</h1> <span>{!! $description !!}</span></div><!--pagetitle-->
<div class="contentinner animate5 fadeInUp" style="background: url('{!! route('frontend.index') !!}/themes/katniss/img/loaders/loader9.gif') no-repeat center center;">
	<div id="ckfinder-widget">
		<?php
		CKFinder::CreateStatic('../plugins/ckfinder_2.6.2.1/', '100%', '650') ;
		?>
	</div>
</div>
<style>
	.maincontent:after{content: ''; clear: both; display: table;}
</style>
@endsection()

@extends('backend.layouts.master')
