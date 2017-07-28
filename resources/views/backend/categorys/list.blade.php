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
        <li class="active">Danh mục</li>
    </ul>
</div><!--breadcrumbs-->
<div class="pagetitle animate4 fadeInUp"><h1>{!! $title !!}</h1> <span>{!! $description !!}</span></div><!--pagetitle-->
<div class="contentinner animate5 fadeInUp">
	<div class="row-fluid">
		<div class="span12 text-right text-top">
			<div class="actionfull">
				@ability('root,admin', 'c_page')
				<a href="{{ route('backend.'.$prefix.'.category.create') }}" class="btn btn-primary"><i class="iconfa-plus"></i> Thêm mới</a>
				@endability
				@ability('root,admin', 'u_page')
				<button class="btn btn-info btn-update"><i class="iconfa-refresh"></i> Cập nhật STT</button>
				@endability
				@ability('root,admin', 'd_page')
				<button class="btn btn-danger btn-deletes" onCLick="return deleteItems('danh mục', '{!! route('backend.'.$prefix.'.category.deletes', 'pages') !!}')"><i class="iconfa-trash"></i> Xóa nhiều</button>
				@endability
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<div id="table-header" class="row-fluid"></div>
			{!! Form::open(['route'=>'backend.'.$prefix.'.category.updatePosition', 'id'=>'update_position']) !!}
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th data-sortable="false" style="width:3%" class="noBackground"><input type="checkbox" name="selectall" id="selectall" class="checkall" /></th>
							<th class="text-left sort" id="sortTITLE" title="Sắp xếp theo Tiêu đề">STT - Tiêu đề</th>
							<th style="width:15%;">Ngày cập nhật</th>
							<th data-sortable="false" style="width:10%;" class="noBackground">Trạng thái</th>
							<th data-sortable="false" style="width:10%;" class="noBackground">Thao tác</th>
						</tr>
					</thead>
					<tbody id="tablecontent">
						@if(empty($items) || count($items)==0)
						<tr>
							<td colspan="20">Not found category ... </td>
						</tr>
						@else
							@foreach($items as $key => $value)
							<tr>
			            		<input type="hidden" name="no[id][]" value="{!! $value['id'] !!}">
			            		<td style="width:3%;"><input type="checkbox" name="chose" id="chose" value="{!! $value->id !!}" class="chose" /></td>
			            		<td class="text-left" style="padding-left: {{10+($value['level']*40)}}px;">
			            			<input type="number" min="0" name="no[no][]" id="no" value="{!! $value->no !!}" class="inputNo"/>
			            			&nbsp;&nbsp;&nbsp;{!! str_limit($value->title, 70) !!}
			            			@if(count($value->posts))
			            			&nbsp;&nbsp;&nbsp;(Có {!! count($value->posts) !!} bài viết)
			            			@endif
			            		</td>
								<td style="width:15%;" class="action">{!! $value->updated_at !!}</td>
								<td style="width:10%;" class="action">
									@if(Auth::user()->ability('root,admin', 'u_page'))
									<a href="{!! route('backend.'.$prefix.'.category.active', $value->id) !!}" title="Click để {!! ($value->active)?'khóa lại':'mở khóa' !!}" data-toggle="tooltip" data-html="true">{!! $value->option_actives->value_type !!}</a>
									@else
									{!! $value->option_actives->value_type !!}
									@endif
								</td>
								<td style="width:10%;" class="action">
									<a href="{!! route('backend.'.$prefix.'.category.view', $value->id) !!}" title="Xem chi tiết" data-toggle="tooltip" class="btn-read"><span class="iconfa-eye-open muted"></span></a>
									@ability('root,admin', 'u_page')
									<a href="{{ route('backend.'.$prefix.'.category.edit', $value->id) }}" title="Chỉnh sửa" data-toggle="tooltip" class="btn-update"><span class="iconfa-edit muted"></span></a>
									@endability
									@ability('root,admin', 'd_page')
									<a href="javascript: void(0)" title="Xóa" data-toggle="tooltip" class="btn-delete" onClick="return deleteItem('Khi bạn đồng ý xóa thì tất cả dữ liệu của danh mục sẽ <span class=&quot;text-error&quot;>bị xóa vĩnh viễn</span>. <br/>Nếu bạn không muốn danh mục hoạt động nữa bạn có thể, <br/>cập nhật trạng thái danh mục thành <span class=&quot;label&quot;>Tạm khóa</span><br/><br/><p class=&quot;text-error text-center&quot;>Bạn có chắc vẫn muốn xóa danh mục [<strong>{!! $value->title !!}</strong>]?</p>', '{!! route('backend.'.$prefix.'.category.delete', $value->id) !!}')"><span class="iconfa-trash muted"></span></a>
									@endability
								</td>
							</tr>
							@endforeach
						@endif
					</tbody>
				</table>
			{!! Form::close() !!}
			<div id="table-footer"></div>
		</div>
	</div><!--row-fluid-->
	<div class="row-fluid">
		<div class="span12 text-right text-bottom">
			<div class="actionfull">
				@ability('root,admin', 'c_page')
				<a href="{{ route('backend.'.$prefix.'.category.create') }}" class="btn btn-primary"><i class="iconfa-plus"></i> Thêm mới</a>
				@endability
				@ability('root,admin', 'u_page')
				<button class="btn btn-info btn-update"><i class="iconfa-refresh"></i> Cập nhật STT</button>
				@endability
				@ability('root,admin', 'd_page')
				<button class="btn btn-danger btn-deletes" onCLick="return deleteItems('danh mục', '{!! route('backend.'.$prefix.'.category.deletes', 'pages') !!}')"><i class="iconfa-trash"></i> Xóa nhiều</button>
				@endability
			</div>
		</div>
	</div>
</div><!--contentinner-->
@endsection