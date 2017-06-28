<?php

 /** 
  通过案由号获取当事人姓名
   **/

include('../../../common/global.php');


$result= array();
$user_id = _request('user_id'); 
if($user_id){
    //查找是否有这个验证码，如果没有的话就插入，有的话就覆盖
    //$sql = "select * from ssfw_session where type=2 and user_id=".$user_id.' and val ='.$yzm;
    //$list = $mysql->get_one($sql);
    $user_sql = 'select name from ssfw_litigation_user where id = '."'$user_id' " ;
    $user_list = $mysql->get_one($user_sql);
    if($user_list){
        $name = $user_list['name'];
    }else{
        $name = '';
    }
    $result['state']=1; 
    $result['name']=$name; 
    
}else{
    $result['state']=0;
}


echo json_encode($result);
   


?>