<?php 
   /** 查看法庭位置**/
   include('../../common/global.php');
   
   $result= array();
   $court_id = _request('court_id'); 
   
   $court_id = get_court_id($court_id,$mysql);
   
   if($court_id){
      $floor_sql = 'select id,name,num from ssfw_room_floor where court_id='.$court_id;
      $floor_list = $mysql->get_all($floor_sql);
      if($floor_list){
        
        $room_data = array();
        
        /** 取得所有楼层**/
        foreach($floor_list  as $keys=>$val){
            
            $room_sql = 'select address_pic,name from ssfw_court_room where court_id='.$court_id.' and floor_id='.$val['id'];
            $room_list = $mysql->get_all($room_sql);
            $vo = array();
            if($room_list){
                foreach($room_list as $key=>$va){
                   
                    /** 判断图片是否存在**/
                    if($va['address_pic']==''){
                        $va['address_pic'] = COUET_ROOM_ADDRESS_IMG;
                    }else{
                        $va['address_pic'] = $baseurl.$va['address_pic'];
                    }
                    $vo[$key] = $va;
                } 
            }
            $room_data[$keys]['name'] = $val['name'];
            $room_data[$keys]['num'] = $val['num'];
            $room_data[$keys]['items'] = $vo;
        }
        
        $result['room_data']=$room_data;
        $result['floor_data']=$floor_list;
        $result['state']='1'; //代表成功
      }else{
        $result['state']='1';
        $result['room_data']=array();
        $result['floor_data']=array();
      }
   }else{
      $result['state']='0'; //代表失败
   }

   echo json_encode($result);
   
?>