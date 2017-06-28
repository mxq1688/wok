<?php
/*
* 1:成功上传
*-1:文件超过规定大小
*-2:文件类型不符
*-3:移动文件出错
*/
include ('../../../common/global.php');
$user_id = _request('user_id');
$lian_num = _request('user_token');
$file_index = _request('file_index');
$file_id = _request('file_id');
$file_type = _request('file_type');
$kxcl_type = _request('kxcl_type');

$upfile = $_FILES['inputFile_' . $file_type . '_' . $file_id . '_' . $file_index];

if ($upfile) {
    if (is_uploaded_file($upfile['tmp_name'])) {

        $url = "upload/" . date("Y") . "/" . date("m") . "/" . date("d") . "/" . $user_id .
            '/';
        $photo_folder = "../../../" . $url; //上传照片路径
        ///////////////////////////////////////////////////开始处理上传
        if (!file_exists($photo_folder)) //检查照片目录是否存在
            {
            mkdir($photo_folder, 0777, true); //mkdir("temp/sub, 0777, true);
        }

        //重置文件名


        $name = $upfile['name'];
        
        $old_name = $name;
        
        if ($file_type == 'bxcl') {
            $name = get_new_cl_name($name, $file_type, $file_id, $file_index);
        } else {
            $name = get_new_cl_name($name, $file_type, $kxcl_type, $file_index);
        }
        
        
       // $name = iconv("UTF-8", "GBK", $name);
        $photo_name = $upfile["tmp_name"];
        $state = 0;
        $photo_server_folder = $photo_folder . $old_name; //这里是上传的完整路径
 //echo $photo_server_folder;exit;
        if (!move_uploaded_file($photo_name, $photo_server_folder)) {
            $result['state'] = 0;
        } else {
            //$ch = curl_init('http://ssfw.jsfy.gov.cn:8038/ytj/app/UploadServlet_Yz');
            //
            //            // 创建一个 CURLFile 对象
            //            $cfile = curl_file_create(realpath($photo_server_folder));
            //            //echo $photo_server_folder;exit;
            //            // 设置 POST 数据
            //           // $climg = array('file' => $cfile);
            //            $climg = array('file' => $cfile,'userid'=>'ytj@2016_JSNJtdh','passwd'=>'tdhJSNJ@2016ytj');
            //            curl_setopt($ch, CURLOPT_POST,1);
            //            curl_setopt($ch, CURLOPT_POSTFIELDS, $climg);
            //            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //
            //            $data = array();
            //            // 执行句柄
            //            $res = curl_exec($ch);
            //            curl_close($ch);
            //           // $xml = simplexml($res);
            //            $xml = simplexml($res,'UploadServlet_Yz','tjcl.php');
            //           // $xml = simplexml_load_string($res);
            //
            //            if(isset($xml->CODE)){
            //                $data['cl_id'] = $xml->CODE;
            //            }


            $data['name'] = $name;
            $data['url'] = $url . $old_name;
            $data['create_time'] = time();
            // $data['type_id'] = $type_id;


            //  $sql = 'select id,url from ssfw_material where  type='.$file_id.' and lian_num='."'$lian_num'".' and type_id='.$type_id;
            //  $list = $mysql->get_one($sql);

            //  if($list){
            //删除旧的文件
            // del_file($list['url']);

            //              $lists = $mysql->update('ssfw_material',$data,'id='.$list['id']);
            //              if($lists){
            //                 $result['id']=$list['id'];
            //                 $result['state']='1'; //代表成功
            //              }else{
            //                 $result['state']='0'; //代表失败
            //              }
            //   }else{
            if ($file_type == 'bxcl') {
                $data['type'] = $file_id;
            } else {
                $data['type'] = $kxcl_type;

            }

            $data['type_id'] = $file_type;
            $data['lian_num'] = $lian_num;
            $lists = $mysql->insert('ssfw_material', $data);
            if ($lists) {
                $result['id'] = $mysql->insert_id();
                $result['state'] = '1'; //代表成功
            } else {
                $result['state'] = '0'; //代表失败
            }
            //   }

        }

    } else {
        $result['state'] = '0'; //代表失败
    }
} else {
    $result['state'] = '0'; //代表失败
}

echo json_encode($result);




?>