<?php

    $db_config["hostname"] = "localhost"; //服务器地址
    $db_config["username"] = "root"; //数据库用户名
    $db_config["password"] = "root"; //数据库密码
    $db_config["database"] = "ssfw_yg"; //数据库名称
    $db_config["charset"] = "utf8";//数据库编码
    $db_config["pconnect"] = 1;//开启持久连接
    $db_config["log"] = 0;//开启日志
    $db_config["logfilepath"] = (dirname(__FILE__));//开启日志

    //echo $db_config["logfilepath"];exit;
    
    
    $litigation_fee = array(
                array('1'=>'财产案件'),
                array('3'=>'离婚案件'),
                array('4'=>'其他非财产案件'),
                array('6'=>'知识产权案件'),
                array('7'=>'知识产权(财产)'),
                array('8'=>'侵害姓名权等人格权'),
                array('9'=>'劳动争议案件'),
                array('10'=>'破产案件'),
                array('15'=>'管辖权异议'),
                array('17'=>'申请公示催告'),
                array('18'=>'申请支付令'),
                array('20'=>'商标、专利、海事行政案件'),
                array('22'=>'其他行政案件'),
                array('24'=>'申请认定或撤消仲裁案件'),
                array('25'=>'执行案件'),
                array('26'=>'保全案件'),
  
    );
    
    $case_state = array(
                array('100'=>'登'),
                array('110'=>'报'),
                array('120'=>'补'),
                array('125'=>'退'),
                array('130'=>'符'),
                array('140'=>'核'),
                array('150'=>'缴'),
                array('160'=>'转'),
                array('200'=>'收案'),
                array('220'=>'呈报'),
                array('300'=>'立'),
                array('310'=>'立排'),
                array('400'=>'移送'),
                array('500'=>'审'),
                array('501'=>'准备'),
                array('510'=>'开庭'),
                array('521'=>'报告'),
                array('522'=>'合议'),
                array('523'=>'中层'),
                array('525'=>'请示'),
                array('526'=>'讨论'),
                array('533'=>'呈批'),
                array('537'=>'签发'),
                array('540'=>'宣判'),
                array('600'=>'预案'),
                array('610'=>'查控'),
                array('620'=>'普执'),
                array('630'=>'强执'),
                array('780'=>'结案登记'),
                array('790'=>'报结'),
                array('800'=>'结'),
                array('810'=>'报送'),
                array('820'=>'结果'),
                array('830'=>'反馈'),
                array('840'=>'生效'),
                array('900'=>'送检'),
                array('910'=>'退回'),
                array('920'=>'通过'),
                array('950'=>'提档'),
                array('960'=>'退档'),
                array('970'=>'档'),
                array('999'=>'终'),
  
    );

   $api = array(
      'LoginAnjian_Yz'=>'http://ssfw.jsfy.gov.cn:8038/ytj/app/LoginAnjian_Yz',
      'QueryWslaAnjian_Yz'=>'http://ssfw.jsfy.gov.cn:8038/ytj/app/QueryWslaAnjian_Yz',
      'SqWsyj_Yz'=>'http://ssfw.jsfy.gov.cn:8038/ytj/app/SqWsyj_Yz',
      'WsyjLb_Yz'=>'http://ssfw.jsfy.gov.cn:8038/ytj/app/WsyjLb_Yz',
      'WsyjXx_Yz'=>'http://ssfw.jsfy.gov.cn:8038/ytj/app/WsyjXx_Yz',
      'DetailAnjian_Yz'=>'http://ssfw.jsfy.gov.cn:8038/ytj/app/DetailAnjian_Yz',
      'KaitingNoticeNew_Yz'=>'http://ssfw.jsfy.gov.cn:8038/ytj/app/KaitingNoticeNew_Yz',
      'Login_Ls_Yz'=>'http://ssfw.jsfy.gov.cn:8038/ytj/app/Login_Ls_Yz',
      'AgencyCaseList_Ls_Yz'=>'http://ssfw.jsfy.gov.cn:8038/ytj/app/AgencyCaseList_Ls_Yz',
      'CaseFiling_Ls_Yz'=>'http://ssfw.jsfy.gov.cn:8038/ytj/app/CaseFiling_Ls_Yz',
      'CaseServlet_Yz'=>'http://ssfw.jsfy.gov.cn:8038/ytj/app/CaseServlet_Yz',
      'UploadServlet_Yz'=>'http://ssfw.jsfy.gov.cn:8038/ytj/app/UploadServlet_Yz',
      'Jiedian'=>'http://139.196.46.251/JH_Court/ProcessNode/getProcess',
      'DASQ_JG_Yz'=>'http://119.97.184.140:85/ytj/service/DASQ_JG_Yz',
      'Downlowd_JCYX_Yz'=>"http://119.97.184.140:85/ytj/service/Downlowd_JCYX_Yz",
      'DASQ_Yz'=>'http://119.97.184.140:85/ytj/service/DASQ_Yz',
      'SDHZ_Yz'=>'http://119.97.184.140:85/ytj/service/SDHZ_Yz',
      
   );

    
    
 ?>