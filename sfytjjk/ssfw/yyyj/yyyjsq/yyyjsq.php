<?php 
   /** 预约立案申请
   type 1 案件编号 查询
   type 2 手机号码 查询
   state 》1  指案件受理状态 已经立案的
   **/
   include('../../../common/global.php');
   $result= array();
   $case_num = _request('case_num'); 
   $pwd = _request('password'); 
   $mobile = _request('mobile'); 
   $type = _request('type'); 
   $user_id = _request('user_id'); 
   
   $data = array();
   $data['user_id'] = $user_id;
   $data['case_pwd'] = $pwd;
   
      if($type==1 && $case_num!='' &&$pwd!=''){
            
            if($case_num=='2106000000001'&&$pwd=='123456'){

                //print_R($obj);
                $list = array();
                $list['lsh'] = '115000000086926';
                $list['handle_time'] = '2015-4-2';
                $list['create_time'] = '2015-6-2';
                $list['court_name'] = '马鞍山中级人民法院';
                $list['case_num'] = '(2015)皖民初字第00171号';
                $list['judge_name'] = '王法官';  //承办法官
                $list['judge_mobile'] = '15645454854';  //承办法官联系方式
                $list['case_action_name'] = '离婚纠纷';  //
                $list['biaode'] = '50000';  //
                $list['course_room_name'] = '第六法庭';  //
                $list['state'] = 2;
                $list['case_view_state'] = 3; //详情信息
                $list['dsr_name'] = '任子明';
                //取到当事人姓名
        
                $list['case_name'] = $list['dsr_name'].$list['case_action_name'];
                $list['title'] = $list['dsr_name'].$list['case_action_name'];
                $list['user_name'] = $list['dsr_name'];
                $list['dsr'] = $list['dsr_name'];
                
        
                $list_array[0] = $list;
                $result['data']=$list_array;
                
              }else{
          //先请求4.1接口，查到案件列表，通过案件列表查到

            //先查通达海的，然后查询我们
            $curl = new Http();
           // $url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/DetailAnjian_Yz';
            $url = $api['DetailAnjian_Yz'];
            $arr = array('account'=>$case_num,'password'=>$pwd,'type'=>$type);
            $xml = $curl->request($url,$arr,'POST');
            $xml = simplexml($xml,'DetailAnjian_Yz','yyyjsq.php');
            $list = array();
            
          //  $code = xml_to_str($xml->code);
            $code = '';
            if(isset($xml->code)){
              $code = xml_to_str($xml->code);
            }
            
            if($code==1){
             //登录后获取信息
             $list = get_case($xml);
             //http://ip:port/service/DetailAnjian_Yz
             //参数 lsh：案件流水号 court : 法院代码
                   
             //还需要根据流水号找到该案件的详细信息
          //   $list['allinfo'] = get_case_by_lsh($list['lsh'],$arr,$xml);
             
            
            }
            
            if($list){
            $list = getzanwu_time($list,1);
            }
          }
            $result['data']=$list;
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
           $xml = simplexml($xml,'LoginAnjian_Yz','yyyjsq.php');
           
           // $xml = (simplexml_load_file('../../../xml/yonghudenglu.xml'));
           $count = 0;
            if(isset($xml->lb->xh)){
              $count = $xml->lb->xh->count();
            }
            
           //$count = $xml->lb->xh->count();
           
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
                 //   $list['allinfo'] = get_case_by_lsh($list['lsh'],$arrold,$val,2);

                    $vo[$keys] = $list;
                    $keys++;
                  }
            }
            
            $result['data']=$vo;
            $result['state']=1;
      }else{
         $result['state']='0'; //代表失败
      }


   
   //把阅卷填写的帐号跟密码保存下来
   
//   $sql = 'select id from ssfw_review_user where  type='.$data['type'].' and case_user = '.$data['case_user']. ' and case_pwd='.$data['case_pwd'];
//      
//   $list = $mysql->get_one($sql);
//  
//   if($list){
//      $lists = $mysql->update('ssfw_review_user',$data,'id='.$list['id']);
//   }else{
//      $lists = $mysql->insert('ssfw_review_user',$data);
//   }
   echo json_encode($result);
   
?>