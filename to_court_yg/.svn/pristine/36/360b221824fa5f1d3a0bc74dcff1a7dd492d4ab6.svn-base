<?php
/*存件取件改件操作*/

include ('../common/global.php');
include ('../common/lib/phpqrcode/phpqrcode.php');


$result = array();
$operation_time = time();
$operation_day = date("m", $operation_time) . '.' . date("d", $operation_time);
$xylsh = _request('xylsh');
$user_id = _request('user_id');

$record = $mysql->select_one('yg_record', '*', 'xylsh=' . "'$xylsh'" .
    " and operation=2");
if (!$record) {
    $record = $mysql->select_one('yg_record', '*', 'xylsh=' . "'$xylsh'" .
        "  and operation=1");
    if ($record) {
        $court_id = $record['court_id'];

        //获取地址
        $yg_group = $mysql->select_one('yg_group', '*', 'id=' . $record['yg_group_id']);
        $address = $yg_group['address'];

        if ($user_id && $xylsh) {

            //将旧的收件人的二维码设为过期
            $data_info = array();
            $data_info['state'] = '0';
            $res_qr_code = $mysql->update('qr_code', $data_info, 'xylsh=' . "'$xylsh'");

            //生成新二维码
            $info = array();
            $info['create_time'] = time();
            $info['date_time'] = date('Ymd', time());
            $info['state'] = 1;
            $info['court_id'] = $court_id;
            $info['yg_box_id'] = $record['yg_group_id'];
            $info['xylsh'] = $xylsh;
            $info['identifying_code'] = rand(100000, 999999);
            //随机码
            $info['randomid'] = generate_password();
            $sql = "select max(id) from qr_code";
            $max_id = $mysql->get_max_value($sql);
            $id = intval($max_id) + 1;
            //验证码=md5(id+随机码)
            $info['validid'] = md5($id . $info['randomid']);

            //生成二维码图片
            $info['path'] = 'upload/erweima/jh/' . $info['validid'] . '_erweima.png';
            $filename = '../upload/erweima/jh/' . $info['validid'] . '_erweima.png';
            QRcode::png($info['validid'], $filename, 1, 4, 1, false);
            $ewm_path = $baseytj . '/' . $info['path'];
            $list = $mysql->insert("qr_code", $info);


            //保存操作记录
            $data = array();
            $data['box_num'] = $record['box_num'];
            $data['xylsh'] = $xylsh;
            $data['operation'] = 3;
            $data['user_name'] = $record['sjr_name'];
            ;
            $data['operation_time'] = $operation_time;


            //获取收件人
            $judge = $mysql->select_one('judge', 'user_name,user_phone', 'id=' . $user_id);


            $data['fjr_id'] = $record['fjr_id'];
            $data['sjr_id'] = $user_id;
            $data['fjr_name'] = $record['fjr_name'];
            $data['sjr_name'] = $judge['user_name'];
            $fjr_name = $data['fjr_name'];
            $sjr_name = $data['sjr_name'];

            $data['fjr_mobile'] = $record['fjr_mobile'];
            $cj_mobile = $record['fjr_mobile'];

            $data['sjr_mobile'] = $judge['user_phone'];
            $qj_mobile = $data['sjr_mobile'];

            //print_R($data);exit;
            //微信给取件人发送
            $wx_arr = array();
            $wx_arr['xylsh'] = $xylsh;
            $wx_arr['address'] = $address;
            $wx_arr['cjr_name'] = $fjr_name;
            $wx_arr['identifying_code'] = $info['identifying_code'];
            $wx_arr['type'] = '2';
            $wx_arr['mobile'] = $qj_mobile;
            $wx_arr['code_path'] = $ewm_path;
            $url = "http://sfytj.njxnet.com/service/send_wx_news.php";
            $curl = new Http();
            $curl->request($url, $wx_arr, 'POST');

            $cj_time = date('Y-m-d H:i');


            //短信给存件人发送内容
            $content = "取件通知：您的文件材料已到法院云柜，请您及时领取！存件人：" . $fjr_name . "，流转编号：" . $xylsh .
                "，取件码：" . $info['validid'] . "，取件二维码：" . $ewm_path . "，云柜地址：" . $address .
                '【铉盈网络】';
            if ($qj_mobile) {
                send_cms_mobile($qj_mobile, $content);
            }

            $data['court_id'] = $court_id;
            $data['yg_group_id'] = $record['yg_group_id'];
            $data['identity_name'] = '法官';
            $data['operation_day'] = $operation_day;

            $insert_yg_record = $mysql->insert('yg_record', $data);
            $result['state'] = 1;

        } else {
            $result['state'] = 0;
            $result['info'] = '缺少有效参数';
        }
    } else {
        $result['state'] = 0;
        $result['info'] = '参数有问题';
    }

} else {
    $result['state'] = 0;
    $result['info'] = '该材料已经被取件不能再指派他人';
}

echo json_encode($result);

?>