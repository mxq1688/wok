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
$case_id = del_yinhao(_request('case_id'));
$court_id = del_yinhao(_request('court_id'));
$user_id = del_yinhao(_request('user_id'));

$case_id = think_decrypt($case_id);

$sql = "select * from ssfw_case_handle where id =" . $case_id;
$list_lian = $mysql->get_one($sql);

$log_data = array();
$log_data['search_type'] = 1;
$log_data['type'] = 1;
$log_data['account'] = $list_lian['tdh_case_num'];
$log_data['pwd'] = $list_lian['case_user_pwd'];
$log_data['court_id'] = $court_id;
$log_data['user_id'] = $user_id;
$log_data['lsh'] = $list_lian['tdh_case_num'];
$log_data['result'] = 0;
$log_data['create_time'] = time();
$log_data['case_title'] = $list_lian['user_name'] . $list_lian['case_action_name'].'@';

$case_search = array();

$list['id'] = $list_lian['id'];
$list['lsh'] = $list_lian['tdh_case_num'];
$list['create_time'] = date('Y-m-d', $list_lian['create_time']);
$list['handle_time'] = $list_lian['handle_time']?date('Y-m-d', $list_lian['handle_time']):'-';
$list['user_name'] = $list_lian['user_name'];
$list['dsr'] = $list_lian['user_name'];
$list['court_name'] = $list_lian['court_name'];
$list['reason'] = '-';
$list['case_num'] = $list_lian['user_name'] . $list_lian['case_action_name'];
$list['state'] = $list_lian['state'];
$list['title'] = $list_lian['user_name'] . $list_lian['case_action_name'];
$list['title'] = sub_str($list['title'], 19);
$list['case_action_name'] = $list_lian['case_action_name'];
$list['ckxq_state'] = 0;
$list['biaode'] = $list_lian['apply_money'];

//print_R($list_lian);

if ($list_lian) {
    if ($list_lian['is_tdh_suc'] == 1) {

        $case_num = base64_encode($list_lian['tdh_case_num']);
        $pwd = base64_encode($list_lian['case_user_pwd']);
        $type = base64_encode(1);

        $curl = new Http();
        $url = $api['QueryWslaAnjian_Yz'];
        $arr = array(
            'account' => $case_num,
            'password' => $pwd,
            'type' => $type);
        //print_R($arr);
        $xml = $curl->request($url, $arr, 'POST');

        $xml = simplexml($xml, 'QueryWslaAnjian_Yz', 'ewmcklajz.php');

        if (isset($xml->code)) {
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

                $log_data['case_title'] = $list['dsr'] . $list['case_action_name'] . '@';

            }

            if ($list) {
                $list['id'] = $list_lian['id'];
                if($list['state']==1){
                    $ckxq_state = 1;
                }else if($list['state']==2){
                    $ckxq_state = 2;
                }
                        
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
            
            $list['case_status'] = 2; //1 排队中 2 通达海正式 3 本地 缓存
            $result['data'][0] = $list;
            $result['state'] = 1;
            
        } else {
            if($list['state']==1){
                $ckxq_state = 1;
            }else if($list['state']==2){
                $ckxq_state = 2;
            }
            $list['ckxq_state'] = $ckxq_state;
            
            $list['case_status'] = 3; //1 排队中 2 通达海正式 3 本地 缓存
            $result['data'][0] = $list;
            $result['state'] = 1;
            
        }

    } else {
        $list['case_status'] = 1; //1 排队中 2 通达海正式 3 本地 缓存
        $result['data'][0] = $list;
        $result['state'] = 1;
        
    }

} else {
    $result['state'] = 0;
    $result['msg'] = '不存在该二维码';
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