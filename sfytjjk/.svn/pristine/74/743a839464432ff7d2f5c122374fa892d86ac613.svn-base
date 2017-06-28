<?php 
    /** 用户退出保存相关日志
    **/
    include('../common/global.php');
    $result= array();
    
    $signin_time = _request('signin_time'); 
    $user_id = _request('user_id'); 
    $court_id = _request('court_id'); 
    $fygk_cs = _request('fygk_cs'); 
    $ktgg_cs = _request('ktgg_cs'); 
    $ssyd_cs = _request('ssyd_cs'); 
    $flfg_cs = _request('flfg_cs'); 
    $ajsc_cs = _request('ajsc_cs'); 
    $grzx_cs = _request('grzx_cs'); 
    $qhfy_cs = _request('qhfy_cs'); 
    $sxrcx_cs = _request('sxrcx_cs'); 
    $ssfjs_cs = _request('ssfjs_cs'); 
    $znss_cs = _request('znss_cs'); 
    
    $today_date = date('Ymd');
    
    //公共信息
    $num_log_data = array();
    $num_log_data['product_id'] = 1;
    $num_log_data['user_id'] = $user_id;
    $num_log_data['court_id'] = $court_id;
    $num_log_data['today_date'] = $today_date;
    
    
    //法院概况,type 5 
    if($fygk_cs){
        save_num_log($num_log_data,5,$fygk_cs,'法院概况',$mysql);
    }
    
    //开庭公告,type 6 
    if($ktgg_cs){
        save_num_log($num_log_data,6,$ktgg_cs,'开庭公告',$mysql);
    }
    
    //诉讼引导,type 7 
    if($ssyd_cs){
        save_num_log($num_log_data,7,$ssyd_cs,'诉讼引导',$mysql);
    }
    
    //法律法规,type 8 
    if($flfg_cs){
        save_num_log($num_log_data,8,$flfg_cs,'法律法规',$mysql);
    }
    
    //案件收藏,type 9 
    if($ajsc_cs){
        save_num_log($num_log_data,9,$ajsc_cs,'案件收藏',$mysql);
    }
    
    //诉讼引导,type 7 
    if($grzx_cs){
        save_num_log($num_log_data,7,$grzx_cs,'诉讼引导',$mysql);
    }
    
    //切换法院,type 11 
    if($qhfy_cs){
        save_num_log($num_log_data,11,$qhfy_cs,'切换法院',$mysql);
    }
    
    //失信人查询,type 2 
    if($sxrcx_cs){
        save_num_log($num_log_data,2,$sxrcx_cs,'失信人查询',$mysql);
    }
    
    //诉讼费计算,type 3 
    if($ssfjs_cs){
        save_num_log($num_log_data,3,$ssfjs_cs,'诉讼费计算',$mysql);
    }
    
    //智能搜索,type 4 
    if($znss_cs){
        save_num_log($num_log_data,4,$znss_cs,'智能搜索',$mysql);
    }
    
    //登录退出,type 1 
    if(1){
        save_num_log($num_log_data,1,1,'登录退出',$mysql);
    }
    
    
    
    
    
    //保存时间日志
    $signin_time = strtotime($signin_time);
    $time_log_data = array();
    $time_log_data['end_time'] = time();
    $time_log_data['product_id'] = 1;
    $time_log_data['user_id'] = $user_id;
    $time_log_data['court_id'] = $court_id;
    $time_log_data['begin_time'] = $signin_time;
    $time_log_data['uses_time'] = time()-$signin_time;
    $time_log_data['type_id'] = $user_id;
    $time_log_data['type'] = 3;

    $time_log = $mysql->insert('ssfw_time_log',$time_log_data);
    
    $result['state']=1;
    
    echo json_encode($result);
   
?>
