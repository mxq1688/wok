<?php

 /** 发送申请阅卷的验证码
   **/
include('../../../common/global.php');
$result= array();
$code = rand(100000,999999);//取一个随机数当成验证码
$user_id = _request('user_id'); 
$mobile = _request('mobile'); 

if($mobile&&$user_id){
    //查找是否有这个验证码，如果没有的话就插入，有的话就覆盖
    $sql = "select * from ssfw_session where type=2 and user_id=".$user_id;
    $list = $mysql->get_one($sql);
    if($list){
        $data['val'] = $code;
        $list = $mysql->update('ssfw_session',$data,'id='.$list['id']);
    }else{
        $data['val'] = $code;
        $data['type'] = 2;
        $data['user_id'] = $user_id;
        $list = $mysql->insert('ssfw_session',$data);
    }
    
    //给对应的法院管理员发送一条短信

    $content = '您的预约阅卷的验证码是：'.$code.'【铉盈网络】';
    send_cms_mobile($mobile,$content);

    
    
    $result['state']=1;
    $result['code']=$code; 
}else{
    $result['state']=0;
}


echo json_encode($result);
   


?>