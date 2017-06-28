<?php
/*查询是否有可以使用的柜子*/
include('../common/global.php');
$result = array();
$box_size = _request('box_size');
$group_id = _request('yg_group_id');
$court_id = _request('court_id');
$result=box_search($box_size,$group_id,$court_id,$mysql);
// print_r($result);exit;
echo json_encode($result);



function box_search($box_size,$group_id,$court_id,$mysql){
//判断数据表中数据是否存在
if ($box_size && $group_id && $court_id) {
              // $sql = "select * from yg_box where size='".$box_size."' and group_id='".$group_id."' and court_id='".$court_id."' and state=1";
              // $list = $mysql -> get_one($sql);
              $sql = "size='".$box_size."' and group_id='".$group_id."' and court_id='".$court_id."' and state=1";
              $list = $mysql->select_one('yg_box','*',$sql);
              if ($list) {
                //有可用柜子
                $ret['state'] = 1; 
                $ret['info'] = '有可用柜子';
              } else {
                    $ret['state'] = 0;  
                    $ret['info'] = '此时无可用柜子';
              }
       } else {
             $ret['state'] = 0;  
             $ret['info'] = '缺少有效参数';
       }


return $ret;
}

?>