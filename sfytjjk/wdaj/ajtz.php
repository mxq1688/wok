<?php 
   /** 我的案件查看
   如果获取到id参数 根据id查到相关记录
   1 type 案件号 
   2 type 手机号
   **/
   include('../common/global.php');
   $result= array();
   
   $case = _request('value'); 
   
   $sql = 'select new_type,new_pwd,new_account,new_lsh from ssfw_case_handle where id = '."'$case'" ;
          
   $list= $mysql->get_one($sql);
   
     
          if($list&&$list['new_type']!='' && $list['new_account']!='' &&$list['new_pwd']!=''){
          
          //先请求4.1接口，查到案件列表，通过案件列表查到

            //先查通达海的，然后查询我们
            $curl = new Http();
            //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/DetailAnjian_Yz';
            $url = $api['DetailAnjian_Yz'];
            $arr = array('account'=>$list['new_account'],'password'=>$list['new_pwd'],'type'=>$list['new_type'],'lsh'=>$list['new_lsh']);
            $xml = $curl->request($url,$arr,'POST');
            
            $xml = simplexml($xml,'DetailAnjian_Yz','ajtz.php');
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
                $result['data']=$list;
                $result['state']=1;
            }else{
                $result['state']=0;
            }
            

          
      }
      
      else{
         $result['state']='0'; //代表失败
      }
      
   echo json_encode($result);
   
?>
