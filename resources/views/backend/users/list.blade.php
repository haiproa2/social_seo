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
        <li><a href="{{ route('backend.user') }}">Thành viên</a> <span class="divider">/</span></li>
        <li class="active">Danh sách</li>
    </ul>
</div><!--breadcrumbs-->
<div class="pagetitle animate4 fadeInUp"><h1>{!! $title !!}</h1> <span>{!! $description !!}</span></div><!--pagetitle-->
<div class="contentinner animate5 fadeInUp">
	<div class="row-fluid">
		<div class="span12 text-right text-top">
			<div class="actionfull">
				<a href="" class="btn btn-primary"><i class="iconfa-plus"></i> Thêm mới</a>
				<button class="btn btn-info btn-update"><i class="iconfa-refresh"></i> Cập nhật STT</button>
				<button class="btn btn-danger delall"><i class="iconfa-trash"></i> Xóa nhiều</button>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<div id="table-header" class="row-fluid">
				<div class="span6">
					<span>Hiển thị:</span>
					<select name="limit" id="limit">
						<option value="10">10</option>
						<option value="20"<?=(Request::get('limit') == 20)?'selected':''?>>20</option>
						<option value="50"<?=(Request::get('limit') == 50)?'selected':''?>>50</option>
						<option value="100"<?=(Request::get('limit') == 100)?'selected':''?>>100</option>
					</select>
				</div>
				<div class="span6 text-right">
					<span>Tìm kiếm:</span>
					<input type="text" name="k" id="keyword" value="{{ Request::get('keyword') }}"/>
				</div>
			</div>
			{!! Form::open(['route'=>'backend.user.updatePosition', 'id'=>'update_position']) !!}
				<table class="table table-bordered">
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
			            		<td style="width:3%;"><input type="checkbox" name="chose" id="chose" value="{!! $value['id'] !!}" class="chose" /></td>
			            		<td style="width:5%;" data-order="<?=$key?>"><input type="number" min="0" name="no[no][]" id="no" value="{!! $value['no'] !!}" class="inputNo"/></td>
			            		<td class="text-left">{!! str_limit($value->name, 70) !!}</td>
								<td style="width:17%;" class="text-left">{!! str_limit($value->email, 70) !!}</td>
								<td style="width:17%;" class="text-left">--</td>
								<td style="width:10%;" class="action">{!! $value['updated_at'] !!}</td>
								<td style="width:10%;" class="action">
									<?php if(Auth::check()){ ?>
									<?php if($value['active']){ ?>
										<a href="" title="Đang hoạt động<br/>Click để khóa lại" data-toggle="tooltip" data-html="true"><span class="iconfa-ok-circle text-success"></span></a>
									<?php } else { ?>
										<a href="" title="Bị tạm khóa<br/>Click để mở khóa" data-toggle="tooltip" data-html="true"><span class="iconfa-ban-circle muted"></span></a>
									<?php } } else { ?>
									<?php if($value['active']){ ?>
										<span class="iconfa-ok-circle text-success" title="Đang hoạt động" data-toggle="tooltip"></span>
									<?php } else{ ?>
										<span class="iconfa-ban-circle muted" title="Bị tạm khóa" data-toggle="tooltip"></span>
									<?php } } ?>
								</td>
								<td style="width:10%;" class="action">
									<a href="" title="Xem chi tiết" data-toggle="tooltip" class="btn-read"><span class="iconfa-eye-open muted"></span></a>
									<a href="" title="Chỉnh sửa" data-toggle="tooltip" class="btn-update"><span class="iconfa-edit muted"></span></a>
									<a href="javascript: void(0)" title="Xóa" data-toggle="tooltip" class="btn-delete" onClick="return deleteItem('Bạn muốn xóa tài khoản [<strong>{{ strip_tags($value['name']) }}</strong>] có Email [<strong>{{ strip_tags($value['name']) }}</strong>]?', '')"><span class="iconfa-trash muted"></span></a>
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
				<a href="" class="btn btn-primary"><i class="iconfa-plus"></i> Thêm mới</a>
				<button class="btn btn-info btn-update"><i class="iconfa-refresh"></i> Cập nhật STT</button>
				<button class="btn btn-danger delall"><i class="iconfa-trash"></i> Xóa nhiều</button>
			</div>
		</div>
	</div>
</div><!--contentinner-->
<script type="text/javascript">
	function fillter(){		
		var cate = jQuery('#category').find(":selected").val();
		var keyword = jQuery('#keyword').val();
		var limit = jQuery('#limit').find(":selected").val();
		var link = link_limit = "";
		if(limit != 10)
			link_limit = "&limit="+limit;
		if(cate && keyword)
			var link = "?cate="+cate+"&keyword="+keyword+link_limit;
		else if(cate)
			var link = "?cate="+cate+link_limit;
		else if(keyword)
			var link = "?keyword="+keyword+link_limit;
		else if(limit != 10)
			var link = "?limit="+limit;
		window.location.href = "{!! route('backend.user.list') !!}"+link;
	}

	jQuery(document).ready(function(){
		/*jQuery('#category').SumoSelect();
		jQuery('#category').change(function(){
			fillter();
		});*/
		jQuery('#limit').change(function(){
			fillter();
		});
		jQuery('#keyword').on('keyup keypress', function(e) {
			var keyword = jQuery('#keyword').val();
			var keyCode = e.keyCode || e.which;
			if (keyCode === 13) {
				fillter();
			}
		});
		var msg = type = '';
		<?php if (!$errors->isEmpty()){ ?>
		msg = "Đã xảy ra một vài lỗi.<br/>Vui lòng xem lại các trường dữ liệu."; 
		type = "error"; 
		<?php } if (Session::has('flash_type')){ ?>
		msg = "{!! Session::get('flash_messager') !!}"; 
		type = "{{ Session::get('flash_type') }}"; 
		<?php } ?>
		if(msg)
			jQuery.jGrowl(msg, { life: 5000, theme: type});
	});
</script>
@endsection