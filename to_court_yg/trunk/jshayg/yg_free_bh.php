<?php
        /*获取空闲柜子*/
       include('../common/global.php');
       
       $court_id = _request('court_id');
       
       $gz_sql = "select number from ssfw_yg_configuration where number not in (select ygid from ssfw_yg_state where court_id=$court_id) and court_id=$court_id order by id";
       $gz_list = $mysql -> get_one($gz_sql);
       if ($gz_list) {
              $result['ygid'] = $gz_list['number'];
              $result['state'] = 1;  
       } else {
              $result['state'] = 0;  
              $result['info'] = "没有空闲柜子，请等待";  
       }
       echo json_encode($result);
?>
                 
                    