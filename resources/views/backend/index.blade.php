@extends('backend.layouts.master')

@section('content')
<script type="text/javascript" src="{{ asset('themes/katniss/js/charts.js') }}"></script>
<div class="contentinner content-charts">

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
@endsection