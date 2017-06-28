<?php 
   include('./global.php');
   include('./tjaj.php');
   header("Content-Type:text/html;charset=gb2312");
   
   $redis = new redis();  
   $redis->connect('127.0.0.1', 6379); 
   
   $redis->delete('test');  
   while(True){
       // echo $redis->lsize("test");exit;
      if($redis->lsize("test")>0){
          //取到第一个值
          //$a= $redis->sort("test");
          //$c = count($a);
          $first_value = $redis->lget("test",0);
          $len = $redis->lsize("test");
          $is_lock = false;
          $key = 'suo';
        //  if(!$is_lock){
               if($first_value){
              // $foo = new Foo();
                try{
                  $lock_state = lock_state($first_value,$mysql);
                  echo 'lock='.$lock_state;
                  if($lock_state){
                    if($len>1){
                        $first_value = $redis->lget("test",1);
                    }
                  }
                  
                  echo 'id='.$first_value.'bg_time='.time();
                  
                  $state = tjaj($first_value,$mysql,$api,$baseytj);
                 // $is_lock = lock($redis,$key, 5);
                  if($state){
                    $redis->lpop("test");
                    redis_log("[id=$first_value]第一次提交案件成功");
                    $len = $len - 1;
                    redis_log("等待队列：$len");
                    echo "等待队列：$len 当前id=$first_value 第一次提交成功\r\n";
                    unlock($redis,$key);
                    
                  }else{
                      
                      redis_log("[id=$first_value]第一次提交案件失败");
                      redis_log("等待队列：$len");
                      echo "等待队列：$len 当前id=$first_value 第一次提交失败\r\n";
        
                      $state = tjaj($first_value,$mysql,$api,$baseytj);
                      if($state){
                        $redis->lpop("test");
                        redis_log("[id=$first_value]第二次提交案件成功");
                        $len = $len - 1;
                        redis_log("等待队列：$len");
                        echo "等待队列：$len 当前id=$first_value 第二次提交成功\r\n";
                      //  unlock($redis,$key);
                      }else{
                        redis_log("[id=$first_value]第二次提交案件失败");
                        redis_log("等待队列：$len");
                        echo "等待队列：$len 当前id=$first_value 第二次提交失败\r\n";
 
                        $state = tjaj($first_value,$mysql,$api,$baseytj);
                        if($state){
                            $redis->lpop("test");
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
                          //  unlock($redis,$key);
                            
                        }
                        
                      }
                        
                  }
                 

                }catch(Exception $e){
                  // $foo->info("[id=$first]提交案件失败");
                 }
              }
        //  }
      
      }else{
           $sql = "select id from ssfw_case_handle where is_tdh_suc=0 and is_handle_suc=0";
           $list = $mysql->get_all($sql);
           //$list = array(9009,9010,9011,9012,9013);
           rsort($list);
           if($list){
             foreach($list as $val){
                $redis->lpush("test",$val['id']);  
             }
           }
      }
      
      sleep(5);
   }
            

      


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