<?php 
  
   /** 定义数据库类路径变量**/
   $com_contact = dirname(__FILE__);
   define("COM_CONTACT", $com_contact.'/contact.php');
   
   define("CONFIG", $com_contact.'/config.php');
   
    /** 设置时区**/
   ini_set('date.timezone','Asia/Shanghai'); 
   
   /** 定义数据库配置路径变量**/
   $com_contact = dirname(__FILE__);
   define("COM_CONFIG", $com_contact.'/config.php');
   
   $ip = '139.224.26.151';
   
   $baseurl = 'http://'.$ip.'/testssfw';
   
   $baseytj = 'http://'.$ip.'/sfytjjk';

   include(COM_CONTACT);
   
   include(CONFIG);
   
   /** 引用curl类 **/
   include('curl.class.php');

   include($com_contact.'/log4php/foo.class.php');
   
   /** 允许所有访问 ajax跨域   **/
   header("Access-Control-Allow-Origin:*"); 
   
   /** application/json是更通用且符合标准的****/
   header('Content-type: application/json');
   
   /** 定义法庭封面默认图片路径变量**/
   $court_room_img = 'http://'.$ip.'/ssfw/Uploads/moren/fating.jpg';
   define("COUET_ROOM_IMG", $court_room_img);
   
   /** 默认头像的链接**/
   $avatar_img = 'http://'.$ip.'/ssfw/Uploads/moren/avator.jpg';
   define("AVATOR_IMG", $avatar_img);
   
   /** 诉讼引导默认的图片链接**/
   $ssyd_img = 'http://'.$ip.'/ssfw/Uploads/moren/ssyd.png';
   define("SSYD_IMG", $ssyd_img);
   
   
    /** 定义法庭分布默认图片路径变量**/
   $court_room_img = 'http://'.$ip.'/ssfw/Uploads/moren/fating.jpg';
   define("COUET_ROOM_ADDRESS_IMG", $court_room_img);
  
  /** 定义法院默认图片**/
   $court_img = 'http://'.$ip.'/ssfw/Uploads/moren/fayuan.png';
   define("COUET_IMG", $court_img);
     
    /** 定义法新闻封面路径变量**/
   $court_article_img = 'http://'.$ip.'/ssfw/Uploads/moren/article.jpg';
   define("COUET_ARTICLE_IMG", $court_room_img);
   
   /** 设置报错级别**/
   //ini_set("error_reporting","E_ALL & ~E_NOTICE");
   
   
   /** 报错*****/
   error_reporting(0);
   set_error_handler('errorHandler');
   register_shutdown_function('fatalErrorHandler');
   
   
   //验证接口
   
  // $pid = isset($_GET['pid'])?$_GET['pid']:0;
//   $ip = isset($_GET['ip'])?$_GET['ip']:0;
//   if(!$pid || !$ip){
//      echo '接口出错';exit;
//   }
  
    /** 判断一个变量**/
    function _request($str){
      $val = !empty($_REQUEST[$str]) ? $_REQUEST[$str] : null;
      $val = strFilter($val);
      return trim($val);
    }
    
    /**解析xml不对的话就返回接口出错的
    $type true  直接返回报错 false  过滤
    **/
    function simplexml($xml,$api_name='',$filename='',$type=true){
        
        $foo = new Foo();
        if(strstr($xml,'version')){
            if(strstr($xml,'5pyN5Yqh5Zmo5YaF6YOo6ZSZ6K+vTnVsbFBvaW50ZXJFeGNlcHRpb24=')){
                return '';
            }else{
                $xml = simplexml_load_string($xml);
                return $xml;
            }
            
         }else{
            if($xml){
                
                if($type){
                    $ip = getIP();
                    $foo->info("[$ip][$filename]中[$api_name]接口出错[$xml]");
                    return '接口出错';
                }else{
                    return '';
                }
            }else{
               
                if($type){
                    $ip = getIP();
                    $foo->info("[$ip][$filename]中[$api_name]接口超时");
                    return '接口超时';
                }
            }
            
         }      
    }


//过滤特殊字符串    
function strFilter($str){
    
    $str = str_replace('&', '', $str);
    $str = str_replace('<', '', $str);
    $str = str_replace('>', '', $str);

    return $str;
}
       
       
    
    
  //  /** 判断是否是一个图片文件**/
