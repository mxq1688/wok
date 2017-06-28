<?php 
   /** 法院地址
   
   **/
   include('../../../common/global.php');
   $result= array();
   $court_id = _request('court_id'); 
   $court_id = get_court_id($court_id,$mysql);
   
   if($court_id){
      $sql = 'select name,address,code,zzbgs_tel,xzuobiao,yzuobiao,city from ssfw_court where id='.$court_id;
      $list = $mysql->get_one($sql);
      
      $result['data']=$list;
      $result['state']='1'; //代表成功
      
   }else{
      $result['state']='0'; //代表失败
   }
   
   echo json_encode($result);
   
?>