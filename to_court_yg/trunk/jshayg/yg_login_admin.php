<?php
       /*管理员登陆*/ 
       include('../common/global.php');
       $result = array();

       $username = _request('username');
       $password = _request('password');
       $court_id = _request('court_id');     

       if ($username && $password) {
              $sql = "select * from ssfw_yg_user where username='".$username."' and password='".$password."' and court_id=$court_id";
              $list = $mysql -> get_one($sql);
              if ($list) {
                    $result['state'] = 1;  
                    $result['user_id'] = $list['id'];
                    $result['user_name'] = $list['username'];
              } else {
                    $result['state'] = 0;  
                    $result['info'] = '用户名或密码不正确';
              }
       } else {
             $result['state'] = 0;  //代表失败，未传递二维码参数
             $result['info'] = '缺少有效参数';
       }

       echo json_encode($result);
?>