//        
//    function isfile($url){
//        if( file_exists($url) && is_file( $url ) ){
//            return 1;
//        }else{
//            return 0;
//        }
//    }

   //判断是否有这个法官id
   function get_court_id($court_id,$mysql){
    
       if($court_id){
          $sql = 'select id from ssfw_product where court_id='.$court_id;
          $list_state = $mysql->get_one($sql);
          if(!$list_state){
            $court_id = 58;
          }
       }else{
          $court_id = 58;
       }
      return $court_id;
   }
    
    
    /** 数组转为tree***/
    function list_to_tree($list, $root = 0, $pk = 'id', $pid = 'pid', $child = 'items') {
    	// 创建Tree
    	$tree = array();
    	if (is_array($list)) {
    		// 创建基于主键的数组引用
    	 
    		$refer = array();
    		foreach ($list as $key => $data) {
    			$refer[$data[$pk]] = &$list[$key];
    		}
    		foreach ($list as $key => $data) {
    			// 判断是否存在parent
    			$parentId = 0;
    			if (isset($data[$pid])) {
    				$parentId = $data[$pid];
    			}
    			if ((string)$root == $parentId) {
    				$tree[] = &$list[$key];
    			} else {
    				if (isset($refer[$parentId])) {
    					$parent = &$refer[$parentId];
    					$parent[$child][] = &$list[$key];
    				}
    			}
    		}
    	}
    
    	return $tree;
    }
    
    /** 案由数组转为tree***/
    function list_to_treeanyou($list, $root = 0, $pk = 'action_num', $pid = 'pid', $child = 'children') {
    	// 创建Tree
    	$tree = array();
    	if (is_array($list)) {
    		// 创建基于主键的数组引用
    	 
    		$refer = array();
    		foreach ($list as $key => $data) {
    			$refer[$data[$pk]] = &$list[$key];
    		}
    		foreach ($list as $key => $data) {
    			// 判断是否存在parent
    			$parentId = 0;
    			if (isset($data[$pid])) {
    				$parentId = $data[$pid];
    			}

    			if ((string)$root == $parentId) {
    			    
    				$tree[] = &$list[$key];
                    if($parentId==0){
                        $tree[0]['state'] = array('opened'=>true,'disable'=>true);
                    }
    			} else {
    				if (isset($refer[$parentId])) {
    					$parent = &$refer[$parentId];
    					$parent[$child][] = &$list[$key];
    				}
    			}
    		}
    	}
    
    	return $tree;
    }
    
    /** 删除引号****/
    function del_yinhao($str){
        $str = str_replace("'","",$str ); 
        $str = str_replace('"',"",$str ); 
        return $str;
    }
     /** 删除指定文件****/
    function del_file($path){
        $path = '../../../'.$path;
        if(file_exists($path)){
            unlink($path);
        }
    }
    
    /** php json 转数组****/
    function object_array($array){
      if(is_object($array)){
        $array = (array)$array;
      }
      if(is_array($array)){
        foreach($array as $key=>$value){
          $array[$key] = object_array($value);
        }
      }
      return $array;
    }
    
      /** 将图片链接保存到服务器本地****/
    function GrabImage($url, $url_file,$filename=""){
        
        //$url 为空则返回 false;
        
        
        if($url == ""){return false;}
        
        $ext = strrchr($url, ".");//得到图片的扩展名
        
        if($ext != ".gif" && $ext != ".jpg" && $ext != ".bmp"){echo "格式不支持!";return false;}
        
        if($filename == ""){$filename = time()."$ext";}//以时间戳另起名
        
        //开始捕捉
        
        ob_start();
        readfile($url);
        
        $img = ob_get_contents();
        
        ob_end_clean();
        
        $size = strlen($img);
        
        $fp2 = fopen($url_file.$filename , "a");
        
        fwrite($fp2, $img);
        
        fclose($fp2);
        
        return $filename;
        
        }
    
    /** 下载材料****/
    function downfile($fileurl,$name){
        
         $fp=fopen($fileurl,"r");
        $file_size=filesize($fileurl);
        //下载文件需要用到的头
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length:".$file_size);
        Header("Content-Disposition: attachment; filename=".$list['name']);
        $buffer=1024;
        $file_count=0;
        //向浏览器返回数据
        while(!feof($fp) && $file_count<$file_size){
        $file_con=fread($fp,$buffer);
        $file_count+=$buffer;
        echo $file_con;
        }
        fclose($fp);
    }
    
    
     //字符串截取
      function  sub_str($str, $length = 0, $append = true,$end ='...', $charset='utf8') {
               $str = trim($str);
               $str = strip_tags($str);
               $strlength = strlen($str);
               $charset = strtolower($charset);

               if ($charset == 'utf8') {
                       $l = 0;
                       $i=0;
                       while ($i < $strlength) {
                               if (ord($str{$i}) < 0x80) { 
                                       $l++; $i++;
                               } else if (ord($str{$i}) < 0xe0) {
                                       $l++; $i += 2; 
                               } else if (ord($str{$i}) < 0xf0) { 
                                       $l += 2; $i += 3; 
                               } else if (ord($str{$i}) < 0xf8) {
                                       $l += 1; $i += 4; 
                               } else if (ord($str{$i}) < 0xfc) { 
                                       $l += 1; $i += 5; 
                               } else if (ord($str{$i}) < 0xfe) { 
                                       $l += 1; $i += 6; 
                               }

                               if ($l >= $length) { 
                                       $newstr = substr($str, 0, $i);
                                       break;
                               }
                       }
                       if($l < $length) {
                               return $str;
                       }
               } elseif($charset == 'gbk') {
                       if ($length == 0 || $length >= $strlength) {
                               return $str;
                       }
                       while ($i <= $strlength) {
                               if (ord($str{$i}) > 0xa0) { 
                                       $l += 2; $i += 2;
                               } else {
                                       $l++; $i++;
                               }

                               if ($l >= $length) { 
                                       $newstr = substr($str, 0, $i);
                                       break;
                               }
                       }
               }

               if ($append && $str != $newstr) {
                       $newstr .= $end;
               }

               return $newstr;
       }
       
       //立案时间格式化
       function getzanwu_time($val,$result_tpye=2){
         
         if($result_tpye==2){
             $create_time = date('Y-m-d',$val['create_time']);
             $handle_time = date('Y-m-d',$val['handle_time']);
             $val['create_time'] = $create_time;
             $val['handle_time'] = $handle_time;
         }
         if($val['state']<2){
             $val['title'] = $val['user_name'].$val['case_action_name'].'案';
             $val['title'] = sub_str($val['title'],19);
             $val['judge_name'] = '暂无';
             $val['case_num'] = $val['user_name'].$val['case_action_name'];
             $val['judge_mobile'] = '暂无';
             $val['handle_time'] = '暂无';
             
         }
         return $val;
       }
       
       //阅卷时间格式化
       function getzanwu_yue($val=array()){
        
        if($val){
             $create_time = date('Y-m-d',$val['create_time']);
             $handle_time = date('Y-m-d',$val['handle_time']);
             $val['create_time'] = $create_time;
             $val['handle_time'] = $handle_time;
             if($val['state']<2){
                 $val['handle_time'] = '暂无';
             }
        }  
         return $val;
       }
       
       
       //发送短信
       function send_cms_mobile($mobile,$content){
            $flag = 0; 
        	$params='';//要post的数据 	
        
        	//以下信息自己填以下
        	$argv = array( 
        		'name'=>'xuanying',     //必填参数。用户账号
        		'pwd'=>'9FA6EB4D075A98F84F896CF0D451',     //必填参数。（web平台：基本资料中的接口密码）
        		'content'=>$content,   //必填参数。发送内容（1-500 个汉字）UTF-8编码
        		'mobile'=>$mobile,   //必填参数。手机号码。多个以英文逗号隔开
        		'stime'=>'',   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
        		'sign'=>'',    //必填参数。用户签名。
        		'type'=>'pt',  //必填参数。固定值 pt
        		'extno'=>''    //可选参数，扩展码，用户定义扩展码，只能为数字
        	); 
        	//print_r($argv);exit;
        	//构造要post的字符串 
        	//echo $argv['content'];
        	foreach ($argv as $key=>$value) { 
        		if ($flag!=0) { 
        			$params .= "&"; 
        			$flag = 1; 
        		} 
        		$params.= $key."="; $params.= urlencode($value);// urlencode($value); 
        		$flag = 1; 
        	} 
        	$url = "http://sms.1xinxi.cn/asmx/smsservice.aspx?".$params; //提交的url地址
        	$con= substr( file_get_contents($url), 0, 1 );  //获取信息发送后的状态
        	return $con;
	
       }
       
       //把SimpleXMLElement Object数据都转换成数组
       function xmlToArr($xml, $root = true)
	{

		if(!$xml->children())
		{
			return (string)$xml;
		}
		$array = array();
		foreach($xml->children() as $element => $node)
		{
			$totalElement = count($xml->{$element});
			if(!isset($array[$element]))
			{
				$array[$element] = "";
			}
			// Has attributes
			if($attributes = $node->attributes())
			{
				$data = array('attributes' => array(), 'value' => (count($node) > 0) ? xmlToArr($node, false) : (string)$node);
				foreach($attributes as $attr => $value)
				{
					$data['attributes'][$attr] = (string)$value;
				}
				if($totalElement > 1)
				{
					$array[$element][] = $data;
				}
				else
				{
					$array[$element] = $data;
				}
				// Just a value
			}
			else
			{
				if($totalElement > 1)
				{
					$array[$element][] = xmlToArr($node, false);
				}
				else
				{
					$array[$element] = xmlToArr($node, false);
				}
			}
		}
		if($root)
		{
			return array($xml->getName() => $array);
		}
		else
		{
			return $array;
		}

	}
    
    /**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 单位 秒
 * @return string
 * @author 杜波 <jydubo@163.com>
 */

