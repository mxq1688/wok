<?php 

include('../../../common/global.php');
include('../../../common/lib/phpqrcode/phpqrcode.php');
ini_set("max_execution_time", "3800"); 

//保存之类发送短信密码
$form_data = _request('form_data'); 
$bg_list_data = _request('bg_list_data');
$yg_list_data = _request('yg_list_data');
$dsr_list_data = _request('dsr_list_data');
$yg_dlr_list_data = _request('yg_dlr_list_data');
$bg_dlr_list_data = _request('bg_dlr_list_data');
$wyla_begintime = _request('wyla_begintime');
$qrcode = _request('qrcode');

$user_token = _request('user_token');
$form_data = object_array(json_decode($form_data));
$bg_list_data = object_array(json_decode($bg_list_data));
$dsr_list_data = object_array(json_decode($dsr_list_data));
$yg_list_data = object_array(json_decode($yg_list_data));
$bg_dlr_list_data = object_array(json_decode($bg_dlr_list_data));
$yg_dlr_list_data = object_array(json_decode($yg_dlr_list_data));

if(!$form_data['court_id']){
    $result = array();
    $result['msg']= '缺少参数';
    $result['state']='0'; //代表失败
    echo json_encode($result);
    exit;
}

//案件相关信息
$data['court_id'] = $form_data['court_id'];
$data['user_id'] = $form_data['user_id'];
$data['case_action_id'] = $form_data['ay_id'];
$data['yu_case_num'] = date('ymdHis').$form_data['user_id'].rand(1000,9999);
$data['create_time'] = time();
$data['apply_money'] = $form_data['ajbd'];
$data['la_identity'] = $form_data['lasf'];
$data['litigation_request'] = $form_data['ssqq'];
$data['pay_state'] = 1;

$lists = $mysql->insert('ssfw_case',$data);

$sql = 'select name,mobile_contact,court_num,short_name from ssfw_court where  id='.$data['court_id'];
  
$list_court = $mysql->get_one($sql);

$msg = '';

$val = array();
$val[0] = time().$form_data['user_id'].rand(1000,9999);
$val[1] = rand(100000,999999);
$pwd = $val[1];

$case_data=array();
if($list_court){
    $case_data['court_name']= $list_court['name'];
}
$case_data['yu_case_num']= $data['yu_case_num'];
$case_data['user_id']= $data['user_id'];
$case_data['create_time']= $data['create_time'];
$case_data['court_id']= $data['court_id'];
$case_data['case_num']= $data['yu_case_num'];
$case_data['state']= 1;
$case_data['case_pwd']= $val[1];
$case_data['case_action_id']= $data['case_action_id'];
$case_data['mobile']= $form_data['li_phone'];
$case_data['case_user']= $val[0];
$case_data['case_user_pwd']= $val[1];
$case_data['apply_money']= $form_data['ajbd'];
$case_data['la_identity']= $form_data['lasf'];
$case_data['litigation_request']= $form_data['ssqq'];


if($form_data['ajlx']==21){
    $case_data['type']= '民事案件';
}else if($form_data['ajlx']==51){
    $case_data['type']= '执行案件';
}else if($form_data['ajlx']==31){
    $case_data['type']= '行政案件';
}


//21 代表民事 51 执行
if($form_data['ajlx']==51){
    $case_data['zxyj']= $form_data['zxyj'];
    $case_data['zxyjdw']= $form_data['zxyjdw'];
    $case_data['zxyjwh']= $form_data['zxyjwh'];
}
$case_data['other_contact']= $form_data['qtfs'];
$case_data['email']= $form_data['dzyj'];



$case_data['case_action_name'] = $form_data['ay'];


//取到用户名
$sql_user = 'select user_name,identity_num from ssfw_case_user where  id='.$form_data['user_id'];
  
$list_user = $mysql->get_one($sql_user);
if($list_user){
    $case_data['user_name'] = $list_user['user_name'];
}

$lists_case = $mysql->insert('ssfw_case_handle',$case_data);
$new_id = $mysql->insert_id();



//给对应的法院管理员发送一条短信

$mobile = $list_court['mobile_contact'];
if($mobile){
    $content = $list_user['user_name'].'在'.$list_court['name'].'网上申请立案，请尽快审核。【铉盈网络】';
  //  send_cms_mobile($mobile,$content);
}


