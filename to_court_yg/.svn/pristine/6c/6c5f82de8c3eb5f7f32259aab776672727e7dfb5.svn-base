<?php

include('../common/global.php');
$result = array();
$ic_card = _request('ic_card');
$court_num = _request('fid');
//通过court_num 获取court_id
$court_id = get_court_id_by_num($court_num,$mysql);
$result=login($ic_card,$court_id,$mysql);
// print_R($result);exit;
echo json_encode($result);



function login($ic_card,$court_id,$mysql){
//判断数据表中数据是否存在
if ($ic_card && $court_id) {
              // $sql = "select * from ic_card where ic_num='".$ic_card."' and court_id='".$court_id."'";
              // $list = $mysql -> get_one($sql);
              $sql = "ic_num='".$ic_card."' and court_id='".$court_id."'";
              $list = $mysql->select_one('ic_card','*',$sql);
              if ($list) {
                    $result['state'] = 1;  
                    $result['user_id'] = $list['id'];
                    $result['user_name'] = $list['name'];
                    $result['court_id'] = $list['name'];
              } else {
                    $result['state'] = 0;  
                    $result['info'] = '此卡无效';
              }
       } else {
             $result['state'] = 0;  
             $result['info'] = '缺少有效参数';
       }


return $result;
}

?>