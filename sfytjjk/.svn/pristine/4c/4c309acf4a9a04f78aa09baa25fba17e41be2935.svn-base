<?php 
   /** 我的预约案件查询
   **/
   include('../common/global.php');
   
   /** 用户资料保存在session中的***/
   $id = _request('id'); 

   if($id){
    
      //立案的数据
      $sql = "select tdh_case_num,case_pwd,id from  ssfw_case_handle where id = "."'$id'";
      $list = $mysql->get_one($sql);
        
        if($list){
            $val = $list;
            //先要去判断是否有通达海流水号
            $case_num = $val['tdh_case_num'];
            //http://ip:port/service/DetailAnjian 
            //参数lsh：案件流水号 court : 法院代码
            $curl = new Http();
        
            
            $lsh = $case_num;
            $pwd = $val['case_pwd'];
            $type = 1;
            
            $curl = new Http();
            //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/QueryWslaAnjian_Yz';
            $url = $api['QueryWslaAnjian_Yz'];
            $arr = array('account'=>base64_encode($lsh),'password'=>base64_encode($pwd),'type'=>base64_encode($type));
            $xml = $curl->request($url,$arr,'POST');
            
            $xml = simplexml($xml,'QueryWslaAnjian_Yz','wdlapj.php');
            $code = 0;
            if(isset($xml->code)){
                $code = xml_to_str($xml->code,true);
            }
            
            
            if($code=='true'){
           
                $list = get_simple_case_jz($xml->lajzcx,true,$mysql);
                $list['id'] = $val['id'];
            }
         }

      $result= array();
      $result['data']=$list;

      
      $result['state']='1'; //代表成功
  //print_R($result);
   }else{
      $result['state']='0'; //代表失败
   }
   echo json_encode($result);
   
?>