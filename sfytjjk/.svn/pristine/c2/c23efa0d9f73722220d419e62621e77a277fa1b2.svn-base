<?php
/*
 * 1:成功上传
 *-1:文件超过规定大小
 *-2:文件类型不符
 *-3:移动文件出错
 */
include('../../../common/global.php');
$user_id = _request('user_id');
$lian_num = _request('user_token');
$li_type = _request('li_type');
$type_id = _request('type_id');
if($type_id<10){
    $type_id = $li_type;
}

$upfile=$_FILES['inputFile_'.$type_id];
if($upfile){
if(is_uploaded_file($upfile['tmp_name'])){

        $url = "upload/".date("Y")."/".date("m")."/".date("d")."/".$user_id.'/';
        $photo_folder="../../../".$url; //上传照片路径
        ///////////////////////////////////////////////////开始处理上传
		
        if(!file_exists($photo_folder))//检查照片目录是否存在
        {
			
            mkdir($photo_folder, 0777, true);  //mkdir("temp/sub, 0777, true);
        }
        
        //重置文件名
        
        
        $name=$upfile['name'];
        
        
        $name = get_new_cl_name($name,$li_type,$type_id);
        $old_name = $name;
        $name = iconv("UTF-8", "GBK", $name);
        
        $photo_name=$upfile["tmp_name"];
        $state = 0;
        $photo_server_folder = $photo_folder.$name;//这里是上传的完整路径
        //echo $name;exit;
        if(!move_uploaded_file ($photo_name, $photo_server_folder))
		{
		// $state = "0"; //echo "移动文件出错";
		 $result['state'] = 0;	
		}else{
            $ch = curl_init('http://ssfw.jsfy.gov.cn:8038/ytj/app/upload');

            // 创建一个 CURLFile 对象
            $cfile = curl_file_create(realpath($photo_server_folder));

            // 设置 POST 数据
            $climg = array('file' => $cfile);
            curl_setopt($ch, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $climg);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


            // 执行句柄
            $res = curl_exec($ch);
            curl_close($ch);
            $xml = simplexml_load_string($res);
            if(isset($xml->CODE)){
                $data['cl_id'] = $xml->CODE;
            }
    
		  
		  //先要判断该文件是否已经上传，已上传就删除旧的
         
           $data['name'] = $old_name;
           $data['url'] = $url.$old_name;
           $data['create_time'] = time();
           $data['type_id'] = $type_id;
           
           
     
          $sql = 'select id,url from ssfw_material where  type='.$li_type.' and lian_num='."'$lian_num'".' and type_id='.$type_id;
          $list = $mysql->get_one($sql);

          if($list){
              //删除旧的文件
              del_file($list['url']);
              
              $lists = $mysql->update('ssfw_material',$data,'id='.$list['id']);
              if($lists){
                 $result['id']=$list['id']; 
                 $result['state']='1'; //代表成功
              }else{
                 $result['state']='0'; //代表失败
              } 
          }else{
               $data['type'] = $li_type;
               $data['lian_num'] = $lian_num;
               $lists = $mysql->insert('ssfw_material',$data);
               if($lists){
                  $result['id']=$mysql->insert_id(); 
                  $result['state']='1'; //代表成功
               }else{
                 $result['state']='0'; //代表失败
               }
          }
          
		}
               
    }else{
        $result['state']='0'; //代表失败
    }  
  }else{
        $result['state']='0'; //代表失败
  }
       
        echo   json_encode($result);
        
        
        

?>