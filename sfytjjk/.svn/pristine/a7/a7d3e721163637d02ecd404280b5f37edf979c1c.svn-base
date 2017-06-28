<?php 
   /** 开庭公告
  
   **/
   include('../../common/global.php');
   $result= array();
   $court_id = _request('court_id'); 
   /** 搜索时间**/
   $begin_time = _request('begin_time'); 
   $end_time = _request('end_time'); 
  
  if($court_id!=58 && $court_id!=86){
      $court_id = 58;
   }
   if($court_id){
      $sql = "select a.*,b.name as floor_name,b.num from ssfw_notice a join ssfw_room_floor b on a.floor_id = b.id where a.court_id=".$court_id;
      if($begin_time){
         $begin_time = strtotime($begin_time);
         $sql.=' and lawful_time>='.$begin_time;
      }
      if($end_time){
        $end_time = strtotime($end_time)+86400;
        $sql.=' and lawful_time<='.$end_time;
      }
      
      $list = $mysql->get_all($sql);
      $vo = array();
      if($list){
        
         foreach($list  as $keys=>$val){
            
                $val['lawful_time'] = date('Y/m/d H:i',$val['lawful_time']);
                $val['create_time'] = date('Y/m/d H:i',$val['create_time']);
                $today = date('Y-m-d',time());
                $create_today = date('Y-m-d',strtotime($val['lawful_time']));
                $val['title'] = sub_str($val['title'],40);
                if($today==$create_today){
                    $val['today'] = 1;
                }else{
                    $val['today'] = 0;
                }
            $vo[$keys] = $val;
                
          }
      
      }
      $result['data']=$vo;
      $result['state']='1'; //代表成功
     
   }else{
      $result['state']='0'; //代表失败
   }
   
   echo json_encode($result);
   
?>