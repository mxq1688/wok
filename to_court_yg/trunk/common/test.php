<?php
   include('global.php');
   //print_R($api);exit;
  echo  getRandChar(18);exit;
   
    $sql = 'select case_action_name,id from ssfw_case_handle';
  
    $list_court = $mysql->get_all($sql);
    if($list_court){
       foreach($list_court as $val){
          $name = $val['case_action_name'];
           $sql2 = 'select * from ssfw_case_action where name ='."'$name'";
           $list = $mysql->get_one($sql2);
           if($list){
               $a = $mysql->update('ssfw_case_handle',array('case_action_id'=>$list['id']),'id='.$val['id']);
           }
           
       }
    }
?>