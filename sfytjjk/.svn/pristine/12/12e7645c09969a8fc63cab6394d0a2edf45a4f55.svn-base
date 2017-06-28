<?php
/** 预约立案进展查询
 * lei_type 1 我的预约案件 
 * lei_type 2 我的阅卷 
 * lei_type 3 已受理案件
 * type 1 查询帐号 查询
 * type 2 手机号码 查询
 * state  指案件受理状态
 * $ckxq_state 查看案件详情
 * 0 不可以看
 * 1 请求确认表
 * 2 请求详情
 **/
include ('../../../common/global.php');

$result = array();
$case_num = del_yinhao(_request('case_num'));
$lei_type = _request('lei_type');
$pwd = _request('password');
$mobile = _request('mobile');
$type = _request('type');
$name = del_yinhao(_request('name'));
$court_id = del_yinhao(_request('court_id'));
$user_id = del_yinhao(_request('user_id'));

$log_data = array();
$log_data['search_type'] = $lei_type;
$log_data['type'] = $type;
if ($case_num) {
    $log_data['account'] = $case_num;
} else {
    $log_data['account'] = $mobile;
}

$log_data['pwd'] = $pwd;
$log_data['court_id'] = $court_id;
$log_data['user_id'] = $user_id;
$log_data['lsh'] = $case_num;
$log_data['result'] = 0;
$log_data['create_time'] = time();
$log_data['name'] = $name;

$case_search = array();


