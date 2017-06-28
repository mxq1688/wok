<?php 
   /** 数据字典
   type =1;民族
   2       国家
   **/
   include('../../../common/global.php');
   $result= array();
   $mz_sql = "select * from  ssfw_ziliao where type=1";
   $mz_list = $mysql->get_all($mz_sql);
   
   $gj_sql = "select * from  ssfw_ziliao where type=2";
   $gi_list = $mysql->get_all($gj_sql);
   
   
   $mz_arr = array();
   if($mz_list){
     foreach($mz_list as $key=>$val){
        $id = $val['daihao'].'-'.$val['num'];
        $mz_arr[$key]['id'] = $id;
        $mz_arr[$key]['name'] = $val['name'];
     }
   }
   
   $gj_arr = array();
   if($gi_list){
     foreach($gi_list as $key=>$val){
        $id = $val['daihao'].'-'.$val['num'];
        $gj_arr[$key]['id'] = $id;
        $gj_arr[$key]['name'] = $val['name'];
     }
   }

   $arr = array();
   $arr['mz_data'] = $mz_arr;
   $arr['gj_data'] = $gj_arr;

   
   echo json_encode($arr);  

    

  
   
?>