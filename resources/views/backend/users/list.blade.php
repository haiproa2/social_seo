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
        <li class="active">Thành viên</li>
    </ul>
</div><!--breadcrumbs-->
<div class="pagetitle animate4 fadeInUp"><h1>{!! $title !!}</h1> <span>{!! $description !!}</span></div><!--pagetitle-->
<div class="contentinner animate5 fadeInUp">
	<div class="row-fluid">
		<div class="span12 text-right text-top">
			<div class="actionfull">
				@ability('root,admin', 'c_user')
				<a href="{{ route('backend.user.create') }}" class="btn btn-primary"><i class="iconfa-plus"></i> Thêm mới</a>
				@endability
				@ability('root,admin', 'u_user')
				<button class="btn btn-info btn-update"><i class="iconfa-refresh"></i> Cập nhật STT</button>
				@endability
				@ability('root,admin', 'd_user')
				<button class="btn btn-danger btn-deletes" onCLick="return deleteItems('thành viên', '{!! route('backend.user.deletes', 'users') !!}')"><i class="iconfa-trash"></i> Xóa nhiều</button>
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
					{{ Form::text('k', Request::get('keyword'), ['id'=>'keyword', 'data-route'=>'list', 'autofocus'=>true]) }}
					@if(Request::get('keyword'))
					<span class="iconfa-remove" title="Hủy" data-toggle="tooltip"></span>
					@endif
				</div>
			</div>
			{!! Form::open(['route'=>'backend.user.updatePosition', 'id'=>'update_position']) !!}
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th data-sortable="false" style="width:3%" class="noBackground"><input type="checkbox" name="selectall" id="selectall" class="checkall" /></th>
							<th style="width:5%;" class="sort" id="sortNO" title="Sắp xếp theo STT">STT</th>
							<th class="text-left sort" id="sortTITLE" title="Sắp xếp theo Họ và tên">Họ và tên</th>
							<th class="text-left sort" id="sortEMAIL" title="Sắp xếp theo Địa chỉ Email">Địa chỉ Email</th>
							<th class="text-left sort" id="sortROLE" title="Sắp xếp theo Nhóm">Nhóm</th>
							<th style="width:15%;">Ngày cập nhật</th>
							<th data-sortable="false" style="width:10%;" class="noBackground">Trạng thái</th>
							<th data-sortable="false" style="width:10%;" class="noBackground">Thao tác</th>
						</tr>
					</thead>
					<tbody id="tablecontent">
						@if(empty($items) || count($items)==0)
						<tr>
							<td colspan="20">Not found user ... </td>
						</tr>
						@else
							@foreach($items as $key => $value)
							<tr>
			            		<input type="hidden" name="no[id][]" value="{!! $value['id'] !!}">
			            		<td style="width:3%;"><input type="checkbox" name="chose" id="chose" value="{!! $value->id !!}" class="chose" /></td>
			            		<td style="width:5%;" data-order="<?=$key?>"><input type="number" min="0" name="no[no][]" id="no" value="{!! $value->no !!}" class="inputNo"/></td>
			            		<td class="text-left">{!! str_limit($value->name, 70) !!}</td>
								<td style="width:17%;" class="text-left">{!! str_limit($value->email, 70) !!}</td>
								<td style="width:17%;" class="text-left">
									@if($value->roles)
										@foreach($value->roles as $key => $val)
										{!! $val->display_name !!}
										@endforeach
									@else
									--
									@endif
								</td>
								<td style="width:10%;" class="action">{!! $value->updated_at !!}</td>
								<td style="width:10%;" class="action">
									@if(Auth::user()->ability('root,admin', 'u_user'))
									<a href="{!! route('backend.user.active', $value->id) !!}" title="Click để {!! ($value->active)?'khóa lại':'mở khóa' !!}" data-toggle="tooltip" data-html="true">{!! $value->option_actives->value_type !!}</a>
									@else
									{!! $value->option_actives->value_type !!}
									@endif
								</td>
								<td style="width:10%;" class="action">
									<a href="{!! route('backend.user.view', $value->id) !!}" title="Xem chi tiết" data-toggle="tooltip" class="btn-read"><span class="iconfa-eye-open muted"></span></a>
									@ability('root,admin', 'u_user')
									<a href="{{ route('backend.user.edit', $value->id) }}" title="Chỉnh sửa" data-toggle="tooltip" class="btn-update"><span class="iconfa-edit muted"></span></a>
									@endability
									@ability('root,admin', 'd_user')
									<a href="javascript: void(0)" title="Xóa" data-toggle="tooltip" class="btn-delete" onClick="return deleteItem('Khi bạn đồng ý xóa thì tất cả dữ liệu của thành viên sẽ <span class=&quot;text-error&quot;>bị xóa vĩnh viễn</span>. <br/>Nếu bạn không muốn thành viên hoạt động nữa bạn có thể, <br/>cập nhật trạng thái thành viên thành <span class=&quot;label&quot;>Tạm khóa</span><br/><br/><p class=&quot;text-error text-center&quot;>Bạn có chắc vẫn muốn xóa thành viên [<strong>{!! $value->name !!}</strong>]?</p>', '{!! route('backend.user.delete', $value->id) !!}')"><span class="iconfa-trash muted"></span></a>
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
				<span style="float:left">Hiển thị từ {{ (($items->currentPage() - 1) * $items->perPage()) + 1  }} đến {{ (($items->currentPage() - 1) * $items->perPage()) + count($items)  }} trong tổng {{ $items->total() }} thành viên.</span>
				{{ $items->links('backend.paginator') }}
			@endif
			</div>
		</div>
	</div><!--row-fluid-->
	<div class="row-fluid">
		<div class="span12 text-right text-bottom">
			<div class="actionfull">
				@ability('root,admin', 'c_user')
				<a href="{{ route('backend.user.create') }}" class="btn btn-primary"><i class="iconfa-plus"></i> Thêm mới</a>
				@endability
				@ability('root,admin', 'u_user')
				<button class="btn btn-info btn-update"><i class="iconfa-refresh"></i> Cập nhật STT</button>
				@endability
				@ability('root,admin', 'd_user')
				<button class="btn btn-danger btn-deletes" onCLick="return deleteItems('thành viên', '{!! route('backend.user.deletes', 'users') !!}')"><i class="iconfa-trash"></i> Xóa nhiều</button>
				@endability
			</div>
		</div>
	</div>
</div><!--contentinner-->
@endsection