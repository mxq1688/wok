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
$file_id = _request('file_id');
$file_type = _request('file_type');
$kxcl_type = _request('kxcl_type');
$dir_type = _request('dir_type');

if($user_id && $lian_num&&$dir_type){
    $state = 0;

    $file_array = array();
    $list = array();
    
    if($file_type=='bxcl'){
       $dir = '../../../upload/gpy/'.$lian_num.'/'.$dir_type;
    }else{
       $dir = '../../../upload/gpy/'.$lian_num.'/'.$file_id.'/'.$dir_type;
    }

    
    if (is_dir($dir)){
        if ($dh = opendir($dir)){
            while (($file = readdir($dh))!= false){
                if(($file!='.')&&($file!='..')){
                	//文件名的全路径 包含文件名
                //	$filePath = 'upload/gpy/'.$user_id.'/'.$dir_type.'/'.$file;
                    $file_array[] = $file;
                }
                
            }
            closedir($dh);
        }else{
            $result['state']='0';
        }
    }else{
        $result['state']='0';
    }
    
    
        
    if($file_type=='bxcl'){
       $new_file_array = get_gpy_new_cl_name($file_type,$file_id,$file_array,$mysql,$lian_num);
    }else{
       $new_file_array = get_gpy_new_cl_name($file_type,$kxcl_type,$file_array,$mysql,$lian_num); 
    }

   
    if($new_file_array){
        
        foreach($new_file_array as $key=>$val){
    
            $name = iconv( "UTF-8","GBK",$val['old_name']);
            
            if($file_type=='bxcl'){
               $photo_folder = 'upload/gpy/'.$lian_num.'/'.$dir_type.'/';
    
            }else{
                $photo_folder = 'upload/gpy/'.$lian_num.'/'.$file_id.'/'.$dir_type.'/';
            }
            
           $photo_server_folder = '../../../'.$photo_folder.$name;//这里是上传的完整路径
    
    	  //先要判断该文件是否已经上传，已上传就删除旧的
          
           $photo_server_folder = '';
        
           $data['name'] = $val['new_name'];
           $data['url'] = $photo_folder.$name;
           $data['create_time'] = time();

            if($file_type=='bxcl'){
               $data['type'] = $file_id;
            }else{
               $data['type'] = $kxcl_type;
              
            }
            
           $data['type_id'] = $file_type;  
           $data['lian_num'] = $lian_num;
        //   print_R($data);
           $lists = $mysql->insert('ssfw_material',$data);
          
          //删除图片 
           //$del=unlink($photo_server_folder);
           
           if($lists){
              $list[$key]['id'] = $mysql->insert_id(); 
              $list[$key]['filename'] = $val['new_name']; 
              
              $state='1'; //代表成功
           }else{
              $state='0'; //代表失败
           }
        }
    }
        
       // $deldir2 = '../../../upload/gpy';
         //删除目录及图片
       // $pathdir = dirname(dirname(dirname(dirname(__FILE__))));
       // $deldir = $pathdir.'/upload/gpy';
       // delDirAndFile($deldir,$lian_num);
        
    
        $result = array();
		$result['data'] = $list;
        $result['state'] = $state;
               
   }else {
    
    $result['state']='0';
    }
    
    echo   json_encode($result);
        
  

?>