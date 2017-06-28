<?php 
   /** 失信人查询结果详情页
   **/
   include('../common/global.php');
   $result= array();
   $id = _request('id'); 

   if($id){
      $sql = "select * from ssfw_dishonesty_user where id=".$id;
      
      $list = $mysql->get_one($sql);

      $result['data']=$list;
      $result['state']='1'; //代表成功
      
   }else{
      $result['state']='0'; //代表失败
   }
   
   echo json_encode($result);
   
?>