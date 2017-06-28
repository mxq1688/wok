<?php
/*
删除高拍仪目录
 */

include('../../../common/global.php');
$lian_num = _request('user_token');


if( $lian_num){

  $deldir2 = '../../../upload/gpy';
  if($deldir2.'/'.$lian_num){
      delDirAndFile($deldir2,$lian_num);
  }
  
  //删除目录及图片

  $result['state']='1'; 
            
}else{
  $result['state']='0';
}

echo   json_encode($result);
        



?>