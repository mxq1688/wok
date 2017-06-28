<?php
/*存件取件改件操作*/

include ('../common/global.php');
include ('../common/lib/phpqrcode/phpqrcode.php');


$result = array();
$content = _request('content');
$operation = _request('operation');
$open_id = @_request('open_id');
$operation_time = time();
$operation_day = date("m", $operation_time) . '.' . date("d", $operation_time);
$user_id = _request('user_id');

$file = _request('file');
$file = object_array(json_decode($file));
$state = '';
if ($operation == 2) {
    if ($content && $open_id) {
        $sql = "validid = " . "'$content'";
        $qr_code = $mysql->select_one('qr_code', '*', $sql);
        if ($qr_code) {
            if ($qr_code['state'] == 1) {
                $xylsh = $qr_code['xylsh'];
                //找到这个用户openid
                $yg_wechat = $mysql->select_one('yg_wechat', '*', 'open_id=' . "'$open_id'");
                if ($yg_wechat) {
                    //先判断这个取件人是否对
                    $sjr_mobile = $yg_wechat['mobile'];
                    if ($sjr_mobile) {
                        //根据手机号码获取judge获取名字
                        $judge = $mysql->select_one('judge', '*', 'user_phone=' . "'$sjr_mobile'");

                        $record = $mysql->select_one('yg_record', '*', 'xylsh=' . "'$xylsh'" .
                            " and operation=1 ");
                        // echo $judge['user_name'];
                        //  echo $record['sjr_name'];exit;
                        if ($judge['user_name'] == $record['sjr_name']) {

                            //执行改件

                            //修改二维码表信息
                            $data_info = array();
                            $data_info['state'] = '0';
                            $res_qr_code = $mysql->update('qr_code', $data_info, 'id=' . $qr_code['id']);

                            if ($res_qr_code) {

                                $state = "success";

                                //获取短信通知需要的信息
                                $sjr_name = $record['sjr_name'];
                                $fjr_name = $record['fjr_name'];
                                $qj_time = date('Y-m-d H:i');

                                //print_R($record);exit;
                                //调用微信发送 发送给存件人发

                                $wx_arr = array();
                                $wx_arr['sjr_name'] = $sjr_name;
                                $wx_arr['xylsh'] = $xylsh;
                                $wx_arr['address'] = '';
                                $wx_arr['type'] = '3';
                                $wx_arr['mobile'] = $record['fjr_mobile'];
                                $url = "http://sfytj.njxnet.com/service/send_wx_news.php";
                                $curl = new Http();
                                // $curl->request($url, $wx_arr, 'POST');

                                //调用短信发送给存件人发
                                // $content = "存件出柜通知：您的材料已被收件人取出。收件人：" . $sjr_name . "，流转编号：" . $xylsh . "，取件时间：" .
                                //  $qj_time . "，云柜地址：" . $address . '【铉盈网络】';
                                // send_cms_mobile($record['fjr_mobile'], $content);


                                //调用微信发送 给取件人发送通知(第一个取件人))

                                $sjr_name = $record['sjr_name'];
                                $fjr_name = $record['fjr_name'];

                                $wx_arr = array();
                                $wx_arr['xylsh'] = $xylsh;
                                $wx_arr['address'] = '';
                                $wx_arr['cjr_name'] = $fjr_name;
                                $wx_arr['sjr_name'] = $sjr_name;
                                $wx_arr['type'] = '4';
                                $wx_arr['mobile'] = $record['sjr_mobile'];
                                $url = "http://sfytj.njxnet.com/service/send_wx_news.php";
                                $curl = new Http();
                                //$curl->request($url, $wx_arr, 'POST');


                                //调用短信发送给存件人发
                                //$content = "取出通知：您的材料已成功取出。取件人：" . $record['fjr_name'] . "，收件人：" . $sjr_name .
                                //   "，流转编号：" . $xylsh . "，取件时间：" . $qj_time . "，云柜地址：" . $address . '【铉盈网络】';

                                // send_cms_mobile($record['sjr_mobile'], $content);


                                //保存取件日志


                            } else {
                                $result['state'] = 0; //失败
                                $result['info'] = '取件：柜子状态修改失败';
                            }

                        } else {
                            $result['state'] = 0;
                            $result['info'] = '收件人不一致';
                        }
                    } else {
                        $result['state'] = 0;
                        $result['info'] = '该用户没有填写手机号码';
                    }


                } else {
                    $result['state'] = 0;
                    $result['info'] = '该用户未绑定微信信息';
                }


            } else {
                $result['state'] = 0;
                $result['info'] = '该二维码已经取件';
            }
        } else {
            $result['state'] = 0;
            $result['info'] = '该二维码信息有误';
        }
    } else {
        $result['state'] = 0;
        $result['info'] = '缺少有效参数';
    }
}


