<?php

include ('./lib/phpqrcode/phpqrcode.php');

function tjaj($case_id, $mysql, $api, $baseytj)
{

    $state = 0;

    $sql = 'select * from ssfw_case_handle where  id=' . $case_id;
    $case_list = $mysql->get_one($sql);
    $list_court = '';
    //取到法院编码
    if ($case_list['court_id']) {
        $sql = 'select name,mobile_contact,court_num,short_name from ssfw_court where  id=' .
            $case_list['court_id'];
        $list_court = $mysql->get_one($sql);
    }

    //取到案由编号
    $list_ay = '';
    if ($case_list['case_action_id']) {
        $sql = 'select name,action_num from ssfw_case_action where id=' . $case_list['case_action_id'];
        $list_ay = $mysql->get_one($sql);
    }


    //取到用户名
    if ($case_list['user_id']) {
        $sql_user = 'select name,identity_num from ssfw_litigation_user where  id=' . $case_list['user_id'];
        $list_user = $mysql->get_one($sql_user);
    }

    $case_num = $case_list['case_num'];
    //原告信息
    $yg_list = array();
    $yg_sql = 'select name,character_type,nation,mobile,address,identity_num,nationality,company_name,sex,zj_type,zj_code from ssfw_case_user where type=1 and case_num = ' .
        "'$case_num' order by id desc";
    $yg_list = $mysql->get_all($yg_sql);


    //被告信息
    $bg_list = array();
    $bg_sql = 'select name,character_type,nation,mobile,address,identity_num,nationality,company_name,sex,zj_type,zj_code from ssfw_case_user where type=2 and case_num = ' .
        "'$case_num' order by id desc";
    $bg_list = $mysql->get_all($bg_sql);

    //print_R($bg_list);exit;
    //第三人信息
    $dsr_list = array();
    $dsr_sql = 'select name,character_type,nation,mobile,address,identity_num,nationality,company_name,sex,zj_type,zj_code from ssfw_case_user where type=3 and case_num = ' .
        "'$case_num' order by id desc";
    $dsr_list = $mysql->get_all($dsr_sql);

    //代理人信息
    $dlr_sql = 'select name,nation,mobile,address,identity_num,nationality,company_name,user_type,zj_type,zj_code,daiid from ssfw_case_user where type=4 and case_num = ' .
        "'$case_num' order by id desc";
    $dl = $mysql->get_all($dlr_sql);
    if (!$dl) {
        $dlr_list = array();
    } else {
        $dlr_list = array();
        foreach ($dl as $key => $val) {
            $dlr_list[$key] = $val;
            if ($val['daiid'] != '') {
                $id = $val['daiid'];
                $sql = 'select name,type from ssfw_case_user where id = ' . "'$id'";
                $list_d = $mysql->get_one($sql);
                if ($list_d) {
                    $dlr_list[$key]['dl_name'] = $list_d['name'];
                    if ($list_d['type'] == 1) {
                        $dlr_list[$key]['ssdw'] = 1;
                    } else
                        if ($list_d['type'] == 2) {
                            $dlr_list[$key]['ssdw'] = 2;
                        }

                } else {
                    $dlr_list[$key]['dl_name'] = '暂无';
                    $dlr_list[$key]['ssdw'] = 0;
                }
            } else {
                $dlr_list[$key]['ssdw'] = 0;
                $dlr_list[$key]['dl_name'] = '暂无';
            }
        }
    }
    // print_R($case_list['case_user_pwd']);exit;

    if ($case_list['is_tdh_suc'] == 0 && $case_list['is_lock'] == 0) {


        //拼出立案需要的数据
        $xml_array = array();
        $xml_array['slfy'] = $list_court['court_num']; //受理法院
        if ($list_ay) {
            $xml_array['sqay'] = $list_ay['action_num']; //申请案由
            $xml_array['ayms'] = $list_ay['name']; //申请案由
        }

        $xml_array['sdfs'] = (2); //送达方式  1 在线送达、2 邮寄送达 默认快递

        if ($list_user) {
            $xml_array['lasq']['xm'] = $list_user['name']; //姓名
            //$xml_array['lasq']['xm'] = 'ceshiaaaa';
            $xml_array['lasq']['sfz'] = $list_user['identity_num']; //身份证
        }

        $xml_array['lasq']['sjhm'] = $case_list['mobile']; //手机号码
        // $xml_array['lasq']['sjhm'] = '15951859324';
        $xml_array['lasq']['lasf'] = $case_list['la_identity']; //立案身份
        $xml_array['lasq']['cxmm'] = $case_list['case_user_pwd']; //查询密码
        $xml_array['lasq']['bdje'] = $case_list['apply_money']; //诉讼标的金额

        $xml_array['ajlx'] = '21';
        if ($case_list['type'] == '民事案件') {
            $xml_array['ajlx'] = '21';
        } else
            if ($case_list['type'] == '执行案件') {
                $xml_array['ajlx'] = '51';
            } else
                if ($case_list['type'] == '行政案件') {
                    $xml_array['ajlx'] = '31';
                }

        $aj_type = 1; //1 代表民事 2 执行 3 行政

        if ($xml_array['ajlx'] == 51) {
            //执行案件时
            $xml_array['lasq']['zxyj'] = $case_list['zxyj']; //执行依据
            $xml_array['lasq']['zxyjwh'] = $case_list['zxyjwh']; //执行依据文号
            $xml_array['lasq']['zxyjdw'] = $case_list['zxyjdw']; //执行依据单位

            $aj_type = 2;

        } else
            if ($xml_array['ajlx'] == 31) {
                $aj_type = 3;
            }


        //当事人信息
        $person = get_dsr_info($yg_list, $bg_list, $dsr_list, $aj_type);

        $xml_array['dsr'] = $person;

        //代理人信息
        $dlr_person = get_dlr_info($dlr_list);

        $xml_array['dlr'] = $dlr_person;

        //获取材料信息
        $list = array();
        if ($case_list['cl_token']) {
            $user_token = $case_list['cl_token'];
            //  $user_token = '35_UERQL6';
            $sql = 'select * from ssfw_material where  lian_num=' . "'$user_token'";
            $list = $mysql->get_all($sql);
        }

        $cai_liao = array();
        if ($list) {
            foreach ($list as $keys => $val) {

                if ($val['type'] != '' && $val['type_id'] != '' && $val['name'] != '') {

                    //上传材料
                    $pathdir = dirname(dirname(__file__));
                    $photo_server_folder = $pathdir . '/' . $val['url'];
                    if (file_exists($photo_server_folder)) {
                        $cl_id = tjcl($photo_server_folder);
                        if ($cl_id) {
                            $cai_liao[$keys] = array();
                            array_push($cai_liao[$keys], get_cl_type_id($val['type'], $val['type_id']));
                            array_push($cai_liao[$keys], $cl_id);
                            array_push($cai_liao[$keys], $val['name']);

                            $mater_data = array();
                            $mater_data['cl_id'] = $cl_id;
                            $lists = $mysql->update('ssfw_material', $mater_data, 'id=' . $val['id']);
                        }
                    }

                }
            }
        }
        
        $lock_state = lock_state($case_id, $mysql);
        if ($lock_state == 0) {
            // print_R($cai_liao);exit;

            //给对应的法院管理员发送一条短信

            $mobile = $list_court['mobile_contact'];
            if ($mobile) {
                $content = $list_user['name'] . '在' . $list_court['name'] .
                    '网上申请立案，请尽快审核。【铉盈网络】';
                //  send_cms_mobile($mobile,$content);
            }


            $xml_str = array_to_xml($xml_array);

            //$xml_new_array = array();
            $cai_str = '<sscl><sy>' . $case_list['litigation_request'] . '</sy>';
            // $cai_liao = array();
            if ($cai_liao) {
                foreach ($cai_liao as $_val) {
                    $cai_str .= '<cl lx=' . "'$_val[0]'" . ' id=' . "'$_val[1]'" . ' mc=' . "'$_val[2]'" .
                        '/>';
                }
            }

            $cai_str .= '</sscl></data>';


            //字符串替换将最后的</data>替换
            $xml_new_str = str_replace("</data>", $cai_str, $xml_str);
            //单引号换成双引号
            $xml_new_str = str_replace("'", '"', $xml_new_str);
            $xml_new_str = urlencode(urlencode($xml_new_str));


            $curl = new Http();

            $url = $api['CaseServlet_Yz'];

            $arr = array(
                'uid' => 'wsla',
                'pass' => 'wsla',
                'xml' => urlencode(urlencode($xml_new_str)),
                );

            $xml = $curl->request($url, $arr, 'POST');

            $new_id = $case_list['id'];
            //echo $xml_new_str;exit;
            //  print_R($xml);
            if (isset($xml)) {
                $xml = simplexml($xml, 'CaseServlet_Yz', 'xxtj.php');
                if (isset($xml->status)) {

                    $status = xml_to_str($xml->status);
                    $code = xml_to_str($xml->msg);

                    if ($status == 'true') {

                        //保存$code
                        $new_data = array();
                        //生成一个二维码

                        $user_id = $case_list['user_id'];

                        //二维码链接
                        $uer_erweima = $baseytj . '/wdaj/ewm.php?cid=' . base64_encode($new_id);
                        $new_data['tdh_case_num'] = $code;
                        $new_data['is_tdh_suc'] = 1;

                        $lists = $mysql->update('ssfw_case_handle', $new_data, 'id=' . $new_id);

                        //保存之类发送短信密码
                        $mobile = $case_list['mobile'];
                        $mobile = 15951859324;

                        $content = '该案件已提交成功，请等待审核，您可以通过查询账号：' . $code . ' ; 密码：' . $case_list['case_user_pwd'] .
                            '; 案件二维码：' . $uer_erweima . '， 查询该案的审核情况【铉盈网络】';

                        //send_cms_mobile($mobile, $content);

                        $state = 1;

                        //删除目录及文件
                        if ($case_list['cl_token']) {
                            $pathdir = dirname(dirname(__file__));
                            $deldir = $pathdir . '/upload/gpy';
                            delDirAndFile($deldir, $case_list['cl_token']);
                        }


                    }
                } else {
                    $new_data['is_handle_suc'] = 1;
                    $lists = $mysql->update('ssfw_case_handle', $new_data, 'id=' . $new_id);
                    $state = 0;
                }
            } else {
                $new_data['is_handle_suc'] = 1;
                $lists = $mysql->update('ssfw_case_handle', $new_data, 'id=' . $new_id);
                $state = 0;
            }
        } else {
            $state = 0;
        }

    } else {
        if($case_id){
            $new_data = array();
            $new_data['is_lock'] = 0;
            $lists = $mysql->update('ssfw_case_handle', $new_data, 'id=' . $case_id);
        
        }
    }

    return $state;
}


