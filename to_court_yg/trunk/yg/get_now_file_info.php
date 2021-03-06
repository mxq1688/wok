<?php
/*通过铉盈流水号取得案件最新记录
  statue  1 未取件 2 已取件
  type 1 流水号 2 材料号
*/
include('../common/global.php');
$result = array();

$content = _request('content');
$type = _request('type');

$xylsh = '';
if($content&&$type){
    if($type==1){
        
        $record = $mysql->select_one('yg_record', '*', 'xylsh=' . "'$content'" .
                        " and operation=1  order by id desc");
        if(!$record){
            $data['state'] = 0;
            $data['info'] = '未查到符合条件的记录';
        }else{
            $xylsh = $content ;
        }
        
    }else{
        $file = $mysql->select_one('yg_file', '*', 'file_num=' . "'$content'" .
                        "  order by id desc");
        if(!$file){
            $data['state'] = 0;
            $data['info'] = '未查到符合条件的记录';
        }else{
            $xylsh = $file['xylsh'] ;
            $record = $mysql->select_one('yg_record', '*', 'xylsh=' . "'$xylsh'" .
                        " and operation=1  order by id desc");
        }
    }
    
    if($xylsh){
        $data['sjr_name'] = $record['sjr_name'];
        $data['fjr_name'] = $record['fjr_name'];
        $data['cj_time'] = date('Y-m-d H:i',$record['operation_time']);
        $data['state'] = 1;
        
        //判断是否取件，退件未取，退件已取
        
        $record_qj = $mysql->select_one('yg_record', '*', 'xylsh=' . "'$xylsh'" .
                            "  and operation=2");
                            
        $record_tj = $mysql->select_one('yg_record', '*', 'xylsh=' . "'$xylsh'" .
                            "  and operation=4");   
                             
        if($record_tj&&$record_tj){
            //退件已取
            $data['statue'] = 4;
        }
        
        if(!$record_qj&&$record_tj){
            //退件未取
            $data['statue'] = 5;
        }   
                                       
        if(!$record_qj&&!$record_tj){
            //未取
            $data['statue'] = 1;
            //还需要判断是否过期
            if($record['yg_group_id']){
                $group = $mysql->select_one('yg_group', 'expire', 'id=' . $record['yg_group_id']);  
                if(!$group['expire']==0){
                    //取到存件时间
                    $now_time = time();
                    if (($now_time-$record['operation_time'])>($group['expire']*60)) {
                        $data['statue'] = 3;
                    }
                }
            }
        }
        
        if($record_qj&&!$record_tj){
            //已经取件
            $data['statue'] = 2;
            
        }
        
        if($record_qj){
            $data['qj_time'] = date('Y-m-d H:i',$record_qj['operation_time']);
        }  
    }
    
}else{
    $data['state'] = 0;
    $data['info'] = '缺少有效参数';
}
echo json_encode($data);
?>