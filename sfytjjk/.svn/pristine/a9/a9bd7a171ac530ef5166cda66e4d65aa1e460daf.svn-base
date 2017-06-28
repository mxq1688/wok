<?php
/*
 * 1:删除文件
 */
include('../../../common/global.php');
$result =array();

$id = _request('id');
$id = json_decode($id);
$info = '';

if($id){
    if(is_array($id)){
        foreach($id as $val){
            $sql = 'select url from ssfw_material where id='.$val;
            $list = $mysql->get_one($sql);
            
            if($list){
                del_file($list['url']);
                
                $sql = 'delete from ssfw_material where id='.$val;
                $mysql->query($sql);
            }
        }
        $state = 1;
    }else{
        $sql = 'select url from ssfw_material where id='.$id;
		$list = $mysql->get_one($sql);
		
		if($list){
			del_file($list['url']);
			
			$sql = 'delete from ssfw_material where id='.$id;
			$mysql->query($sql);
            
            $state = 1;
		}else{
		  $state = 0;
          $info = '不存在此图片';
          
		}
    }
    
    
    
}else{
    $state = 0;
    $info = '缺少有效参数';
}


$result['state'] =  $state;    
$result['info'] =  $info;   
echo   json_encode($result);
        
        
        

?>