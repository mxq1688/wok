<?php 

   $com_contact = dirname(__FILE__);
   define("COM_CONTACT", $com_contact.'/contact.php');
   
   define("CONFIG", $com_contact.'/config.php');
   
    /** 设置时区**/
   ini_set('date.timezone','Asia/Shanghai'); 
   
   /** 定义数据库配置路径变量**/
   $com_contact = dirname(__FILE__);
   define("COM_CONFIG", $com_contact.'/config.php');
   
   $ip = '192.168.1.152';
   
   $baseurl = 'http://'.$ip.'/testssfw';
   
   $baseytj = 'http://'.$ip.'/sfytjxjk';

   include(COM_CONTACT);
   
   include(CONFIG);
   
   /** 引用curl类 **/
   include('curl.class.php');

   include('log4php/foo.class.php');
   
   /** 允许所有访问 ajax跨域   **/
   header("Access-Control-Allow-Origin:*"); 
   
   /** application/json是更通用且符合标准的****/
   header('Content-type: application/json');
?>