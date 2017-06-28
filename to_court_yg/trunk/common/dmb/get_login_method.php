<?php 
	//获取登录方式
	include('../global.php');

	$result = array();

	$function_code = _request('function_code');

	if ($function_code) {
		$sql = "select * from ssfw_dmb where dmlb='登录方式' and dmlx=".$function_code." order by dmbh";
		$list = $mysql -> get_all($sql);
		if ($list) {
			$result['state'] = 1;
			$result['data'] = $list;
		} else {
			$result['state'] = 0;
              	$result['info'] = '没有匹配的登录方式';
		}
	} else {
		$result['state'] = 0;
              $result['info'] = '缺少有效参数';
	}

	echo json_encode($result);
?>