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
        <li class="active">Trang tĩnh</li>
    </ul>
</div><!--breadcrumbs-->
<div class="pagetitle animate4 fadeInUp"><h1>{!! $title !!}</h1> <span>{!! $description !!}</span></div><!--pagetitle-->
<div class="contentinner animate5 fadeInUp">
	<div class="row-fluid">
		<?php
			$array = array('-'=>'- Tất cả Template -'); $templates = array_merge($array, $templates);
		?>
		<div class="span6 text-top">
			<span>Template:</span>
			<span style="width: auto; display: inline-flex;"> 
			{{ Form::select('category', $templates, (Request::get('limit'))?Request::get('limit'):10, ['id' => 'category', 'class'=>'span12 SumoSelect', 'data-route'=>$prefix]) }}
			</span>
		</div>
		<div class="span6 text-right text-top">
			<div class="actionfull">
				@ability('root,admin', 'c_page')
				<a href="{{ route('backend.page.create') }}" class="btn btn-primary"><i class="iconfa-plus"></i> Thêm mới</a>
				@endability
				@ability('root,admin', 'u_page')
				<button class="btn btn-info btn-update"><i class="iconfa-refresh"></i> Cập nhật STT</button>
				@endability
				@ability('root,admin', 'd_page')
				<button class="btn btn-danger btn-deletes" onCLick="return deleteItems('trang', '{!! route('backend.page.deletes', 'pages') !!}')"><i class="iconfa-trash"></i> Xóa nhiều</button>
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
					{!! Form::select('limit', $limits, (Request::get('limit'))?Request::get('limit'):20, ['id'=>'limit', 'data-route'=>$prefix]) !!}
					@endif
				</div>
				<div class="span6 text-right search-area">
					<span>Tìm kiếm:</span>
					{{ Form::text('k', Request::get('keyword'), ['id'=>'keyword', 'data-route'=>$prefix, 'autofocus'=>true]) }}
					@if(Request::get('keyword'))
					<span class="iconfa-remove" title="Hủy" data-toggle="tooltip"></span>
					@endif
				</div>
			</div>
			{!! Form::open(['route'=>'backend.page.updatePosition', 'id'=>'update_position']) !!}
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th data-sortable="false" style="width:3%" class="noBackground"><input type="checkbox" name="selectall" id="selectall" class="checkall" /></th>
							<th style="width:5%;" class="sort" id="sortNO" title="Sắp xếp theo STT">STT</th>
							<th class="text-left sort" id="sortTITLE" title="Sắp xếp theo Tiêu đề">Tiêu đề</th>
							<th class="text-left sort" style="width:22%;" id="sortTEMPLATE" title="Sắp xếp theo Template">Template</th>
							<th style="width:15%;">Ngày cập nhật</th>
							<th data-sortable="false" style="width:10%;" class="noBackground">Trạng thái</th>
							<th data-sortable="false" style="width:10%;" class="noBackground">Thao tác</th>
						</tr>
					</thead>
					<tbody id="tablecontent">
						@if(empty($items) || count($items)==0)
						<tr>
							<td colspan="20">Not found page ... </td>
						</tr>
						@else
							@foreach($items as $key => $value)
							<tr>
			            		<input type="hidden" name="no[id][]" value="{!! $value['id'] !!}">
			            		<td style="width:3%;"><input type="checkbox" name="chose" id="chose" value="{!! $value->id !!}" class="chose" /></td>
			            		<td style="width:5%;" data-order="<?=$key?>"><input type="number" min="0" name="no[no][]" id="no" value="{!! $value->no !!}" class="inputNo"/></td>
			            		<td class="text-left">{!! str_limit($value->title, 70) !!}</td>
								<td style="width:22%;" class="text-left">{!! $value->option_templates->value_type !!}</td>
								<td style="width:15%;" class="action">{!! $value->updated_at !!}</td>
								<td style="width:10%;" class="action">
									@if(Auth::user()->ability('root,admin', 'u_page'))
									<a href="{!! route('backend.page.active', $value->id) !!}" title="Click để {!! ($value->active)?'khóa lại':'mở khóa' !!}" data-toggle="tooltip" data-html="true">{!! $value->option_actives->value_type !!}</a>
									@else
									{!! $value->option_actives->value_type !!}
									@endif
								</td>
								<td style="width:10%;" class="action">
									<a href="{!! route('backend.page.view', $value->id) !!}" title="Xem chi tiết" data-toggle="tooltip" class="btn-read"><span class="iconfa-eye-open muted"></span></a>
									@ability('root,admin', 'u_page')
									<a href="{{ route('backend.page.edit', $value->id) }}" title="Chỉnh sửa" data-toggle="tooltip" class="btn-update"><span class="iconfa-edit muted"></span></a>
									@endability
									@ability('root,admin', 'd_page')
									<a href="javascript: void(0)" title="Xóa" data-toggle="tooltip" class="btn-delete" onClick="return deleteItem('Khi bạn đồng ý xóa thì tất cả dữ liệu của trang sẽ <span class=&quot;text-error&quot;>bị xóa vĩnh viễn</span>. <br/>Nếu bạn không muốn trang hoạt động nữa bạn có thể, <br/>cập nhật trạng thái trang thành <span class=&quot;label&quot;>Tạm khóa</span><br/><br/><p class=&quot;text-error text-center&quot;>Bạn có chắc vẫn muốn xóa trang [<strong>{!! $value->title !!}</strong>]?</p>', '{!! route('backend.page.delete', $value->id) !!}')"><span class="iconfa-trash muted"></span></a>
									@endability
								</td>
							</tr>
							@endforeach
						@endif
					</tbody>
				</table>
			{!! Form::close() !!}
			<div id="table-footer">
			@if(!empty($items) && count($items))
				<span style="float:left">Hiển thị từ {{ (($items->currentPage() - 1) * $items->perPage()) + 1  }} đến {{ (($items->currentPage() - 1) * $items->perPage()) + count($items)  }} trong tổng {{ $items->total() }} trang tĩnh.</span>
				{{ $items->links('backend.paginator') }}
			@endif
			</div>
		</div>
	</div><!--row-fluid-->
	<div class="row-fluid">
		<div class="span12 text-right text-bottom">
			<div class="actionfull">
				@ability('root,admin', 'c_page')
				<a href="{{ route('backend.page.create') }}" class="btn btn-primary"><i class="iconfa-plus"></i> Thêm mới</a>
				@endability
				@ability('root,admin', 'u_page')
				<button class="btn btn-info btn-update"><i class="iconfa-refresh"></i> Cập nhật STT</button>
				@endability
				@ability('root,admin', 'd_page')
				<button class="btn btn-danger btn-deletes" onCLick="return deleteItems('trang', '{!! route('backend.page.deletes', 'pages') !!}')"><i class="iconfa-trash"></i> Xóa nhiều</button>
				@endability
			</div>
		</div>
	</div>
</div><!--contentinner-->
@endsection