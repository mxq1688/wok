<?php 
   /** 获取二维码
   **/
   include('../common/global.php');
   $id = _request('id'); 
   $type = _request('type');
   $result = array();
   $data = array();
   
   if($id){
       if($type==2){
           $sql = "select is_show from  ssfw_review where id = "."'$id'";
           $list = $mysql->get_one($sql);
           
           $data['is_show'] = 1;
           if($list){
              $list = $mysql->update('ssfw_review',$data,'id='.$id);
              $state = 1;
           }else{
              $state = 0;
           }
       }else{
           $sql = "select is_show from  ssfw_case_handle where id = "."'$id'";
           $list = $mysql->get_one($sql);
           
           $data['is_show'] = 1;
           if($list){
              $list = $mysql->update('ssfw_case_handle',$data,'id='.$id);
              $state = 1;
           }else{
              $state = 0;
           }
       }
       
   }else{
      $state = 0;
   }
   
   $result['state'] = $state;
   
   echo json_encode($result);
?>
