<?php 
    session_start();

   /** 验证码检验
   **/
   include('../common/global.php');

   $result = array();
   $content = !empty($_SESSION['content']) ? $_SESSION['content'] : '';
   //echo $content;
   $yzm = _request('yzm'); 
   $user_id = _request('user_id'); 
   $sql = "select val from ssfw_session where type=1 and user_id=".$user_id;

   $list = $mysql->get_one($sql);
   $str = strtolower($list['val']);
   if($yzm){
      if($yzm==$list['val']||$str==$yzm){
         $result['result']='success';
      }else{
         $result['result']='fail';
      }
      $result['state']='1';
   }else{
      $result['state']='0';
   }

   echo json_encode($result);
   
?>