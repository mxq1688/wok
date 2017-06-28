<?php 
   /** 选择法院
   1 民事
   2 执行
   3 行政
   **/
   include('../../../common/global.php');
   $result= array();
   $sql = "select id,pid,action_num,name as text from  ssfw_case_action where type=1";
  
   $list = $mysql->get_all($sql);

   $vo =  list_to_treeanyou($list);
    

    $result['data']=$vo;
    $result['state']='1'; //代表成功
     //  print_R($result) ;

    echo  json_encode($result) ;
   
?>
