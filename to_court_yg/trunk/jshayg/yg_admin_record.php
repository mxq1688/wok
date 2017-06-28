<?php
       //管理员操作：打开柜子
       include('../common/global.php');
       $result = array();

       $ygid = _request('ygid');
       $user_id = _request('user_id');
       $user_name = _request('user_name');
       $court_id = _request('court_id'); 
       
       $operationtime = time();
       $operationday = date("m",$operationtime).'.'.date("d",$operationtime);

       if ($ygid &&  $user_id && $user_name) {
              $sql = "select * from ssfw_yg_state where ygid='".$ygid."' and court_id=$court_id";
              $list = $mysql -> get_one($sql);

              if ($list) {
              //有记录  
                    $data['ygid'] = $ygid;
                    $data['user_id'] = $user_id;
                    $data['user_name'] = $user_name;
                    //管理员
                    $data['user_identity'] = 6;
                    $data['identity_new'] = "管理员";
                    $data['operation'] = 2;
                    $data['operationtime'] = $operationtime;
                    $data['case_id'] = $list['case_id'];
                    $data['fjr_id'] = $list['fjr_id'];
                    $data['sjr_id'] = $list['sjr_id'];
                    $data['operationday'] = $operationday;
                    $data['court_id'] = $court_id;

                    //确认当事人id
                    if ($list['fjr_identity_new'] == "法官" || $list['fjr_identity'] == 4) {
                          $dsr_id = $list['sjr_id'];
                    } else {
                           $dsr_id = $list['fjr_id']; 
                    }
                    if($dsr_id){
                        $dsr_sql = "select * from ssfw_yg_record where case_id=".$list['case_id']." and (sjr_id=".$dsr_id." or fjr_id=".$dsr_id.")";
                        $dsr_list = $mysql -> get_all($dsr_sql);
                        $num = count($dsr_list);
                        $num++;
                        $data['operationnum'] = $num;
                    }
                    
                    $insert_yg_record = $mysql -> insert('ssfw_yg_record',$data);
                    $del_yg_state = $mysql -> delete("ssfw_yg_state", "id=".$list['id']);
                    
                    //取得该案件的信息
                    $sql = "select * from ssfw_case_handle where id='".$list['case_id']."'";
                    $list_case = $mysql -> get_one($sql);
                    
                    $result['ah'] = $list_case['ah'];
                    $result['sjr_name'] = $list['sjr_name'];
                    $result['sjr_identity_new'] = $list['sjr_identity_new'];
                    $result['case_title'] = $list_case['case_title'];
                    
                    if ($insert_yg_record && $del_yg_state) {
                          $result['state'] = 1; 
                    } else {
                          $result['state'] = 0;  
                          $result['info'] = '有记录数据库修改出错';  
                    }
              } else{
                     //无记录
                    $data['ygid'] = $ygid;
                    $data['user_id'] = $user_id;
                    $data['user_name'] = $user_name;
                    //管理员
                    $data['user_identity'] = 6;
                    $data['identity_new'] = "管理员";
                    $data['operation'] = 2;
                    $data['operationtime'] = $operationtime;
                    $data['court_id'] = $court_id;
                    
                    $insert_yg_record = $mysql -> insert("ssfw_yg_record",$data);
                    if ($insert_yg_record) {
                          $result['state'] = 1; 
                    } else {
                          $result['state'] = 0;  
                          $result['info'] = '无记录数据库修改出错';  
                    }
              }
       } else {
              $result['state'] = 0;  
              $result['info'] = '缺少有效参数';  
       }

      echo json_encode($result);
?>