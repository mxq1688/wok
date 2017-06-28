<?php 
   /** 获取二维码
   **/
   include('../common/global.php');
   header("Content-type:text/html;charset=utf-8");
   $cid = _request('cid'); 
   $cid = base64_decode($cid);
   $path = '';
   if($cid){
       $sql = "select path from  ssfw_case_handle where id = "."'$cid'";
       $list = $mysql->get_one($sql);
       if($list){
          $path = $list['path'];
       }
   }
   $html = '';
   $html.= "<div style='width:100%;margin:auto auto;text-align:center;font-size:14px'>";
   $html.="<div style='width: 80%;font-size: 4em;text-align: center;margin: auto;'>案件二维码，可以在诉服一体机自助终端扫描该二维码查询该案件的进展</div>";
   if($path){
      $html.="<div style='width: 360px;height:360px;text-align: center;margin: auto;'><img style='width: 360px;height:360px;' src='".$baseytj.'/'.$path."'/></div>";
   }
  
   $html.="</div>";
   print($html) ;
?>
