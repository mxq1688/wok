<?php 

   include('../../../common/global.php');

   header('Content-type: text/html');

   
   $result= array();
   $case_num = del_yinhao(_request('case_num')); 
   $case_h_sql = 'select case_num,id from ssfw_case_handle where  id = '."'$case_num' order by id desc" ;
   $case_h_list = $mysql->get_one($case_h_sql);
   
//   if($case_h_list){
//    
//       $sql = 'select id from ssfw_case_handle where tdh_case_num = '."'$case_num'".' and id<'.$case_h_list['id'];
//          
//       $list_qr = $mysql->get_one($sql);
//      
//       if($list_qr){
//           $data = array();
//           $data['is_tdh_del'] = 1;
//           //将所有的置为删除
//           $sql = 'update ssfw_case_handle set is_tdh_del =1 where  tdh_case_num = '."$case_num".' and id<'.$case_h_list['id'];
//           $mysql->query($sql);
//           // $mysql->update('ssfw_case_handle',$data,'id='.$list_qr['id']);
//       }
//       
//   }
   
  // $case_h_list['case_num'] = '160420153848122397'; 
   if($case_h_list['case_num']!=''){
     
     $case_num = $case_h_list['case_num'];
     //原告信息
      $yg_sql = 'select name,character_type,nation,mobile,address,identity_num,nationality,company_name,sex,zj_type,zj_code from ssfw_case_user where type=1 and case_num = '."'$case_num' order by id desc" ;
      $yg_list = $mysql->get_all($yg_sql);
      if(!$yg_list){
        $yg_list = array();
      }   
     
      //被告信息
      $bg_sql = 'select name,character_type,nation,mobile,address,identity_num,nationality,company_name,sex,zj_type,zj_code from ssfw_case_user where type=2 and case_num = '."'$case_num' order by id desc" ;
      $bg_list = $mysql->get_all($bg_sql);
      if(!$bg_list){
        $bg_list = array();
      }  
       //print_R($bg_list);exit;
      //第三人信息
      $dsr_sql = 'select name,character_type,nation,mobile,address,identity_num,nationality,company_name,sex,zj_type,zj_code from ssfw_case_user where type=3 and case_num = '."'$case_num' order by id desc" ;
      $dsr_list = $mysql->get_all($dsr_sql);
      if(!$dsr_list){
        $dsr_list = array();
      } 
      //代理人信息
      $dlr_sql = 'select name,nation,mobile,address,identity_num,nationality,company_name,user_type,zj_type,zj_code,daiid from ssfw_case_user where type=4 and case_num = '."'$case_num' order by id desc" ;
      $dl = $mysql->get_all($dlr_sql);
      if(!$dl){
        $dlr_list = array();
      }else{
        $dlr_list = array();
        foreach($dl as $key =>$val){
            $dlr_list[$key] = $val;
            if($val['daiid']!=''){
                $id = $val['daiid'];
                $sql = 'select name,type from ssfw_case_user where id = '."'$id'" ;
                $list_d = $mysql->get_one($sql);
                if($list_d){
                    $dlr_list[$key]['dl_name'] = $list_d['name'];
                    if($list_d['type']==1){
                        $dlr_list[$key]['ssdw'] = 1;
                    }else if($list_d['type']==2){
                        $dlr_list[$key]['ssdw'] = 2;
                    }
                    
                }else{
                    $dlr_list[$key]['dl_name'] = '暂无';
                    $dlr_list[$key]['ssdw'] = 0;
                }
            }else{
                $dlr_list[$key]['ssdw'] = 0;
                $dlr_list[$key]['dl_name'] = '暂无';
            }
            
        }
      } 
      
      
      $ch_sql = 'select court_name,case_action_name,mobile,user_id,path,case_user_pwd,tdh_case_num from ssfw_case_handle where case_num = '."'$case_num' " ;
      $ch_list = $mysql->get_one($ch_sql);
      if(!$ch_list){
        $ch_list = array();
      }
      $action_sql = 'select apply_money,litigation_request,la_identity from ssfw_case where yu_case_num = '."'$case_num'";
      $action_list = $mysql->get_one($action_sql);
      
      //申请人信息
      $user_id = '';
      if($ch_list){
        $user_id = $ch_list['user_id'];
      }
      $user_list = array();
      if($user_id){
         $user_sql = 'select identity_num,name from ssfw_litigation_user where id = '."'$user_id' " ;
         $user_list = $mysql->get_one($user_sql);
      }
      //二维码加上图片
      if($ch_list['path']!=''){
        $ch_list['path'] = $baseytj.'/'.$ch_list['path'];
      }
      
      
      $list['list'] = array_merge($ch_list,$action_list,$user_list);
      $list['bg_list'] = $bg_list;
      $list['yg_list'] = $yg_list;
      $list['dsr_list'] = $dsr_list;
      $list['dlr_list'] = $dlr_list;
    
      //print_R($result);
      
       $result= array();
       $mz_sql = "select * from  ssfw_ziliao where type=1";
       $mz_list = $mysql->get_all($mz_sql);
       
       $gj_sql = "select * from  ssfw_ziliao where type=2";
       $gi_list = $mysql->get_all($gj_sql);
       
       
       $mz_arr = array();
       if($mz_list){
         foreach($mz_list as $key=>$val){
            $id = $val['daihao'].'-'.$val['num'];
            $mz_arr[$key]['id'] = $id;
            $mz_arr[$key]['name'] = $val['name'];
         }
       }
       
       $gj_arr = array();
       if($gi_list){
         foreach($gi_list as $key=>$val){
            $id = $val['daihao'].'-'.$val['num'];
            $gj_arr[$key]['id'] = $id;
            $gj_arr[$key]['name'] = $val['name'];
         }
       }
    
       $arr = array();
       $arr['mz_data'] = $mz_arr;
       $arr['gj_data'] = $gj_arr;
      
  }

   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Expires" content="0"/> 
    <title>自助立案确认表</title>
       <link rel="stylesheet" type="text/css" href="/sfytj/bower_components/table.css"/>
