<?php 
   /** 法律法规首页
    cid ，就显示子类的信息
    id 查看具体的法律法规
   **/
   include('../../common/global.php');
   $result= array();
   $cid = _request('cid'); 
   $id = _request('id');
    /** 搜索关键字**/
   $keys = _request('keys'); 
   if(!$id){
       if($cid){
          $sql = 'select id,title,content,create_time,state,morelink from ssfw_laws  where cid='.$cid;
          
       }else{
          $sql = 'select id,title,content,create_time,state,morelink from ssfw_laws where cid=0 ';
       }
       
       if($keys){
             /** 将关键词的引号去掉**/
             $keys = del_yinhao($keys);
             $sql.=" and title like '%$keys%'";
       }
       
       /** 读取10条 根据需要可以改***/
       $sql .= 'limit 0,10';
       
       $list = $mysql->get_all($sql);
       $vo = array();
       foreach($list  as $keys=>$val){
            $val['create_time'] = date('Y/m/d',$val['create_time']);
            $val['title'] = sub_str($val['title'],30);
            $vo[$keys] = $val; 
        }
        
      $result['data']=$vo;
   }else{
       
       $sql = 'select title,content from ssfw_laws  where id='.$id;
       $list = $mysql->get_one($sql);
       $result['data']=$list;
   }
   
   
   $result['state']='1'; //代表成功
      

   echo json_encode($result);
   
?>