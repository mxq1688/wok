'use strict';

/* 收藏案件 */

function scaj(){
    var sc_cx_account = localStorage.getItem("sc_cx_account");
    var sc_cx_password = localStorage.getItem("sc_cx_password");
    var sc_cx_type = localStorage.getItem("sc_cx_type");  //查询类型 1 预约案件 2 阅卷 3 已受理
    var sc_cx_name = localStorage.getItem("sc_cx_name");
    var sc_cx_login_type = localStorage.getItem("sc_cx_login_type");//登录类型 1 帐号 2 手机
    var user_id = localStorage.getItem("user_id");
    var sc_cx_lsh = localStorage.getItem("sc_cx_lsh");
    var sc_cx_xh = localStorage.getItem("sc_cx_xh");
    var httpurl=global_data.httpurl;

    //请求立案确认表中的本地立案数据
    ajax(
            ""+httpurl+"/wdaj/scaj.php",
            "sc_cx_account="+sc_cx_account+"&sc_cx_password="+sc_cx_password+"&sc_cx_type="+sc_cx_type+"&sc_cx_name="+sc_cx_name+"&sc_cx_login_type="+sc_cx_login_type+'&user_id='+user_id+'&sc_cx_lsh='+sc_cx_lsh+'&sc_cx_xh='+sc_cx_xh,
            function(data){
                if(data.state==1){
                    open_modal('该案件收藏成功');
                }else if(data.state==2){
                    open_modal('该案件已经收藏');
                }else if(data.state==0){
                    open_modal('该案件收藏失败');
                }
            }
    );
}

/* 案件删除 */
function delaj(id,type){
    var httpurl=global_data.httpurl;
    ajax(
            ""+httpurl+"/wdaj/delaj.php",
            "id="+id+"&type="+type,
            function(data){
                //隐藏取消按钮
                var fatherBody = $(window.top.document.body);
                var modal_close = fatherBody.find('.id_modal_close .tip_modal .modal_close');
                modal_close.hide();
                
                if(data.state==1){
                    //隐藏该条记录
                    var val_selected = $(".panel-collapse.collapse.in");
                    val_selected.parent().remove();
                    
                    //案件总数减1
                    if(type==1){
                        var lajzcx_count = $("#lajzcx_count").text();
                        lajzcx_count = parseInt(lajzcx_count)-1;
                        $("#lajzcx_count").text(lajzcx_count)
                        
                    }else if(type==2){
                        var yjjzcx_count = $("#yjjzcx_count").text();
                        yjjzcx_count = parseInt(yjjzcx_count)-1;
                        $("#yjjzcx_count").text(yjjzcx_count)
                    }else if(type==3){
                        var slajcx_count = $("#slajcx_count").text();
                        slajcx_count = parseInt(slajcx_count)-1;
                        $("#slajcx_count").text(slajcx_count)
                    }
                    
                    
                    open_modal_close('该案件删除成功');
                }else if(data.state==0){
                    open_modal_close('该案件删除失败');
                }
            }
    );  
      
}