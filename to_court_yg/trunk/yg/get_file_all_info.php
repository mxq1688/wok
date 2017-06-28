<?php
/*获取该流转号的所有信息
*/
include ('../common/global.php');
$result = array();

$xylsh = _request('xylsh');
$list = array();
if ($xylsh) {
    $record = $mysql->select_all('yg_record', '*', 'xylsh=' . "'$xylsh'");
    if($record){
       foreach($record as $key=>$val){
          $list[$key]['create_time'] = date('Y-m-d',$val['operation_time']);
          $list[$key]['num'] = $key+1;
          if($val['operation']==1){
             $list[$key]['content'] = $val['fjr_name'].'存件';
          }
          if($val['operation']==2){
            //判断是否是管理员
             if($val['identity_name']=='法官'){
                $list[$key]['content'] = $val['sjr_name'].'取件';
             }else{
                $list[$key]['content'] = '管理员'.'取件';
             }
             
          }
          //指派
          if($val['operation']==3){
             if($key>0){
               $fjr_name = $record[($key-1)]['sjr_name'];
             }
             $list[$key]['content'] = $fjr_name.'指派'.$val['sjr_name'];
          }
          
          if($val['operation']==4){
             $list[$key]['content'] = $val['fjr_name'].'退件';
             $list[$key]['tj_reason'] = $val['reason'];
          }
          
       }   
    }
    
    //print_R($list);exit;
    $data['state'] = 1;
    $data['data'] = $list;
    
} else {
    $data['state'] = 0;
    $data['info'] = '缺少有效参数';
}




echo json_encode($data);
?>