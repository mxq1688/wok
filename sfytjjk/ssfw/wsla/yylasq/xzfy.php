<?php 
   /** 选择法院**/
   include('../../../common/global.php');
   
   $court_id = _request('court_id');
   $type = _request('type');
   
   $sql = "select id,pid,court_num from  ssfw_court where id=".$court_id;
      
   $list_court = $mysql->get_one($sql);
   
   $str = substr($list_court['court_num'],0,2);
   $new_num = $str.'0000';
   
   $num = 0;
   
   //判断这个法院的高院id
   
   $sql = "select id from  ssfw_court where court_num=".$new_num;
   
   //取得高院的id
   $list_gypid = $mysql->get_one($sql);
   
   $gy_id = $list_gypid['id'];
   if(!$court_id){
     $court_id = $gy_id;
   }
   
    
    if($list_court['pid']!=0&&$list_court['pid']!=$gy_id){
        $zy_id = $list_court['pid'];
    }else if($list_court['pid']==$gy_id){
        $zy_id = $list_court['id'];
    }
    if($zy_id){
        //echo $zy_id;exit;
        //找到中院在第几个
        $sql = "select * from ssfw_court where id<".$zy_id.' and pid='.$gy_id;
        $list = $mysql->get_all($sql);
        $num = count($list);
    
    }
   
        
   $result= array();
   if($court_id&&$type){
        
        //判断是否是第三级
       // if($list['pid']!=0&&$list['pid']!=$gy_id){
            
            
            
            
        //    $num1 =  substr($list['court_num'],3,1);
//            $num2 =  substr($list['court_num'],2,1);
//            if($num2==0){
//                $num = $num1 - 1;
//            }else{
//                $num = $num1 + 10-1;
//            }
            
     //   }
        $result['data']=$num;
        $result['state']='1'; //代表成功
        
   }else{
        
        $sql = "select id,pid,court_num from  ssfw_court where id=".$court_id;
      
        $list = $mysql->get_one($sql);
        
        $str = substr($list['court_num'],0,2);
        $new_num = $str.'0000';
        
        $sql = "select id,pid,court_num from  ssfw_court where court_num=".$new_num;
      
        $list = $mysql->get_one($sql);
        
        $sql = "select id,pid,name,court_num from  ssfw_court where court_num like '%$str%'";
        $list = $mysql->get_all($sql);
        $vo =  list_to_tree($list);
        
        $result['data']=$vo;
        $result['num']=$num;
        $result['alldata']=$list;
        $result['state']='1'; //代表成功
   }
   
     //  print_R($result) ;

    echo json_encode($result) ;
   
?>