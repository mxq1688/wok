<?php 
   /** 立案用户信息**/
   include('../../../common/global.php');
   $result= array();
   $user_id = _request('user_id'); 
   if($user_id){
       $sql = "select email,identity_num,mobile,name from  ssfw_litigation_user where id = ".$user_id;
  
       $list = $mysql->get_all($sql);
  
       $result['data']=$list;
       $result['state']='1'; //代表成功
   }else{
       $result['state']='0'; //失败
   }
   
     //  print_R($result) ;

    echo json_encode($result) ;
   
?>