<?php 
   /** 图片新闻
    type 1 法院要闻
    type 2 新闻风采
    type 3 文字新闻
    type 4 图片新闻 
    type 5 法官风采
    type 6 法官之家
   
   **/
   include('../../../common/global.php');
   $result= array();
   $court_id = _request('court_id'); 
   $type = _request('type'); 
   $court_id = get_court_id($court_id,$mysql);
   if($court_id){
      $sql = 'select id,title,content,create_time,path from ssfw_article where court_id='.$court_id.' and cid='.$type;
      $list = $mysql->get_all($sql);
      $vo = array();
      foreach($list  as $keys=>$val){
            
            /** 判断图片是否存在不存在给一个默认值**/
            if($val['path']==''){
                $val['path'] = COUET_ROOM_IMG;
               
            }else{
                $val['path'] = $baseurl.$val['path'];
            }
            $val['create_time'] = date('m-d',$val['create_time']);
            $vo[$keys] = $val;
            
        }
      $result['data']=$vo;
      $result['state']='1'; //代表成功
      
   }else{
      $result['state']='0'; //代表失败
   }
   
   echo json_encode($result);
   
?>