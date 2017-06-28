<?php 
   /** 失信人查询 百度接口
   名称必填 省份跟身份证或组织机构选填
   **/
   include('../common/global.php');
   $result= array();
   $name = del_yinhao(_request('name')); 
   $code = del_yinhao(_request('code')); 
   $page = del_yinhao(_request('page')); 
   $province_id = del_yinhao(_request('province_id')); 
   if(!$page){
      $page = 1;
   }
   if($name||$code){
       $url = "https://sp0.baidu.com/8aQDcjqpAAV3otqbppnN2DJv/api.php?resource_id=6899&query=失信被执行人名单&cardNum=$code&iname=$name&areaName=$province_id&ie=utf-8&oe=utf-8&format=json";
       $info=file_get_contents($url);
       $info = json_decode($info,true);
       $all_num = 0;
       $num = 0;
       if($info['data']){
            $all_num = count($info['data'][0]['result']);
            $result['all_data'] = $info['data'][0]['result'];
            $num = $page*20;
            $i = ($page-1)*20;
            for($j=$i;$j<$num;$j++){
                if(isset($info['data'][0]['result'][$j])){
                    $info['data'][0]['result'][$j]['iname'] = sub_str($info['data'][0]['result'][$j]['iname'],20);
                    $result['data'][] = $info['data'][0]['result'][$j];
                }
            }
       }else{
         $result['data'] = array();
       }
       
       if($all_num>$num){
          $result['next_page']=1;
       }else{
          $result['next_page']=0;
       }
       
       
       $result['state']=1;
       $result['page']=$page;
       
   
   }else{
      $result['state']=0;
   }
   //print_R($result);
   echo json_encode($result);
   
?>