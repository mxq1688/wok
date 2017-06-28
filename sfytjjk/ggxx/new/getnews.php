<?php 
   /** 获取新闻咨询**/
   include('../../common/global.php');
   $result= array();
   $court_id = _request('court_id'); 
   
   if($court_id){
      $sql = 'select id,ip from ssfw_court where  court_num='.$court_id;
      $list_court = $mysql->get_one($sql);
      if($list_court){
        $sql = 'select id from ssfw_product where  court_id='.$list_court['id'];
        $list_state = $mysql->get_one($sql);
        if(!$list_state){
            $court_id = 320000;
        }
      }else{
        $court_id = 320000;
      }
    
   }else{
      $court_id = 320000;
   }

   if($court_id){
      //通过法院编号找到对应的id
      $sql_court = "select * from ssfw_court where court_num=".$court_id;
      
      $list_court = $mysql->get_one($sql_court);
      if($list_court){
        $id = $list_court['id'];
      }else{
        $id = '58';
      }
      $sql = "select * from ssfw_article  where court_id=".$id.' order by id desc limit 0,6 ';
      
      $list = $mysql->get_all($sql);
      $vo = array();
      if($list){
        
        foreach($list  as $keys=>$val){
            
            //判断图片是否存在,没有就取默认图片
            if($val['path']==''){
                $val['path'] = COUET_ARTICLE_IMG;
            }else{  
                if($val['court_id']==166||$val['court_id']==59||$val['court_id']==58){
                    if($val['cid']!=3){
						if($list_court['ip']!=''){
							$val['path'] = $list_court['ip'].$val['path'];
						}else{
						    $val['path'] = $baseurl.$val['path'];
						}
                        
                    }
                }else{
                       if($list_court['ip']!=''){
							$val['path'] = $list_court['ip'].$val['path'];
						}else{
						    $val['path'] = $baseurl.$val['path'];
						}
                }
                
               
            }
            $val['month'] = date("m",$val['create_time']);
            $val['year'] = date("Y",$val['create_time']);
            $val['day'] = date("d",$val['create_time']);
            
            //根据id获取法院的名称
            
            if($list_court){
                $val['court_name'] = $list_court['name'];
            }else{
                $val['court_name'] = '未知';
            }
            
            //判断编辑人是否添加
            if($val['author']==''){
                $val['author'] = '未知';
            }
            
            //截取文章内容
            $val['content'] = sub_str($val['content'],400);
            
            $vo[$keys] = $val;
            
        }
        
      }
        $result['data']=$vo;
        $result['state']='1'; //代表成功
   }else{
      $result['state']='0'; //代表失败
   }
   echo json_encode($result);
   
?>