function think_encrypt($data, $key = 'ssfw', $expire = 0) {
	
	$data = base64_encode($data);
	$x = 0;
	$len = strlen($data);
	$l = strlen($key);
	$char = '';

	for ($i = 0; $i < $len; $i++) {
		if ($x == $l)
			$x = 0;
		$char .= substr($key, $x, 1);
		$x++;
	}

	$str = sprintf('%010d', $expire ? $expire + time() : 0);

	for ($i = 0; $i < $len; $i++) {
		$str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1))) % 256);
	}
	return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($str));
}

/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key  加密密钥
 * @return string
 * @author 杜波 <jydubo@163.com>
 */

function think_decrypt($data, $key = 'ssfw') {
	$data = str_replace(array('-', '_'), array('+', '/'), $data);
	$mod4 = strlen($data) % 4;
	if ($mod4) {
		$data .= substr('====', $mod4);
	}
	$data = base64_decode($data);
	$expire = substr($data, 0, 10);
	$data = substr($data, 10);

	if ($expire > 0 && $expire < time()) {
		return '';
	}
	$x = 0;
	$len = strlen($data);
	$l = strlen($key);
	$char = $str = '';

	for ($i = 0; $i < $len; $i++) {
		if ($x == $l)
			$x = 0;
		$char .= substr($key, $x, 1);
		$x++;
	}

	for ($i = 0; $i < $len; $i++) {
		if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
			$str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
		} else {
			$str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
		}
	}
	return base64_decode($str);
}


    //数组转xml
    function array_to_xml($arr,$dom=0,$item=0){
        
        
        if (!$dom){
            $dom = new DOMDocument("1.0","utf-8");
        }
        if(!$item){
            $item = $dom->createElement("data"); 
            $dom->appendChild($item);
        }
        foreach ($arr as $key=>$val){
            
             if(is_string($key)){
                $k = $key;
                
             }else{
                if(isset($val['id'])){
                     $k = 'cl';
                }else{
                     $k = 'person';
                }
             }
          //  $k = is_string($key)?$key:"person";
            $itemx = $dom->createElement($k);
            
            $item->appendChild($itemx);
            if (!is_array($val)){
                $text = $dom->createTextNode($val);
                $itemx->appendChild($text);
                
            }else {
                array_to_xml($val,$dom,$itemx);
            }
        }

      
        return $dom->saveXML();
        
    }
    
    //将SimpleXMLElement转为字符串,还需要进行解码
    function xml_to_str($array,$s=false){
        if(is_array((array)$array)){
            $str = (array)$array;
            if($str){
                if($s==true){
                    if($str[0]==''){
                        $str[0] = '-';
                    }
                    return base64_decode($str[0]);
                    
                }else{
                    if($str[0]==''){
                        $str[0] = '-';
                    }
                    return $str[0];
                }
            }else{
                return '暂无';
            }
            
        }else{
            if($array!=''){
                if($s==true){
                    return base64_decode($array);
                }else{
                    return $array;
                }
            }else{
                return '暂无';
            }
            
            
        }
    }
    
    //转化案件状态
    function state_t_to_w($state){
       $case_state = '';
       
       if($state==125||$state==120||$state==999){
         $case_state = 0; //拒绝
       }else if($state>=300){
         $case_state = 2; //通过
       }else{
         $case_state = 1;  //申请中
       }
       return $case_state;
    }
    
    //案件详情状态
    function case_state_t_to_w($state){
       $case_state = '';
       
       if($state>=300&&$state<=400){
         $case_state = 1; //立案
       }
       if($state>=500&&$state<=501){
         $case_state = 2; //受理
       }
       if($state>=510&&$state<=790){
         $case_state = 3;  //开庭
       }else if($state>=800){
         $case_state = 4;//结案
       }
       return $case_state;
    }
    
    //转阅卷状态
    function ystate_t_to_w($yue_state){
        
        //1申请 2同意 3不同意
        
        $state = '';
        if($yue_state==1){
            $state = 1;
        }else if($yue_state==3){
            $state = 0;
        }else if($yue_state==2){
            $state = 2;
        }
        
        return $state;
        
    }
    
    function get_state($state){
        include('config.php');
        $keys = '';
        foreach($case_state as $val){
           foreach($val as $key=>$_val){
              if($_val==$state){
                $keys = $key;
                break;
              }
             
           }
        }
        return $keys;
    }
    
    
    //用户登录后获取该案件的信息
    function get_case($xml){
        
        $obj = $xml->ajxx->lb;
        //print_R($obj);
        $list = array();
        $list['lsh'] = xml_to_str($obj->item[0]['value']);
        $list['handle_time'] = date('Y-m-d',strtotime($obj->item[3]['value']));
        $list['create_time'] = date('Y-m-d',strtotime($obj->item[2]['value']));
        $list['court_name'] = xml_to_str($obj->item[13]['value']);
        $list['case_num'] = xml_to_str($obj->item[11]['value']);
        $list['judge_name'] = xml_to_str($obj->item[8]['value']);  //承办法官
        $list['judge_mobile'] = xml_to_str($obj->item[9]['value']);  //承办法官联系方式
        $list['case_action_name'] = xml_to_str($obj->item[14]['value']);  //
        $list['biaode'] = xml_to_str($obj->item[4]['value']);  //
        $list['course_room_name'] = xml_to_str($obj->item[17]['value']);  //
        
        //案件状态
        $state = get_state($obj->item[1]['value']);  //案件状态
        $list['state'] = state_t_to_w($state);
        $list['case_view_state'] = case_state_t_to_w($state); //详情信息
        
        //取到当事人姓名
        $u_list = (array)$obj[2];
        $dsr = '';
        for($i=0;$i<count($u_list['xh']);$i++){
            if($obj[2]->xh[$i]->item[0]['value']==('上诉人'||'原告')){
                $dsr = xml_to_str($obj[2]->xh[$i]->item[1]['value']);
                 break;  
            }
        }
        
        $list['case_name'] = $dsr.$list['case_action_name'];
        $list['title'] = $dsr.$list['case_action_name'];
        $list['user_name'] = $dsr;
        $list['dsr'] = $dsr;
        $list['dsr'] = sub_str($list['dsr'],13);
        $list['user_name'] = sub_str($list['user_name'],18);
        $list['title'] = sub_str($list['title'],18);
        
        //搜索日志
        
        $list['dsr_name'] = $dsr;
        
        
        
        return $list;
        
             
         
    }
    
    
        //案件详情信息 搜索需要的信息
    function get_case2($xml,$mysql){
        
        $obj = $xml->ajxx->lb;
        $list = array();

        $list['court_name'] = xml_to_str($obj->item[13]['value']);
        $court_name = $list['court_name'];
        if($court_name){
            $sql = 'select name,id,court_num from ssfw_court where  name like'. "'%$court_name%'";
      
            $list_court = $mysql->get_one($sql);
            
            if($list_court){
                $list['court_id'] = $list_court['id'];
                $list['court_num'] = $list_court['court_num'];
                
            }
        }else{
            $list['court_id'] = '';
            $list['court_num'] = '';
        }
        $list['check_name'] = xml_to_str($obj->item[8]['value']);
        $list['check_mobile'] = xml_to_str($obj->item[9]['value']);
        $list['collegiate_name'] = xml_to_str($obj->item[10]['value']);
        $list['ah'] = xml_to_str($obj->item[11]['value']);
        $list['clerk_name'] = xml_to_str($obj->item[12]['value']);
        $list['close_type'] = xml_to_str($obj->item[15]['value']);
        $list['close_time'] = xml_to_str($obj->item[16]['value']);
        $list['check_dept'] = xml_to_str($obj->item[17]['value']);
        
        
        return $list;
        
         
    }
    
    //得到案件的简要信息
    function get_simple_case($xml){
        
        $obj = $xml->lb->xh;
        $list = array();
        $case_lsh = $obj->lsh;
        $list['lsh'] = xml_to_str($case_lsh);
        $list['handle_time'] = date('Y-m-d',strtotime($obj->larq));
        $list['user_name'] = xml_to_str($obj->dsr);
        $list['court_name'] = xml_to_str($obj->fyjc);
        $list['case_num'] = xml_to_str($obj->ah);
        $list['state'] = state_t_to_w(xml_to_str($obj->zt));
        $list['title'] = $obj->dsr.$obj->ay;  
        
        
        return $list;
    }
    
    //得到案件的简要信息 LoginAnjian_Yz
    function get_case_lie($xml,$type=false){
        
        $obj = $xml;
        $list = array();
        $case_lsh = $obj->lsh;
        $list['lsh'] = xml_to_str($case_lsh,$type);
        $list['create_time'] = '-';
        $list['handle_time'] = date('Y-m-d',strtotime(xml_to_str($obj->larq,$type)));
        $list['user_name'] = xml_to_str($obj->yhxm,$type);
        $list['court_name'] = xml_to_str($obj->fyjc,$type);
        $list['case_num'] = xml_to_str($obj->ah,$type);
        $list['state'] = 2;
        $list['case_action_name'] = xml_to_str($obj->ay,$type); 
        $list['title'] = xml_to_str($obj->yhxm,$type).xml_to_str($obj->ay,$type);  
        $list['title'] = sub_str($list['title'],19);
        $list['biaode'] = xml_to_str($obj->bd,$type); 
        $list['user_name'] = sub_str($list['user_name'],19);
        $list['case_name'] = xml_to_str($obj->yhxm,$type).xml_to_str($obj->ay,$type);
        
        return $list;
    }
    
    //得到案件的进展的简要信息
    function get_simple_case_jz($obj,$type=true,$mysql){
       // print_R($obj);exit;
        //print_R($obj);exit;
        $sq_time = xml_to_str($obj['sqrq'],$type);
        $js_time = xml_to_str($obj['scrq'],$type);
        $sq = substr($sq_time,0,4).substr($sq_time,4,2).substr($sq_time,6,2);
        $cl = substr($js_time,0,4).substr($js_time,4,2).substr($js_time,6,2);
        $list['lsh'] = xml_to_str($obj['lsh'],$type);
        $list['create_time'] = date('Y-m-d',strtotime($sq));
        if($js_time==''){
            $list['handle_time'] = '暂无';
        }else{
            $list['handle_time'] = date('Y-m-d',strtotime($cl));;
        }
        
        $list['user_name'] = xml_to_str($obj['sqrxm'],$type);
        $list['dsr'] = xml_to_str($obj['sqrxm'],$type);
        
        $court_id = xml_to_str($obj['fydm'],$type);
        $sql = 'select name,id from ssfw_court where  court_num='."'$court_id'";
  
        $list_court = $mysql->get_one($sql);
        if($list_court){
            $list['court_name'] = $list_court['name']; 
        }else{
            $list['court_name'] = '暂无';
        }
        
        
        $list['reason'] = xml_to_str($obj['scyjly'],$type);;
        
        $list['case_num'] = xml_to_str($obj['sqrxm'],$type).xml_to_str($obj['ayms'],$type);
        $list['state'] = state_t_to_w(xml_to_str($obj['zt'],$type));
        $list['title'] = xml_to_str($obj['sqrxm'],$type).xml_to_str($obj['ayms'],$type);  
        $list['title'] = sub_str($list['title'],27);
        $list['case_action_name'] = xml_to_str($obj['ayms'],$type); 
        $list['ckxq_state'] = 1;
        $list['biaode'] = xml_to_str($obj['bd'],$type);
        
        //搜索添加的字段
        $list['check_name'] = xml_to_str($obj['scrxm'],$type);
        $list['case_type'] = xml_to_str($obj['ajlx'],$type);
        $list['court_num'] = $court_id;
        $list['court_id'] = $list_court['id'];;
        if($list['case_type']=='民事'){
            $list['case_type_name'] = '民事案件';
        }else if($list['case_type']=='执行'){
            $list['case_type_name'] = '执行案件';
        }else if($list['case_type']=='行政'){
            $list['case_type_name'] = '行政案件';
        }else{
            $list['case_type_name'] = '';
        }

        if($list['state']==2){
            $list['ckxq_state'] = 1;
        } else{
            $list['ckxq_state'] = 0;
        }
        return $list;
        
    }
    
    //得到案件的进展的简要信息
    function get_simple_case_jz_all($xml){
        
        $obj = $xml->lajzcx;
        $sq_time = xml_to_str($obj['sqrq'],true);
        $js_time = xml_to_str($obj['scrq'],true);
        $sq = substr($sq_time,0,4).substr($sq_time,4,2).substr($sq_time,6,2);
        $cl = substr($js_time,0,4).substr($js_time,4,2).substr($js_time,6,2);
        $list['lsh'] = xml_to_str($obj->lsh);
        $list['create_time'] = date('Y-m-d',strtotime($sq));
        if($js_time==''){
            $list['handle_time'] = '暂无';
        }
        
        $list['user_name'] = xml_to_str($obj['sqrxm'],true);
        $list['dsr'] = xml_to_str($obj['sqrxm'],true);
        
        $list['court_name'] = '暂无';
        $list['reason'] = xml_to_str($obj['scyjly'],true);;
        
        $list['case_num'] = '-';
        $list['state'] = state_t_to_w(xml_to_str($obj['zt'],true));
        $list['title'] = xml_to_str($obj['sqrxm'],true).xml_to_str($obj['ayms'],true);  
        $list['title'] = sub_str($list['title'],27);
        $list['case_action_name'] = xml_to_str($obj['ayms'],true); 
        $list['ckxq_state'] = 1;
        $list['biaode'] = '-';
        
        if($list['state']==2){
            $list['ckxq_state'] = 1;
        } else{
            $list['ckxq_state'] = 1;
        }

        return $list;
    }
    
    //根绝法院id得到法院的编号
    function get_court_num_by_id($id,$mysql){
        
         $sql = 'select court_num from ssfw_court where id='.base64_encode($id) ;
         $list = $mysql->get_one($sql);
         return $list['court_num'];
    }
    
    //通过法院代码找到法院的简称
    function get_court_name_by_num($code,$mysql){
        if($code!='暂无'&&$code){
            if(strlen($code)==6){
                $sql = 'select name from ssfw_court where court_num='.($code) ;
            }else{
                $sql = 'select name from ssfw_court where name='."'$code'" ;
            }
            
            $list = $mysql->get_one($sql);
            $name = $list['name']; 
        }else{
            $name='-';
        }
         
         return $name;
    }

           //得到案件的进展的简要信息
    function get_simple_case_jz2($obj,$type=true,$mysql){
       // print_R($obj);exit;
        //print_R($obj);exit;
        $sq_time = xml_to_str($obj->sqrq,$type);
        $js_time = xml_to_str($obj->scrq,$type);
        $sq = substr($sq_time,0,4).substr($sq_time,4,2).substr($sq_time,6,2);
        $cl = substr($js_time,0,4).substr($js_time,4,2).substr($js_time,6,2);
        $list['lsh'] = xml_to_str($obj->lsh,$type);
        $list['create_time'] = date('Y-m-d',strtotime($sq));
        if($js_time==''){
            $list['handle_time'] = '暂无';
        }else{
            $list['handle_time'] = date('Y-m-d',strtotime($cl));;
        }
        
        $list['user_name'] = xml_to_str($obj->sqrxm['sqrxm'],$type);
        $list['dsr'] = xml_to_str($obj->sqrxm,$type);
        
        $court_id = xml_to_str($obj->fydm,$type);
        
        $sql = 'select name,id from ssfw_court where  court_num='."'$court_id'";
  
        $list_court = $mysql->get_one($sql);
        if($list_court){
            $list['court_name'] = $list_court['name']; 
        }else{
            $list['court_name'] = '暂无';
        }
        
        
        $list['reason'] = xml_to_str($obj->scyjly,$type);;
        
        $list['case_num'] = xml_to_str($obj->sqrxm,$type).xml_to_str($obj->ayms,$type);
        $list['state'] = state_t_to_w(xml_to_str($obj->zt,$type));
        $list['title'] = xml_to_str($obj->sqrxm,$type).xml_to_str($obj->ayms,$type);  
        $list['title'] = sub_str($list['title'],27);
        $list['case_action_name'] = xml_to_str($obj->ayms,$type); 
        $list['ckxq_state'] = 1;
        $list['biaode'] = xml_to_str($obj->bd,$type);
        
        //搜索添加的字段
        $list['check_name'] = xml_to_str($obj->scrxm,$type);
        $list['case_type'] = xml_to_str($obj->ajlx,$type);
        $list['court_num'] = $court_id;
        $list['court_id'] = $list_court['id'];;
        if($list['case_type']=='民事'){
            $list['case_type_name'] = '民事案件';
        }else if($list['case_type']=='执行'){
            $list['case_type_name'] = '执行案件';
        }else if($list['case_type']=='行政'){
            $list['case_type_name'] = '行政案件';
        }else{
            $list['case_type_name'] = '';
        }
        
        
        
        
        
        if($list['state']==2){
            $list['ckxq_state'] = 1;
        } else{
            $list['ckxq_state'] = 1;
        }
        return $list;
    }
    
    

    //获取阅卷的案件的信息
    function get_yue_case_by_lsh($xml,$mysql,$arr,$name){
        //0申请 1审查同意 2审查不同意 阅卷状态
         
         $count = xml_to_str($xml->amount,true);
         $list =array();
         if($count>0){
            for($i=0;$i<$count;$i++){
                 $obj = $xml->marklist->markxx[$i]->attributes();
                 $list[$i]['lsh'] = xml_to_str($obj->lsh,true);
                 $list[$i]['handle_time'] = date('Y-m-d',strtotime(xml_to_str($obj->scrq,true)));
                 $list[$i]['create_time'] = date('Y-m-d',strtotime(xml_to_str($obj->sqrq,true)));
                 if(xml_to_str($obj->sqrq,true)==''){
                    $list[$i]['create_time'] = '-';
                 }
                 
                 $list[$i]['user_name'] = xml_to_str($obj->sqrxm,true);
                 
                 if($list[$i]['user_name']==''){
                    $list[$i]['user_name'] = $name;
                 }
                 
                 $list[$i]['state'] = ystate_t_to_w(xml_to_str($obj->zt,true));
                 //echo xml_to_str($obj->fydm,true);exit;
                 $list[$i]['court_name'] = get_court_name_by_num(xml_to_str($obj->fydm,true),$mysql);
                 $list[$i]['reason'] = xml_to_str($obj->fydm,true);
                 $list[$i]['xh'] = xml_to_str($obj->xh,true);
                 if($list[$i]['state']<2){
                     $list[$i]['handle_time'] = '暂无';
                 }
                 //按时间排序
                 $xh = xml_to_str($obj->xh,true);
                 $xh = xml_to_str($obj->xh,true);
                 
                 $list[$i]['allinfo'] = get_yue_case_xx_by_lsh($list[$i]['lsh'],$xh,$arr);
                 
                 //得到阅卷案件的标的 时间 案由
                 $case = array();
                 $case = get_simple_case_by_lsh(xml_to_str($obj->lsh,true),$arr);
                 
                 
                 $list[$i]['case_action_name'] = $case['case_action_name'];
                 $list[$i]['biaode'] = $case['biaode'];
                 $list[$i]['case_num'] = $case['ah'];
                 
                // $list[$i]['state'] = 2;
                 
            }
            
            if(count($list)>1){
                $list = arraySort($list,'create_time','desc');
            }
         }
         return $list;
       
         //通过法院编号取得法院名称
         
    }
    
