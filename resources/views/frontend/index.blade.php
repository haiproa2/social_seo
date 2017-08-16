@extends('layouts.master')

@section('content')
<div id="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-9">
				@include('layouts.slider')
				@if(count($items))
				<div class="news">
					@foreach($items as $key => $value)
						<div class="item">
							<div class="thumb">
								<a href="{{ $value->slug }}" title="{{ $value->title }}" class="image-default">
									<img src="{!! Image::url((($value->photo)?'uploads/'.$value->photo:''), 500, 310, array('crop')) !!}" width="500" height="310" alt="{{ $value->title }}" onerror="this.src='{!! Image::url('images/no-image-available.jpg', 500, 310, array('crop')) !!}';">
								</a>
								<span class="thumbnail-caption">
									<a href="{{ $value->slug }}" title="{{ $value->title }}">Xem chi tiết <i class="fa fa-angle-right"></i></a>
								</span>
								@if(count($value->categorys))
								<span class="category-line">
									@foreach($value->categorys as $k => $val)
									<a href="{{ $val->slug }}" title="Xem tất cả bài viết trong {{ $val->title }}">{!! $val->title !!}</a>
									@endforeach
								</span>
								@endif
							</div>
							<h3 class="title"><a href="{{ $value->slug }}" title="{{ $value->title }}">{!! $value->title !!}</a></h3>
							<p class="meta"><i class="fa fa-calendar-o"></i> {!! date_vi('H:i - \N\g\à\y d, \T\h\á\n\g m, \N\ă\m Y', strtotime($value->updated_at)) !!}</p>
							<div class="description">
								<p>{{ str_limit($value->seo_description, 200) }}</p>
								<p class="text-right"><a href="{{ $value->slug }}" title="{{ $value->title }}" class="more-link">Đọc tiếp <i class="fa fa-angle-right"></i></a></p>
							</div>
						</div>
					@endforeach
				</div>
				{{ $items->links('layouts.paginator') }}
				@endif
			</div>
			<div class="col-sm-3">@include('layouts.sidebar')</div>
		</div>
	</div>
</div>
@endsection