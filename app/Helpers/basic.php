<?php
@define ('LANG','one');
@define ('PATH_IMAGE_UPLOAD','uploads');
@define ('PATH_IMAGE_AVATAR','uploads/images/members');
@define ('PATH_IMAGE_AVATAR_ADMIN','../uploads/images/members');


function getCountViewYoutube($url){
	preg_match('[\\?&](?:v=)([^&#]*)', $url, $matches);
	$id = ($matches === null)?$url:$matches[1];
	$JSON = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=$id&key=AIzaSyDyt1bPwGDsgNRKrbgjnejkcFwp7q7q6y4");
	$json_data = json_decode($JSON, true);
	return $json_data['items'][0]['statistics']['viewCount'];
}
function getCountCommentFacebook($url)
{
  $json = json_decode(file_get_contents('https://graph.facebook.com/?ids='.$url));
  return isset($json->$url->comments) ? $json->$url->comments : 0;
}
function showSelectTable($listOriginal, $listCurrent=array(), $disabled = '', $name='permissions'){
	$i=0;
	$str = '<table class="table table-striped text-center table-permission">';
	$str .= '<tr>
				<td style="width: 40px;">STT</td>
				<td class="text-left">Tên Mudule</td>
				<td style="width: 50px;">&nbsp;</td>
				<td style="width: 80px;">Xem</td>
				<td style="width: 80px;">Tạo mới</td>
				<td style="width: 80px;">Chỉnh sửa</td>
				<td style="width: 80px;">Xóa</td>
			</tr>';
	foreach ($listOriginal as $key => $value) {
		if($key == 0) $str .= '<tr>
			<td colspan="2"></td>
			<td class="default">&nbsp;</td>
			<td class="default"><label for="view-all" title="Chọn/Hủy tất cả quyền xem" data-toggle="tooltip"><input type="checkbox" class="permission-all" id="view-all" value="view" '.$disabled.'></label></td>
			<td class="default"><label for="create-all" title="Chọn/Hủy tất cả quyền tạo mới" data-toggle="tooltip"><input type="checkbox" class="permission-all" id="create-all" value="create" '.$disabled.'></label></td>
			<td class="default"><label for="update-all" title="Chọn/Hủy tất cả quyền chỉnh sửa" data-toggle="tooltip"><input type="checkbox" class="permission-all" id="update-all" value="update" '.$disabled.'></label></td>
			<td class="default"><label for="delete-all" title="Chọn/Hủy tất cả quyền xóa" data-toggle="tooltip"><input type="checkbox" class="permission-all" id="delete-all" value="delete" '.$disabled.'></label></td>
		</tr>';
		$permissions = explode('_', $value['name']);
		$permissionName = substr($value['description'], 4, strlen($value['description']));
		if($permissions[0]=='v'){
			$i++;
			$permission = $permissions[1].((isset($permissions[2]))?'_'.$permissions[2]:'');
			$str .= '<tr>
				<td>'.$i.'</td>
				<td class="text-left">'.ucfirst($permissionName).'</td>
				<td class="default"><label for="'.$permission.'-all" title="Chọn/Hủy tất cả quyền của <br/>Module: '.ucfirst($permissionName).'" data-toggle="tooltip" data-html="true"><input type="checkbox" class="permission-all" id="'.strtolower($permission).'-all" value="'.strtolower($permission).'" '.$disabled.'></label></td>
				<td class="info"><label for="permission-'.$key.'" title="'.$value['description'].'" data-toggle="tooltip"><input type="checkbox" id="permission-'.$key.'" class="view '.strtolower($permission).'" name="'.$name.'[]"'.((in_array($value['id'], $listCurrent))?' checked':'').' value="'.$value['id'].'" '.$disabled.'></label>
				</td>';
		}
		if($permissions[0]=='c')
			$str .= '<td class="success"><label for="permission-'.$key.'" title="'.$value['description'].'" data-toggle="tooltip"><input type="checkbox" id="permission-'.$key.'" name="'.$name.'[]"'.((in_array($value['id'], $listCurrent))?' checked':'').' class="create '.strtolower($permission).'" value="'.$value['id'].'" '.$disabled.'></label></td>';
		if($permissions[0]=='u')
			$str .= '<td class="warning"><label for="permission-'.$key.'" title="'.$value['description'].'" data-toggle="tooltip"><input type="checkbox" id="permission-'.$key.'" name="'.$name.'[]"'.((in_array($value['id'], $listCurrent))?' checked':'').' class="update '.strtolower($permission).'" value="'.$value['id'].'" '.$disabled.'></label></td>';
		if($permissions[0]=='d')
			$str .= '<td class="danger"><label for="permission-'.$key.'" title="'.$value['description'].'" data-toggle="tooltip"><input type="checkbox" id="permission-'.$key.'" name="'.$name.'[]"'.((in_array($value['id'], $listCurrent))?' checked':'').' class="delete '.strtolower($permission).'" value="'.$value['id'].'" '.$disabled.'></label></td></tr>';
	}
	$str .= '</table>';
	return $str;
}
function showTrees($items, $checkeds, $name = 'cate_id[]', $type = 'checkbox', $titledefault = 'Danh mục chính'){
	$str = '
	<div class="item" style="padding-left:0px">
		<label><input type="'.$type.'" class="'.$type.'" name="'.$name.'" value="0" checked>'.$titledefault.'</label>
	</div>
	';
	if(is_array($items) && count($items)) {
		foreach ($items as $key => $value) {
			$checked = "";
			if((is_array($checkeds) || is_object($checkeds)) && count($checkeds)){
				foreach ($checkeds as $k => $v) {
					if($value['id']==$v['cate_id']){
						$checked = " checked";
						break;
					}
				}
			} else if(is_numeric($checkeds)){
				if($value['id'] == $checkeds){
					$checked = " checked";
				}
			} else $checked = "";

			$str .= '
				<div class="item" style="padding-left:'.($value['level']*22).'px">
					<label><input type="'.$type.'" class="'.$type.'" name="'.$name.'" '.(($name=='cate_id')?' data-slug="'.$value['slug'].'/"':'').' value="'.$value['id'].'"'.$checked.'>'.$value['title'].'</label>
				</div>
			';
		}
	}
	return $str;
}

function recursive($arrData, &$result, $parent = 0, $level = 0) {
    if (count($arrData) > 0) {
        foreach ($arrData as $key => $val) {
            if ($parent == $val['id_parent']) {
                $val['level'] = $level;
                $result[] = $val;
                $_parent = $val['id'];
                unset($arrData[$key]);
                recursive($arrData, $result, $_parent, $level + 1);
            }
        }
    }
}