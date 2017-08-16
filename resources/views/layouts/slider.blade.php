<?php if(count($slider)){ ?>
<div id="slider">	
	<div class="owl-carousel">
		<?php foreach ($slider as $key => $value) { ?>
		<div class="item">
			<div class="thumb">
				<?php if($value['slug']) { ?>
				<a href="{{ $value['slug'] }}" title="{{ $value->title }}" {!! (isValidURL($value['slug']))?'target="_blank"':'' !!}>
					<img src="{!! Image::url((($value->photo)?'uploads/'.$value->photo:''), 590, 360, array('crop')) !!}" alt="{{ $value->title }}">
				</a>
				<?php } else { ?>
				<img src="{!! Image::url((($value->photo)?'uploads/'.$value->photo:''), 590, 360, array('crop')) !!}" alt="{{ $value->title }}">
				<?php } ?>					
			</div>
			<div class="info">
				<h3 class="title">
					<a href="{{ $value['slug'] }}" title="{{ $value->title }}"{!! (isValidURL($value['slug']))?'target="_blank"':'' !!}>{{ $value['title'] }}</a>
				</h3>
				<p class="meta">
					<i class="fa fa-calendar-o"></i>
					{!! date_vi('\N\g\à\y d, \T\h\á\n\g m, \N\ă\m Y', strtotime($value->updated_at)) !!}
				</p>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<?php } ?>