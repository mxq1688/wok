<?php
/*取件二维码登录，查询是否有效，并返回柜号
 $type  1 二维码 2 验证码
*/
include ('../common/global.php');
$result = array();
$content = _request('content');
$court_num = _request('court_num');
$type = _request('type');

//通过court_num 获取court_id
$court_id = get_court_id_by_num($court_num,$mysql);

if ($content||$court_num||$type) {
    if ($type == 1) {
        $sql = "validid = $content ";
    } else {
        $sql = "identifying_code = $content ";
    }
    $sql .= "and court_id=$court_id";
    
    $list = $mysql->select_one('qr_code','*',$sql);
    if ($list['state']==1) {
        $box = $mysql->select_one('yg_box','*','id='.$list['yg_box_id']) ;
        if($box['state']==2){
            //正常使用云柜
            $result['xylsh'] = $box['xylsh'];
            $result['box_num'] = $box['number'];
            $result['state'] = 1;
            $result['qr_code_id'] = $list['id'];
        }else{
            $result['state'] = 0; 
            $result['info'] = '二维码信息无效，云柜是空的'; 
        }
    } else {
        $result['state'] = 0; 
        $result['info'] = '二维码信息已失效'; 
    }
} else {
    $result['info'] = '缺少有效参数';
}

echo json_encode($result);

?>