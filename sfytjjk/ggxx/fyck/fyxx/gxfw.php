<?php 
   /** 法院信息 管辖范围
   type 1 管辖范围
   type 2 部门职能
   type 3 投诉渠道
   **/
   include('../../../common/global.php');
   $result= array();
   $court_id = _request('court_id'); 
   $type = _request('type'); 
   $court_id = get_court_id($court_id,$mysql);
   
   if($court_id){
      $sql = 'select dept_position,manage_range,complaint from ssfw_court where id='.$court_id;
      $list = $mysql->get_one($sql);
      
      if($type==1){
        $result['data']=$list['manage_range'];
      } else if($type==2){
        $result['data']=$list['dept_position'];
      }else if($type==3){
        $result['data']=$list['complaint'];
      }else{
        $result['data']=$list['manage_range'];
      }
      
      $result['state']='1'; //代表成功
     
   }else{
      $result['state']='0'; //代表失败
   }
   echo json_encode($result);
   
?>