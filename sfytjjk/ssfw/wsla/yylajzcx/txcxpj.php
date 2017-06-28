<?php 
   /** 预约立案进展查询评价
   type 1 立案评价
        2 阅卷评价
   type_id 指案件号case_num或阅卷review_id
   **/
   include('../../../common/global.php');
   $result= array();
   
   $type_id = _request('type_id'); 
   $user_id = _request('user_id'); 
   $fw_td = _request('fw_td'); 
   $fw_xl = _request('fw_xl'); 
   $fw_gz = _request('fw_gz'); 
   $type = _request('type'); 
   
   $data['user_id'] = $user_id;
   $data['fw_td'] = $fw_td;
   $data['fw_xl'] = $fw_xl;
   $data['fw_gz'] = $fw_gz;
   $data['create_time'] = time();
   $data['type'] = $type;
   $data['type_id'] = $type_id;
   
   if($type_id!=''&&$user_id!=''&&$fw_td!=''&&$fw_xl!=''&&$fw_gz!=''&&$type!=''){
      
      $sql = 'select id from ssfw_evaluate where  type='.$type.' and user_id = '.$user_id. ' and type_id='."'$type_id'";
      
      $list = $mysql->get_one($sql);
      
      if($list){
          $lists = $mysql->update('ssfw_evaluate',$data,'id='.$list['id']);
          if($lists){
             $result['state']='1'; //代表成功
          }else{
             $result['state']='0'; //代表失败
          } 
      }else{
          $lists = $mysql->insert('ssfw_evaluate',$data);
          if($lists){
             $result['state']='1'; //代表成功
          }else{
             $result['state']='0'; //代表失败
          } 
      }
      
   }else{
       $result['state']='0'; //代表失败
   }
   
   
   
   echo json_encode($result);
   
?>