<?php 
include('../../../common/global.php');
$yy_id = _request('yy_id');
$la_id = _request('la_id');
$ckcl_type = _request('ckcl_type');

$result = array();
if($yy_id || $la_id){
    
    if($yy_id){
        $sql = 'select id,url,name from ssfw_review_material where id='.$yy_id;
    }else{
        $sql = 'select id,url,name from ssfw_material where id='.$la_id;
    }
    
    
    $list = $mysql->get_one($sql);
    if($list){
        $result['data'] =  'http://'.$ip.'/sfytjjk/'.$list['url'];
    }else{
        $state = 0;
        $result['state'] = $state;
    }
}else{
     $state = 0;
     $result['state'] = $state;
     
       
}
echo  json_encode($result);
?>