<?php 
   /** 预约阅卷进展查询
   type 1 原告 2 被告 3 第三人
   user_id 
   case_num 案件号',
   uses '用途',
   name  '申请人姓名',
   zj_type  '证件类型 1身份证 2 护照 3 军官证 ',
   zj_code  '证件号',
   mobile  '联系电话',
   create_time int(11) NOT NULL COMMENT '创建时间',
   
    **/
   include('../../../common/global.php');
   
   $result= array(); 
   $case_num = _request('case_num'); 
   $uses = _request('uses'); 
   $name = _request('name'); 
   $type = _request('type'); 
   $user_id = _request('user_id'); 
   $case_title = _request('case_title'); 
   $create_time = time(); 
   
   $account = _request('yue_account'); 
   $password = _request('yue_pwd'); 
   $yue_type = _request('yue_type'); 
   $court_id = _request('court_id'); 
   $wyyj_begintime = _request('wyyj_begintime');
   
   $wyyj_begintime = strtotime($wyyj_begintime);
   
   // ?case_num=1&uses=22&name=22&type=2&user_id=3&zj_type=3&zj_code=333&mobile=3
   if($case_num!='' && $uses!='' &&$name!='' &&$type!=''  && $user_id!=''){

      $data['case_num'] = del_yinhao($case_num);
      $data['uses'] = del_yinhao($uses);
      $data['name'] = del_yinhao($name);
      $data['type'] = del_yinhao($type);
      $data['user_id'] = del_yinhao($user_id);
      $data['create_time'] = $create_time;
      $data['account'] = $account;
      $data['pwd'] = $password;
      $data['lei_type'] = $yue_type;
      $data['lsh'] = $case_num;
      $data['court_id'] = $court_id;
      $data['case_title'] = $case_title;
      
      //查处该案件的案件类型
      $ysl_data['account'] = $account;
      $ysl_data['password'] = $password;
      $ysl_data['type'] = $yue_type;
      $ysl_data['lsh'] = $case_num;

      $data['case_type'] = get_yy_case_type($ysl_data,$mysql);
     
      $list = $mysql->insert('ssfw_review',$data);
     
      $id = $mysql->insert_id();
      
      //保存时间日志
      
        
      $time_log_data = array();
      $time_log_data['end_time'] = time();
      $time_log_data['product_id'] = 1;
      $time_log_data['user_id'] = $data['user_id'];
      $time_log_data['court_id'] = $data['court_id'];;
      $time_log_data['begin_time'] = $wyyj_begintime;
      $time_log_data['uses_time'] = time()-$wyyj_begintime;
      $time_log_data['type_id'] = $id;
      $time_log_data['type'] = 2;
        
      $time_log = $mysql->insert('ssfw_time_log',$time_log_data);
      
      if($list){
        //修改对应案件的预约字段
        //取到案由名称
        $sql = 'select is_review,id from ssfw_case_handle where case_num = '."'$case_num'" ;
          
        $list_case = $mysql->get_one($sql);
        if($list_case && $list_case['is_review']!=2){
            $case_data=array();
            $case_data['is_review'] = 2;
            $list = $mysql->update('ssfw_case_handle',$case_data,'id='.$list_case['id']);
        }
        
        
        
        //接口名称：http://ip:port/service/SqWsyj
       // $password = '205544';
       // $yue_type = '1';
       // $case_num = '115000000086926';
       // $account = '115014000111001';
        
        $fyid = '320000';
        
        $arr = array(
            
            'lsh' => base64_encode($case_num),
            'type' => base64_encode($yue_type),
            'account' => base64_encode($account),
            'password' => base64_encode($password),
            'fyid' => base64_encode($fyid),
            'sqnr' => base64_encode($type),
            'sqyy' => base64_encode($uses),
            'sqrxm' => base64_encode($name),
        );
        
        $curl = new Http();
        $url = $api['SqWsyj_Yz'];
       // $url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/SqWsyj_Yz';
        $xml = $curl->request($url,$arr,'POST');
        $xml = simplexml($xml);
        
        if(isset($xml->code)&&(xml_to_str($xml->code,true)=='true')){
            $data = array();
            $data['xh'] = xml_to_str($xml->msg,true);
            $mysql->update('ssfw_review',$data,'id='.$id);
            $result['state']='1'; 
            
        }else{
            $result['state']='0'; 
        }
        
         
      }else{
        $result['state']='0'; 
      }
     
   }else{
      $result['state']='0'; //代表失败
   }
   
   echo json_encode($result);
   
?>