<?php 
   /** 我的预约案件查询
   **/
   include('../common/global.php');
   
   /** 用户资料保存在session中的***/
   $user_id = _request('user_id'); 
   $page = _request('page'); 
   $page_num = 5;
   if(!$page){
      $page = 0;
   }
   $offset = $page*5;
   if($user_id){
    
      //阅卷的数据
      //$sql_yue = 'select b.*,a.create_time,a.handle_time,a.state,a.id,a.lsh,a.account,a.pwd,a.lei_type as review_id from ssfw_review as a join ssfw_case_handle as b on a.case_num = b.case_num  where  a.user_id = '.$user_id.' order by a.create_time desc';
      //$sql_yue = "select * from ssfw_review where user_id = $user_id and lsh>0 and account>0 and pwd>0 and xh>0 and is_show=0 order by id desc limit $offset,$page_num";
      $sql_yue = "select * from ssfw_review where user_id = $user_id and lsh>0 and account>0 and pwd>0 and is_show=0 order by id desc limit $offset,$page_num";
          
      $list_yue = $mysql->get_all($sql_yue);
      
      $all_sql = "select id from ssfw_review where user_id=$user_id and lsh>0 and account>0 and pwd>0 and xh>0 and is_show=0";
      
      $all_list_lian = $mysql->get_all($all_sql);
      $count = count($all_list_lian);
     
      $next_page = 0;
      
      //判断是否有下一页
      if($count>($offset+5)){
        $next_page = 1;
      }

      $ckxq_state = 0;
      $vo_yue = array();
      
      //先判断是否有帐号密码流水号如果没有的话查询我们数据
      $key=0;
      foreach($list_yue  as $keys=>$val){
        if($val['court_id']==286){
                $vo_yue[$keys]['lsh'] = '(2015)花民一初字第01765号';
                $vo_yue[$keys]['create_time'] = date('Y-m-d',$val['create_time']);
                $vo_yue[$keys]['handle_time'] = '-';
                $vo_yue[$keys]['user_name'] = $val['name'];
                $vo_yue[$keys]['dsr'] = $val['name'];
                $vo_yue[$keys]['court_name'] = '马鞍山中级人民法院'; 
                $vo_yue[$keys]['reason'] = '-';
                $vo_yue[$keys]['state'] = 1;
                $vo_yue[$keys]['title'] = $val['name'].'离婚纠纷';
                $vo_yue[$keys]['case_action_name'] = '离婚纠纷';
                $vo_yue[$keys]['biaode'] = '5000';
                $vo_yue[$keys]['case_num'] = '(2015)花民一初字第01765号';
            }else{
                
                $lsh = $val['lsh'];
                $account = $val['account'];
                $pwd = $val['pwd'];
                $type = $val['lei_type'];
                $name = $val['name'];
                $xh = $val['xh'];
                
                $curl = new Http();
                //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/WsyjXx_Yz';
                $url = $api['WsyjXx_Yz'];
                $arr = array('account'=>base64_encode($account),'password'=>base64_encode($pwd),'type'=>base64_encode($type),'xh'=>base64_encode($xh),'lsh'=>base64_encode($lsh));
                $xml = $curl->request($url,$arr,'POST');
                $xml = simplexml($xml,'WsyjXx_Yz','yyaj.php');
              
                $vo = array();

                if(isset($xml->markxx)){
                    
                     //登录后获取信息
                     $list = get_yue_case_xx($xml,$mysql,$name,$arr);
                     $list['id'] = $val['id'];
                     $vo_yue[$key] = $list;
                     
                     $data=array();
                     $data['handle_time'] = strtotime($list['handle_time']);
                     if($list['state']==2){
                        
                        $data['state'] = 2;
                        $mysql->update('ssfw_review',$data,'id='.$val['id']);
                        
                     }else if($list['state']==0){

                        $data['state'] = 0;
                        $data['state'] = 0;
                        $mysql->update('ssfw_review',$data,'id='.$val['id']);
                        
                     }
                    
                }else{
                   
                    //获取案件信息

//                    $vo_yue[$key]['lsh'] = '(2015)花民一初字第01765号';
//                    $vo_yue[$key]['create_time'] = date('Y-m-d',$val['create_time']);
//                    $vo_yue[$key]['handle_time'] = '-';
//                    $vo_yue[$key]['user_name'] = $val['name'];
//                    $vo_yue[$key]['dsr'] = $val['name'];
//                    $vo_yue[$key]['court_name'] = '马鞍山中级人民法院'; 
//                    $vo_yue[$key]['reason'] = '-';
//                    $vo_yue[$key]['state'] = 1;
//                    $vo_yue[$key]['title'] = $val['name'].'离婚纠纷';
//                    $vo_yue[$key]['case_action_name'] = '离婚纠纷';
//                    $vo_yue[$key]['biaode'] = '-';
//                    $vo_yue[$key]['case_num'] = '(2015)花民一初字第01765号';

                }
             }
                    
          $key++;      
      }
      
      //阅卷的重新遍历下
      $yue_list = array_values($vo_yue);
      
      $result['data']['all_count']=$count;
      $result['data']['next_page']=$next_page;
      $result['data']['yuejuan']=$vo_yue;
      $result['state']='1'; //代表成功
      
  //print_R($result);
   }else{
      $result['state']='0'; //代表失败
   }
   echo json_encode($result);
   
?>