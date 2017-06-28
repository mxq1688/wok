<?php 
   /** 文书样式
   如果获取到id参数 根据id查到相关记录
   **/
   include('../../common/global.php');
   $result= array();
   $keys = _request('keys'); 
   $id = _request('id'); 
   if($id){
       $sql = 'select title,content from ssfw_doc where id= '.$id;
       $list = $mysql->get_one($sql);
       if($list){
          $result['data']=$list;
          $result['state']='1'; //代表成功
       }else{
          $result['state']=0;
       }
      
       
   }else{
       $sql = 'select id,title,create_time from ssfw_doc ';
       
       if($keys){
         /** 将关键词的引号去掉**/
         $keys = del_yinhao($keys);
         $sql.=" where title like '%$keys%'";
       }
       
       $list = $mysql->get_all($sql);
       $vo = array();
       foreach($list  as $keys=>$val){
            $val['create_time'] = date('Y/m/d',$val['create_time']);
            $vo[$keys] = $val; 
        }
        
       $result['data']=$vo;
       $result['state']='1'; //代表成功
   }
   
   
   
   echo json_encode($result);
   
?>