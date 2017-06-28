<?php 
   /** 选择案由 拼出需要的数据**/
   include('../../../common/global.php');
   $result= array();
   //$sql = "select id,pid,name,action_num  from  ssfw_case_action where type=2";
//    $list = $mysql->get_all($sql);
//    
//     $html = '';
//    foreach($list as $val){
//        $html .='<li class="list-group-item node-treeview1 nodeid-'.$val['action_num'].' nodepid-'.$val['pid'].'"' ;
//        $html .='onclick="change_tree()" data-nodeid="'.$val['action_num'].'" style="display: none;"><span class="indent"></span><span class="indent"></span>';
//        $html .='<span class="indent"></span><span class="expand-collapse glyphicon"></span>';
//        $html .='<span class="icon glyphicon glyphicon-stop"></span>'.$val['name'].' </li>';
//    }
    

   /** 选择法院
   1 民事
   2 执行
   **/
 //  include('../../../common/global.php');
   $result= array();
   $sql = "select id,pid,action_num,name as text from  ssfw_case_action where type=2";
  
   $list = $mysql->get_all($sql);

   $vo =  list_to_treeanyou($list);
    

    $result['data']=$vo;
    $result['state']='1'; //代表成功
     // print_R($result) ;exit;

    echo json_encode($result) ;

   

    

  
   
?>