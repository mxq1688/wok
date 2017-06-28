<?php
       //管理员操作：打开柜子
       include('../common/global.php');
       $result = array();
       
       $court_id = _request('court_id');     
       $ygid = _request('ygid');

       if ($ygid ) {
              $sql = "select * from ssfw_yg_state where ygid='".$ygid."' and court_id = $court_id";
              $list = $mysql -> get_one($sql);

              if ($list) {
              //有记录  
                    //取得该案件的信息
                    $sql = "select * from ssfw_case_handle where id='".$list['case_id']."'";
                    $list_case = $mysql -> get_one($sql);
                    
                    $result['ah'] = $list_case['ah'];
                    $result['sjr_name'] = $list['sjr_name'];
                    $result['sjr_identity_new'] = $list['sjr_identity_new'];
                    $result['case_title'] = $list_case['case_title'];
                    $result['state'] = 1; 
                    
                    
              }else{
                 $result['state'] = 0;  
              } 
       } else {
              $result['state'] = 0;  
              $result['info'] = '缺少有效参数';  
       }

      echo json_encode($result);
?>