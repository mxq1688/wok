<?php

echo 33;
exit;
 include('./common/global.php');
 

//插入
$data = array(
    'title'=>101,
    'content'=>123456,
    'hits'=>'2',
    'create_time'=>time(),
    );
$list = $mysql->query('select * from ssfw_user');
print_R($list);exit;
//查询
$res = $mysql->field(array('sid','aa','bbc'))
    ->order(array('sid'=>'desc','aa'=>'asc'))
    ->where(array('sid'=>"101",'aa'=>array('123455','>','or')))
    ->limit(1,2)
    ->select('t_table');
$res = $mysql->field('sid,aa,bbc')
    ->order('sid desc,aa asc')
    ->where('sid=101 or aa>123455')
    ->limit(1,2)
    ->select('t_table');
//获取最后执行的sql语句
$sql = $mysql->getLastSql();
//直接执行sql语句
$sql = "show tables";
$res = $mysql->doSql($sql);
//事务
$mysql->startTrans();
$mysql->where(array('sid'=>102))->update('t_table',array('aa'=>666666));
$mysql->where(array('sid'=>103))->update('t_table',array('bbc'=>'呵呵8888呵呵'));
$mysql->where(array('sid'=>104))->delete('t_table');
$mysql->commit();
 ?>