<?php 
   /** 获取新闻咨询**/
   include('../../common/global.php');
   $result= array();
   $court_id = _request('court_id'); 
   
   if($court_id){
      $sql = 'select id from ssfw_court where  court_num='."'$court_id'";
      $list_court = $mysql->get_one($sql);
      if($list_court){
        $sql = 'select id from ssfw_product where  court_id='.$list_court['id'];
        $list_state = $mysql->get_one($sql);
        if(!$list_state){
            $court_id = 320000;
        }
      }else{
        $court_id = 320000;
      }
    
   }else{
      $court_id = 320000;
   }
   
   if($court_id){
      //通过法院编号找到对应的id
      $sql_court = "select * from ssfw_court where court_num=".$court_id;
      
      $list_court = $mysql->get_one($sql_court);
      if($list_court){
        $name = $list_court['name'];
      }

        $result['data']=$name;
        $result['state']='1'; //代表成功
   }else{
      $result['state']='0'; //代表失败
   }
   echo json_encode($result);
   
?>