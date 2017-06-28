<?php
  /*当事人存件取件改件操作*/

include('../common/global.php');
$result = array();

$ygid = _request('ygid');
$case_id = _request('case_id');
$operation = _request('operation');
$user_name = _request('user_name');
$user_identity = _request('user_identity');
$user_id = _request('user_id');
$operationtime = time();
$operationday = date("m",$operationtime).'.'.date("d",$operationtime);
$ajmc = _request('ajmc');
$fjr_id = _request('fjr_id');
$sjr_id = _request('sjr_id');
$fjr_identity = _request('fjr_identity');
$sjr_identity = _request('sjr_identity');
$fjr_name = _request('fjr');
$sjr_name = _request('sjr');

// if ($fjr_identity == "原告/原告代理人") {
//       $fjr_identity = 1;
// } else if ($fjr_identity == "被告/被告代理人") {
//       $fjr_identity = 2;
// } else if ($fjr_identity == "第三人") {
//       $fjr_identity = 3;
// } else if ($fjr_identity == "法官") {
//       $fjr_identity = 4;
// }

// if ($sjr_identity == "原告/原告代理人") {
//       $sjr_identity = 1;
// } else if ($sjr_identity == "被告/被告代理人") {
//       $sjr_identity = 2;
// } else if ($sjr_identity == "第三人") {
//       $sjr_identity = 3;
// } else if ($sjr_identity == "法官") {
//       $sjr_identity = 4;
// }

//获取当前是第几次操作
$sql = "select * from ssfw_yg_record where case_id=".$case_id." and user_id=".$user_id;
$list = $mysql -> get_all($sql);
$num = count($list);
$num++;
/*1. 存件*/
if ($operation == 1) {
      $data_info['ygid'] = $ygid;
      $data_info['case_id'] = $case_id;
      $data_info['fjr_name'] = $fjr_name;
      $data_info['sjr_name'] = $sjr_name;
      $data_info['fjr_id'] = $fjr_id;
      $data_info['sjr_id'] = $sjr_id;
      $data_info['fjr_identity'] = $fjr_identity;
      $data_info['sjr_identity'] = $sjr_identity;
      $data_info['cftime'] = $operationtime;
      $data_info['state'] = 1;
      $insert_yg_state = $mysql -> insert('ssfw_yg_state',$data_info);

      //保存操作记录
      if ($insert_yg_state) {
      } else{
            $result['state'] = 0;  //失败
            $result['info'] = '存件：柜子状态修改失败';  
      }
/*2.取件*/
} else if ($operation == 2) {
      $del_yg_state = $mysql -> delete("ssfw_yg_state", "ygid="."'$ygid'");

        //保存操作记录
      if ($del_yg_state) {
      } else {
            $result['state'] = 0;  //失败
            $result['info'] = '取件：柜子状态修改失败';  
      }
/*3.改件*/
} else if ($operation == 3) {
        $data_info['cftime'] = $operationtime;
        $update_yg_state = $mysql -> update("ssfw_yg_state", $data_info, "ygid="."'$ygid'");

        //保存操作记录
      if ($update_yg_state) {    
      } else {
            $result['state'] = '0';  //失败
            $result['info'] = '改件：柜子状态修改失败';  
      }
} 

$data['ygid'] = $ygid;
$data['case_id'] = $case_id;
$data['operation'] = $operation;
$data['user_name'] = $user_name;
$data['operationtime'] = $operationtime;
$data['ajmc'] = $ajmc;
$data['user_id'] = $user_id;
$data['user_identity'] = $user_identity;
$data['fjr_id'] = $fjr_id;
$data['sjr_id'] = $sjr_id;
$data['operationday'] = $operationday;
$data['operationnum'] = $num;
$insert_yg_record = $mysql -> insert('ssfw_yg_record',$data);

echo json_encode($result);
?>