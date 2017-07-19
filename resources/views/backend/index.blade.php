@extends('backend.layouts.master')

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
        <li class="active">Trang chủ</li>
    </ul>
</div><!--breadcrumbs-->
<div class="pagetitle animate5 fadeInUp"><h1>{!! $title !!}</h1> <span>{!! $description !!}</span></div><!--pagetitle-->
<div class="contentinner content-charts animate7 fadeInUp">
	<div class="alert alert-info">
    	<button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Xin chào {{ Auth::user()->name }}!</strong> Chào mừng bạn quay trở lại trang quản lý dữ liệu website.
    </div>
	<div class="row-fluid">
		<div class="span6">
			<h4 class="widgettitle">Simple Chart</h4>
			<br />
			<div id="chartplace" style="height:300px;"></div>
		</div>
		<div class="span6">
			<h4 class="widgettitle">Bar Graph</h4>
			<br />
			<div id="bargraph" style="height:300px;"></div>
		</div>
	</div><!--row-fluid-->

	<br /><br />

	<div class="row-fluid">
		<div class="span6">
			<h4 class="widgettitle">Real Time Chart</h4>
			<br />
			<div id="realtime" style="height:300px;"></div>
			<br />
			<small>You can update a chart periodically to get a real-time effect by using a timer to insert the new data in the plot and redraw it.</small>
		</div>

		<div class="span6">
			<h4 class="widgettitle">Pie Chart</h4>
			<br />
			<div id="piechart" style="height: 300px;"></div>
		</div>
	</div><!--row-fluid-->

	<div class="divider30"></div>

	<pre class="prettyprint linenums">
</div><!--contentinner-->
<script type="text/javascript" src="{{ asset('themes/katniss/js/charts.js') }}"></script>
@endsection