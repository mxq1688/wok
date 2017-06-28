<?php
	/*当事人操作：取件，存件，改件： 返回前台显示的案件信息*/
	include('../common/global.php');
      $result = array();

      $id = _request('case_id');
      $user_name = _request('user_name');
      $identity = _request('identity');
      $user_id = _request('user_id');

      if ($id && $identity && $user_id) { 	
    		//根据流水号获取案件信息： 案件名称，案件类型，立案日期 （根据铉盈流水号）
	      $aj_sql = "select case_title,type,create_time,judge_name,ah from ssfw_case_handle where id=".$id;
	      $aj_list = $mysql -> get_one($aj_sql);
	      if ($aj_list) {
	        	$result['ajmc'] = $aj_list['case_title'];
	        	$result['ajlx'] = $aj_list['type'];
	        	$result['larq'] = date("Y-m-d H:i",$aj_list['create_time']);
	    		$judge_name = $aj_list['judge_name'];
	    		$result['ah'] = $aj_list['ah'];
	    	}

	    	//获取收件人和发件人信息
	    	$sql = "select id,sjr_id,fjr_id,ygid,sjr_identity,fjr_identity,sjr_name,fjr_name from ssfw_yg_state where case_id=".$id;
    		$list = $mysql -> get_one($sql);  

	    	if ($list) {
	    		//存在此案件记录
	    		$fjr_id = $list['fjr_id'];
	    		// $fjr_identity = $list['fjr_identity'];
	    		$fjr_name = $list['fjr_name'];

	    		$sjr_id = $list['sjr_id'];
	    		// $sjr_identity = $list['sjr_identity'];
	    		$sjr_name = $list['sjr_name'];

		    	$result['fjr_id'] =  $fjr_id;
		    	$result['fjr'] = $fjr_name;
		    	$result['sjr_id'] =  $sjr_id;
		    	$result['sjr'] = $sjr_name;
		    	$result['fjr_identity'] = $list['fjr_identity'];
		    	$result['sjr_identity'] = $list['sjr_identity'];
		    	// if ($fjr_identity == 1) {
		    	// 	$result['fjr_identity'] = "原告/原告代理人";
		    	// } else if ($fjr_identity == 2) {
		    	// 	$result['fjr_identity'] = "被告/原告代理人";
		    	// } else if ($fjr_identity == 3) {
		    	// 	$result['fjr_identity'] = "第三人";
		    	// } else if ($fjr_identity == 4) {
		    	// 	$result['fjr_identity'] = "法官";
		    	// }

		    	// if ($sjr_identity == 1) {
		    	// 	$result['sjr_identity'] = "原告/原告代理人";
		    	// } else if ($sjr_identity == 2) {
		    	// 	$result['sjr_identity'] = "被告/原告代理人";
		    	// } else if ($sjr_identity == 3) {
		    	// 	$result['sjr_identity'] = "第三人";
		    	// } else if ($sjr_identity == 4) {
		    	// 	$result['sjr_identity'] = "法官";
		    	// }

		    	if ($sjr_id == $user_id && $list['sjr_identity'] == $identity) {
		    		//收件人是当事人：取件
		    		$result['operation'] = '取件'; //取件
		    		$result['ygid'] = $list['ygid'];
		    	} else if ($fjr_id == $user_id && $list['fjr_identity'] == $identity) {
		    		//发件人是当事人：改件
		    		$result['operation'] = '改件'; //改件
		    		$result['ygid'] = $list['ygid'];
		    	} else {
		    		//收件人和发件人都不是当事人：存件
		    		$result['operation'] = '存件'; //存件
		    		//选取一个空白的柜子
		           	$gz_sql = "select number from ssfw_yg_configuration where number not in (select ygid from ssfw_yg_state) order by id";
		             $gz_list = $mysql -> get_one($gz_sql);
		           	if ($gz_list) {
		                   $result['ygid'] = $gz_list['number'];
		             }
		    	}
		} else {
		    	//不存在此案件记录：存件
		    	$result['operation'] = '存件'; //存件
		    	//选取一个空白的柜子
		      $gz_sql = "select number from ssfw_yg_configuration where number not in (select ygid from ssfw_yg_state) order by id";
		      $gz_list = $mysql -> get_one($gz_sql);
		      if ($gz_list) {
		           $result['ygid'] = $gz_list['number'];
		      }
		      $result['fjr'] = $user_name;
		      $result['fjr_id'] =  $user_id;
		      $result['fjr_identity'] = $identity;
		     //  if ($identity == 1) {
		    	// 	$result['fjr_identity'] = "原告/原告代理人";
		    	// } else if ($identity == 2) {
		    	// 	$result['fjr_identity'] = "被告/原告代理人";
		    	// } else if ($identity == 3) {
		    	// 	$result['fjr_identity'] = "第三人";
		    	// } else if ($identity == 4) {
		    	// 	$result['fjr_identity'] = "法官";
		    	// }

		      if ($judge_name) {
		        	$result['sjr'] = $judge_name;
		      } else {
		        	$result['sjr'] = "法官";
		      }
		      //收件人id 法官的信息？需要重新考虑 或者法官登录的时候记录
		      $result['sjr_id'] = 0;
		      $result['sjr_identity'] ="4";
		}
		$result['state'] = '1';  //代表成功
	} else {
		$result['state'] = '0';  
		$result['info'] = '缺少有效参数';  
	}

     echo json_encode($result);
?>