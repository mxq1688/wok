<?php
/*通过服务流水号取得案号*/
include('../common/global.php');
$result = array();
$fwlsh = _request('fwlsh');

$result=get_case_num($fwlsh,$mysql);
// print_r($result);exit;
echo json_encode($result);



function get_case_num($fwlsh,$mysql){
//判断数据表中数据是否存在
if ($fwlsh) {
		  $sql = "fwlsh='".$fwlsh."'";
		  $list = $mysql->select_one('yg_cj_info','*',$sql);
		  if ($list) {
			
			//有可用柜子
			$ret['state'] = 1;
			$ret['ah'] = $list['ah'];
            //找到该姓名
            
            $list = $mysql->select_one('judge','*'," id=".$ret['sjr_id']);
            $ret['name'] = $list['user_name'];

		  } else {
				$ret['state'] = 0;  
				$ret['info'] = '此时服务流水号无案号';
		  }
   } else {
		 $ret['state'] = 0;  
		 $ret['info'] = '缺少有效参数';
   }


return $ret;
}

?>