if($lists && $lists_case){
  
  //保存诉讼人相关信息
  if($yg_list_data){
        
        foreach($yg_list_data as $val){      
           $yg_list = insert_case_user($val,$form_data,$data['yu_case_num'],1);
           $yg_list_result = $mysql->insert('ssfw_case_user',$yg_list);
        }
  }
  if($dsr_list_data){
       foreach($dsr_list_data as $val){      
           $yg_list = insert_case_user($val,$form_data,$data['yu_case_num'],3);
           $yg_list_result = $mysql->insert('ssfw_case_user',$yg_list);
        }
  }
  if($bg_list_data){
       foreach($bg_list_data as $val){      
           $yg_list = insert_case_user($val,$form_data,$data['yu_case_num'],2);
           $yg_list_result = $mysql->insert('ssfw_case_user',$yg_list);
        }
  }
  
  //保存代理人信息
  
  //原告
  if($yg_dlr_list_data){
  foreach($yg_dlr_list_data as $val){
     $dai = array();
     $dai['name'] = $val[4];
     $dai['court_id'] = $form_data['court_id'];
     $dai['user_type'] = $val[3];
     $dai['zj_type'] = $val[6];
     $dai['zj_code'] = $val[7];
     $dai['address'] = $val[8];
     $dai['mobile'] = $val[5];
     $dai['character_type'] = 4; 
     $dai['company_name'] = $val[9]; 
     $dai['yu_case_num'] = $data['yu_case_num'];
     $dai['case_num'] = $data['yu_case_num']; 
     
     //判断是谁的代理人
     $dsr_name = $val[2]; //当事人姓名
     $case_num = $data['yu_case_num'];
     
     
     $user_sql = 'select * from ssfw_case_user where name='."'$dsr_name'".'and case_num='."'$case_num'";
     $user_list = $mysql->get_one($user_sql);
     if(!$user_list){
        $user_sql = '';
        $user_sql = 'select * from ssfw_case_user where company_name='."'$dsr_name'".'and case_num='."'$case_num'";
        $user_list = $mysql->get_one($user_sql);
     }
     if($user_list){
        $dai['daiid'] = $user_list['id']; 
     }
     
     $dai['type'] = 4; 
     $dai['user_id'] = $form_data['user_id']; 
     $mysql->insert('ssfw_case_user',$dai);
     
  }}
  
  //被告
  if($bg_dlr_list_data){
    foreach($bg_dlr_list_data as $val){
     $dai = array();
     $dai['name'] = $val[4];
     $dai['court_id'] = $form_data['court_id'];
     $dai['user_type'] = $val[3];
     $dai['zj_type'] = $val[6];
     $dai['zj_code'] = $val[7];
     $dai['address'] = $val[8];
     $dai['mobile'] = $val[5];
     $dai['character_type'] = 4; 
     $dai['company_name'] = $val[9]; 
     $dai['yu_case_num'] = $data['yu_case_num']; 
     $dai['case_num'] = $data['yu_case_num']; 
     
     //判断是谁的代理人
     $dsr_name = $val[2]; //当事人姓名
     $case_num = $data['yu_case_num'];
     $user_sql = 'select * from ssfw_case_user where name='."'$dsr_name'".'and case_num='."'$case_num'";
     $user_list = $mysql->get_one($user_sql);
     
     if(!$user_list){
        $user_sql = '';
        $user_sql = 'select * from ssfw_case_user where company_name='."'$dsr_name'".'and case_num='."'$case_num'";
        $user_list = $mysql->get_one($user_sql);
     }
     
     if($user_list){
        $dai['daiid'] = $user_list['id']; 
     }
     
     $dai['type'] = 4; 
     $dai['user_id'] = $form_data['user_id']; 
     $mysql->insert('ssfw_case_user',$dai);
     
  }}
  
  //将保存的图片跟案件关联
  $sql = '';
 // $sql = 'select id,type_id,type,cl_id,name from ssfw_material where  lian_num='."'$user_token'";
  $sql = 'select id,type_id,cl_id,type,name from ssfw_material where  lian_num='."'$user_token'";
  
  $list = $mysql->get_all($sql);
  
  $cai_liao = array();
  if($list){
    foreach($list as $keys=>$val){
        if($val['type']!=''&&$val['type_id']!=''&&$val['name']!=''&&$val['cl_id']!='false'){
        
            $mater_data = array();
            $mater_data['yu_case_num'] = $data['yu_case_num'];
            $lists = $mysql->update('ssfw_material',$mater_data,'id='.$val['id']);
            $cai_liao[$keys]= array();
            array_push($cai_liao[$keys], get_cl_type_id($val['type'],$val['type_id']));
            array_push($cai_liao[$keys], $val['cl_id']);
           // $n = array();
           // $n = array_filter(explode('.',$val['name']));
            array_push($cai_liao[$keys], $val['name']);
            
        }
    }
      
  }
  
  
  
  //拼出立案需要的数据
  $xml_array = array();
  $xml_array['ajlx'] = ($form_data['ajlx']);  //案件类型
  //受理法院通过法院id取得法院的代号
  if($list_court){
    $xml_array['slfy'] = $list_court['court_num'];  //受理法院 
  }
  //通过案由id获取案由编号
   $sql_anyou = 'select action_num,name from ssfw_case_action where  id='.$form_data['ay_id'];
  
   $list_anyou = $mysql->get_one($sql_anyou);
   if($list_anyou){
       $xml_array['sqay'] = ($list_anyou['action_num']);  //申请案由
       $xml_array['ayms'] = ($list_anyou['name']);  //申请案由
   }
  
  $xml_array['sdfs'] = (2);  //送达方式  1 在线送达、2 邮寄送达 默认快递
  
  if($list_user){
    $xml_array['lasq']['xm'] = ($list_user['user_name']);     //姓名
    $xml_array['lasq']['sfz'] = ($list_user['identity_num']); //身份证
  }
  
  $xml_array['lasq']['sjhm'] = ($form_data['li_phone']); //手机号码
  $xml_array['lasq']['lasf'] = ($form_data['lasf']); //立案身份
  $xml_array['lasq']['cxmm'] = $pwd; //查询密码
  $xml_array['lasq']['bdje'] = ($form_data['ajbd']); //诉讼标的金额
  $aj_type = 1;//1 代表民事 2 执行 3 行政
  if($form_data['ajlx']==51){
    //执行案件时
    $xml_array['lasq']['zxyj'] = ($form_data['zxyj']); //执行依据
    $xml_array['lasq']['zxyjwh'] = ($form_data['zxyjwh']); //执行依据文号
    $xml_array['lasq']['zxyjdw'] = ($form_data['zxyjdw']); //执行依据单位
    
    $aj_type = 2;
    
  }else if($form_data['ajlx']==31){
    $aj_type = 3;
  }
  
  //当事人信息
  $person = get_dsr_info($yg_list_data,$bg_list_data,$dsr_list_data,$aj_type);
  
  $xml_array['dsr'] = $person;
  
  //代理人信息
  $dlr_person = get_dlr_info($yg_dlr_list_data,$bg_dlr_list_data);
  
  $xml_array['dlr'] = $dlr_person;
  

  
  $xml_str = array_to_xml($xml_array);
  
   
  //$xml_new_array = array();
  $cai_str = '<sscl><sy>'.$form_data['ssqq'].'</sy>';
  if($cai_liao){
    foreach($cai_liao as $_val){
        $cai_str .= '<cl lx='."'$_val[0]'".' id='."'$_val[1]'".' mc='."'$_val[2]'".'/>';
    }
  }
  
  $cai_str .= '</sscl></data>';
 
  //字符串替换将最后的</data>替换
  $xml_new_str = str_replace("</data>", $cai_str, $xml_str);
  //单引号换成双引号
  $xml_new_str = str_replace("'", '"', $xml_new_str);
//echo $xml_new_str;exit;
  $xml_new_str = urlencode(urlencode($xml_new_str));

  $arr = array(
    'uid' => 'wsla',
    'pass' => 'wsla',
    'xml' => $xml_new_str,
  );
  //提交案件
  $xml = jkapi('CaseServlet_Yz',$arr,$api['CaseServlet_Yz'],'xxtj.php');

  if(isset($xml->status)){
    
      $status = xml_to_str($xml->status);
      $code = xml_to_str($xml->msg);
      
      if($status=='true'){
         
         //保存$code
        $new_data = array();  
        $new_data['tdh_case_num'] = $code;
        
        $sql = "select * from ssfw_qr_code where validid = "."'$qrcode'";
        $list_qr = $mysql -> get_one($sql);
        $qr_id = 0;
        if($list_qr){
            $qr_id = $list_qr['id'];   //上面获取的
        }
        
        $qr_code = array();
        $qr_code['case_id'] = $new_id;
        $mysql->update('ssfw_qr_code',$qr_code,'id='.$new_id);
        
        //获取二维码图片
        $sql = 'select path from ssfw_qr_code where id='."'$qr_id'";
        $list_qr = $mysql->get_one($sql);
        $uer_erweima = '';
        $path = '';
        if($list_qr){
            $path = $list_qr['path'];
            $uer_erweima = $baseytj.'/'.$path;
        }
        
        $new_data['path'] = $path;
        $lists = $mysql->update('ssfw_case_handle',$new_data,'id='.$new_id);
        
        
        $mobile = $form_data['li_phone'];
        $content = '该案件已提交成功，请等待审核，您可以通过查询账号：'.$code.' ; 密码：'.$case_data['case_user_pwd'].'; 案件二维码：'.$uer_erweima.'，查询该案的审核情况【铉盈网络】';
        //$content = '该案件已提交成功，请等待审核，您可以通过查询账号：'.$code.' ; 密码：'.$case_data['case_user_pwd'].'; 案件二维码：'.$uer_erweima.'，查询该案的审核情况';
        
        send_cms_mobile($mobile,$content);
        
//        $curl = new Http();
//        $arr['mobile'] = $mobile;
//        $arr['content'] = $content;
//        $url = $api['SendCms'];
//        $curl->request($url,$arr,'POST');
        
        insert_message(2,$mobile,$content,'系统',$case_data['user_name'],$form_data['court_id'],$mysql);

        //保存时间日志
        $wyla_begintime = strtotime($wyla_begintime);
        $time_log_data = array();
        $time_log_data['end_time'] = time();
        $time_log_data['product_id'] = 1;
        $time_log_data['user_id'] = $form_data['user_id'];
        $time_log_data['court_id'] = $form_data['court_id'];
        $time_log_data['begin_time'] = $wyla_begintime;
        $time_log_data['uses_time'] = time()-$wyla_begintime;
        $time_log_data['type_id'] = $data['yu_case_num'];
        $time_log_data['type'] = 1;
        
        $list = $mysql->insert('ssfw_time_log',$time_log_data);
        
        //给该二维码添加云柜权限，立案进展权限
        $ssfw_qr_code = array();
        $ssfw_qr_code['la_state'] = 1;
        $ssfw_qr_code['yg_state'] = 2;
        $ssfw_qr_code['cx_lajz_state'] = 2;
        $ssfw_qr_code['case_id'] = $new_id;
        $lists = $mysql->update('ssfw_qr_code',$ssfw_qr_code,'id='.$qr_id);
        
        //修改当事人信息
        
        $sql = "select * from ssfw_case_user where yu_case_num =".$data['yu_case_num'];
        $list_user = $mysql->get_all($sql);
        //print_R($case_id);exit;
        if($list_user){
            $xx = array();
            foreach($list_user as $val){
                $xx['case_id'] = $new_id;
                $lists = $mysql->update('ssfw_case_user',$xx,'id='.$val['id']);
            }
        }
        
        //返回信息
        $result['state']='1'; //
        $result['msg']='提交成功'; //
        $result['path']=$path; //
        $result['case_num']=$new_id; //
        
    }else{
        $result['msg']= xml_to_str($xml->msg); //代表失败
        $result['state']='0'; //代表失败
    } 
  }else{
    $result['msg']= '网络超时';
    $result['state']='0'; //代表失败
  }

 
  
}else{
    $result['msg']= '缺少参数';
    $result['state']='0'; //代表失败
}

