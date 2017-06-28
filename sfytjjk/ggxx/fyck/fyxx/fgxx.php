<?php 
   /** 法官信息
   type 1 法官 数据库id代表 14
   type 2 审委会成员 数据库id代表 15
   **/
   include('../../../common/global.php');
   $result= array();
   $court_id = _request('court_id'); 
   $type = _request('type'); 
   $court_id = get_court_id($court_id,$mysql);
   if($court_id){
      $sql = 'select emp_no,sex,name,address,office_tel,dept_id,pic from ssfw_court_user where court_id='.$court_id.' and position_id=';
      
      if($type==1){
        $sql .= 14;
      } else if($type==2){
        $sql .= 15;
      }else{
        $sql .= 14;
      }
      $list = $mysql->get_all($sql);
        
      if($type==2){
          $court_sql = 'select name from ssfw_court where id='.$court_id;
          $court_list = $mysql->get_one($court_sql);
          
          if($list){
            $vo = array();
            foreach($list  as $keys=>$val){
                $vo[$keys]['court_name'] = $court_list['name'];
                /** 判断图片是否存在**/
                if($val['pic']==''){
                    $val['pic'] = AVATOR_IMG;
                }
                $vo[$keys] = $val;
             }
          }
      } else{
         if($list){
            $vo = array();
            foreach($list  as $keys=>$val){
                /** 判断图片是否存在**/
                if($val['pic']==''){
                    $val['pic'] = AVATOR_IMG;
                }
                $val['post'] = '法官';
                $vo[$keys] = $val;
             }
          }
      }
      
      
      $result['data']=$vo;
      $result['state']='1'; //代表成功
      
   }else{
      $result['state']='0'; //代表失败
   }
   
   echo json_encode($result);
   
?>