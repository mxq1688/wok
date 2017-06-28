<?php 

include('../../../common/lib/phpqrcode/phpqrcode.php');
include('../../../common/global.php');

$user_id = _request('user_id'); 
$ajlx = _request('ajlx'); 
//$password = _request('pwd'); 
if($user_id){
    //生成临时帐号/密码
    $user = time().$user_id.rand(1000,9999);
    $pwd = rand(100000,999999);
    
    $str = $user.'/'.$pwd;
    //密码加密下
    $password = think_encrypt($pwd);
    $str_er = $user.'/'.$password;
    
    //保存到数据库中
    //保存
    //21 代表民事 二维码 51代表 执行二维码
    if($ajlx==21){
        $sql = "select * from ssfw_session where type=4 and user_id=".$user_id;
    }else{
        $sql = "select * from ssfw_session where type=5 and user_id=".$user_id;
    }
    
    $list = $mysql->get_one($sql);
    $path = 'upload/erweima/'.$user_id.$pwd.'_erweima.png';
    if($list){
        $data['val'] = $str;
        $data['path'] = $path;
        $list = $mysql->update('ssfw_session',$data,'id='.$list['id']);
    }else{
        $data['val'] = $str;
        $data['path'] = $path;
        if($ajlx==21){
            $data['type'] = 4;
        }else{
            $data['type'] = 5;
        }
        
        $data['user_id'] = $user_id;
        $list = $mysql->insert('ssfw_session',$data);
    }
    
    $filename = '../../../upload/erweima/'.$user_id.$pwd.'_erweima.png';
    $a = QRcode::png($str_er,$filename,1,4,1,false);
    
    $url = 'upload/erweima/'.$user_id.$pwd.'_erweima.png';
    $result= array();
    $result['erweima'] = $url;
    $result['state'] = 1;
    
    
}else{
    $result['state'] = 0;
}
echo json_encode($result);

?>