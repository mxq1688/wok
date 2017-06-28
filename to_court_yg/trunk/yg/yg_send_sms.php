<?php
      include('../common/global.php');
      $result = array();
      $mobile = _request('mobile'); 
      $ygid = _request('ygid'); 
      $dsr_name = _request('dsr_name'); 
      $court_id = 204;

      $content = '您的资料已经储存在' .$ygid. '号柜子。【铉盈网络】';
     //保存之类发送短信密码
      if($mobile&&$ygid&&$dsr_name){
        send_cms_mobile($mobile,$content);
    
        insert_message(5,$mobile,$content,'系统',$dsr_name,$court_id,$mysql);
      }
      
?>
