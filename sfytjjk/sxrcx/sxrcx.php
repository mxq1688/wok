<?php 
   /** 失信人查询
   名称必填 省份跟身份证或组织机构选填
   **/
   include('../common/global.php');
   $result= array();
   $name = del_yinhao(_request('name')); 
   $code = del_yinhao(_request('code')); 
   $province_id = _request('province_id'); 

   if($name){
      $sql = "select * from ssfw_dishonesty_user where name='{$name}'";
      if($code){
         $sql.=' and code='.$code;
      }
      if($province_id){
        $sql.=' and province_id='.$province_id;
      }
      
      $list = $mysql->get_all($sql);
      $vo = array();
      foreach($list  as $keys=>$val){
            $val['create_time'] = date('H年m月d日',$val['create_time']);
            $val['la_time'] = date('H年m月d日',$val['la_time']);
            $vo[$keys] = $val; 
        }
        
      $result['data']=$vo;
      $result['state']='1'; //代表成功

   }else{
      $result['state']='0'; //代表失败
   }
   echo json_encode($result);
   
?>