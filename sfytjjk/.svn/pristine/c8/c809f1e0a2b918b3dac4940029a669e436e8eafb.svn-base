<?php 
   /** 开庭公告
  
   **/
   include('../../common/global.php');
   $result= array();
   $court = _request('court_id'); //获取的参数
   /** 搜索时间**/
   $begin_time = _request('begin_time'); 
   $end_time = _request('end_time'); 
   $page = _request('page'); 
   //$court_id = '320000';
 //  if($court!=58 && $court!=86 && $court!=166){
      $sql = 'select court_num from ssfw_court where  id='.$court;
  
      $list_court = $mysql->get_one($sql);
      if($list_court){
        $court_id = $list_court['court_num'];
      }
  // }
   
   if(!$page){
    $page = 0;
   }
   $next_page = 0;
   if($page<3){
     $next_page = 1;
   }
   //通过法院id 找到法院编号

   $ktrq1 = date('Ymd');
   $ktrq1 = strtotime($ktrq1 . "+".$page." day");
   $ktrq1 = date('Ymd',$ktrq1);
   $ktrq2 = $ktrq1;
       
   if($begin_time){
      $ktrq1 = date('Ymd',strtotime($begin_time));
   }
   if($end_time){
     $ktrq2 = date('Ymd',strtotime($end_time));
   }
   if($court_id){
      
      $curl = new Http();
      $uid = 'sfgk';
      $pass = 'sfgksa';
      $ktrq1 = $ktrq1;
      $ktrq2 = $ktrq2;
      //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/KaitingNoticeNew_Yz';
      $url = $api['KaitingNoticeNew_Yz'];
      $arr = array('uid'=>$uid,'pass'=>$pass,'ktrq1'=>$ktrq1,'ktrq2'=>$ktrq2,'fydm'=>$court_id,'fyjc' =>'');
      $xml = $curl->request($url,$arr,'POST');
      if($xml){
        
          $xml = simplexml($xml,'KaitingNoticeNew_Yz','55ktgg.php');
          
          $count = xml_to_str($xml->response->code);
          $num = xml_to_str($xml->count);
          $list =array();
          if($count==0){
             $obj = (array)$xml->ftsylist;
             
             for($i=0;$i<$num;$i++){
                
                    $val =(array)$obj['ftsy'][$i];
                    if(strpos($val['cbr'], $court_id) !== false){
                        $today = date('Y-m-d',time());
                        $create_today = $val['ktrq'];
                        
                        if($today==$create_today){
                            $t = 1;
                        }else{
                            $t = 0;
                        }
                       
                        $list[$i]['case_num'] = $val['ah'];
                        $list[$i]['course_room_name'] = $val['ktft'];
                        $list[$i]['anyou'] = $val['ay'];
                        $list[$i]['court_name'] = $val['fy'];
                        $list[$i]['judge_name'] = $val['fy'];
                        $list[$i]['judge_tel'] = $val['fy'];
                        $list[$i]['lawful_time'] = $val['kssj'].'-'.$val['jssj'];
                        $list[$i]['create_time'] = $val['fbrq'];
                        $list[$i]['today'] = $t;
                        $list[$i]['kt_time'] = $val['ktrq'];
                    }

                 
             }
          }else{
            
            //如果当天没有就请求后一天
            $ktrq2 = strtotime($ktrq1 . "+1 day");
            $ktrq2 = date('Ymd',$ktrq2);
            $arr = array('uid'=>$uid,'pass'=>$pass,'ktrq1'=>$ktrq1,'ktrq2'=>$ktrq2,'fydm'=>$court_id,'fyjc' =>'');
            $xml = $curl->request($url,$arr,'POST');
            
            if($xml){
            
              $xml = simplexml($xml,'KaitingNoticeNew_Yz','100ktgg.php');
              
              $count = xml_to_str($xml->response->code);
              $num = xml_to_str($xml->count);
              $list =array();
              if($count==0){
                 $obj = (array)$xml->ftsylist;
                 
                 for($i=0;$i<$num;$i++){
                    
                        $val =(array)$obj['ftsy'][$i];
                        if(strpos($val['cbr'], $court_id) !== false){
                            $today = date('Y-m-d',time());
                            $create_today = $val['ktrq'];
                            
                            if($today==$create_today){
                                $t = 1;
                            }else{
                                $t = 0;
                            }
                           
                            $list[$i]['case_num'] = $val['ah'];
                            $list[$i]['course_room_name'] = $val['ktft'];
                            $list[$i]['anyou'] = $val['ay'];
                            $list[$i]['court_name'] = $val['fy'];
                            $list[$i]['judge_name'] = $val['fy'];
                            $list[$i]['judge_tel'] = $val['fy'];
                            $list[$i]['lawful_time'] = $val['kssj'].'-'.$val['jssj'];
                            $list[$i]['create_time'] = $val['fbrq'];
                            $list[$i]['today'] = $t;
                            $list[$i]['kt_time'] = $val['ktrq'];
                        }
    
                     
                 }
              }  
           }
            
          }
      }else{
        $list = array();
      }
      
      //数组重新排序
      $list = array_merge($list);
      $result['data']=$list;
      $result['next_page']=$next_page;
      $result['state']='1'; //代表成功
     
   }else{
      
      $result['state']='0'; //代表失败
   }
   
   echo json_encode($result);
   
?>