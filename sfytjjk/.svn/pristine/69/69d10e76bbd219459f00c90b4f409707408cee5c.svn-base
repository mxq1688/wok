<?php 
   /** 我的预约案件查询
   **/
   include('../common/global.php');
   
   /** 用户资料保存在session中的***/
   $user_id = _request('user_id'); 

   if($user_id){
    
      //立案的数据
      $sql = 'select tdh_case_num,path,case_pwd,state,user_name,create_time,case_num,handle_time,case_action_name,court_id,court_name from ssfw_case_handle where user_id='.$user_id.' order by create_time desc';
      
      $list_lian = $mysql->get_all($sql);
      $vo = array();
      $vo_yla = array();
      $ckxq_state = 0;

      foreach($list_lian  as $keys=>$val){
        

            //先要去判断是否有通达海流水号
            if($val['tdh_case_num']!=''){
                $case_num = $val['tdh_case_num'];
                //http://ip:port/service/DetailAnjian 
                //参数lsh：案件流水号 court : 法院代码
                $curl = new Http();
                
                //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/DetailAnjian';
                //$arr = array('lsh'=>$case_num);
                //$xml = $curl->request($url,$arr,'POST');
                
                $lsh = $case_num;
                $pwd = $val['case_pwd'];
                $type = 1;
                //echo $lsh;echo $pwd;echo $type;
                
                $curl = new Http();
                //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/QueryWslaAnjian_Yz';
                $url = $api['QueryWslaAnjian_Yz'];
                $arr = array('account'=>base64_encode($lsh),'password'=>base64_encode($pwd),'type'=>base64_encode($type));
                $xml = $curl->request($url,$arr,'POST');
                
                $xml = simplexml($xml,'QueryWslaAnjian_Yz','wldaq.php');
              //  print_R($xml);
               // print_R($xml);exit;
                $code = 0;
                if(isset($xml->code)){
                    $code = xml_to_str($xml->code,true);
                }
                
                
                if($code=='true'){
                  
                    $list = get_simple_case_jz($xml->lajzcx,true,$mysql);
                   // print_R($list);exit;
                    if($list['state']==1){
                        $vo[$keys] = $list;
                        $vo[$keys]['ckxq_state'] = 1;
                    }else if($list['state']==2){
                        
                        $vo_yla[$keys] = $list;
                        $vo[$keys] = $list;
                        $vo_yla[$keys]['ckxq_state'] = 2;
                        $vo[$keys]['ckxq_state'] = 2;
                        //如果已经受理就改变状态
                        $data=array();
                        $data['state'] = 2;
                        $mysql->update('ssfw_case_handle',$data,'id='.$val['id']);
                        
                    }else{
                        
                        $vo[$keys] = $list;
                        $vo_yla[$keys] = $list;
                        $vo_yla[$keys]['ckxq_state'] = 0;
                        $vo[$keys]['ckxq_state'] = 0;
                        //如果已经受理就改变状态
                        $data=array();
                        $data['state'] = 0;
                        $mysql->update('ssfw_case_handle',$data,'id='.$val['id']);
                        
                    }

                }else{
                    //查到标的
                    $case_num = $val['case_num'];
                    $y_sql = 'select apply_money from ssfw_case where yu_case_num = '."'$case_num'";
                    $list_y = $mysql->get_one($y_sql);
                    
                    $result_arr = getzanwu_time($val,2);
                    
                    $vo[$keys] = $result_arr;
                    $vo[$keys]['ckxq_state'] = 1;
                    $vo[$keys]['lsh'] = $case_num;
                    $vo[$keys]['dsr'] = $result_arr['user_name'];
                    if($list_y){
                        $vo[$keys]['biaode'] = $list_y['apply_money'];
                    }else{
                        $vo[$keys]['biaode'] = '-';
                    }
                    
                }
            }else{
                //查到标的
                $case_num = $val['case_num'];
                
                $result_arr = getzanwu_time($val,2);
                $result_arr['dsr'] = $result_arr['user_name'];
                $vo[$keys] = $result_arr;
                $vo[$keys]['ckxq_state'] = 1;
                $vo[$keys]['lsh'] = $case_num;
                $y_sql = 'select apply_money from ssfw_case where yu_case_num = '."'$case_num'";
                $list_y = $mysql->get_one($y_sql);
                if($list_y){
                    $vo[$keys]['biaode'] = $list_y['apply_money'];
                }else{
                    $vo[$keys]['biaode'] = '-';
                }
                   
            }
      }
    //  print_R($vo);
      $lian_list = $vo;
      
      

      //阅卷的数据
      //$sql_yue = 'select b.*,a.create_time,a.handle_time,a.state,a.id,a.lsh,a.account,a.pwd,a.lei_type as review_id from ssfw_review as a join ssfw_case_handle as b on a.case_num = b.case_num  where  a.user_id = '.$user_id.' order by a.create_time desc';
      $sql_yue = 'select * from ssfw_review where user_id = '.$user_id.' order by create_time desc';
          
      $list_yue = $mysql->get_all($sql_yue);
      
      $vo_yue = array();
      
      //先判断是否有帐号密码流水号如果没有的话查询我们数据
      $key=0;
      foreach($list_yue  as $keys=>$val){
        
            if($val['lsh']!=''&&$val['account']!=''&&$val['pwd']!=''){
                
                $lsh = $val['lsh'];
                $account = $val['account'];
                $pwd = $val['pwd'];
                $type = $val['lei_type'];
                
                if($type==1){
                    $curl = new Http();
                    //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/DetailAnjian_Yz';
                    $url = $api['DetailAnjian_Yz'];
                    $arr = array('account'=>$account,'password'=>$pwd,'type'=>$type);
                    $xml = $curl->request($url,$arr,'POST');
                    $xml = simplexml($xml,'DetailAnjian_Yz','152行.wldaq.php');
                    
                    $vo = array();
                    $code = '';
                    if(isset($xml->code)){
                        $code = xml_to_str($xml->code);
                    }
                    
                    if($code==1){
                         //登录后获取信息
                         $list = get_case($xml);
                         $vo_yue[$key] = $list;
                    }else{
                       // $vo_yue[$key] = array();
                    }
                    
                }else if($type==2){
                    $curl = new Http();
                    //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/DetailAnjian_Yz';
                    $url = $api['DetailAnjian_Yz'];
                    $arr = array('account'=>$account,'password'=>$pwd,'type'=>$type,'lsh'=>$lsh);
                    $xml = $curl->request($url,$arr,'POST');
                    $xml = simplexml($xml,'DetailAnjian_Yz','173行.wldaq.php');
                    
                    $vo = array();
                    $code = '';
                    if(isset($xml->code)){
                        $code = xml_to_str($xml->code);
                    }
                    
                    
                    if($code==1){
                         //登录后获取信息
                         $list = get_case($xml);
                         $vo_yue[$key] = $list;
                    }else{
                       //  $vo_yue[$key] = array();
                    }
                }else{
                   // $vo_yue[$key] = array();
                }
            }else{
              //  $vo_yue[$key] = $val;
            }   
            
          $key++;      
      }
     
      $yue_list =array();
      if($vo_yue){
        foreach($vo_yue as $keys=> $val){
            $val['state'] = 1;
            $yue_list[$keys] = $val;
        }
      }
      
      //阅卷的重新遍历下
      $yue_list = array_values($yue_list);

      //已受理的重新遍历下
      $yls_list = array_values($vo_yla);

      
      
      //已经立案
      //$sql_yla = 'select * from ssfw_case_handle where user_id='.$user_id .' and state!=1 order by create_time desc';;
//      
//      $list_yla = $mysql->get_all($sql_yla);
//      $vo_yla = array();
//      foreach($list_yla  as $keys=>$val){
//               
//            $arr = getzanwu_time($val);
//            $vo_yla[$keys] = $arr;
//                
//      }
      
      $result= array();
      $result['data']['lian']=$lian_list;
      $result['data']['yla']=$yls_list;
      $result['data']['yuejuan']=$yue_list;
      $result['state']='1'; //代表成功
  //print_R($result);
   }else{
      $result['state']='0'; //代表失败
   }
   echo json_encode($result);
   
?>