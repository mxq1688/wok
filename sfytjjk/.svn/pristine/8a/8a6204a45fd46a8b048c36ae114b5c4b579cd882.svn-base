<?php 
   /** 我的案件查看
   如果获取到id参数 根据id查到相关记录
   1 type 案件号 
   2 type 手机号
   **/
   include('../common/global.php');
   $result= array();
   
   $case = _request('case'); 
   $case_num = _request('case_num'); 
   $pwd = _request('password'); 
   $mobile = _request('mobile'); 
   $type = _request('type'); 
   
     
          if($type==1 && $case_num!='' &&$pwd!=''){
          
          //先请求4.1接口，查到案件列表，通过案件列表查到

            //先查通达海的，然后查询我们
            $curl = new Http();
            //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/DetailAnjian_Yz';
            $url = $api['DetailAnjian_Yz'];
            $arr = array('account'=>$case_num,'password'=>$pwd,'type'=>$type);
            $xml = $curl->request($url,$arr,'POST');
            //$xml = simplexml_load_string($xml);
            $xml = simplexml($xml,'DetailAnjian_Yz','ajck.php');
            $list = array();
            
            $code = xml_to_str($xml->code);
            if($code==1){
             //登录后获取信息
             $list = get_case($xml);
             //http://ip:port/service/DetailAnjian_Yz
             //参数 lsh：案件流水号 court : 法院代码
                   
             //还需要根据流水号找到该案件的详细信息
             $list['allinfo'] = get_case_by_lsh($list['lsh'],$arr,$xml);
             
            
            }
            
            if($list){
            $list = getzanwu_time($list,1);
            }
            $result['data'][0]=$list;
            $result['state']=1;

          
      }else if($type==2 && $mobile!='' &&$pwd!=''){
      
           $arrold = array('account'=>$mobile,'password'=>$pwd,'type'=>$type);
           
           $mobile = base64_encode($mobile);
           $pwd = base64_encode($pwd);
           $type = base64_encode($type);
           
           $curl = new Http();
           //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/LoginAnjian_Yz';
           $url = $api['LoginAnjian_Yz'];
           $arr = array('account'=>$mobile,'password'=>$pwd,'type'=>$type);
           $xml = $curl->request($url,$arr,'POST');
           $xml = simplexml($xml,'LoginAnjian_Yz','ajck.php');
           
           $count = $xml->lb->xh->count();
           
           $vo = array();
           if($count){ 
                 $keys = 0; 
                 foreach($xml->lb->xh  as $val){
                    //登录返回的案件数据
                    $list = get_case_lie($val,true);    
                   // print_R($list);
                    
                    //判断案件的状态部分信息重写
                    $list = getzanwu_time($list,1);
                    
                    //根据流水号得到该案件的详细信息 请求案件详细接口 4.11
                    $list['allinfo'] = get_case_by_lsh($list['lsh'],$arrold,$val,2);

                    $vo[$keys] = $list;
                    //找一个符合的
                   // break;
                    $keys++;
                  }
            }
            $result['data']=$vo;
            $result['state']=1;
      }else{
         $result['state']='0'; //代表失败
      }
      
   echo json_encode($result);
   
?>
