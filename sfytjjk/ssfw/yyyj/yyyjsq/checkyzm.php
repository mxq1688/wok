<?php

 /** 验证验证码是否真确
  type 2 代表阅卷
   **/

include('../../../common/global.php');


$result= array();
$user_id = _request('user_id'); 
$type = _request('type'); 
$yzm = _request('yzm');
if($user_id&&$type){
    //查找是否有这个验证码，如果没有的话就插入，有的话就覆盖
    $sql = "select * from ssfw_session where type=2 and user_id=".$user_id.' and val ='.$yzm;
    $list = $mysql->get_one($sql);
    if($list){
        $result['state']=2; //验证成功
    }else{
        $result['state']=1; //验证失败
    }
    
    //给对应的法院管理员发送一条短信
    
}else{
    $result['state']=0;
}


echo json_encode($result);
   


?>