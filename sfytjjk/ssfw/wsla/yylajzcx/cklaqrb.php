<?php 
   /** 预约立案确认表查询
    
   **/
   include('../../../common/global.php');
   
   $result= array();
   $case_num = del_yinhao(_request('case_num')); 
   $case_h_sql = 'select case_num,id from ssfw_case_handle where  tdh_case_num = '."'$case_num' order by id desc" ;
   $case_h_list = $mysql->get_one($case_h_sql);
   
   if($case_h_list){
    
       $sql = 'select id from ssfw_case_handle where tdh_case_num = '."'$case_num'".' and id<'.$case_h_list['id'];
          
       $list_qr = $mysql->get_one($sql);
      
       if($list_qr){
           $data = array();
           $data['is_tdh_del'] = 1;
           //将所有的置为删除
           $sql = 'update ssfw_case_handle set is_tdh_del =1 where  tdh_case_num = '."$case_num".' and id<'.$case_h_list['id'];
           $mysql->query($sql);
           // $mysql->update('ssfw_case_handle',$data,'id='.$list_qr['id']);
       }
       
   }
   
   
   if($case_h_list['case_num']!=''){
     
     $case_num = $case_h_list['case_num'];
     //原告信息
      $yg_sql = 'select name,character_type,nation,mobile,address,identity_num,nationality,company_name,sex,zj_type,zj_code from ssfw_case_user where type=1 and case_num = '."'$case_num' order by id desc" ;
      $yg_list = $mysql->get_all($yg_sql);
      if(!$yg_list){
        $yg_list = array();
      }   
      
      //被告信息
      $bg_sql = 'select name,character_type,nation,mobile,address,identity_num,nationality,company_name,sex,zj_type,zj_code from ssfw_case_user where type=2 and case_num = '."'$case_num' order by id desc" ;
      $bg_list = $mysql->get_all($bg_sql);
      if(!$bg_list){
        $bg_list = array();
      }  
      
      //第三人信息
      $dsr_sql = 'select name,character_type,nation,mobile,address,identity_num,nationality,company_name,sex,zj_type,zj_code from ssfw_case_user where type=3 and case_num = '."'$case_num' order by id desc" ;
      $dsr_list = $mysql->get_all($dsr_sql);
      if(!$dsr_list){
        $dsr_list = array();
      } 
      //代理人信息
      $dlr_sql = 'select name,nation,mobile,address,identity_num,nationality,company_name,user_type,zj_type,zj_code,daiid from ssfw_case_user where type=4 and case_num = '."'$case_num' order by id desc" ;
      $dl = $mysql->get_all($dlr_sql);
      if(!$dl){
        $dlr_list = array();
      }else{
        $dlr_list = array();
        foreach($dl as $key =>$val){
            $dlr_list[$key] = $val;
            if($val['daiid']!=''){
                $id = $val['daiid'];
                $sql = 'select name,type from ssfw_case_user where id = '."'$id'" ;
                $list_d = $mysql->get_one($sql);
                if($list_d){
                    $dlr_list[$key]['dl_name'] = $list_d['name'];
                    if($list_d['type']==1){
                        $dlr_list[$key]['ssdw'] = 1;
                    }else if($list_d['type']==2){
                        $dlr_list[$key]['ssdw'] = 2;
                    }
                    
                }else{
                    $dlr_list[$key]['dl_name'] = '暂无';
                    $dlr_list[$key]['ssdw'] = 0;
                }
            }else{
                $dlr_list[$key]['ssdw'] = 0;
                $dlr_list[$key]['dl_name'] = '暂无';
            }
            
        }
      } 
      
      
      $ch_sql = 'select court_name,case_action_name,mobile,user_id,path from ssfw_case_handle where case_num = '."'$case_num' " ;
      $ch_list = $mysql->get_one($ch_sql);
      if(!$ch_list){
        $ch_list = array();
      }
      $action_sql = 'select apply_money,litigation_request,la_identity from ssfw_case where yu_case_num = '."'$case_num'";
      $action_list = $mysql->get_one($action_sql);
      
      //申请人信息
      $user_id = '';
      if($ch_list){
        $user_id = $ch_list['user_id'];
      }
      if($user_id){
         $user_sql = 'select identity_num,name from ssfw_litigation_user where id = '."'$user_id' " ;
         $user_list = $mysql->get_one($user_sql);
      }else{
         $user_list = array();
      }
      
      //二维码加上图片
      if($ch_list['path']!=''){
        $ch_list['path'] = $baseytj.'/'.$ch_list['path'];
      }
      
      
      
      $list['list'] = array_merge($ch_list,$action_list,$user_list);
      $list['bg_list'] = $bg_list;
      $list['yg_list'] = $yg_list;
      $list['dsr_list'] = $dsr_list;
      $list['dlr_list'] = $dlr_list;
      
      $result['data']=$list;
      $result['state']=1;
      
      //print_R($result);
      
  }else{
     $result['state']='0'; //代表失败
    }

   echo json_encode($result);
   
?>