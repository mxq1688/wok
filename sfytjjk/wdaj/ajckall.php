<?php 
   /** 我的案件查看
   如果获取到id参数 根据id查到相关记录
   **/
   include('../common/global.php');
   $result= array();
   
   $case_num = _request('case_num'); 
   
   if($case_num){

       $sql = 'select a.*,b.course_room_name,b.course_room_id,b.lawful_time from ssfw_case_handle as a join ssfw_notice as b on a.case_num = b.case_num where a.case_num= '."'$case_num'";
       $list = $mysql->get_one($sql);
       $list['lawful_time'] = date('Y/m/d',$list['lawful_time']);
       
       $user_sql = 'select a.type,a.name,a.character_type from ssfw_case_user as a where a.case_num = '."'$case_num'";
       $user_list = $mysql->get_all($user_sql);
       
       $mar_sql = 'select a.id,a.name,a.type from ssfw_material as a where a.case_num = '."'$case_num' and a.type>0";
       $mar_list = $mysql->get_all($mar_sql);
       $mar = array();
       if($mar_list){
        //1当事人身份 2 申请执行书 3 生效裁判卷 4 执行线索材料 5 送达确认书 6 营业执照 7授权委托书
         foreach($mar_list as $key=>$_val){
            switch ($_val['type'])
            {
            case 1:
              $type_name = '当事人身份证明';
              break;  
            case 2:
              $type_name = '申请执行书';
              break;
            case 3:
              $type_name = '生效裁判卷';
              break;
            case 4:
              $type_name = '执行线索材料';
              break;
            case 5:
              $type_name = '当事人送达地址确认书';
              break;
            case 10:
              $type_name = '营业执照';
              break;
            case 11:
              $type_name = '授权委托书';
              break;
            default:
            $type_name='';
            break;
            }
            $mar[$key] = $_val;
            $mar[$key]['type_name'] = $type_name;
            
         }
       }
       $result['data']=$list;
       $result['dsrdata']=$user_list;
       $result['mardata']=$mar;
       $result['state']='1'; //代表成功
       
       
   }else{
       $result['state']=0;
   }
   
   echo json_encode($result);
   
?>
