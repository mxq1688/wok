<?php
   include('global.php');
   header("Content-type:text/html;charset=utf-8");

   
//   
//   
   print_R($api);exit;
  echo   $str = getRandChar(18);
 echo $str = getRandChar(20).'ddddddddddd';
 $str1 = substr($str,0,5);
 $str2 = substr($str,5,5);
 $str3 = substr($str,10,5);
 $str4 = substr($str,15,5);
 echo $str1.'-'.$str2.'-'.$str3.'-'.$str4;
 exit;
//   
//    $sql = 'select case_action_name,id from ssfw_case_handle';
//  
//    $list_court = $mysql->get_all($sql);
//    if($list_court){
//       foreach($list_court as $val){
//          $name = $val['case_action_name'];
//           $sql2 = 'select * from ssfw_case_action where name ='."'$name'";
//           $list = $mysql->get_one($sql2);
//           if($list){
//               $a = $mysql->update('ssfw_case_handle',array('case_action_id'=>$list['id']),'id='.$val['id']);
//           }
//           
//       }
//    }
?>