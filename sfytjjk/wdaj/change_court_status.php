<?php 
   /** 我的预约案件查询
   **/
   include('../common/global.php');
   
   /** 用户资料保存在session中的***/
   $court_id = _request('court_id'); 
  if(!$court_id){
    $result['state'] = 0;
	$result['info'] = '缺少参数';
  }else{
    $data['sf'] = '1000';
    $state = $mysql->update('ssfw_court',$data,'id='.$court_id);
	$result['state'] = 1;
	$result['info'] = '修改成功';
  }
  
                        
   
   
                        
   echo json_encode($result);
   
?>