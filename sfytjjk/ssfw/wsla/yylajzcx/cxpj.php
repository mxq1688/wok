<?php 
   /** 查看评价
    type 1 立案评价
        2 阅卷评价
    type_id 指案件号case_num或阅卷review_id
   **/
   include('../../../common/global.php');
   $result= array();

   $type_id = _request('type_id'); 
   $user_id = _request('user_id'); 
   $type = _request('type'); 
   
   if($type_id!=''&&$user_id!=''&&$type!=''){
      
      $sql = 'select fw_gz,fw_xl,fw_td from ssfw_evaluate where  type='.$type.' and user_id = '.$user_id. ' and type_id='."'$type_id'";
      
      $list = $mysql->get_one($sql);
      if($list){
        $result['state']=1;
      }else{
        $result['state']=1;
      }
      $result['data']=$list;
      
   }else{
      $result['state']='0'; //代表没有评价
   }
   
   echo json_encode($result);
   
?>