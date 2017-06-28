<?php 
include('../../../common/global.php');
$did = _request('did');
$result = array();
if($did){
    $sql = 'select url,name from ssfw_material where id='.$did;
    $list = $mysql->get_one($sql);
    if($list){
        $fileurl = dirname(dirname(dirname(dirname(__FILE__)))).'/'.$list['url'];
        $fileurl = iconv("utf-8","gb2312",$fileurl);
        $fp=fopen($fileurl,"r");
        $file_size=filesize($fileurl);
        $FileName=iconv("utf-8","gb2312",$list['name']);
        //下载文件需要用到的头
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length:".$file_size);
        Header("Content-Disposition: attachment; filename=".$list['name']);
        $buffer=1024;
        $file_count=0;
        //向浏览器返回数据
        while(!feof($fp) && $file_count<$file_size){
        $file_con=fread($fp,$buffer);
        $file_count+=$buffer;
        echo $file_con;
        }
        fclose($fp);
        //downfile($fileurl,$list['name']);
    }else{
        $state = 0;
        $result['state'] = $state;
         echo  json_encode($result);
    }
}else{
    $state = 0;
     $result['state'] = $state;
     echo  json_encode($result);
       
}

?>