<?php
/*存件取件改件操作*/

include ('../common/global.php');
include ('../common/lib/phpqrcode/phpqrcode.php');


$result = array();
$box_num = _request('box_num');
$operation = _request('operation');
$user_name = @_request('user_name');
$operation_time = time();
$operation_day = date("m", $operation_time) . '.' . date("d", $operation_time);
$court_id = _request('court_id');
$xylsh = _request('xylsh');
$qr_code_id = _request('qr_code_id');
$yg_group_id = _request('yg_group_id');
$yg_box_id = _request('yg_box_id');

$file = _request('file');
$file = object_array(json_decode($file));

//获取地址
$yg_group = $mysql->select_one('yg_group', '*', 'id=' . $yg_group_id);
$address = $yg_group['address'];

if ($box_num && $operation) {

    /*1. 存件*/
    if ($operation == 1) {
        
        //修改云柜信息
        $arr = array();
        $arr['xylsh'] = $xylsh;
        $arr['state'] = 2;
        $where = "number='$box_num' and group_id='".$yg_group_id."' and court_id='".$court_id."'";
        $list = $mysql->update('yg_box',$arr,$where);
        //保存材料信息
        if($file){
            foreach($file as $_file){
                $file_arr = array();
                $file_arr['xylsh'] = $xylsh;
                $file_arr['file_num'] = $_file['file_num'];
                $file_arr['box_num'] = $box_num;
               // $file_arr['file_name'] = $_file['file_name'];
               // $file_arr['file_page'] = $_file['page_num'];
                $file_arr['yg_group_id'] = $yg_group_id;
                $list = $mysql->insert("yg_file", $file_arr); 
                
                $lsh = $_file['file_num'];
                //修改对应的材料号的流水号
                $data_info = array();
                $data_info['xylsh'] = $xylsh;
                $res_cj_info = $mysql->update('yg_cj_info', $data_info, 'fwlsh=' . "'$lsh'");
            }
        }
        
        
        
        //生成二维码
        $info = array();
        $info['create_time'] = time();
        $info['date_time']   = date('Ymd', time());
        $info['state'] = 1;
        $info['court_id'] = $court_id;
        $info['yg_box_id'] = $yg_box_id;
        $info['xylsh'] = $xylsh;
        $info['identifying_code'] = rand(100000,999999);
        //随机码
        $info['randomid'] = generate_password();
        $sql              = "select max(id) from qr_code";
        $max_id           = $mysql->get_max_value($sql);
        $id               = intval($max_id) + 1;
        //验证码=md5(id+随机码)
        $info['validid'] = md5($id . $info['randomid']);
        
        //生成二维码图片
        $info['path'] = 'upload/erweima/jh/' . $info['validid'] . '_erweima.png';
        $filename     = '../upload/erweima/jh/' . $info['validid'] . '_erweima.png';
        QRcode::png($info['validid'], $filename, 1, 4, 1, false);
        $ewm_path = $baseytj.'/'.$info['path'];
        $list = $mysql->insert("qr_code", $info);
      
        $state = "success";
        
        $cj_time = date('Y-m-d H:i');
        

        /*2.取件*/
    } else
        if ($operation == 2) {

            //将云柜信息表（关联通达海）
            //$ewm_arr = array();
            //          $data_info = array();
            //          $data_info['is_show'] = 2;
            //            $mysql->update('ssfw_yg_cj_info', $data_info, 'id=' . $ewmid);

            //修改云柜使用状态
            $data_info = array();
            $data_info['xylsh'] = '';
            $data_info['state'] = '1';
            
            $res_box = $mysql->update('yg_box', $data_info, 'xylsh=' . "'$xylsh'");

            //修改二维码表信息
            $data_info = array();
            $data_info['state'] = '0';
            $res_qr_code = $mysql->update('qr_code', $data_info, 'id=' . $qr_code_id);

            if ($res_box && $res_qr_code) {

                $state = "success";
                //查到收件人
                $yg_cj = $mysql->select_one('yg_cj_info', '*', 'xylsh=' . "'$xylsh'" .
                    " and court_id=$court_id");
                $qjr = '';
                $lsh = '';
                if ($yg_cj) {
                    $lsh = $yg_cj['fwlsh'];
                    $qjr = $yg_cj['sjr'];
                }
                
/*

                //通知通达海完成取件
                $client = new SoapClient("http://172.103.91.200:8081/clgl/ws/CloudBoxGet?wsdl");

                //通知存件人存件已被取走
                $uid = base64_encode("clgl");
                $pass = base64_encode("clglsa");
                $time = date("Y-m-d H:i:s", time());
                $xml = '<?xml version="1.0" encoding="UTF-8"?> <case>
                                <qjr>' . base64_encode($qjr) . '</qjr>
                                <qjsj>' . base64_encode($time) . '</qjsj>
                                <fwlshlist>
                                <fwlsh lsh="' . base64_encode($lsh) . '" zjcs="' .
                    base64_encode(1) . '"/>
                                </fwlshlist>
                            </case>';
                $curl_post_arr_qjxx = array(
                    'uid' => $uid,
                    'pass' => $pass,
                    'xml' => $xml);
                $response = $client->CloudBoxGet($curl_post_arr_qjxx);
                
*/
                //获取短信通知需要的信息
                $record = $mysql->select_one('yg_record', '*', 'xylsh=' . "'$xylsh'" .
                    " and court_id=$court_id order by id desc");
                $sjr_name = $record['sjr_name'];
                $fjr_name = $record['fjr_name'];
                $qj_time = date('Y-m-d H:i');
                
               //print_R($record);exit; 
                //调用微信发送 发送给存件人发
                
                //todo 微信地址需要更改
                $wx_arr = array();
                $wx_arr['sjr_name'] = $sjr_name;
                $wx_arr['xylsh'] = $xylsh;
                $wx_arr['address'] = $address;
                $wx_arr['type'] = '3';
                $wx_arr['mobile'] = $record['fjr_mobile'];
                $url = "http://sfytj.njxnet.com/service/send_wx_news.php";
                $curl = new Http();
                $curl->request($url,$wx_arr,'POST');

                //调用短信发送给存件人发
                $content = "存件出柜通知：您的材料已被收件人取出。收件人：".$sjr_name."，流转编号：".$xylsh."，取件时间：".$qj_time."，云柜地址：".$address.'【铉盈网络】';
                send_cms_mobile($record['fjr_mobile'],$content);
                
                
                //调用微信发送 给取件人发送通知(第一个取件人))
                
                $record = $mysql->select_one('yg_record', '*', 'xylsh=' . "'$xylsh'" .
                    " and court_id=$court_id and operation=1");
                $sjr_name = $record['sjr_name'];
                $fjr_name = $record['fjr_name'];
                
                $wx_arr = array();
                $wx_arr['xylsh'] = $xylsh;
                $wx_arr['address'] = $address;
                $wx_arr['cjr_name'] = $fjr_name;
                $wx_arr['sjr_name'] = $sjr_name;
                $wx_arr['type'] = '4';
                $wx_arr['mobile'] = $record['sjr_mobile'];
                $url = "http://sfytj.njxnet.com/service/send_wx_news.php";
                $curl = new Http();
                $curl->request($url,$wx_arr,'POST');
                
                
                //调用短信发送给存件人发
                $content = "取出通知：您的材料已成功取出。取件人：".$record['fjr_name']."，收件人：".$sjr_name."，流转编号：".$xylsh."，取件时间：".$qj_time."，云柜地址：".$address.'【铉盈网络】';
                send_cms_mobile($record['sjr_mobile'],$content);

            } else {
                $result['state'] = 0; //失败
                $result['info'] = '取件：柜子状态修改失败';
            }


        }

    if ($state == "success") {

        //保存操作记录
        $data = array();
        $data['box_num'] = $box_num;
        $data['xylsh'] = $xylsh;
        $data['operation'] = $operation;
        $data['user_name'] = $user_name;
        $data['operation_time'] = $operation_time;
        if ($operation == 1) {
            
            if($file){
                
                $fwlsh = $file[0]['file_num'];
                $cj_info = $mysql->select_one('yg_cj_info', '*', 'fwlsh=' . "'$fwlsh'" .
                    " and court_id=$court_id");
                $cj_mobile = '';
                $qj_mobile = '';
                if($cj_info){
                    $data['fjr_id'] = $cj_info['fjr_id'];
                    $data['sjr_id'] = $cj_info['sjr_id'];
                    $data['fjr_name'] = $cj_info['slr_name'];
                    $data['sjr_name'] = $cj_info['sjr_name'];
                    $fjr_name = $data['fjr_name'];
                    $sjr_name = $data['sjr_name'];
                    
                    //取到对应的手机号码
                    $cj_info_mobile = $mysql->select_one('judge', 'user_phone', 'id=' . $cj_info['fjr_id']);
                    $data['fjr_mobile'] = $cj_info_mobile['user_phone'];
                    $cj_mobile = $data['fjr_mobile'];
                    
                    $cj_info_mobile = $mysql->select_one('judge', 'user_phone', 'id=' . $cj_info['sjr_id']);
                    $data['sjr_mobile'] = $cj_info_mobile['user_phone'];
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
                    $curl->request($url,$wx_arr,'POST');
                    
                    //短信给存件人发送内容
                     $content = "存件入柜通知：您的材料已入柜，请尽快在微信中选择收件人并完善材料信息。流转编号：".$xylsh."，存件时间：".$cj_time."，云柜地址：".$address.'【铉盈网络】';
            
                     if($cj_mobile){
                       send_cms_mobile($cj_mobile,$content);
                     }
                     
                     
                     //短信给存件人发送内容
                     $content = "取件通知：您的文件材料已到法院云柜，请您及时领取！存件人：".$cj_info['slr_name']."，流转编号：".$xylsh."，取件码：".$info['validid']."，取件二维码：".$ewm_path."，云柜地址：".$address.'【铉盈网络】';
                     if($qj_mobile){
                        send_cms_mobile($qj_mobile,$content);
                     }
                }
            }
            
            //print_R($qj_mobile);exit;

                    
                    
                    
                    //微信给收件人发送
                    //$wx_arr = array();
            //        $wx_arr['sjr_name'] = $sjr_name;
            //        $wx_arr['code'] = $validid;
            //        $wx_arr['address'] = $address;
            //        $wx_arr['xylsh'] = $xylsh; 
            //        $wx_arr['qj_code'] = $qj_code;
            //        $wx_arr['type'] = 'cj_sjr';
            //        $url = "http://sfytj.njxnet.com/service/send_wx_news.php";
            //        $curl = new Http();
                  //  $curl->request($url,$wx_arr,'POST');
                  
                   
                     
                     
            
        }else{
            $data['fjr_id'] = $record['fjr_id'];
            $data['sjr_id'] = $record['sjr_id'];
            $data['fjr_name'] = $record['fjr_name'];
            $data['sjr_name'] = $record['sjr_name'];
            $data['sjr_mobile'] = $record['sjr_mobile'];
            $data['fjr_mobile'] = $record['fjr_mobile'];
        }
         
        $data['court_id'] = $court_id;
        $data['yg_group_id'] = $yg_group_id;
        $data['identity_name'] = '法官';
        $data['operation_day'] = $operation_day;
        
        $insert_yg_record = $mysql->insert('yg_record', $data);
        $result['state'] = 1;
    }
} else {
    $result['state'] = 0;
    $result['info'] = '缺少有效参数';
}

echo json_encode($result);

?>