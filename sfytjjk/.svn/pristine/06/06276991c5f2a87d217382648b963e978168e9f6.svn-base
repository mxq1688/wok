<?php 
   /** 新闻查看
   如果获取到id参数 根据id查到相关记录
   **/
   include('../../../common/global.php');
   $result= array();
   $id = _request('id'); 
   if($id){
       $sql = 'select title,content,create_time,author from ssfw_article where id= '.$id;
       $list = $mysql->get_one($sql);
       if($list){
          $result['data']=$list;
          $result['state']='1'; //代表成功
       }else{
          $result['state']=0;
       }
      
       
   }else{
       $result['state']='0'; //代表成功
   }
   
   
   
   echo json_encode($result);
   
?>