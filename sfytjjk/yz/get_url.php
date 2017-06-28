<?php
/** 验证设备成功后获取跳转链接
 * type 1 登录
 * type 2 立案
 * type 3 阅卷
 * type 4 查询
 **/
include ('../common/global.php');
$result = array();

$pid = _request('pid');
$type = _request('type');
$sf = 'js';
if(!$type){
    $type = 1;
}

$sql = "select * from ssfw_tdh_api where sf = '$sf'";
$list = $mysql->get_one($sql);
if($list['is_connect']=='-1'){
    $result['state'] = 0;
	$result['info'] = '法宗系统数据错误';
}else{
    if ($pid) {
		$sql = "select * from ssfw_product where product_id = '$pid'";

		$list = $mysql->get_one($sql);
		if ($list) {
			$result['state'] = 1;
			if($type==1){
				$result['url'] = '/sfytj/dist/html/common/sfytj_index.html';
			}else if($type==2){
				$result['url'] = '/sfytj/dist/html/ssfw/wyla_index.html';
			}else if($type==3){
				$result['url'] = '/sfytj/dist/html/ssfw/yyyj/yyyjsq/yyyjtk.html';
			}else if($type==4){
				$result['url'] = '/sfytj/dist/html/wycx/index.html';
			}
			
		} else {

			$result['state'] = 0;
			$result['info'] = '非法操作';
		}
	} else {
		$result['state'] = 0;
		$result['info'] = '非法操作';
	}


}

echo json_encode($result);

?>
 