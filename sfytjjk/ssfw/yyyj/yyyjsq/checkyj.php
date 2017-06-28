<?php 
   /** 阅卷判断是否已经申请过了并且已经受理
   state 》2  指案件受理状态 
   **/
   include('../../../common/global.php');
   $result= array();
   $case_num = _request('case_num'); 
   $user_id = _request('user_id'); 
   
   if($user_id && $case_num){
    
      $sql_yue = "select * from ssfw_review where case_num='$case_num' and user_id = '$user_id' and state=2";
      $list = $mysql->get_one($sql_yue);
      if($list){
        $result['state']=2; //已经通过了不能在阅卷了
      }else{
        $result['state']=1; 
      }
      
      
   }else{
      $result['state']=0; 
   }


   echo json_encode($result);
   
?>