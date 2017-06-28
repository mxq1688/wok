<?php 
   /** 登录页面
  通过身份证号取得用户id
   **/
   include('../common/global.php');
   $result= array();
   $identity_num = _request('identity_num'); 
   $name = _request('name');
   if($identity_num){
       $sql = "select id from  ssfw_litigation_user where identity_num = "."'$identity_num'";
  
       $list = $mysql->get_one($sql);
       if(!$list){
          $data['identity_num'] = $identity_num;
          $data['name'] = $name;
          $mysql->insert('ssfw_litigation_user',$data);
          $id = $mysql->insert_id();
          $list['id'] = $id;
       }
       
       $result['data']=$list['id'];
       $result['state']='1'; //代表成功
       
   }else{
       $result['state']='0'; //失败
   }
   echo json_encode($result);
?>
