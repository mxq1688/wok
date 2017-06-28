<?php 
   /** 绑定案件信息
    **/
   include('../common/global.php');
   
   $result= array(); 
   $accound = _request('accound'); 
   $case = _request('case'); 
   $password = _request('password'); 
   $type = _request('type'); 
   $lsh = _request('new_lsh'); 

   if($accound!='' && $case!='' &&$password!='' &&$type!=''){

      $data['new_lsh'] = $lsh;
      $data['new_pwd'] = $password;
      $data['new_account'] = $accound;
      $data['new_type'] = $type;
      
      //判断该案件是否已经提交了
      
      $sql = 'select id from ssfw_case_handle where tdh_case_num = '."'$case'" ;
          
      $list= $mysql->get_one($sql);
      
      if($list){
         $list = $mysql->update('ssfw_case_handle',$data,'id='.$list['id']);
         echo '1';
      }else{
         echo '0';
      }

     
   }
   //echo json_encode($result);
   
?>