echo json_encode($result);

function insert_case_user($val,$form_data,$yu_case_num,$type){
    
        $yg_list = array();
   
        $yg_list['type'] = $type;
        $yg_list['character_type'] = $val[1];
        $yg_list['court_id'] = $form_data['court_id'];
        $yg_list['yu_case_num'] = $yu_case_num;
        $yg_list['case_num'] = $yu_case_num;
        $yg_list['user_id'] = $form_data['user_id'];
        $yg_list['name'] = $val[2];
        
        if($val[1]=='09_01001-1'){
            $yg_list['identity_num'] = $val[3];
            $yg_list['nation'] = $val[4];
            $yg_list['sex'] = $val[5];
            $yg_list['mobile'] = $val[6];
            $yg_list['nationality'] = $val[7];
            $yg_list['address'] = $val[8];
            $yg_list['litigation_type'] = '';
            
        }else {
            $yg_list['mobile'] = $val[3];
            $yg_list['name'] = $val[5];
            $yg_list['address'] = $val[4];
            $yg_list['company_name'] = $val[2];
            $yg_list['zj_type'] = $val[6];
            $yg_list['zj_code'] = $val[7];
            
        }
        return $yg_list;

    
}

//获取当事人信息
function get_dsr_info($yg_list_data,$bg_list_data,$dsr_list_data,$aj_type){
    if($yg_list_data){
        krsort($yg_list_data);
    }
    if($bg_list_data){
        krsort($bg_list_data);
    }
    if($dsr_list_data){
        krsort($dsr_list_data);
    }
    
    $yg_person = array();
    if($yg_list_data){
        
       
       foreach($yg_list_data as $key=>$val){  
        
           //自然人
           if($val[1]=='09_01001-1'){
              $yg_person[$key]['lx'] = $val[1];
              $yg_person[$key]['xm'] = $val[2];
              $yg_person[$key]['sfz'] = $val[3];
              $yg_person[$key]['mz'] = $val[4];
              $yg_person[$key]['xb'] = $val[5];
              $yg_person[$key]['lxdh'] = $val[6];
              $yg_person[$key]['gj'] = $val[7];
              $yg_person[$key]['dz'] = $val[8];
              
           }else{
            //非自然人
              $yg_person[$key]['lx'] = $val[1];
              $yg_person[$key]['xm'] = $val[2];
              $yg_person[$key]['fddbr'] = $val[5];
              $yg_person[$key]['dbrzjzl'] = $val[6];
              $yg_person[$key]['dbrzjhm'] = $val[7];
              $yg_person[$key]['lxdh'] = $val[3];
              $yg_person[$key]['dz'] = $val[4];
              
           }
             if($aj_type==1){
                $yg_person[$key]['ssdw'] = '09_03207-1';
              }else if($aj_type==2){
                $yg_person[$key]['ssdw'] = '09_06205-1';
              }else{
                $yg_person[$key]['ssdw'] = '09_04210-1';
              }
        }
  }
  
  $bg_person = array();
  if($bg_list_data){
       
       foreach($bg_list_data as $key=>$val){  
        
           //自然人
           if($val[1]=='09_01001-1'){
              $bg_person[$key]['lx'] = $val[1];
              $bg_person[$key]['xm'] = $val[2];
              $bg_person[$key]['sfz'] = $val[3];
              $bg_person[$key]['mz'] = $val[4];
              $bg_person[$key]['xb'] = $val[5];
              $bg_person[$key]['lxdh'] = $val[6];
              $bg_person[$key]['gj'] = $val[7];
              $bg_person[$key]['dz'] = $val[8];
           }else{
            //非自然人
              $bg_person[$key]['lx'] = $val[1];
              $bg_person[$key]['xm'] = $val[2];
              $bg_person[$key]['fddbr'] = $val[5];
              $bg_person[$key]['dbrzjzl'] = $val[6];
              $bg_person[$key]['dbrzjhm'] = $val[7];
              $bg_person[$key]['lxdh'] = $val[3];
              $bg_person[$key]['dz'] = $val[4];
              
           }
           
           if($aj_type==1){
             $bg_person[$key]['ssdw'] = '09_03207-2';
           }else if($aj_type==2){
             $bg_person[$key]['ssdw'] = '09_06205-2';
           }else{
             $bg_person[$key]['ssdw'] = '09_04210-2';
           }
        }
  }
  
  $dsr_person = array();
  if($dsr_list_data){
       
       foreach($dsr_list_data as $key=>$val){  
        
           //自然人
           if($val[1]=='09_01001-1'){
              $dsr_person[$key]['lx'] = $val[1];
              $dsr_person[$key]['xm'] = $val[2];
              $dsr_person[$key]['sfz'] = $val[3];
              $dsr_person[$key]['mz'] = $val[4];
              $dsr_person[$key]['xb'] = $val[5];
              $dsr_person[$key]['lxdh'] = $val[6];
              $dsr_person[$key]['gj'] = $val[7];
              $dsr_person[$key]['dz'] = $val[8];
 
           }else{
            //非自然人
              $dsr_person[$key]['lx'] = $val[1];
              $dsr_person[$key]['xm'] = $val[2];
              $dsr_person[$key]['fddbr'] = $val[5];
              $dsr_person[$key]['dbrzjzl'] = $val[6];
              $dsr_person[$key]['dbrzjhm'] = $val[7];
              $dsr_person[$key]['lxdh'] = $val[3];
              $dsr_person[$key]['dz'] = $val[4];
              
           }
           
           if($aj_type==1){
             $dsr_person[$key]['ssdw'] = '09_03207-3';
           }else if($aj_type==2){
             $dsr_person[$key]['ssdw'] = '09_06205-2';
           }else{
             $dsr_person[$key]['ssdw'] = '09_04210-3';
           }
           
        }
  }
  
  $list = array_merge($bg_person,$dsr_person,$yg_person);
  $new_list = array();
  if($list){
    foreach($list as $key=>$val){
        $val['xh'] = $key;
        $new_list[$key] = $val;
    }
  }
  
  //需要将key换成person
  return $new_list;
  
}

