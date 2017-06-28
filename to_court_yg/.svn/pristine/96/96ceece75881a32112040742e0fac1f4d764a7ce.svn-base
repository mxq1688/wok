<?php
      /*获取云柜状态*/
      include('../common/global.php');
      $result = array();
      $court_id = _request('court_id'); 
      $group_id = _request('group_id');
      $group_id =1; 
      if($court_id){
          $sql = "select * from yg_box where court_id = $court_id and group_id=$group_id order by id";
          $list = $mysql -> get_all($sql);
          $i = 0;
          $j = 0;
          $m = 0;
        //print_r($list);exit;
          if ($list) {
                 foreach($list  as $keys=>$val){
    
                        if ($val['state']==2) {
                               
                               //取得柜子使用时间点
                               $gq_sql = "select * from yg_record where box_num='".$val['number']."' and court_id='".$court_id."' order by id desc";
                               $gq_list = $mysql -> get_one($gq_sql);
                               //取得柜子过期时间
                               $group_sql = "select * from yg_group where id='".$val['group_id']."'";
                               //print_r($group_sql);exit;
                               $group_list = $mysql -> get_one($group_sql);
                               
                               $nowtime = time();

                               if (($nowtime-$gq_list['operation_time'])>($group_list['expire']*60)) {
                                      //过期
                                      
                                      $i++;
                               } else {
                                      //已用
                                
                                      $j++;
                               }
                        } else {
                              //未用
                              //$yg[$keys]['state'] = 1;
                              $m++;
                        }
                        $result['state'] = 1; 
                        //$result['yg'] = $yg; 
                        $result['wy_num'] = $m; 
                        $result['yy_num'] = $j;  
                        $result['gq_num'] = $i;  
                 }
          } else {
                $result['state'] = 0;  
                $result['info'] = '云柜配置为空，请联系系统管理员';  
          }
      }else{
         $result['state'] = 0;  
         $result['info'] = '缺少参数'; 
      }
      echo json_encode($result);
?>