function tjcl($url)
{

    $photo_server_folder = $url;
    $ch = curl_init('http://ssfw.jsfy.gov.cn:8038/ytj/app/UploadServlet_Yz');

    // 创建一个 CURLFile 对象
    $cfile = curl_file_create($photo_server_folder);

    //echo $photo_server_folder;exit;
    // 设置 POST 数据
    $climg = array(
        'file' => $cfile,
        'userid' => 'ytj@2016_JSNJtdh',
        'passwd' => 'tdhJSNJ@2016ytj');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $climg);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

    // 执行句柄
    $res = curl_exec($ch);
    curl_close($ch);
    $xml = simplexml($res, 'UploadServlet_Yz', 'tjaj.php');

    $code = '';
    //错误进入
    //   if(curl_errno($ch))
    //    {
    //        return $code;
    //
    //    }

    if (isset($xml->CODE)) {
        $code = $xml->CODE;
    }
    return $code;


}

//获取当事人信息
function get_dsr_info($yg_list_data, $bg_list_data, $dsr_list_data, $aj_type)
{

    $yg_person = array();
    if ($yg_list_data) {


        foreach ($yg_list_data as $key => $val) {

            //自然人
            if ($val['character_type'] == '09_01001-1') {
                $yg_person[$key]['lx'] = $val['character_type'];
                $yg_person[$key]['xm'] = $val['name'];
                $yg_person[$key]['sfz'] = $val['identity_num'];
                $yg_person[$key]['mz'] = $val['nation'];
                $yg_person[$key]['xb'] = $val['sex'];
                $yg_person[$key]['lxdh'] = $val['mobile'];
                $yg_person[$key]['gj'] = $val['nationality'];
                $yg_person[$key]['dz'] = $val['address'];

            } else {
                //非自然人
                $yg_person[$key]['lx'] = $val['character_type'];
                $yg_person[$key]['xm'] = $val['company_name'];
                $yg_person[$key]['fddbr'] = $val['name'];
                $yg_person[$key]['dbrzjzl'] = $val['zj_type'];
                $yg_person[$key]['dbrzjhm'] = $val['zj_code'];
                $yg_person[$key]['lxdh'] = $val['mobile'];
                $yg_person[$key]['dz'] = $val['address'];

            }
            if ($aj_type == 1) {
                $yg_person[$key]['ssdw'] = '09_03207-1';
            } else
                if ($aj_type == 2) {
                    $yg_person[$key]['ssdw'] = '09_06205-1';
                } else {
                    $yg_person[$key]['ssdw'] = '09_04210-1';
                }
        }
    }

    $bg_person = array();
    if ($bg_list_data) {

        foreach ($bg_list_data as $key => $val) {

            //自然人
            if ($val['character_type'] == '09_01001-1') {
                $bg_person[$key]['lx'] = $val['character_type'];
                $bg_person[$key]['xm'] = $val['name'];
                $bg_person[$key]['sfz'] = $val['identity_num'];
                $bg_person[$key]['mz'] = $val['nation'];
                $bg_person[$key]['xb'] = $val['sex'];
                $bg_person[$key]['lxdh'] = $val['mobile'];
                $bg_person[$key]['gj'] = $val['nationality'];
                $bg_person[$key]['dz'] = $val['address'];
            } else {
                //非自然人
                $bg_person[$key]['lx'] = $val['character_type'];
                $bg_person[$key]['xm'] = $val['company_name'];
                $bg_person[$key]['fddbr'] = $val['name'];
                $bg_person[$key]['dbrzjzl'] = $val['zj_type'];
                $bg_person[$key]['dbrzjhm'] = $val['zj_code'];
                $bg_person[$key]['lxdh'] = $val['mobile'];
                $bg_person[$key]['dz'] = $val['address'];

            }

            if ($aj_type == 1) {
                $bg_person[$key]['ssdw'] = '09_03207-2';
            } else
                if ($aj_type == 2) {
                    $bg_person[$key]['ssdw'] = '09_06205-2';
                } else {
                    $bg_person[$key]['ssdw'] = '09_04210-2';
                }
        }
    }

    $dsr_person = array();
    if ($dsr_list_data) {

        foreach ($dsr_list_data as $key => $val) {

            //自然人
            if ($val['character_type'] == '09_01001-1') {
                $dsr_person[$key]['lx'] = $val['character_type'];
                $dsr_person[$key]['xm'] = $val['name'];
                $dsr_person[$key]['sfz'] = $val['identity_num'];
                $dsr_person[$key]['mz'] = $val['nation'];
                $dsr_person[$key]['xb'] = $val['sex'];
                $dsr_person[$key]['lxdh'] = $val['mobile'];
                $dsr_person[$key]['gj'] = $val['nationality'];
                $dsr_person[$key]['dz'] = $val['address'];

            } else {
                //非自然人
                $dsr_person[$key]['lx'] = $val['character_type'];
                $dsr_person[$key]['xm'] = $val['company_name'];
                $dsr_person[$key]['fddbr'] = $val['name'];
                $dsr_person[$key]['dbrzjzl'] = $val['zj_type'];
                $dsr_person[$key]['dbrzjhm'] = $val['zj_code'];
                $dsr_person[$key]['lxdh'] = $val['mobile'];
                $dsr_person[$key]['dz'] = $val['address'];

            }

            if ($aj_type == 1) {
                $dsr_person[$key]['ssdw'] = '09_03207-3';
            } else
                if ($aj_type == 2) {
                    $dsr_person[$key]['ssdw'] = '09_06205-2';
                } else {
                    $dsr_person[$key]['ssdw'] = '09_04210-3';
                }

        }
    }

    $list = array_merge($bg_person, $dsr_person, $yg_person);
    $new_list = array();
    if ($list) {
        foreach ($list as $key => $val) {
            $val['xh'] = $key;
            $new_list[$key] = $val;
        }
    }
    //需要将key换成person
    return $new_list;

}

