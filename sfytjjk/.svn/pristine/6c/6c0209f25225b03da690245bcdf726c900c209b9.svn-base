<?php
/*
 * 文件类型修改
 */
include('../../../common/global.php');

$id = _request('id');
$id = json_decode($id);
$kxcl_type = _request('kxcl_type');

if($id && $kxcl_type){
    foreach($id as $val){
        $sql = 'select id,url from ssfw_material where  id='.$val;
        $list = $mysql->get_one($sql);
        $data['type'] = $kxcl_type;
        if($list){
          
          $lists = $mysql->update('ssfw_material',$data,'id='.$list['id']);
        }
    }
    
    $result['state']='1'; //代表成功
    
}else{
  $result['state']='0'; //代表失败

}  

echo   json_encode($result);
        
        
        

?>