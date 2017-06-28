<?php
       /*二维码登录-20160825 二维码绑定案件和当事人*/ 
       include('../common/global.php');
       $result = array();
       $ewmid = _request('ewmid');
       $operation = _request('operation');
        
       /*1.根据二维码id(base64加密=id+随机码)获取案件信息（case_id）和用户身份信息（identity,user_name,user_id）*/
       
      function en64($str){
        return base64_encode($str);
      }

      function xmlToArray($xml){ 
 
          //禁止引用外部xml实体 
       
          libxml_disable_entity_loader(true); 
       
          $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA); 
       
          $val = json_decode(json_encode($xmlstring),true); 
       
          return $val; 
       
      } 

      /*
      **  modify by ShenBoWen 
      **  2017-04-28
      */
      

    if($ewmid){
         //$ewmid = base64_encode($ewmid);
         //通过流水号获取案号
          if($operation==1){
            $sql = "select * from ssfw_yg_cj_info where fwlsh = "."'$ewmid'".' and is_show=1';;
          }else{
			     $ewmid = base64_decode($ewmid);
            $sql = "select * from ssfw_yg_cj_info where id = ".$ewmid.' and is_show=1';
          }
          

          $list = $mysql -> get_one($sql);
          
        if($list){

            
            //正常使用云柜
            $result['xxly'] = $list['xxly']=='ZX'?'中心':'法官';
            $result['slr'] = $list['slr_name'];
            $result['sqsj'] = $list['sqsj'];
            $result['ah'] = $list['ah'];
            $result['sjr'] = $list['sjr_name'];
            $result['ygid'] = $list['gh'];

            $result['state'] = 1;


        }else{

            $result['state'] = 0;  //代表失败, 此二维码无效，非铉盈生成
            $result['info'] = '二维码信息无效';  //代表失败, 此二维码无效，非铉盈生成
        }

    }else{

        $result['state'] = 0;  //代表失败，未传递二维码参数
        $result['info'] = '缺少有效参数';
    }


    echo json_encode($result);

?>