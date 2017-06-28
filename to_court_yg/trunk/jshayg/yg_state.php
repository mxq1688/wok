<?php
      /*获取云柜状态*/
      include('../common/global.php');
      $result = array();
      $court_id = _request('court_id'); 
      if($court_id){
          $sql = "select * from ssfw_yg_configuration where court_id = $court_id order by id";
          $list = $mysql -> get_all($sql);
          $i = 0;
          $j = 0;
          $m = 0;
        
          if ($list) {
                 foreach($list  as $keys=>$val){
                        $ygid = $val['number'];
                        $yg_sql = "select * from ssfw_yg_state where ygid='".$ygid."' and court_id = $court_id";
                        $yg_list = $mysql -> get_one($yg_sql);
                        $yg[$keys]['ygid'] = $ygid;
    
                        if ($yg_list) {
                               $cftime = $yg_list['cftime'];
                               //云柜过期读取配置
                               $gq_sql = "select * from ssfw_dmb where dmlb='云柜过期'";
                               $gq_list = $mysql -> get_one($gq_sql);
                               $gqhour = $gq_list['dmms'];
                               $nowtime = time();
                               if (($nowtime-$cftime)>($gqhour*60*60)) {
                                      //过期
                                      $yg[$keys]['state'] = 3;
                                      $i++;
                               } else {
                                      //已用
                                      $yg[$keys]['state'] = 2;
                                      $j++;
                               }
                        } else {
                              //未用
                              $yg[$keys]['state'] = 1;
                              $m++;
                        }
                        $result['state'] = 1; 
                        $result['yg'] = $yg; 
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