function get_dlr_info($dlr_list)
{

    $yg_person = array();
    if ($dlr_list) {

        foreach ($dlr_list as $key => $val) {

            //自然人
            $yg_person[$key]['lx'] = get_dlr_lx($val['user_type']); //'09_03207-1'; //原告
            $yg_person[$key]['dldsr'] = $val['dl_name'];
            $yg_person[$key]['xm'] = $val['name'];
            $yg_person[$key]['dw'] = $val['company_name'];
            $yg_person[$key]['lxdh'] = $val['mobile'];
            $yg_person[$key]['zjzl'] = $val['zj_type'];
            $yg_person[$key]['zjhm'] = $val['zj_code'];
            $yg_person[$key]['dz'] = $val['address'];

        }
    }

    $bg_person = array();

    $list = array_merge($yg_person, $bg_person);
    $new_list = array();
    if ($list) {
        foreach ($list as $key => $val) {
            $val['xh'] = $key;
            $new_list[$key] = $val;
        }
    }
    return $new_list;

}

function get_dlr_lx($val)
{
    $lx = '';
    switch ($val) {
        case '律师':
            $lx = '09_01010-1';
            break;
        case '承担法律援助的律师':
            $lx = '09_01010-2';
            break;
        case '监护人':
            $lx = '09_01010-3';
            break;
        case '亲友':
            $lx = '09_01010-4';
            break;
        case '人民团体推荐的人':
            $lx = '09_01010-5';
            break;
        case '所在单位推荐的人':
            $lx = '09_01010-6';
            break;
        case '法院许可的其他公民':
            $lx = '09_01010-7';
            break;
        case '法律工作者':
            $lx = '09_01010-8';
            break;
    }
    return $lx;
}




?>