<?php 
   /** 我的预约案件查询
   **/
   include('../common/global.php');
   
   /** 用户资料保存在session中的***/
   $user_id = _request('user_id'); 
   $page = _request('page'); 
   $page_num = 5; //每页显示的个数
   
   if(!$page){
      $page = 0;
   }
   $offset = $page*5;
   
   if($user_id){
    
      //立案的数据
      $sql = "select sc_login_type,new_lsh,new_pwd,new_account,new_type,sc_type,id,tdh_case_num,path,case_pwd,state,user_name,create_time,case_num,handle_time,case_action_name,court_id,court_name,is_sc from ssfw_case_handle where user_id=".$user_id." and state=2 and tdh_case_num is  not  null and is_show=0 order by id desc limit $offset,$page_num";
      $all_sql = "select id from ssfw_case_handle where user_id=".$user_id." and tdh_case_num is  not  null and state=2 and is_show=0";
      $all_list_lian = $mysql->get_all($all_sql);
      $count = count($all_list_lian);
      $next_page = 0;
      if($count>($offset+5)){
        $next_page = 1;
      }
      
      $list_lian = $mysql->get_all($sql);
      $vo = array();
      $vo_yla = array();
      $ckxq_state = 0;

      foreach($list_lian  as $keys=>$val){
        
           //判断是否为收藏案件
           if($val['is_sc']==0||($val['is_sc']==1 && $val['sc_login_type']==1)){
            
           
                $case_num = $val['tdh_case_num'];
                
                $curl = new Http();
                $lsh = $case_num;
                $pwd = $val['case_pwd'];
                $type = 1;
                //echo $lsh;echo $pwd;echo $type;
                
                $curl = new Http();
                //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/QueryWslaAnjian_Yz';
                $url = $api['DetailAnjian_Yz'];
                $arr = array('account'=>base64_encode($lsh),'password'=>base64_encode($pwd),'type'=>base64_encode($type));
                $xml = $curl->request($url,$arr,'POST');
                
                $xml = simplexml($xml,'DetailAnjian_Yz','53行.yslaj.php');
               // print_R($xml);exit;
                $code = 0;
                if(isset($xml->code)){
                    $code = xml_to_str($xml->code,true);
                }
                $list = array();
                if($code=='true'){
                    $list = get_simple_case_jz($xml->lajzcx,true,$mysql);
                    $list['is_tdh_del'] = 0;

                    //print_R($list);exit;
                  //  if($list['state']==1){
                    //    $vo[$keys] = $list;
                    //    $vo[$keys]['ckxq_state'] = 1;
                   // }else 
                    
                    //状态为2或者0为已处理
                    
                    
                }else{
                    $list['court_name'] = $val['court_name'];
                    $list['state'] = $val['state'];
                    $list['case_num'] = '暂无案号';
                    $list['title'] = $val['user_name'].$val['case_action_name'];
                    $list['dsr'] = $val['user_name'];
                    $list['case_action_name'] = $val['case_action_name'];
                    $list['biaode'] = $val['apply_money'];
                    $list['handle_time'] = '暂无';
                    $list['user_name'] = $val['user_name'];
                    $list['create_time'] = date('Y-m-d',$val['create_time']);
                    $list['is_tdh_del'] = 1;
                    $data['is_tdh_del'] = 1;
                    $mysql->update('ssfw_case_handle',$data,'id='.$val['id']);
           
                }
      
         }else{
            //1 为帐号查询 2 手机号查询

                $curl = new Http();
                //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/DetailAnjian_Yz';
                $url = $api['DetailAnjian_Yz'];
                $arr = array('account'=>$val['new_account'],'password'=>$val['new_pwd'],'type'=>$val['new_type'],'lsh'=>$val['new_lsh']);
                $xml = $curl->request($url,$arr,'POST');
                
                $xml = simplexml($xml,'DetailAnjian_Yz','83行.yslaj.php');
                $list = array();
                
                $code = 0;
                if(isset($xml->code)){
                    $code = xml_to_str($xml->code);
                }
                
                if($code==1){
                 //登录后获取信息
                 $list = get_case($xml);
                
                }
             
            
         }
            
        if($list){
             $list['id'] = $val['id'];
             if($list['state']==2){
                
                $vo_yla[$keys] = $list;
                $vo[$keys] = $list;
                $vo_yla[$keys]['ckxq_state'] = 2;
                $vo[$keys]['ckxq_state'] = 2;
                //如果已经受理就改变状态
                $data=array();
                $data['state'] = 2;
                $mysql->update('ssfw_case_handle',$data,'id='.$val['id']);
                
            }else{
                $vo_yla[$keys] = $list;
                $vo[$keys] = $list;
                $vo_yla[$keys]['ckxq_state'] = 0;
                $vo[$keys]['ckxq_state'] = 0;
                //如果已经受理就改变状态
                $data=array();
                $data['state'] = 0;
                $mysql->update('ssfw_case_handle',$data,'id='.$val['id']);
            }
        }
        

            
            //else{
//                //查到标的
//                $case_num = $val['case_num'];
//                
//                $result_arr = getzanwu_time($val,2);
//                $result_arr['dsr'] = $result_arr['user_name'];
//                $vo[$keys] = $result_arr;
//                $vo[$keys]['ckxq_state'] = 1;
//                $vo[$keys]['lsh'] = $case_num;
//                $y_sql = 'select apply_money from ssfw_case where yu_case_num = '."'$case_num'";
//                $list_y = $mysql->get_one($y_sql);
//                if($list_y){
//                    $vo[$keys]['biaode'] = $list_y['apply_money'];
//                }else{
//                    $vo[$keys]['biaode'] = '-';
//                }
//                   
//            }
      }
    //  print_R($vo);
      $vo_yla = $vo;
      

      //已受理的重新遍历下
      $yls_list = array_values($vo_yla);

      
      $result= array();
      $result['data']['yla']=$yls_list;
      $result['data']['next_page']=$next_page;
      $result['data']['all_count']=$count;
      $result['state']='1'; //代表成功
      
   }else{
      $result['state']='0'; //代表失败
   }
   echo json_encode($result);
   
?>