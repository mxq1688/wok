<?php
       //管理员操作：打开柜子
       include('../common/global.php');
       $result = array();

       $case_id = _request('case_id');
       $dsr_id = _request('dsr_id');

       if ($case_id && $dsr_id) {
              $sql = "select * from ssfw_sdhz where case_id=$case_id and dsr_id=$dsr_id and sdhz = 1";
              $list = $mysql -> get_one($sql);
              $result['mobile'] = $list['mobile']; 
              $result['state'] = 1; 
              $result['sdhz_type'] = array_filter(explode(',',$list['sdhz_type']));;  
       } else {
              $result['state'] = 0;  
              $result['info'] = '缺少有效参数';  
       }

      echo json_encode($result);
?>