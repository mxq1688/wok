<?php 
   /** 查看阅卷卷宗
  
   **/
   include('../../../common/global.php');
   $result= array();
   
   $case_num = _request('case_num'); 
   
   if($case_num){

       $sql = 'select a.*,b.course_room_name,b.course_room_id,b.lawful_time from ssfw_case_handle as a join ssfw_notice as b on a.case_num = b.case_num where a.case_num= '."'$case_num'";
       $list = $mysql->get_one($sql);
       $list['lawful_time'] = date('Y/m/d',$list['lawful_time']);
       
       $user_sql = 'select a.type,a.name,a.character_type from ssfw_case_user as a where a.case_num = '."'$case_num'";
       $user_list = $mysql->get_all($user_sql);
       
       
        //卷宗信息
       $sql = 'select * from ssfw_review_material where case_num = '."'$case_num'";
       $mardata = $mysql->get_all($sql);
       
       $result['data']=$list;
       
       $result['yymardata']=$mardata;
       $result['state']='1'; //代表成功
       
       
   }else{
       $result['state']=0;
   }
   
   
   echo json_encode($result);
   
?>