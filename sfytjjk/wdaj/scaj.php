<?php 
   /** 我的预约案件查询
    * $sc_cx_type 1 案件进度 2 阅卷 3 已受理
    * $sc_cx_login_type 1 帐号 2 手机
   **/
   include('../common/global.php');
   
   $sc_cx_account = _request('sc_cx_account'); 
   $sc_cx_password = _request('sc_cx_password'); 
   $sc_cx_type = _request('sc_cx_type'); 
   $sc_cx_name = _request('sc_cx_name'); 
   $sc_cx_login_type = _request('sc_cx_login_type');
   $sc_cx_lsh = _request('sc_cx_lsh');
   $user_id = _request('user_id');
   $sc_cx_xh = _request('sc_cx_xh');
   
   
   $data = array();
   $data['is_sc'] = 1;
   $data['user_id'] = $user_id;
   $data['tdh_case_num'] = $sc_cx_lsh;
   $data['case_pwd'] = $sc_cx_password;  
   $data['sc_type'] = $sc_cx_login_type;
   $data['sc_login_type'] = 1;  
   if($sc_cx_account&&$sc_cx_password&&$sc_cx_login_type&&$sc_cx_type&&$sc_cx_lsh){
     if($sc_cx_type==1||$sc_cx_type==3){
         
        //先判断能不能查到，能查到就不能收藏
          $sql = 'select user_id,id from ssfw_case_handle where tdh_case_num ='.$sc_cx_lsh.' and user_id='.$user_id.' and is_show=0';
          //
          //$sql = 'select id from ssfw_case_handle where new_lsh ='.$sc_cx_lsh.' and new_type='.$sc_cx_login_type.' and new_account='.$sc_cx_account.' and user_id = '.$user_id. ' and new_pwd='."'$sc_cx_password'";
      
          $list = $mysql->get_one($sql);
          
          if($list){
              $result['state']='2'; 
          }else{
            //如果是已受理案件，保存该案件的受理后的帐号
              if($sc_cx_type==3){
                 $data['new_account'] = $sc_cx_account;
                 $data['new_pwd'] = $sc_cx_password;  
                 $data['new_type'] = $sc_cx_login_type; 
                 $data['new_lsh'] = $sc_cx_lsh;
                 $data['state'] = 2;  
                 $data['sc_login_type'] = 2;  
                 
                 
              }
              $lists = $mysql->insert('ssfw_case_handle',$data);
              if($lists){
                 $result['state']='1'; //代表成功
              }else{
                 $result['state']='0'; //代表失败
              } 
          }
     }else if($sc_cx_type==2){
        
         //先判断能不能查到已经查到就不能收藏
          $sql = 'select user_id,id from ssfw_review where user_id='.$user_id.' and lsh='.$sc_cx_lsh.' and account='.$sc_cx_account.' and pwd='.$sc_cx_password.' and xh='.$sc_cx_xh.' and is_show=0';;
          //$sql = 'select id from ssfw_case_handle where new_lsh ='.$sc_cx_lsh.' and new_type='.$sc_cx_login_type.' and new_account='.$sc_cx_account.' and user_id = '.$user_id. ' and new_pwd='."'$sc_cx_password'";
      
          $list = $mysql->get_one($sql);
          if($list){
            $result['state']='2'; //代表成功
          }else{
                $data = array();
                $data['is_sc'] = 1;
                $data['user_id'] = $user_id;
                $data['lsh'] = $sc_cx_lsh;
                $data['account'] = $sc_cx_account;
                $data['pwd'] = $sc_cx_password;  
                $data['xh'] = $sc_cx_xh;
                $data['lei_type'] = $sc_cx_login_type;
                
                $lists = $mysql->insert('ssfw_review',$data);
                if($lists){
                     $result['state']='1'; //代表成功
                }else{
                     $result['state']='0'; //代表失败
                } 
          }
     }
   }else{
      $result['state']='0'; 
   }
   echo json_encode($result);
   
?>