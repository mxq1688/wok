<?php 
   /** 法庭分布**/
   include('../../common/global.php');
   $result= array();
   $court_id = _request('court_id'); 
   /** 搜索关键字**/
   $keys = _request('keys'); 
   $court_id = get_court_id($court_id,$mysql);
   if($court_id){
      $sql = "select a.*,b.name as floor_name,b.num from ssfw_court_room a join ssfw_room_floor b on a.floor_id = b.id where a.court_id=".$court_id;
      
      if($keys){
         /** 将关键词的引号去掉**/
         $keys = del_yinhao($keys);
         $sql.=" and a.name like '%$keys%'";
      }
      
      $list = $mysql->get_all($sql);
      $vo = array();
      if($list){
        
        foreach($list  as $keys=>$val){
            
            /** 判断图片是否存在**/
            if($val['address_pic']==''){
                $val['address_pic'] = COUET_ROOM_IMG;
            }else{
                $val['address_pic'] = $baseurl.$val['address_pic'];
            }
            if($val['path']==''){
                $val['path'] = COUET_ROOM_IMG;
            }
            else{
                
               $val['path'] = $baseurl.$val['path'];
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