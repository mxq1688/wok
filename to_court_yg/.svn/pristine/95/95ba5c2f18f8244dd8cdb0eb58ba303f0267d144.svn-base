<?php
       //获取数据字段信息
       //type 1 获取法院
       include('./global.php');
       $result = array();

       $type = _request('type');
       $area_id = _request('area_id');
       $court_id = _request('court_id');
       
       if($type==1){
             
           $str = substr($area_id,0,2);
           $new_num = $str.'0000';
           $str2 = substr($area_id,2,2);
           
           //获取高院法院
           
           $gy_court = $mysql->select_one('court', '*', 'court_num=' . $new_num);
           
           //获取中院下的法院
           $zy_court = $mysql->select_one('court', '*', 'court_num=' . $area_id);
           
           $jy_court = array();
           if($zy_court){
             $jy_court = $mysql->select_all('court', '*', 'pid=' . $zy_court['id']);
           }
           
           
           $list = array();
           if($jy_court){
              foreach($jy_court as $key=>$val){
                $list[$key+2]['label'] = $val['name'];
                $list[$key+2]['value'] = $val['id'];
              }
           }
           
           if($str2=='01'){
              $list[0]['label'] = $gy_court['name'];
              $list[0]['value'] = $gy_court['id'];
              $list[1]['label'] = $zy_court['name'];
              $list[1]['value'] = $zy_court['id'];
           }
           
           $result['state'] = 1;
           $result['data'] = $list;
           
       }
       if($type==2){
         $dept = $mysql->select_all('dept', '*', 'court_id=' . $court_id);
         $list = array();
         if($dept){
           foreach($dept as $key=>$val){
             $list[$key]['label'] = $val['name'];
             $list[$key]['value'] = $val['id'];
             $list[$key]['dept_code'] = $val['dept_code'];
             //获取人员
             $judge = $mysql->select_all('judge', '*', 'court_id=' . $court_id.' and dept_code='.$val['dept_code']);  
             if($judge){
               foreach($judge as $keys=>$_val){
                 $list[$key]['children'][$keys]['label'] = $_val['user_name'];
                 $list[$key]['children'][$keys]['value'] = $_val['id'];
               }
             }
            
           }
        }
        
         $result['state'] = 1;
         $result['data'] = $list;
         
       }
       
       //print_R($list);exit;

       echo json_encode($result);
?>