function get_dlr_info($yg_dlr_list_data,$bg_dlr_list_data){
    
    if($yg_dlr_list_data){
        krsort($yg_dlr_list_data);
    }
    if($bg_dlr_list_data){
        krsort($bg_dlr_list_data);
    }
    
    
    
    $yg_person = array();
    if($yg_dlr_list_data){

       foreach($yg_dlr_list_data as $key=>$val){  
        
           //自然人
              $yg_person[$key]['lx'] = get_dlr_lx($val[3]);
              $yg_person[$key]['dldsr'] = $val[2];
              $yg_person[$key]['xm'] = $val[4];
              $yg_person[$key]['dw'] = $val[9];
              $yg_person[$key]['lxdh'] = $val[5];  
              $yg_person[$key]['zjzl'] = $val[6];
              $yg_person[$key]['zjhm'] = $val[7];
              $yg_person[$key]['dz'] = $val[8];
          
        }
  }
  
  $bg_person = array();
  if($bg_dlr_list_data){
       
       foreach($bg_dlr_list_data as $key=>$val){  
        
              $bg_person[$key]['lx'] = get_dlr_lx($val[3]);
              $bg_person[$key]['dldsr'] = $val[2];
              $bg_person[$key]['xm'] = $val[4];
              $bg_person[$key]['dw'] = $val[9];
              $bg_person[$key]['lxdh'] = $val[5];  
              $bg_person[$key]['zjzl'] = $val[6];
              $bg_person[$key]['zjhm'] = $val[7];
              $bg_person[$key]['dz'] = $val[8];
        }
  }

  
  $list = array_merge($yg_person,$bg_person);
  $new_list = array();
  if($list){
    foreach($list as $key=>$val){
        $val['xh'] = $key;
        $new_list[$key] = $val;
    }
  }

  return $new_list;


}

//代理人类型切换
function get_dlr_lx($val){
    $lx = '';
    switch($val){
        case '律师':
        $lx = '09_01010-1';break;
        case '承担法律援助的律师':
        $lx = '09_01010-2';break;
        case '监护人':
        $lx = '09_01010-3';break;
        case '亲友':
        $lx = '09_01010-4';break;
        case '人民团体推荐的人':
        $lx = '09_01010-5';break;
        case '所在单位推荐的人':
        $lx = '09_01010-6';break;
        case '法院许可的其他公民':
        $lx = '09_01010-7';break;
        case '法律工作者':
        $lx = '09_01010-8';break;
    }
    return $lx;
}




?>