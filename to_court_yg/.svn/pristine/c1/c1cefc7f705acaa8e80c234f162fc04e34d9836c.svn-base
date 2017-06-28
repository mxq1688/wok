<?php
/*取得可使用的云柜*/
include('../common/global.php');
$result = array();
$box_size = _request('box_size');
$group_id = _request('yg_group_id');
$court_id = _request('court_id');
$result=box_select($box_size,$group_id,$court_id,$mysql);
// print_r($result);exit;
echo json_encode($result);

function box_select($box_size,$group_id,$court_id,$mysql){
//判断数据表中数据是否存在
if ($box_size && $group_id && $court_id) {
              // $sql = "select * from yg_box where size='".$box_size."' and group_id='".$group_id."' and court_id='".$court_id."' and state=1";
              // $list = $mysql -> get_one($sql);
              $sql = "size='".$box_size."' and group_id='".$group_id."' and court_id='".$court_id."' and state=1";
              $list = $mysql->select_one('yg_box','*',$sql);
              if ($list) {
				//修改该柜子的状态
               // $sql = "update yg_box set state=2 where id=".$list['id'];
               // $mysql -> get_one($sql);
                $lsh=date('Ymd') . str_pad(mt_rand(1, 99999999), 5, '0', S
                TR_PAD_LEFT);

                //有可用柜子
                $ret['state'] = 1;
                $ret['number'] = $list['number'];
                $ret['xylsh'] = $lsh;
                $ret['yg_box_id'] = $list['id'];
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