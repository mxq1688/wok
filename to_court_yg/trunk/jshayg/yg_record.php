<?php
      include('../common/global.php');
      $result = array();

      $case_id = _request('case_id');
      $user_id = _request('user_id');
      $identity = _request('identity');
      $identity_new = _request('identity_new');

      if ($case_id && $identity_new) {
            // if ($identity == 4) {
            if ($identity_new == "法官") {
                  $sql = "select * from ssfw_yg_record where case_id=".$case_id." order by id desc";
            } else {
                  $sql = "select * from ssfw_yg_record where case_id=".$case_id." and (fjr_id=".$user_id." or sjr_id=".$user_id.") order by id desc";
            }
            $list = $mysql -> get_all($sql);
            if ($list) {
                  $result['state'] = 1; 
                  $result['data'] = $list;  
            } else {
                  $result['state'] = 0;  
                  $result['info'] = '此案件暂无存取记录'; 
            }
      } else {
            $result['state'] = 0;  
            $result['info'] = '缺少有效参数';  
      }
      echo json_encode($result);
?>
