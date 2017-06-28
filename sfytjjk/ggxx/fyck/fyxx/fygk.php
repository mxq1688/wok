<?php 
   /** 法院概况
   
   **/
   include('../../../common/global.php');
   $result= array();
   $court_id = _request('court_id'); 
   $court_id = get_court_id($court_id,$mysql);
   if($court_id){
      $sql = 'select info,lazx_tel,ssfw_tel,zzbgs_tel,reception,path from ssfw_court where id='.$court_id;
      $list = $mysql->get_one($sql);
      
      //判断图片是否为空,空的话默认去高院
      if($list['path']==''){
        $list['path']= COUET_IMG;
      }else{
        $list['path'] = $baseurl.$list['path'];
      }
      
      $result['data']=$list;
      $result['state']='1'; //代表成功
      
   }else{
      $result['state']='0'; //代表失败
   }
   
   echo json_encode($result);
   
?>