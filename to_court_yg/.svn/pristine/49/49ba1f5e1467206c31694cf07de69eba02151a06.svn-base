<?php 
   /** 根据法院的id获取法院的信息
   **/
   include('../common/global.php');
   $result= array();
    /** 搜索关键字**/
   $keys = _request('court_num'); 
   if($keys){
      $list = array();
      $sql = 'select id,name from court where court_num='.$keys;
      $list = $mysql->get_one($sql);
      if(!$list){
         $list['id'] = 58;
         $list['name'] = '江苏省高级人民法院';
      }
       $result['state']='1'; //代表成功
       $result['data'] = $list;
   }else{
       $result['state']='0'; 
       $result['info']='缺少参数'; 
   }
   
   
   echo json_encode($result);
   
?>  