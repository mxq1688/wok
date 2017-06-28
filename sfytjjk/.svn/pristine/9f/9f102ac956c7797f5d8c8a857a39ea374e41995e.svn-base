<?php 
   /** 我的预约案件查询
   **/
   include('../common/global.php');
   
   /** 用户资料保存在session中的***/
   $id = _request('id'); 

   if($id){
    
      //立案的数据
      $sql = "select account,pwd,lsh,lei_type,id,name,xh from ssfw_review where id = "."'$id'";
      $list = $mysql->get_one($sql);
        
        if($list){
            $val = $list;
            $lsh = $val['lsh'];
            $account = $val['account'];
            $pwd = $val['pwd'];
            $type = $val['lei_type'];
            $name = $val['name'];
            $xh = $val['xh'];
            
            //if($type==1){
            $curl = new Http();
            //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/WsyjXx_Yz';
            $url = $api['WsyjXx_Yz'];
            $arr = array('account'=>base64_encode($account),'password'=>base64_encode($pwd),'type'=>base64_encode($type),'xh'=>base64_encode($xh),'lsh'=>base64_encode($lsh));
            $xml = $curl->request($url,$arr,'POST');
            $xml = simplexml($xml,'WsyjXx_Yz','wdyypj.php');
          
            $vo = array();
            
            $state = 0;
            if(isset($xml->markxx)){
                 //登录后获取信息
                 $list_yy = get_yue_case_xx($xml,$mysql,$name,$arr);
                 $state = $list_yy['state'];
                 
            }
            
            
            
            
            $curl = new Http();
            //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/DetailAnjian_Yz';
            $url = $api['DetailAnjian_Yz'];
            $arr = array('account'=>$val['account'],'password'=>$val['pwd'],'type'=>$val['lei_type'],'lsh'=>$val['lsh']);
            $xml = $curl->request($url,$arr,'POST');
            
            $xml = simplexml($xml,'DetailAnjian_Yz','wdyypj.php');
            $list = array();
            
            $code = 0;
            if(isset($xml->code)){
                $code = xml_to_str($xml->code);
            }
            
            if($code==1){
             //登录后获取信息
             $list = get_case($xml);
             $list['id'] = $val['id'];
             $list ['state'] = $state;
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