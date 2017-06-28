<?php
       /*返回前台显示的案件信息*/
       include('../common/global.php');
       $result = array();
       $case_id = _request('case_id');
    
       if ($case_id) {   
              //根据流水号获取案件信息： 案件名称，案件类型，立案日期 （根据铉盈流水号）
              $sql = "select case_title,type,create_time,judge_name,ah,case_action_name from ssfw_case_handle where id=".$case_id;
              $list = $mysql -> get_one($sql);
              if ($list) {
                    $result['ajmc'] = @$list['case_title'];
                    $result['ajlx'] = $list['type'];
                    $result['larq'] = date("Y-m-d H:i",$list['create_time']);
                    $result['fg'] = @$list['judge_name'];
                    $result['ah'] = @$list['ah'];
                    $result['ay'] = $list['case_action_name'];
                    $result['state'] = 1;  //代表成功
              }
       } else {
             $result['state'] = 0;  
             $result['info'] = '缺少有效参数';  
       }
      echo json_encode($result);
?>