/*
      @author namimori
      @date   16/04/29
    */
    function file_force_contents($dir, $contents){
        $parts = explode('/', $dir);
        $file = iconv('utf-8', 'gbk', array_pop($parts));
        $dir = '../../../';
        foreach($parts as $part)
            if(!is_dir($dir .= "$part/")) mkdir($dir);
        file_put_contents("$dir$file", $contents);
    }

    ///获取阅卷的案件的详细信息
    //流水号 序号 帐号
    function get_yue_case_xx_by_lsh($lsh,$xh,$arr){
         include(CONFIG);
         
         $arr['xh'] = base64_encode($xh);
         $curl = new Http();
         //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/WsyjXx_Yz';
         $url = $api['LoginAnjian_Yz'];
         $xml = $curl->request($url,$arr,'POST');
         $xml = simplexml($xml,'LoginAnjian_Yz','get_yue_case_xx_by_lsh.global.php');
         $list = array();
         $jz = array();
         if(isset($xml->fjcl->cl)&&$xml->fjcl->cl->count()){
            $key = 0;
            foreach($xml->fjcl->cl as $val){
                $jz[$key] = array(
                  'id' => xml_to_str($val['id'], true),
                  'name' => xml_to_str($val['text'], true),
                  'url' =>'download/'.xml_to_str($val['id'],true).'/'.xml_to_str($val['text'],true),
                );



                /*
                  @author namimori
                  @date   16/04/29
                */
                $mixed_data_arr = array(
                    'id' => base64_encode($jz[$key]['id']),
                    'account' => $arr['account'],
                    'password' => $arr['password']
                    );
                $mixed_data_str = '';
                foreach ($mixed_data_arr as $mixed_data_key => $mixed_data_value) {
                    $mixed_data_str .= $mixed_data_key.'='.$mixed_data_value.'&';
                }
                $mixed_data_str = substr($mixed_data_str, 0, -1);
                file_force_contents($jz[$key]['url'], fopen("http://ssfw.jsfy.gov.cn:8038/ytj/app/WsyjWjxz?".$mixed_data_str, 'r'));



                $key++;
            }
         }
         $list['jz'] = $jz;
         return $list;
    }
    
    
    //通过阅卷详细接口获取详细数据
    function get_review_xx($xml,$mysql){

         $obj = $xml->markxx->attributes();
         $list['lsh'] = xml_to_str($obj['lsh'][0],true);
         $list['ah'] = xml_to_str($obj['ah'][0],true);
         $list['handle_time'] = date('Y-m-d',strtotime(xml_to_str($obj['scrq'][0],true)));
         $list['create_time'] = date('Y-m-d',strtotime(xml_to_str($obj['sqrq'][0],true)));
         if(xml_to_str($obj['sqrq'][0],true)==''){
            $list['create_time'] = '-';
         }
         
         $list['user_name'] = xml_to_str($obj['sqrxm'][0],true);
         $list['state'] = ystate_t_to_w(xml_to_str($obj['zt'][0],true));

         $list['court_num'] = xml_to_str($obj['fydm'][0],true);
         $court_id = $list['court_num'];
         $sql = 'select name,id from ssfw_court where  court_num='."'$court_id'";
  
         $list_court = $mysql->get_one($sql);
         if($list_court){
             $list['court_name'] = $list_court['name']; 
             $list['court_id'] = $list_court['id']; 
         }
         
         $list['apply_reason'] = xml_to_str($obj['mude'][0],true);
         $list['xh'] = xml_to_str($obj['xh'][0],true);
         $list['apply_content'] = xml_to_str($obj['sqnr'][0],true);
         
         
         return $list;

    }
    
    //排序函数
    /**
     * @desc arraySort php二维数组排序 按照指定的key 对数组进行排序
     * @param array $arr 将要排序的数组
     * @param string $keys 指定排序的key
     * @param string $type 排序类型 asc | desc
     * @return array
     */
    function arraySort($arr, $keys, $type = 'asc') {
        $keysvalue = $new_array = array();
        foreach ($arr as $k => $v){
            $keysvalue[$k] = $v[$keys];
        }
        $type == 'asc' ? asort($keysvalue) : arsort($keysvalue);
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) {
           $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }
    
    ///获取阅卷的案件的详细信息
    //流水号 序号 帐号
    function get_yue_case_xx($xml,$mysql,$name,$arr){
        
         $list = array();
         $obj = $xml->markxx;
         
         $list['lsh'] = xml_to_str($obj['lsh'],true);
         $list['handle_time'] = date('Y-m-d',strtotime(xml_to_str($obj['scrq'],true)));
         $list['create_time'] = date('Y-m-d',strtotime(xml_to_str($obj['sqrq'],true)));
         if(xml_to_str($obj['sqrq'],true)==''){
            $list['create_time'] = '-';
         }
         if(xml_to_str($obj['scrq'],true)==''){
            $list['handle_time'] = '暂无';
         }
        
         $list['user_name'] = xml_to_str($obj['sqrxm'],true);
         
         if($list['user_name']==''){
            $list['user_name'] = $name;
         }
         
         $list['state'] = ystate_t_to_w(xml_to_str($obj['zt'],true));
         //echo xml_to_str($obj->fydm,true);exit;
         $list['court_name'] = get_court_name_by_num(xml_to_str($obj['fydm'],true),$mysql);
         
         //得到阅卷案件的标的 时间 案由
         $case = array();
         $case = get_simple_case_by_lsh(xml_to_str($obj['lsh'],true),$arr);
         
         
         $list['case_action_name'] = $case['case_action_name'];
         $list['biaode'] = $case['biaode'];
         $list['case_num'] = $case['ah'];
         
         return $list;
    }
    
    //数组转xml
    function arrtoxml($arr,$dom=0,$item=0){
        if (!$dom){
            $dom = new DOMDocument("1.0");
        }
        if(!$item){
            $item = $dom->createElement("aa"); 
            $dom->appendChild($item);
        }
        foreach ($arr as $key=>$val){
            $itemx = $dom->createElement(is_string($key)?$key:"item");
            $item->appendChild($itemx);
            if (!is_array($val)){
                $text = $dom->createTextNode($val);
                $itemx->appendChild($text);
                
            }else {
                arrtoxml($val,$dom,$itemx);
            }
        }
        return $dom->saveXML();
    }
    
        //根据流水号得到案件详情   
    // 流水号 帐号 得到的xml数据 type 1 不用查 2 要查询
    function get_simple_case_by_lsh($lsh,$arr){
       include(CONFIG);
       $case = array();
       $list = array();
       if($arr){
        
          $list['account'] = base64_decode($arr['account']);
          $list['password'] = base64_decode($arr['password']);
          $list['type'] = base64_decode($arr['type']);
          $list['lsh'] = base64_decode($arr['lsh']);
          
          // header("Content-type:text/html;charset=utf-8");
           $curl = new Http();
           //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/DetailAnjian_Yz';
           $url = $api['DetailAnjian_Yz'];
           $xml = $curl->request($url,$list,'POST');
           $xml = simplexml($xml,'DetailAnjian_Yz','get_simple_case_by_lsh.global.php');
           $code = false;
           
           if(isset($xml->code)){
              $code = xml_to_str($xml->code);
           }
          
           if($code!='false'){
               $obj = $xml->ajxx->lb;
               $case['case_action_name'] = xml_to_str($obj->item[14]['value']);  //
               $case['biaode'] = xml_to_str($obj->item[4]['value']);  //
               $case['ah'] = xml_to_str($obj->item[11]['value']);  //
           }
       }
       return $case;
    }
    
    //查处该案件对应的案由对应的按键来类型
    function get_yy_case_type($arr,$mysql){
        include(CONFIG);
        $case_type = 3;
        $curl = new Http();
        //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/DetailAnjian_Yz';
        $url = $api['DetailAnjian_Yz'];
        $xml = $curl->request($url,$arr,'POST');
        $xml = simplexml($xml,'DetailAnjian_Yz','get_yy_case_type.global.php');
        $code = xml_to_str($xml->code);
        if(!isset($code)||$code!='false'){
            $list = get_case($xml);
            $action_name = $list['case_action_name'];
            $sql = 'select type from ssfw_case_action where name='."'$action_name'" ;
            $list_action = $mysql->get_one($sql);
            if($list_action){
                $case_type = $list_action['type'];
            }
        }
        
        return $case_type;
        
        
    }
    
    
    //根据流水号得到案件详情   
    // 流水号 帐号 得到的xml数据 type 1 不用查 2 要查询
    function get_case_by_lsh($lsh,$arr,$xml,$type=1){
       include(CONFIG);
      // header("Content-type:text/html;charset=utf-8");
       if($type==2){
           $curl = new Http();
           //$url = 'http://ssfw.jsfy.gov.cn:8038/ytj/app/DetailAnjian_Yz';
           $url = $api['DetailAnjian_Yz'];
           $arr['lsh']=$lsh;
           $xml = $curl->request($url,$arr,'POST');
           $xml = simplexml($xml,'WsyjLb_Yz','get_case_by_lsh.global.php');
       }
       $code = xml_to_str($xml->code);
       if(!isset($code)||$code!='false'){
        
           $list = get_case($xml);
           $obj = $xml->ajxx;
         
           $dsr_count = $obj->lb[2]->xh->count();
           $dsr_list = array();
           if($dsr_count){
              for($i=0;$i<$dsr_count;$i++){
                 $dsr = $obj->lb[2]->xh[$i]->item;
                 $dsr_list[$i]['type'] = xml_to_str($dsr[0]['value']);
                 $dsr_list[$i]['name'] = xml_to_str($dsr[1]['value']);
              }
           }
           //取到当事人信息
           //id name type_name
           $list['dsrdata'] = $dsr_list;
           
           //取得开庭信息
           
           $kt_count = $mar_count = $obj->lb[3]->xh->count();
           $k = $kt_count-1;
           $kt_list = array();
           $kt_list['kt_time'] = '';
           $kt_list['kt_room'] = '';
           if($kt_count){
            
                 $kt = $obj->lb[3]->xh[$k]->item;
                 
                 $kt_list['kt_time'] = xml_to_str($kt[1]['value']).' '.$kt[2]['value'];
                 $kt_list['kt_room'] = xml_to_str($kt[4]['value']);
              
           }
           
           $list['ktdata'] = $kt_list;
           
           //取到材料信息 id name 
           $mar_count = $obj->lb[5]->xh->count();
           $mar_list = array();
           if($mar_count){
              for($i=0;$i<$mar_count;$i++){
                 $mar = $obj->lb[5]->xh[$i]->item;
                
                 $mar_list[$i]['type_name'] = xml_to_str($mar[1]['value']);
                 $mar_list[$i]['name'] = xml_to_str($mar[0]['value']);
                 $mar_list[$i]['id'] = '12';
              }
           }
           $result['data']=$list;
           $list['mardata'] = $mar_list;
       }else{
          $list =array();
       }
       
       //print_R($list);
       return $list;
    }


    //将我们的材料id换成通达海id  
    function get_cl_type_id($type,$type_id){
        $state = '';
        if($type_id=='bxcl'){
            
            switch ($type)
            {
            case 1:
              $state = '01';
              break;
            case 2:
              $state = '02';
              break;
            case 3:
              $state = '06';
              break;
            case 4:
              $state = '13';
              break;
            case 5:
              $state = '09';
              break;
            case 6:
              $state = '10';
              break;
            case 7:
              $state = '11';
              break;
           
           }
       
        }else{
            switch ($type)
            {
            case 1:
              $state = '07';
              break;
            case 2:
              $state = '03';
              break;
            case 3:
              $state = '10';
              break;
            case 4:
              $state = '11';
              break;
            }
        }
        
       return $state;
    }
  
  //重置文件名 转成具体的名字
  function get_new_cl_name($name,$type,$type_id,$file_index)
  {
    $kzm = substr(strrchr($name, '.'), 1); 
    $new_name = '';
    if($name){
        if($type=='bxcl'){
            
            switch ($type_id)
            {
            case 1:
              $new_name = '起诉状'.$file_index;
              break;
            case 2:
              $new_name = '当事人身份证明'.$file_index;
              break;
            case 3:
              $new_name = '证据材料'.$file_index;
              break;
            case 4:
              $new_name = '当事人送达地址确认书'.$file_index;
              break;
            case 5:
              $new_name = '申请执行书'.$file_index;
              break;
            case 6:
              $new_name = '生效裁判案卷'.$file_index;
              break; 
            case 7:
              $new_name = '执行线索材料'.$file_index;
              break;
           
           }
       
        }else{
            switch ($type_id)
            {
            case 1:
              $new_name = '营业执照'.$file_index;
              break;
            case 2:
              $new_name = '授权委托书'.$file_index;
              break;
            case 3:
              $new_name = '生效裁判案卷'.$file_index;
              break;
            case 4:
              $new_name = '执行线索材料'.$file_index;
              break;
            
           }
        }
        
        $new_name = $new_name.'.'.$kzm;
    }
    
    return $new_name;
    
  }
  
  function get_gpy_new_cl_name($type,$type_id,$file_array,$mysql,$lian_num){
    
    $new_file_array = array();
    $new_name = '';
    if($file_array){
        $sql = 'select * from ssfw_material where  type='."'$type_id'" .' and type_id='."'$type'".' and lian_num='."'$lian_num'";
      
            
        $list = $mysql->get_all($sql);
        $c = count($list);
        
        foreach ($file_array as $key=>$val){
            $file_index = $c + 1+$key;
           // echo $file_index;
          //  $kzm = substr(strrchr($val, '.'), 1); 
			$kzm = strtolower(substr(strrchr($name, '.'), 1)); 
            if($type=='bxcl'){
                
                switch ($type_id)
                {
                case 1:
                  $new_name = '起诉状'.$file_index;
                  break;
                case 2:
                  $new_name = '当事人身份证明'.$file_index;
                  break;
                case 3:
                  $new_name = '证据材料'.$file_index;
                  break;
                case 4:
                  $new_name = '当事人送达地址确认书'.$file_index;
                  break;
                case 5:
                  $new_name = '申请执行书'.$file_index;
                  break;
                case 6:
                  $new_name = '生效裁判案卷'.$file_index;
                  break;
                case 7:
                  $new_name = '执行线索材料'.$file_index;
                  break;
                  
               
               }
           
            }else{
                switch ($type_id)
                {
                case 1:
                  $new_name = '营业执照'.$file_index;
                  break;
                case 2:
                  $new_name = '授权委托书'.$file_index;
                  break;
                case 3:
                  $new_name = '生效裁判案卷'.$file_index;
                  break;
                case 4:
                  $new_name = '执行线索材料'.$file_index;
                  break;
                
               }
            }
            
            $new_file_array[$key]['new_name'] = $new_name.'.'.$kzm;
            $new_file_array[$key]['old_name'] = $val;
            
        }
    }
    
    
    return $new_file_array;
  }
  
  
  
  
  function save_num_log($data,$type,$num,$name,$mysql){
    
     $today_date = $data['today_date'];

     $sql = 'select id,num from ssfw_num_log where type='.$type.' and user_id = '.$data['user_id']. ' and court_id = '.$data['court_id']. ' and today_date='."'$today_date'";
     $list = $mysql->get_one($sql);
     if(!$list){
        
        $num_log_data = array();
        $num_log_data['name'] = $name;
        $num_log_data['product_id'] = $data['product_id'];
        $num_log_data['user_id'] = $data['user_id'];
        $num_log_data['court_id'] = $data['court_id'];
        $num_log_data['num'] = $num;
        $num_log_data['type'] = $type;
        $num_log_data['today_date'] = $today_date;
    
        $time_log = $mysql->insert('ssfw_num_log',$num_log_data);
     }else{
        $list['num'] = $list['num'] + $num;
        $time_log = $mysql->update('ssfw_num_log',$list,'id='.$list['id']);
     }
     
  }
  
  
  //获取ip

    function getIP()
    {
        global $ip;
        
        if (getenv("HTTP_CLIENT_IP"))
          $ip = getenv("HTTP_CLIENT_IP");
        else if(getenv("HTTP_X_FORWARDED_FOR"))
          $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if(getenv("REMOTE_ADDR"))
          $ip = getenv("REMOTE_ADDR");
        else
          $ip = "Unknow";
        
        return $ip;
    }
    
    
    function getRandChar($length){
       $str = null;
       $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
       $max = strlen($strPol)-1;
    
       for($i=0;$i<$length;$i++){
        $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
       }
    
       return $str;
      }
 
   //删除文件
