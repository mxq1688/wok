<?php 
   /** 预约阅卷进展查询
   type 1 案件编号 查询
   type 2 手机号码 查询
   state > 1 指案件受理状态
   today 1 今天 0 不是
   **/
   include('../../../common/global.php');
   $result= array(); 
   $case_num = _request('case_num'); 
   $pwd = _request('password'); 
   $mobile = _request('mobile'); 
   $type = _request('type'); 
   
   if($type){
      if($type==1 && $case_num!=''&& $pwd!=''){
          $sql = 'select b.*,a.create_time,a.handle_time,a.state,a.id as review_id  from ssfw_review as a join ssfw_case_handle as b on a.case_num = b.case_num  where  a.case_num = '."'$case_num' and b.case_pwd=".$pwd;
          
          $list = $mysql->get_one($sql);

          if($list){
             $today = date('Y-m-d',time());
             $create_today = date('Y-m-d',$list['create_time']);
             $create_time = date('Y-m-d',$list['create_time']);
             $handle_time = date('Y-m-d',$list['handle_time']);
             if($today==$create_today){
                $list['today'] = 1;
             }else{
                $list['today'] = 0;
             }

            $list['create_time'] = $create_time;
            $list['handle_time'] = $handle_time;
          }
          
          $result['data']=$list;
          $result['state']=1;
      }else if($type==2 && $mobile!='' && $pwd!=''){
          
          $user_sql = 'select id from ssfw_litigation_user where mobile='.$mobile.' and password = '.$pwd;
          $user = $mysql->get_one($user_sql);
          if($user){
            $sql = 'select b.*,a.create_time,a.handle_time,a.state,a.id as review_id from ssfw_review as a join ssfw_case_handle as b on a.case_num = b.case_num  where  a.user_id = '.$user['id'];
          
            $list = $mysql->get_all($sql);
            
              $vo = array();
              if($list){
                 foreach($list  as $keys=>$val){
                       
                        //发起时间比较是否是今日
                        $today = date('Y-m-d',time());
                        $create_today = date('Y-m-d',$val['create_time']);
                        $create_time = date('Y-m-d',$val['create_time']);
                        $handle_time = date('Y-m-d',$val['handle_time']);
                        if($today==$create_today){
                            $val['today'] = 1;
                        }else{
                            $val['today'] = 0;
                        }

                    $val['create_time'] = $create_time;
                    $val['handle_time'] = $handle_time;
                    $vo[$keys] = $val;
                        
                  }
              }
            
            $result['data']=$vo;
            $result['state']=1;
          }else{
            $result['data']=array();
            $result['state']=1;
          }          
      }else{
        $result['state']='0'; 
      }

   }else{
      $result['state']='0'; //代表失败
   }
   
   echo json_encode($result);
   
?>