</head> 
<!--自助立案确认表-->
<body>
<div class="yylaqrb_table" >
    <div class="wrap">  
        <!--主要内容-->
        <div class="title font_header" style="overflow-y: auto!important; max-height: none!important; ">自助立案确认表</div>
        <div class="qr_table " style="font-size:16px">
            <!-- <table border="1">-->
            <table class="table table-bordered">
                
                <tr>
                    <td class="headline">受理法院</td>
                    <td id="slfy" class="fs"></td>
                    <td rowspan="2" class="fs fs1 ">快速查询二维码:
                        <br><span style="font-size:12px">(可在“我要查询”模块扫描此二维码)</span></td>
                    <td rowspan="2"  style=" text-align: center;"><div id="erweima"><img /></div></td>

                </tr>
                <tr>
                    <td class="headline">案由</td>
                    <td id="ay" class="fs"></td>

                </tr>
                <tr>
                    <td class="headline">案件标的</td>
                    <td id="ajbd" class="fs"></td>
                    <td class="headline">申请人</td>
                    <td id="sqrmx" class="fs"></td>
                </tr>
                <tr>

                </tr>
                <!--申请人信息-->
                <tr>
                    <td class="headline">立案身份</td>
                    <td id="lasf" class="fs"></td>
                    <td class="headline">身份证</td>
                    <td id="sqrsfz" class="fs"></td>
                </tr>
                <tr>
                    <td class="headline">联系方式</td>
                    <td id="lxfs" class="fs"></td>
                    <!-- <td class="headline">邮箱</td>
                    <td id="email" class="fs"></td> -->
                    <td class="headline">诉讼与事实请求</td>
                    <td id="susongqq" class="fs susongqq"></td>
                </tr>
                <!-- <tr>
                    <td class="headline">诉讼与事实请求</td>
                    <td id="susongqq" colspan="3" class="fs susongqq"></td>
                </tr> -->
                <!-- <tr>
                    <td class="fgx" colspan="4"></td>
                </tr> -->
            </table>
        </div>

        </div>
    </div>


