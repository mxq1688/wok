<?php 
   include('./global.php');
   include('./tjaj.php');
   //include('./RedisLock.class.php');
   header("Content-Type:text/html;charset=gb2312");
   
   
   $redis = new redis();  
   $redis->connect('127.0.0.1', 6379); 
     
   //$redis->delete('test');  
   while(True){
       // echo $redis->lsize("test");exit;
      if($redis->lsize("test")>0){

          //$a= $redis->sort("test");
          //$c = count($a);
          $first_value = $redis->lget("test",0);
          $len = $redis->lsize("test");
         // echo $redis->get('num1');exit;
          if($first_value){
            
            $is_lock = false;
            if(!$is_lock){
             
              // $foo = new Foo();
                try{
                  $state = tjaj($first_value,$mysql,$api,$baseytj);
                  $is_lock = lock($redis,$key, 5);
                  
                  if($state){
                    
                   // $redis->watch("test");  
                   // $redis->multi();
                    $redis->lpop("test");
                  //  $redis->exec();
                  //  $redis->UNWATCH("test");  
                    redis_log("[id=$first_value]第三次提交案件成功");
                        $len = $len - 1;
                        redis_log("等待队列：$len");
                        echo "等待队列：$len 当前id=$first_value 第三次提交成功\r\n";
                        unlock($redis,$key);
                    }else{
                        $redis->lpop("test");
                        redis_log("[id=$first_value]第三次提交案件失败");
                        $len = $len - 1;
                        redis_log("等待队列：$len");
                        echo "等待队列：$len 当前id=$first_value 第三次提交失败\r\n";
                        unlock($redis,$key);
                        
                    }
                 

                }catch(Exception $e){
                  // $foo->info("[id=$first]?????????");
                 }
              //  sleep(10);
             //   unlock($redis,$key);
            }
          }
      
      }else{
       
           //$arr = array(9009,9010,9011,9012,9013);
//           rsort($arr);
//           if($arr){
//             foreach($arr as $val){
//                $redis->lpush("test",$val);  
//             }
//           }
      }
      
      sleep(5);
   }
            




//$array_mset=$arr;
//$redis->mset($array_mset); #??MSET??δ??????
//$array_mget=array('0');
//$redis->del($array_mget); #????????key
//
//$array_mget=array('0','1','2');
//
//var_dump($redis->mget($array_mget));
//var_dump($redis->mget($array_mget)); #??η?????? //array(3) { [0]=> string(9) "first_val" [1]=> string(10) "second_val" [2]=> string(9) "third_val" }

//print_r($redis->lsize('test1')); 
    
    //print_r($redis->sort('test'));
   // $a = $redis->sort('test');



?>