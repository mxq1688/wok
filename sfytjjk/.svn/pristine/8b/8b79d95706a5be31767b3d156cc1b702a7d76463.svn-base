<?php 
   /** 查看卷宗
    * type 1 申诉人原告
    * type 2 被告
   **/
   include('../../../common/global.php');
   $result= array();

   $case_num = _request('case_num'); 
   
   if($case_num!=''){
      
      //原告人
      $yg_sql = 'select name,address,sex from ssfw_case_user where  type=1 and case_num = '."'$case_num'";;
      $yg_list = $mysql->get_all($yg_sql);
      
      //被告人
      $bg_sql = 'select name,address,sex from ssfw_case_user where type=2 and case_num = '."'$case_num'";;
      $bg_list = $mysql->get_all($bg_sql);
      
      //案由
      $sql = 'select case_action_name,litigation_request,fact_request from ssfw_case_handle where  case_num = '."'$case_num'";;
      $list = $mysql->get_one($sql);
      
      $result['ygdata'] = $yg_list;
      $result['bgdata'] = $bg_list;
      $result['date'] = $list;
      $result['state']=1;
      
   }else{
      $result['state']='0'; //代表失败
   }
   
   echo json_encode($result);
   
?>