<script type="text/javascript" src="/sfytj/bower_components/table.js"></script>
<script type="text/javascript" src="/sfytj/bower_components/zepto.js"></script>
<script type="text/javascript">

    var country_code = JSON.parse(localStorage.getItem("country_code")); 
	var nation_code = JSON.parse(localStorage.getItem("nation_code"));;

	if(country_code == null || nation_code == null) {
		
		country_code = <?php echo json_encode($arr['gj_data']);?>;
		nation_code = <?php echo json_encode($arr['mz_data']);?>;

		localStorage.setItem("country_code", JSON.stringify(country_code));
		localStorage.setItem("nation_code", JSON.stringify(nation_code));
	
	}

        function init_people_info() {
            
            var ajxq_local = <?php echo json_encode($list['list']);?>;

            //当事人数组
            var bg_list_data = <?php echo json_encode($list['bg_list']);?>;
            var dsr_list_data = <?php echo json_encode($list['dsr_list']);?>;
            var yg_list_data = <?php echo json_encode($list['yg_list']);?>;
            //代理人数组
            var dlr_list_data = <?php echo json_encode($list['dlr_list']);?>;

            init_baseinfo(ajxq_local);
            //添加原告、被告、第三人列表
            add_table_bg_or_dsr(yg_list_data, 1);
            add_table_bg_or_dsr(bg_list_data, 2);
            add_table_bg_or_dsr(dsr_list_data, 3);
            
            //添加代理人列表
            add_table_dlr(dlr_list_data);
        
        }
        
        //基本信息列表赋值
        function init_baseinfo(baseinfo){
            if(baseinfo!=null){
                $("#cxzh").html(baseinfo.tdh_case_num);
                $("#cxmm").html(baseinfo.case_user_pwd);
                $("#slfy").html(baseinfo.court_name);
                $("#ay").html(baseinfo.case_action_name);
                $("#ajbd").html(baseinfo.apply_money+"元");
                $("#sqrmx").html(baseinfo.name);
                $("#lasf").html(baseinfo.la_identity);
                $("#sqrsfz").html(baseinfo.identity_num);
                $("#lxfs").html(baseinfo.mobile);
                $("#susongqq").html(baseinfo.litigation_request);
                $("#erweima").html("<img src="+baseinfo.path+">");
            }
        
        }
            
            //添加原告/被告/第三人列表
        function add_table_bg_or_dsr(list_data, index){
        
            if(list_data!=null && list_data.length>0){
                var html = "";
                $.each(list_data, function(n, value){
                   
                    if(value.character_type=="09_01001-1"){   //自然人
                        html+="<tr>";
                        if(index==1){
                            html+="<td class=\"headline\">原告"+(n+1);
                        }else if(index==2){
                            html+="<td class=\"headline\">被告"+(n+1);
                        }else if(index==3){
                            html+="<td class=\"headline\">第三人"+(n+1);
                        }
                        
                        html+="("+check_type(value.character_type)+")";
                        html+="</td>";
                        html+="<td class=\"fs\">"+value.name+"</td>";
                        html+="<td class=\"headline\">身份证</td>";
                        if(value.identity_num!=""){
                            html+="<td class=\"fs\">"+value.identity_num+"</td>";
                        }else{
                            html+="<td class=\"fs\">-</td>";
                        }
                        html+="</tr>"
        
        
                        html+="<tr>";
                        html+="<td class=\"headline\">联系方式</td>";
                        if(value.mobile!=""){
                          html+="<td class=\"fs\">"+value.mobile+"</td>";
                        }else{
                            html+="<td class=\"fs\">-</td>";
                        }
                        html+="<td class=\"headline\">立案身份</td>";
                        if(index==1){
                            html+="<td class=\"fs\">原告</td>";
                        }else if(index==2){
                            html+="<td class=\"fs\">被告</td>";
                        }else if(index==3){
                            html+="<td class=\"fs\">第三人</td>";
                        }
                        html+="</tr>";
        
        
                        html+="<tr>";
                        html+="<td class=\"headline\">国籍</td>";
                        html+="<td class=\"fs\">"+check_country(value.nationality)+"</td>";
                        html+="<td class=\"headline\">民族</td>";
                        html+="<td class=\"fs\">"+check_nation(value.nation)+"</td>";
                        html+="</tr>";
        
                        html+="<tr>";
                        html+="<td class=\"headline\">地址</td>";
                        html+="<td colspan=\"3\" class=\"fs \">"+value.address+"</td>";
                        html+="</tr>";
        
                    }else if(value.character_type=="09_01001-2" || value.character_type=="09_01001-3"){   //法人或非法人
                        html+="<tr>";
                        if(index==1){
                            html+="<td class=\"headline\">原告"+(n+1);
                        }else if(index==2){
                            html+="<td class=\"headline\">被告"+(n+1);
                        }else if(index==3){
                            html+="<td class=\"headline\">第三人"+(n+1);
                        }
                        html+="("+check_type(value.character_type)+")";
                        html+="</td>";
                        html+="<td class=\"fs\">"+value.company_name+"</td>";
                        html+="<td class=\"headline\">联系电话</td>";
                        if(value.mobile!=""){
                            html+="<td class=\"fs\">"+value.mobile+"</td>";     
                        }else{
                            html+="<td class=\"fs\">-</td>";
                        }
                        html+="</tr>";
        
                        html+="<tr>";
                        html+="<td class=\"headline\">所在地址</td>";
                        html+="<td class=\"fs\">"+value.address+"</td>";
                        html+="<td class=\"headline\">法定代表人</td>"
                        if(value.name!=""){
                            html+="<td class=\"fs\">"+value.name+"</td>";
                        }else{
                            html+="<td class=\"fs\">-</td>";
                        }
                        html+="</tr>";
        
                        html+="<tr>"
                        html+="<td class=\"headline\">证件类型</td>"
                        html+="<td class=\"fs\">"+get_dlr_zjzl(value.zj_type)+"</td>";
                        html+="<td class=\"headline\">证件号码</td>"
                        html+="<td class=\"fs\">"+value.zj_code+"</td>";
                        html+="</tr>"
                    } 
                });
        
                $(".table-bordered").append(html);
            }
        }
                    
        
         //添加代理人列表
        function add_table_dlr(dlr_list_data){
              if(dlr_list_data!=null && dlr_list_data.length>0){
                  var html= "";
                  html+="<tr>";
                  html+="<td class=\"fgx\" colspan=\"4\"></td>";
                  html+="</tr>";
        
                  $.each(dlr_list_data, function(n, value){
                        html+="<tr>";
                        if(value.ssdw==1){
                            html+="<td class=\"headline\">原告告代理人"+(n+1);
                        }else if(value.ssdw==2){
                            html+="<td class=\"headline\">被告代理人"+(n+1);
                        }
                        html+="("+value.user_type+")";
                        html+="</td>";
                        html+="<td class=\"fs\">"+value.name+"</td>";
                        html+="<td class=\"headline\">代理当事人</td>";
                        html+="<td class=\"fs\">"+value.dl_name+"</td>";
                        html+="</tr>";
        
                        html+="<tr>";
                        html+="<td class=\"headline\">联系电话</td>";
                        html+="<td class=\"fs\">"+value.mobile+"</td>";
                        html+="<td class=\"headline\">地址</td>";
                        html+="<td class=\"fs\">"+value.address+"</td>";
                        html+="</tr>"
        
                        html+="<tr>";
                        html+="<td class=\"headline\">证件种类</td>";
                        html+="<td class=\"fs\">"+get_dlr_zjzl(value.zj_type)+"</td>";
                        html+="<td class=\"headline\">证件号码</td>";
                        html+="<td class=\"fs\">"+value.zj_code+"</td>";
                        html+="</tr>"
        
                        html+="<tr>";
                        html+="<td class=\"headline\">单位名称</td>";
                        html+="<td colspan=\"3\" class=\"fs\">"+value.company_name+"</td>";
                        html+="</tr>"
        
                  });
        
                  $(".table-bordered").append(html);
              }
        
        }
        
        
        var nation_code = JSON.parse(localStorage.getItem("nation_code"));
        var country_code = JSON.parse(localStorage.getItem("country_code"));
</script>
<script type="text/javascript">
    // 初始化
    $(function () {
        init_people_info();
    });
</script>
</body>
</html>



