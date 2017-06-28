<?php
/*材料存件校验*/
include('../common/global.php');
$result = array();
$fwlsh = _request('cllsh');

$court_id = request('court_id');

//此收件人为多次存件的第一次存件的收件人
$sjr_name = _request('sjr_name');
//判断材料信息是否在yg_cj_info中
$result[0]=is_exist($fwlsh,$court_id,$mysql);
//判断多次存件是否同意收件人
$result[1]=check_sjr($fwlsh,$court_id,$sjr_name,$mysql);
// print_r($result);exit;
echo json_encode($result);



function is_exist($fwlsh,$court_id,$mysql){
//判断数据表中数据是否存在
if ($fwlsh &&  $court_id) {
              // $sql = "select * from yg_cj_info where fwlsh='".$fwlsh."' and court_id='".$court_id."'";
              // $list = $mysql -> get_one($sql);
              $sql = "fwlsh='".$fwlsh."' and court_id='".$court_id."'";
              $list = $mysql->select_one('yg_cj_info','*',$sql);
              if ($list) {
                $ret['state'] = 1;  
                $ret['info'] = '材料存在';
              } else {
                    $ret['state'] = 0;  
                    $ret['info'] = '材料不存在';
              }
       } else {
             $ret['state'] = 0;  
             $ret['info'] = '缺少有效参数';
       }


return $ret;
}


function check_sjr($fwlsh,$court_id,$sjr_name,$mysql){
//判断数据表中数据是否存在
if ($fwlsh &&  $court_id &&  $sjr_name) {
              // $sql = "select * from yg_cj_info where fwlsh='".$fwlsh."' and court_id='".$court_id."' and sjr_name='".$sjr_name."'";
              // $list = $mysql -> get_one($sql);
              $sql = "fwlsh='".$fwlsh."' and court_id='".$court_id."' and sjr_name='".$sjr_name."'";
              $list = $mysql->select_one('yg_cj_info','*',$sql);
              if ($list) {
                $ret['state'] = 1;  
                $ret['info'] = '相同收件人';
              } else {
                    $ret['state'] = 0;  
                    $ret['info'] = '不同收件人';
              }
       } else {
             $ret['state'] = 0;  
             $ret['info'] = '缺少有效参数';
       }


return $ret;
}

?>