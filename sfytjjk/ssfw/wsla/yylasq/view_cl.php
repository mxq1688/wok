 <?php
/*
 * 1:删除文件
 */
include('../../../common/global.php');
$result =array();

$id = _request('id');
$id = json_decode($id);
$cl = array();

if($id){
    foreach($id as $val){
        $sql = 'select url from ssfw_material where id='.$val;
        $list = $mysql->get_one($sql);
        
        if($list){
			$list['url'] = str_replace('../','',$list['url']);
            $cl[] = 'http://'.$ip.'/sfytjjk/'.$list['url'];
        }
    }
    $state = 1;
    
}else{
    $state = 0;
}


$result['state'] = $state;   
$result['data'] = $cl;     
echo   json_encode($result);
        
        
        

?>