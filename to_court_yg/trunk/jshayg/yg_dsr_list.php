<?php
  /*当事人列表*/
       include('../common/global.php');
       $result = array();
       $case_id = _request('case_id');
       $identity = _request('identity');
       $user_id = _request('user_id');
       $identity_new = _request('identity_new');

       if ($identity_new && $case_id) {   
              //法官身份
              // if ($identity == 4) {
             if ($identity_new == "法官") {
                    $sql = "select * from ssfw_case_user where case_id=".$case_id;
                    $list = $mysql -> get_all($sql); 
                    if ($list) {
                          foreach($list  as $keys=>$val){
                                  // $dsr_id = $val['user_id'];
                                  $dsr_id = $val['id'];
                                  $dsr_sql = "select id,sjr_id,fjr_id,ygid,sjr_identity,fjr_identity,sjr_name,fjr_name from ssfw_yg_state where case_id=".$case_id." and (sjr_id=".$dsr_id." or fjr_id=".$dsr_id.")";
                                  $dsr_list = $mysql -> get_one($dsr_sql);  
                                  if ($dsr_list) {
                                         $dsrlist[$keys]['ygid'] = $dsr_list['ygid'];
                                         if ($dsr_id == $dsr_list['sjr_id']) {
                                               $dsrlist[$keys]['operation'] = '改件';
                                         } else if ($dsr_id == $dsr_list['fjr_id']) {
                                               $dsrlist[$keys]['operation'] = '取件';
                                         }
                                  } else {
                                        //没有存件  法官存件待定（位置，可能多个）
                                        $dsrlist[$keys]['operation'] = '存件';
                                        $dsrlist[$keys]['ygid'] = "待定";
                                  }
                                  $dsrlist[$keys]['dsr_name'] = $val['user_name'];
                                  $dsrlist[$keys]['dsr_id'] = $val['id'];
                                  $dsrlist[$keys]['dsr_identity'] = $val['type'];
                                  $dsrlist[$keys]['dsr_identity_new'] = $val['identity_new'];
                          }
                          $result['data'] = $dsrlist;  
                          $result['state'] = 1;  
                    } else {
                           $result['state'] = 0;  
                           $result['info'] = '此案件无当事人信息';
                    }
              //当事人身份
              } else {
                    //获取收件人和发件人信息
                    $sql = "select id,sjr_id,fjr_id,ygid,sjr_identity,fjr_identity,sjr_name,fjr_name from ssfw_yg_state where case_id=".$case_id." and (sjr_id=".$user_id." or fjr_id=".$user_id.")";
                    $list = $mysql -> get_one($sql);  
                    if ($list) {
                           $result['ygid'] = $list['ygid'];
                           if ($user_id == $list['sjr_id']) {
                                  $result['operation'] = '取件';
                                  // $result['dsr_name'] = $list['sjr_name'];
                           } else if ($user_id == $list['fjr_id']) {
                                  $result['operation'] = '改件';
                                  // $result['dsr_name'] = $list['fjr_name'];
                           }
                    } else {
                          //没有存件
                          $result['operation'] = '存件';
                          $gz_sql = "select number from ssfw_yg_configuration where number not in (select ygid from ssfw_yg_state) order by id";
                          $gz_list = $mysql -> get_one($gz_sql);
                          if ($gz_list) {
                               $result['ygid'] = $gz_list['number'];
                          }
                    }
                    $result['state'] = 1;  
              }
       } else {
             $result['state'] = 0;  
             $result['info'] = '缺少有效参数';
       }

       echo json_encode($result);
?>