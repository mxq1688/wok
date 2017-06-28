<?php 
   /** 选择法院 没有分级**/
   include('../../../common/global.php');
   $result= array();
   $sql = "select id,pid,name from  ssfw_court ";
  
   $list = $mysql->get_all($sql);

  // $vo =  list_to_tree($list);
    

    $result['data']=$list;
    $result['state']='1'; //代表成功
     //  print_R($result) ;
    echo json_encode($result) ;
   
?>