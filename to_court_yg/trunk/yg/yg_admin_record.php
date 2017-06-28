<?php
       //管理员操作：打开柜子
       include('../common/global.php');
       $result = array();

       $ygid = _request('ygid');
       $user_id = _request('user_id');
       $user_name = _request('user_name');
       $court_id = _request('court_id'); 
       $group_id = _request('group_id');

       $operationtime = time();
       $operationday = date("m",$operationtime).'.'.date("d",$operationtime);
       $group_id =1;

       if ($ygid &&  $user_id && $user_name) {
              $sql = "select * from yg_box where number='".$ygid."' and court_id=$court_id and state=2 and group_id=$group_id";
              $list = $mysql -> get_one($sql);

              $xylsh=$list['xylsh'];
              if ($list) {
              //有记录  
                    $data['box_num'] = $ygid;
                    $data['user_id'] = $user_id;
                    $data['user_name'] = $user_name;
                    //管理员
                    //$data['user_identity'] = 6;
                    $data['identity_name'] = "管理员";
                    $data['operation'] = 2;
                    $data['operation_time'] = $operationtime;


                    $sql = "select * from yg_cj_info where xylsh='".$xylsh."'";
                    $ret = $mysql -> get_one($sql);
                    $data['fjr_id'] = $ret['fjr_id'];
                    $data['sjr_id'] = $ret['sjr_id'];
                    $data['operation_day'] = $operationday;
                    $data['court_id'] = $court_id;
                    $data['yg_group_id'] = $group_id;

                    $insert_yg_record = $mysql -> insert('yg_record',$data);
                   
                    
                    
                    //修改云柜使用状态
                    $data_info = array();
                    $data_info['xylsh'] = '';
                    $data_info['state'] = '1';
                    
                    $res_box = $mysql->update('yg_box', $data_info, 'xylsh='."'$xylsh'");

                    //修改二维码表信息
                    $data_info = array();
                    $data_info['state'] = '0';
                    $res_qr_code = $mysql->update('qr_code', $data_info, 'xylsh='."'$xylsh'");
                    $result['ah'] = $ret['ah'];
                    $result['sjr_name'] = $ret['sjr_name'];
                    if ($insert_yg_record) {
                          $result['state'] = 1; 
                    } else {
                          $result['state'] = 0;  
                          $result['info'] = '有记录数据库修改出错';  
                    }

              } else{
                     //无记录
                    $data['box_num'] = $ygid;
                    $data['user_id'] = $user_id;
                    $data['user_name'] = $user_name;
                    //管理员
                    //$data['user_identity'] = 6;
                    $data['identity_name'] = "管理员";
                    $data['operation'] = 2;
                    $data['operation_time'] = $operationtime;
                    $data['court_id'] = $court_id;
                    $data['yg_group_id'] = $group_id;
                    $insert_yg_record = $mysql -> insert("yg_record",$data);
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