if ($lei_type == 1) {

    if ($type == 1 && $case_num != '' && $pwd != '') {

        $case_num = base64_encode($case_num);
        $pwd = base64_encode($pwd);
        $type = base64_encode($type);


        $curl = new Http();
        //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/QueryWslaAnjian_Yz';
        $url = $api['QueryWslaAnjian_Yz'];
        $arr = array(
            'account' => $case_num,
            'password' => $pwd,
            'type' => $type);
        //print_R($arr);
        $xml = $curl->request($url, $arr, 'POST');

        $xml = simplexml($xml, 'QueryWslaAnjian_Yz', 'lei_type=1.type=1.88行.cklajz.php');
      
        if (isset($xml->code)&&$xml->code=='true') { 
            //取出返回的状态
            $code = xml_to_str($xml->code, true);
            $result_tpye = 1;

            //false 代表没有查到 true 代表能查到
            $ckxq_state = 0;

            $list = array();
            if ($code == 'true') {
                $log_data['result'] = 1;

                //登录后获取案件信息
                $list = get_simple_case_jz($xml->lajzcx, true, $mysql);
                $list['case_num'] = sub_str($list['case_num'],19);
                $log_data['case_title'] = $list['dsr'] . $list['case_action_name'] . '@';

            }

            if ($list) {
                $list['ckxq_state'] = $ckxq_state;
                $list = getzanwu_time($list, $result_tpye);
                //搜索日志的数据
                $case_search['type'] = 1;
                $case_search['lsh'] = $list['lsh'];
                $case_search['state'] = $list['state'];
                $case_search['case_type'] = $list['case_type'];
                $case_search['case_type_name'] = $list['case_type_name'];
                $case_search['case_action_name'] = $list['case_action_name'];
                $case_search['dsr_name'] = $list['dsr'];
                $case_search['user_name'] = $list['user_name'];
                $case_search['create_time'] = strtotime($list['create_time']);
                $case_search['handle_time'] = strtotime($list['handle_time']);
                $case_search['court_name'] = $list['court_name'];
                $case_search['court_id'] = $list['court_id'];
                $case_search['court_num'] = $list['court_num'];
                $case_search['check_name'] = $list['check_name'];
                $case_search['check_result'] = $list['reason'];
                $case_search['biaodi'] = $list['biaode'];
                $case_search['search_type'] = 1;
                $case_search['search_time'] = time();

            }
            $list['case_status'] = 0;
            $result['data'] = $list;
            $result['state'] = 1;
            $result['aj_status'] = 2; //1 排队中 2 通达海正式 3 本地 缓存
        } else {

            $sql = "select * from ssfw_case_handle where tdh_case_num =" . base64_decode($case_num) .
                ' and case_user_pwd = ' . base64_decode($pwd);
            $list_lian = $mysql->get_one($sql);
            if($list_lian){
                $list['lsh'] = $list_lian['tdh_case_num'];
                $list['create_time'] = date('Y-m-d', $list_lian['create_time']);
                $list['handle_time'] = '-';
                $list['user_name'] = $list_lian['user_name'];
                $list['dsr'] = $list_lian['user_name'];
                $list['court_name'] = $list_lian['court_name'];
                $list['reason'] = '-';
                $list['case_num'] = $list_lian['user_name'] . $list_lian['case_action_name'];
                $list['state'] = $list_lian['state'];
                $list['title'] = $list_lian['user_name'] . $list_lian['case_action_name'];
                $list['title'] = sub_str($list['title'], 19);
                $list['case_action_name'] = $list_lian['case_action_name'];
                $list['ckxq_state'] = 1;
                $list['biaode'] = $list_lian['apply_money'];
                $list['case_num'] = sub_str($list['case_num'],19);
                
                $result['data'] = $list;
                $result['state'] = 1;
                $result['aj_status'] = 3; //1 排队中 2 通达海正式 3 本地 缓存
            }else{
                $list = array();
                $result['data'] = $list;
                $result['state'] = 1;
            }
            
        }


    } else
        if ($type == 2 && $mobile != '' && $pwd != '') {

            $case_num = base64_encode($mobile);
            $pwd = base64_encode($pwd);
            $type = base64_encode($type);

            $curl = new Http();
            //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/QueryWslaAnjian_Yz';
            $url = $api['QueryWslaAnjian_Yz'];
            $arr = array(
                'account' => $case_num,
                'password' => $pwd,
                'type' => $type);

            $xml = $curl->request($url, $arr, 'POST');
            // $xml = simplexml_load_string($xml);
            $xml = simplexml($xml, 'QueryWslaAnjian_Yz', 'lei_type=1.type=2.157行.cklajz.php');

            if (isset($xml->code)) {
                $code = xml_to_str($xml->code, true);

                $vo = array();

                if ($code == 'true') {
                    $log_data['result'] = 1;

                    $xml = (array )$xml;
                    $count = count($xml['lajzcx']);
                    if ($count > 0) {
                        $case_title = 0;
                        for ($i = 0; $i < $count; $i++) {
                            $vo[$i] = get_simple_case_jz($xml['lajzcx'][$i], true, $mysql);
                            $vo[$i]['case_status'] = 0;
                            $log_data['case_title'] = $vo[0]['dsr'] . $vo[0]['case_action_name'] . '@';
                            $case_title .= $vo[$i]['dsr'] . $vo[$i]['case_action_name'] . '@';
                        }
                        $log_data['case_title'] = $case_title;
                    } else {
                        if ($xml['lajzcx']['lsh']) {
                            $vo[0] = get_simple_case_jz($xml['lajzcx'][0], true, $mysql);
                            $vo[0]['case_status'] = 0;
                            $log_data['case_title'] = $vo[0]['dsr'] . $vo[0]['case_action_name'] . '@';
                        }
                    }

                }
                $result['data'] = $vo;
                $result['state'] = 1;
            } else {
                $result['state'] = 0;
            }

        } else {
            $result['state'] = '0'; //代表失败
        }

} else
    if ($lei_type == 2) {
        if ($type == 1 && $case_num != '' && $pwd != '' && $name != '') {

            $sql_yue = "select * from ssfw_review where user_id = $user_id and account='$case_num' and pwd='$pwd' and name='$name'";
            $val = $mysql->get_one($sql_yue);

            //先查通达海的，然后查询我们
            $curl = new Http();
            $url = $api['DetailAnjian_Yz'];
            $arr = array(
                'account' => $case_num,
                'password' => $pwd,
                'type' => $type);
            $xml = $curl->request($url, $arr, 'POST');
            $xml = simplexml($xml, 'DetailAnjian_Yz', 'cklajz.php');

            $vo = array();
            $code = '';
            if (isset($xml->code)) {
                $code = xml_to_str($xml->code);
            }


            if ($code == 1) {

                $log_data['result'] = 1;
                //登录后获取信息
                $list = get_case($xml);

                $log_data['case_title'] = $list['case_name'] . '@';

                //还需要根据流水号找到该案件的预约列表
                $lsh = $list['lsh'];
                $case_num = base64_encode($case_num);
                $pwd = base64_encode($pwd);
                $type = base64_encode($type);
                $lsh = base64_encode($lsh);
                $name = base64_encode($name);

                //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/WsyjLb_Yz';
                $url = $api['WsyjLb_Yz'];
                $arr = array(
                    'account' => $case_num,
                    'password' => $pwd,
                    'type' => $type,
                    'lsh' => $lsh,
                    'sqrxm' => $name);
                $xml = $curl->request($url, $arr, 'POST');
                // $xml = simplexml_load_string($xml);
                $xml = simplexml($xml, 'WsyjLb_Yz', 'lei_type=2.type=1.255行.cklajz.php');
                $code = '';
                if (isset($xml->code)) {
                    $code = xml_to_str($xml->code, true);
                }

                $code = xml_to_str($xml->code, true);
                if (isset($code) && $code != 'false') {
                    $list = get_yue_case_by_lsh($xml, $mysql, $arr, $name);
                    $vo = $list;
                }

            }

            //重新排序
            $vo = array_values($vo);
            //print_r($vo);exit;
            $result['data'] = $vo;
            $result['state'] = 1;


        } else
            if ($type == 2 && $mobile != '' && $pwd != '') {
                $yname = $name;
                $arrold = array(
                    'account' => $mobile,
                    'password' => $pwd,
                    'type' => $type);
                // echo $mobile;echo $pwd;echo $type;
                $mobile = base64_encode($mobile);
                $pwd = base64_encode($pwd);
                $type = base64_encode($type);

                $curl = new Http();
                //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/LoginAnjian_Yz';
                $url = $api['LoginAnjian_Yz'];
                $arr = array(
                    'account' => $mobile,
                    'password' => $pwd,
                    'type' => $type);
                $xml = $curl->request($url, $arr, 'POST');
                //$xml = simplexml_load_string($xml);
                $xml = simplexml($xml, 'LoginAnjian_Yz', 'lei_type=2.type=2.292行.cklajz.php');
                $count = 0;
                if (isset($xml->lb->xh)) {
                    $count = $xml->lb->xh->count();
                }

                $vo = array();
                $list = array();
                if ($count) {
                    $log_data['result'] = 1;
                    $case_title = '';
                    $keys = 0;
                    foreach ($xml->lb->xh as $val) {

                        $case_title .= xml_to_str($val->yhxm, true) . xml_to_str($val->ay, true) . '@';

                        //登录返回的案件数据
                        $lsh = xml_to_str($val->lsh, true);
                        $case_num = ($mobile);
                        $pwd = ($pwd);
                        $type = ($type);
                        $lsh = base64_encode($lsh);
                        $name = base64_encode($yname);

                        //echo $lsh;exit;
                        //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/WsyjLb_Yz';
                        $url = $api['WsyjLb_Yz'];
                        $arr = array(
                            'account' => $case_num,
                            'password' => $pwd,
                            'type' => $type,
                            'lsh' => $lsh,
                            'sqrxm' => $name);
                        $xml = $curl->request($url, $arr, 'POST');
                        $xml = simplexml($xml, 'WsyjLb_Yz', 'lei_type=2.type=2.321行.cklajz.php');
                        $code = '';
                        if (isset($xml->code)) {
                            $code = xml_to_str($xml->code, true);

                        }

                        if (isset($code) && $code != 'false') {
                            $vo[$keys] = get_yue_case_by_lsh($xml, $mysql, $arr, $name);
                        } else {
                            $vo[$keys] = $list;
                        }

                        $keys++;
                    }

                    $log_data['case_title'] = $case_title;
                }

                //时间排序
                $new_array = array();
                if ($vo) {
                    $key = 0;
                    foreach ($vo as $val) {
                        if ($val) {
                            foreach ($val as $_val) {
                                $new_array[$key] = $_val;
                                $key++;
                            }
                        }
                    }

                }

                $new_arr = array();
                if (count($new_array) > 1) {
                    $new_arr = arraySort($new_array, 'create_time', 'desc');
                }

                $result['data'] = $new_arr;
                $result['state'] = 1;
            } else {
                $result['state'] = '0'; //代表失败
            }
    } else
        if ($lei_type == 3) {


            if ($type == 1 && $case_num != '' && $pwd != '') {

                //先请求4.1接口，查到案件列表，通过案件列表查到

                //先查通达海的，然后查询我们
                $curl = new Http();
                //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/DetailAnjian_Yz';
                $url = $api['DetailAnjian_Yz'];
                $arr = array(
                    'account' => $case_num,
                    'password' => $pwd,
                    'type' => $type);
                $xml = $curl->request($url, $arr, 'POST');
                //$xml = simplexml_load_string($xml);
                $xml = simplexml($xml, 'DetailAnjian_Yz', 'lei_type=3.type=1.458行.cklajz.php');
                $list = array();
                $code = xml_to_str($xml->code);
                if ($code == 1) {

                    $log_data['result'] = 1;


                    //登录后获取信息
                    $list = get_case($xml);
                    $log_data['case_title'] = $list['case_name'] . '@';
                    //http://ip:port/service/DetailAnjian_Yz
                    //参数 lsh：案件流水号 court : 法院代码

                    //还需要根据流水号找到该案件的详细信息
                    $list['allinfo'] = get_case_by_lsh($list['lsh'], $arr, $xml);

                    if ($list) {
                        $list = getzanwu_time($list, 1);
                    }


                    $list_array = array();
                    $list_array[0] = $list;
                    $result['data'] = $list_array;
                    $result['state'] = 1;

                    $list_search = get_case2($xml, $mysql);


                    //搜索日志的数据

                    $case_search['type'] = 1;
                    $case_search['lsh'] = $list['lsh'];
                    $case_search['state'] = $list['state'];
                    $case_search['case_action_name'] = $list['case_action_name'];
                    $case_search['dsr_name'] = $list['dsr_name'];
                    $case_search['user_name'] = $list['dsr_name'];
                    $case_search['create_time'] = strtotime($list['create_time']);
                    $case_search['handle_time'] = strtotime($list['handle_time']);
                    $case_search['court_name'] = $list['court_name'];
                    $case_search['court_id'] = $list_search['court_id'];
                    $case_search['court_num'] = $list_search['court_num'];
                    $case_search['check_name'] = $list_search['check_name'];
                    $case_search['biaodi'] = $list['biaode'];
                    $case_search['search_type'] = 2;
                    $case_search['check_mobile'] = $list_search['check_mobile'];
                    $case_search['collegiate_name'] = $list_search['collegiate_name'];
                    $case_search['ah'] = $list_search['ah'];
                    $case_search['clerk_name'] = $list_search['clerk_name'];
                    $case_search['close_type'] = $list_search['close_type'];
                    $case_search['close_time'] = strtotime($list_search['close_time']);
                    $case_search['check_dept'] = $list_search['check_dept'];
                    $case_search['search_time'] = time();


                }


            } else
                if ($type == 2 && $mobile != '' && $pwd != '') {

                    $arrold = array(
                        'account' => $mobile,
                        'password' => $pwd,
                        'type' => $type,
                        '');

                    $mobile = base64_encode($mobile);
                    $pwd = base64_encode($pwd);
                    $type = base64_encode($type);

                    $curl = new Http();
                    //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/LoginAnjian_Yz';
                    $url = $api['LoginAnjian_Yz'];
                    $arr = array(
                        'account' => $mobile,
                        'password' => $pwd,
                        'type' => $type);
                    $xml = $curl->request($url, $arr, 'POST');
                    // $xml = simplexml_load_string($xml);
                    $xml = simplexml($xml, 'LoginAnjian_Yz', 'lei_type=3.type=2.537行.cklajz.php');

                    $count = 0;

                    if (isset($xml->lb->xh)) {
                        $count = $xml->lb->xh->count();
                    }


                    $vo = array();
                    if ($count) {

                        $log_data['result'] = 1;
                        $case_title = '';
                        $keys = 0;
                        foreach ($xml->lb->xh as $val) {
                            //登录返回的案件数据
                            $list = get_case_lie($val, true);

                            $case_title .= $list['case_name'] . '@';

                            //判断案件的状态部分信息重写
                            $list = getzanwu_time($list, 1);

                            //根据流水号得到该案件的详细信息 请求案件详细接口 4.11
                            $list['allinfo'] = get_case_by_lsh($list['lsh'], $arrold, $val, 2);

                            $vo[$keys] = $list;
                            $keys++;
                        }

                        $log_data['case_title'] = $case_title;
                    }

                    $result['data'] = $vo;
                    $result['state'] = 1;
                } else {
                    $result['state'] = '0'; //代表失败
                }

        } else {
            $result['state'] = '0'; //代表失败
        }

        //保存查询日志
        $search_list = $mysql->insert('ssfw_search_log', $log_data);
        $search_id = $mysql->insert_id();
        $case_search['search_id'] = $search_id;
        if (isset($case_search['lsh'])) {
            $search_list_case = $mysql->insert('ssfw_case_search', $case_search);
            if ($mysql->insert_id() && $search_list_case) {
                $case = array();
                $case['result'] = 2;
                $search_list = $mysql->update('ssfw_search_log', $case, 'id=' . $search_id);
            }
        
        }


echo json_encode($result);

?>