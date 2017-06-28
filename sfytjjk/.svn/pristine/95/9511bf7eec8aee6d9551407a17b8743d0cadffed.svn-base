<?php
session_start();
//header("Content-type:image/png");
include('../common/yzm.php');
include('../common/redis.php');
$captcha5 = new Captcha();
 
//@设置验证码宽度
$captcha5->setWidth(197);
 
//@设置验证码高度
$captcha5->setHeight(58);
 
//@设置字符个数
$captcha5->setTextNumber(4);
 
//@设置字符颜色
//$captcha5->setFontColor('#ff9900');
 
//@设置字号大小
$captcha5->setFontSize(40);
 
//@设置字体
$captcha5->setFontFamily('../common/fonts/Candara.ttf');
 
//@设置语言
$captcha5->setTextLang('en');
 
//@设置背景颜色
//$captcha5->setBgColor('#000000');
 
//@设置干扰点数量
$captcha5->setNoisePoint(600);
 
//@设置干扰线数量
$captcha5->setNoiseLine(10);
 
//@设置是否扭曲
$captcha5->setDistortion(false);
 
//@设置是否显示边框
$captcha5->setShowBorder(false);
 
//输出验证码
$code = $captcha5->createImage();

//查找是否有这个验证码，如果没有的话就插入，有的话就覆盖
$sql = "select * from ssfw_session where type=1 and user_id=".$_GET['user_id'];
$list = $mysql->get_one($sql);
if($list){
    $data['val'] = $code;
    $list = $mysql->update('ssfw_session',$data,'id='.$list['id']);
}else{
    $data['val'] = $code;
    $data['type'] = 1;
    $data['user_id'] = $_GET['user_id'];
    $list = $mysql->insert('ssfw_session',$data);
}


?>