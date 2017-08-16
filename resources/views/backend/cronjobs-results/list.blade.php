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
        <li><a href="{{ route('backend.'.$prefix) }}">{!! $prefix_title !!}</a> <span class="divider">/</span></li>
        <li class="active">Thống kê</li>
    </ul>
</div><!--breadcrumbs-->
<div class="pagetitle animate4 fadeInUp"><h1>{!! $title !!}</h1> <span>{!! $description !!}</span></div><!--pagetitle-->
<div class="contentinner animate5 fadeInUp">
	<div class="row-fluid">
		<div class="span12 text-right text-top">
			<div class="actionfull">
				@ability('root,admin', 'd_cronjob')
				<button class="btn btn-danger btn-deletes" onCLick="return deleteItems('log', '{!! route('backend.cronjob.log.deletes', 'log') !!}')"><i class="iconfa-trash"></i> Xóa nhiều</button>
				@endability
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<div id="table-header" class="row-fluid">
				<div class="span6">
					<span>Hiển thị:</span>
					@if(count($limits))
					{!! Form::select('limit', $limits, (Request::get('limit'))?Request::get('limit'):10, ['id'=>'limit', 'data-route'=>'log']) !!}
					@endif
				</div>
				<div class="span6 text-right search-area">
					<span>Tìm kiếm:</span>
					{{ Form::text('k', Request::get('keyword'), ['id'=>'keyword', 'data-route'=>'log', 'autofocus'=>true]) }}
					@if(Request::get('keyword'))
					<span class="iconfa-remove" title="Hủy" data-toggle="tooltip"></span>
					@endif
				</div>
			</div>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th data-sortable="false" style="width:3%" class="noBackground"><input type="checkbox" name="selectall" id="selectall" class="checkall" /></th>
						<th style="width:5%;" class="sort" id="sortNO" title="Sắp xếp theo ID">ID</th>
						<th class="text-left sort" id="sortLINK" title="Sắp xếp theo Liên kết">Liên kết</th>
						<th style="width:15%;">Ngày giờ</th>
						<th data-sortable="false" style="width:10%;" class="noBackground">Trạng thái</th>
						<th data-sortable="false" style="width:10%;" class="noBackground">Thao tác</th>
					</tr>
				</thead>
				<tbody id="tablecontent">
					@if(empty($items) || count($items)==0)
					<tr>
						<td colspan="20">Not found items ... </td>
					</tr>
					@else
						@foreach($items as $key => $value)
						<tr>
		            		<input type="hidden" name="no[id][]" value="{!! $value['id'] !!}">
		            		<td style="width:3%;"><input type="checkbox" name="chose" id="chose" value="{!! $value->id !!}" class="chose" /></td>
		            		<td style="width:5%;">{!! $value->id !!}</td>
							<td class="text-left"><a href="{!! $value->link !!}" title="Xem bài viết gốc" target="_blank">{!! str_limit($value->link, 70) !!}</a></td>
							<td style="width:15%;">{!! $value->updated_at !!}</td>
							<td style="width:10%;" class="action">{!! $value->status !!}</td>
							<td style="width:10%;" class="action">
								@ability('root,admin', 'v_news')
								<a href="{!! route('backend.news.view', $value->post_id) !!}" title="Xem bài viết" data-toggle="tooltip" class="btn-read" target="_blank"><span class="iconfa-eye-open muted"></span></a>
								@endability
								@ability('root,admin', 'd_cronjob')
								<a href="javascript: void(0)" title="Xóa log" data-toggle="tooltip" class="btn-delete" onClick="return deleteItem('Khi bạn đồng ý xóa thì tất cả dữ liệu của log này sẽ <span class=&quot;text-error&quot;>bị xóa vĩnh viễn</span>.<br/><br/><p class=&quot;text-error text-center&quot;><strong style=&quot;max-width:100%;width:370px;display:inline-block&quot;>{{ $value->link }}</strong><br/>Bạn có chắc vẫn muốn xóa log này?</p>', '{!! route('backend.cronjob.log.delete', $value->id) !!}')"><span class="iconfa-trash muted"></span></a>
								@endability
							</td>
						</tr>
						@endforeach
					@endif
				</tbody>
			</table>
			<div id="table-footer">
			@if(!empty($items) && count($items))
				<span style="float:left">Hiển thị từ {{ (($items->currentPage() - 1) * $items->perPage()) + 1  }} đến {{ (($items->currentPage() - 1) * $items->perPage()) + count($items)  }} trong tổng {{ $items->total() }} logs.</span>
				{{ $items->links('backend.paginator') }}
			@endif
			</div>
		</div>
	</div><!--row-fluid-->
	<div class="row-fluid">
		<div class="span12 text-right text-bottom">
			<div class="actionfull">
				@ability('root,admin', 'd_cronjob')
				<button class="btn btn-danger btn-deletes" onCLick="return deleteItems('log', '{!! route('backend.cronjob.log.deletes', 'log') !!}')"><i class="iconfa-trash"></i> Xóa nhiều</button>
				@endability
			</div>
		</div>
	</div>
</div><!--contentinner-->
@endsection