/*1. 存件*/  else
    if ($operation == 1) {
        if ($file && $open_id && $user_id) {

            //验证openid是否有效
            $yg_wechat = $mysql->select_one('yg_wechat', '*', 'open_id=' . "'$open_id' ");
            if ($yg_wechat) {
                $fjr_mobile = $yg_wechat['mobile'];
                if ($fjr_mobile) {

                    //根据手机号码获取judge获取名字
                    $judge = $mysql->select_one('judge', '*', 'user_phone=' . "'$fjr_mobile'");
                    $sjr_judge = $mysql->select_one('judge', '*', 'id=' . $user_id);

                    $fjr_name = $judge['user_name'];
                    $xylsh = date('Ymd') . str_pad(mt_rand(1, 99999999), 5, '0', STR_PAD_LEFT);
                    //保存材料信息
                    if ($file) {
                        foreach ($file as $_file) {
                            $file_arr = array();
                            $file_arr['xylsh'] = $xylsh;
                            $file_arr['file_num'] = $_file['clh'];
                            $file_arr['file_name'] = isset($_file['cl_name'])?$_file['cl_name']:'';
                            $file_arr['file_page'] = isset($_file['cl_page'])?$_file['cl_page']:'';
                            $list = $mysql->insert("yg_file", $file_arr);
                        }
                    }


                    //生成二维码
                    $info = array();
                    $info['create_time'] = time();
                    $info['date_time'] = date('Ymd', time());
                    $info['state'] = 1;
                    $info['court_id'] = '';
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

                    $state = "success";

                    $cj_time = date('Y-m-d H:i');
                } else {
                    $result['state'] = 0;
                    $result['info'] = '该用户没有填写手机号码';
                }
            } else {
                $result['state'] = 0;
                $result['info'] = '该用户未绑定微信信息';
            }

        }
    } else {
        $result['state'] = 0;
        $result['info'] = '缺少有效参数';
    }

    if ($state == "success") {

        //保存操作记录
        $data = array();
        $data['box_num'] = '';
        $data['xylsh'] = $xylsh;
        $data['type'] = 2;
        $data['operation'] = $operation;
        $data['user_name'] = '';
        $data['operation_time'] = $operation_time;
        if ($operation == 1) {


            $data['fjr_id'] = $judge['id'];
            $data['sjr_id'] = $user_id;
            $data['fjr_name'] = $fjr_name;
            $data['sjr_name'] = $sjr_judge['user_name'];
            $sjr_name = $sjr_judge['user_name'];
            $data['fjr_mobile'] = $fjr_mobile;
            $data['sjr_mobile'] = $sjr_judge['user_phone'];
            $qj_mobile = $data['sjr_mobile'];
            $cj_mobile = $fjr_mobile;


            //print_R($data);exit;
            //微信给取件人发送
            $wx_arr = array();
            $wx_arr['xylsh'] = $xylsh;
            $wx_arr['address'] = '';
            $wx_arr['cjr_name'] = $fjr_name;
            $wx_arr['identifying_code'] = $info['identifying_code'];
            $wx_arr['type'] = '2';
            $wx_arr['mobile'] = $qj_mobile;
            $wx_arr['code_path'] = $ewm_path;
            $url = "http://sfytj.njxnet.com/service/send_wx_news.php";
            $curl = new Http();
            $curl->request($url, $wx_arr, 'POST');
            $address = '';

            //短信给存件人发送内容
            //$content = "存件入柜通知：您的材料已入柜，请尽快在微信中选择收件人并完善材料信息。流转编号：" . $xylsh . "，存件时间：" . $cj_time .
//                "，云柜地址：" . $address . '【铉盈网络】';
//
//            if ($cj_mobile) {
//                send_cms_mobile($cj_mobile, $content);
//            }


            //短信给存件人发送内容
            $content = "取件通知：您的文件材料已到法院云柜，请您及时领取！存件人：" . $fjr_name . "，流转编号：" . $xylsh .
                "，取件码：" . $info['identifying_code'] . "，取件二维码：" . $ewm_path . "，云柜地址：" . $address .
                '【铉盈网络】';
            if ($qj_mobile) {
                send_cms_mobile($qj_mobile, $content);
            }


        } else {
            $data['fjr_id'] = $record['fjr_id'];
            $data['sjr_id'] = $record['sjr_id'];
            $data['fjr_name'] = $record['fjr_name'];
            $data['sjr_name'] = $record['sjr_name'];
            $data['sjr_mobile'] = $record['sjr_mobile'];
            $data['fjr_mobile'] = $record['fjr_mobile'];
        }

        $data['court_id'] = '';
        $data['yg_group_id'] = '';
        $data['identity_name'] = '法官';
        $data['operation_day'] = $operation_day;

        $insert_yg_record = $mysql->insert('yg_record', $data);
        $result['state'] = 1;
    }


echo json_encode($result);

?>