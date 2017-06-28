<?php 
   include('global.php');
   
   $sql = "select * from ssfw_case_handle where  id ='502'";
   $list = $mysql->get_one($sql);
   
   $arr = array(9009,9010,9011,9012,9013);
   rsort($arr);
   
   $redis = new redis();  
   $redis->connect('127.0.0.1', 6379); 
  // $redis->delete('test');  
  // $redis->LSET("test",4,6);
   echo  $redis->lsize("test");exit;
   //$a = $redis->sort("test");
   
   //LSET key index value 
   if($redis->lsize("test")>0){
    
   }else{
      if($arr){
        foreach($arr as $val){
            $redis->lpush("test",$val);  
        }
      }
   }

//print_r($redis->sort('test'));
   // $a = $redis->sort('test');
   

//$array_mset=$arr;
//$redis->mset($array_mset); #用MSET一次储存多个值
//$array_mget=array('0');
//$redis->del($array_mget); #同时删除多个key
//
//$array_mget=array('0','1','2');
//
//var_dump($redis->mget($array_mget));
//var_dump($redis->mget($array_mget)); #一次返回多个值 //array(3) { [0]=> string(9) "first_val" [1]=> string(10) "second_val" [2]=> string(9) "third_val" }

//print_r($redis->lsize('test1')); 
    
    //print_r($redis->sort('test'));
   // $a = $redis->sort('test');



?>