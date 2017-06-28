<?php 
   /** 文书样式
   如果获取到id参数 根据id查到相关记录
   **/
   include('../../common/global.php');
   $result= array();


       $sql = 'select id,title,content,path from ssfw_guide ';
       $list = $mysql->get_all($sql);
       if($list){
         $vo = array();
         foreach($list  as $keys=>$val){
            /** 判断图片是否存在**/
            if($val['path']==''){
                $val['path'] = SSYD_IMG;
            }else{
                $val['path'] = $baseurl.$val['path'];
            }
            $val['content'] = $val['content'];
            $vo[$keys] = $val;
          }
       }

      
      
      $result['data']=$vo;
      $result['state']='1'; //代表成功
      
       
   echo json_encode($result);
   
?>