//   function deleteAll($path) {
//    $op = dir($path);
//    while(false != ($item = $op->read())) {
//        if($item == '.' || $item == '..') {
//            continue;
//        }
//        if(is_dir($op->path.'/'.$item)) {
//            deleteAll($op->path.'/'.$item);
//            rmdir($op->path.'/'.$item);
//        } else {
//            unlink($op->path.'/'.$item);
//        }
//    
//    }   
//}

//删除目录
    function delDirAndFile($dirName,$lian_num,$old_name)
{

    $_COOKIE['error_value'] = $lian_num;
    $_COOKIE['error_type'] = 1;
    
    $d = $dirName;
    if ( $handle = opendir( "$dirName" ) ) {
        
        while ( false !== ( $item = readdir( $handle ) ) ) {
            if ( $item != "." && $item != ".." ) {
            if ( is_dir( "$dirName/$item" ) ) {
                delDirAndFile( "$dirName/$item" ,$lian_num,$old_name);
                } else {
                    
                if(strstr($dirName,$old_name.'/'.$lian_num)){     
                    
                  unlink( "$dirName/$item" ) ; 
                } 
                 
                }
            }
        }
        if($dirName!=$old_name){
            
            if($dirName==$old_name.'/'.$lian_num){
                
                is_dir($dirName)? @rmdir($dirName):'';
            }else{
                if(strstr($dirName,$old_name.'/'.$lian_num)){     
                  is_dir($dirName)? @rmdir($dirName):''; 
                }
            }
        }
        
        closedir( $handle );
    }
    
 
   
    
     
     
    
    

}

    //捕获fatalError
    function fatalErrorHandler(){
         $e = error_get_last();
    
          switch($e['type']){
                case E_ERROR:
                case E_PARSE:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_USER_ERROR:
                     errorHandler($e['type'],$e['message'],$e['file'],$e['line']);//type 1 重复删除
                     break;         
            }
    }
    
    function errorHandler($errno,$errstr,$errfile,$errline){
        
         $arr = array(
                        '['.date('Y-m-d h-i-s').']',
                        '|',
                        $errstr,
                        $errfile,
                        'line:'.$errline,
                    );
         //写入错误日志
                     //格式 ：  时间 uri | 错误消息 文件位置 第几行
         $dir = dirname(__FILE__);
         error_log(implode(' ',$arr)."\r\n",3,$dir.'/lib/phpLog.txt','extra');
         if($errstr){
            $error_type = 0;
            if(isset($_COOKIE['error_value'])&&isset($_COOKIE['error_type'])){
                $error_value = $_COOKIE['error_value'] ;
                $error_type = $_COOKIE['error_type'];
            }
            
            if($error_type==1){
                
                $foo = new Foo();
                $foo->info("[$error_value]删除失败");
                
                $dirName = '../../../upload/gpy';
                delDirAndFile($dirName,$error_value);
                $_COOKIE['error_value'] = '';
                $_COOKIE['error_type'] = '';
                
            }
         }
    }
    
    
    function redis_log($str){
        $arr = array(
                        '['.date('Y-m-d h-i-s').']',
                        '|',
                        $str,
                    );
         //写入错误日志
                     //格式 ：  时间 uri | 错误消息 文件位置 第几行
         $dir = dirname(__FILE__);
         error_log(implode(' ',$arr)."\r\n",3,$dir.'/log/redisLog.txt','extra');
    }


    function lock($redis,$key, $expire=5){
        $is_lock = $redis->setnx($key, time()+$expire);

        // 不能获取锁
        if(!$is_lock){

            // 判断锁是否过期
            $lock_time = $redis->get($key);

            // 锁已过期，删除锁，重新获取
            if(time()>$lock_time){
                unlock($redis,$key);
                $is_lock = $redis->setnx($key, time()+$expire);
            }
        }

        return $is_lock? true : false;
    }

    /**
     * 释放锁
     * @param  String  $key 锁标识
     * @return Boolean
     */
     function unlock($redis,$key){
        return $redis->del($key);
    }


    function lock_state($id,$mysql){
        $state = 0;
        $sql = 'select * from ssfw_case_handle where  id='.$id;
        $case_list = $mysql->get_one($sql);
        if($case_list){
            if($case_list['is_lock']==0){
                $new_data = array();
                $new_data['is_lock'] = 1;    
                $lists = $mysql->update('ssfw_case_handle',$new_data,'id='.$id);
            }else{
                $state = 1;
            }
            
        }
        
        return $state;
    }






     
?>