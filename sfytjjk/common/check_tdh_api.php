<?php
include ('./global.php');

$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/DetailAnjian_Yz?account=115014000111001&password=205544&type=1';
$sf = 'js';

  while (true) {
   
    // 调用函数 , 获取实时状态
    $code = httpcode($url);
    if($code != '200') {
      $data['is_connect'] = '-1';
    } else {
      $data['is_connect'] = '1';
    }

	$sql = 'select * from ssfw_tdh_api where  sf=' . "'$sf'";

	$list = $mysql->get_one($sql);

	if ($list) {
		$lists = $mysql->update('ssfw_tdh_api', $data, 'id=' . $list['id']);
		echo date('Y-m-d H:i:s')."\r\n";
	} else {
		$data['sf'] = $sf;
		$lists = $mysql->insert('ssfw_tdh_api', $data);
		echo date('Y-m-d H:i:s')."\r\n";

	}
   
    sleep(60);

  }


//修改数据库状态




function httpcode($url){
  $ch = curl_init();
  // $timeout = 3;
  curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch, CURLOPT_HEADER, 1);
  // curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_exec($ch);
  return $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
  curl_close($ch);
}



?>