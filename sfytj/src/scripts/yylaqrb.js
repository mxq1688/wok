'use strict';

 /* 民商事一审 提交案件 点击确认提交清除导航条步骤cookie */
$(".mss_yylaqrb #btn_qrtj").click(function () {
            var bg_list_data = (getCookie("bg_list_data"));
            var dsr_list_data = (getCookie("dsr_list_data"));
            var yg_list_data = (getCookie("yg_list_data"));
            var bg_dlr_list_data = (getCookie("bg_dlr_list_data"));
            var yg_dlr_list_data = (getCookie("yg_dlr_list_data"));
            var httpurl=global_data.httpurl;
            var form_data = JSON.stringify(get_lasq_form_base());
            var user_token = getCookie("user_token");
            open_modal("<span class='font_bigger'>正在提交数据，请稍等...</span>","正在提交",function(){},"请稍等","static");

            var wyla_begintime = localStorage.getItem("wyla_begintime") || "";

            // 提交立案
            submit_yyla_ajax(bg_list_data,dsr_list_data,yg_list_data,bg_dlr_list_data,yg_dlr_list_data,httpurl,form_data,user_token,0, wyla_begintime);
    
});
 // 执行案件

$(".zxaj_yylaqrb #btn_qrtj").click(function () {
    var bg_list_data = (getCookie("bg_list_data_zxaj"));
    var dsr_list_data = (getCookie("dsr_list_data_zxaj"));
    var yg_list_data = (getCookie("yg_list_data_zxaj"));
    var bg_dlr_list_data = (getCookie("bg_dlr_list_data_zxaj"));
    var yg_dlr_list_data = (getCookie("yg_dlr_list_data_zxaj"));
    var httpurl=global_data.httpurl;
    var form_data = JSON.stringify(get_lasq_form_base_zxaj());
    var user_token = getCookie("user_token");
    open_modal("<span class='font_bigger'>正在提交数据，请稍等...</span>","正在提交",function(){},"请稍等","static");

    var wyla_begintime = localStorage.getItem("wyla_begintime") || "";

    // 提交立案
    submit_yyla_ajax(bg_list_data,dsr_list_data,yg_list_data,bg_dlr_list_data,yg_dlr_list_data,httpurl,form_data,user_token,1, wyla_begintime);
});

//行政案件
$(".xzaj_yylaqrb #btn_qrtj").click(function () {
    var bg_list_data = (getCookie("bg_list_data_xzaj"));
    var dsr_list_data = (getCookie("dsr_list_data_xzaj"));
    var yg_list_data = (getCookie("yg_list_data_xzaj"));
    var bg_dlr_list_data = (getCookie("bg_dlr_list_data_xzaj"));
    var yg_dlr_list_data = (getCookie("yg_dlr_list_data_xzaj"));
    var httpurl=global_data.httpurl;
    var form_data = JSON.stringify(get_lasq_form_base_xzaj());
    var user_token = getCookie("user_token");
    open_modal("<span class='font_bigger'>正在提交数据，请稍等...</span>","正在提交",function(){},"请稍等","static");

    var wyla_begintime = localStorage.getItem("wyla_begintime") || "";

    // 提交立案
    submit_yyla_ajax(bg_list_data,dsr_list_data,yg_list_data,bg_dlr_list_data,yg_dlr_list_data,httpurl,form_data,user_token,2, wyla_begintime);
});


// 打印立案确认表
     function start_print(print_url){
      open_modal("正在准备打印，请稍等...","正在准备",function(){
           $('.tip_modal', window.top.document).modal('hide');
                          setTimeout(function(){
                            window.top.document.LightControl.PowerOff(3);   
                            },200);
        },"请稍等","static");   
        var modal_content = $('.tip_modal .modal_info', window.top.document);
       var modal_title = $('.tip_modal .modal_title', window.top.document);
       var modal_btn = $('.tip_modal .modal_confirm', window.top.document); 
       window.top.document.LightControl.PowerOn(3);
       setTimeout(function(){
           var  httpprinturl = global_data.httpprinturl;
                // A4_print('http://115.28.73.220/sfytj/dist/html/ssfw/wsla/yylasq/table.html');       
                // var i = ReceiptPrinter.Print_html(httpprinturl+"sfytj/dist/html/ssfw/wsla/yylasq/mssys/table.html");
                var i = ReceiptPrinter.Print_html(httpprinturl+print_url);
                console.log(i);   
                if(i==0){
                     modal_content.html("<p>打印出错</p>");
                }
                else{
                   console.log("打印成功!");
                    modal_content.html("<p>正在为您打印，请在打印完毕后关闭此窗口。</p>");
                    modal_btn.html("关闭");
                     modal_title.html("<p>正在打印</p>");
                    modal_btn.click(function(){
                         $('.tip_modal', window.top.document).modal('hide');
                          setTimeout(function(){
                            window.top.document.LightControl.PowerOff(3);   
                            },200);
                    });
           
                }

      },500) ;
     }


// 预约立案确认表倒计时
    function yylaqrb_run(){
        var fatherBody = $(window.top.document.body)
        var sum = fatherBody.find("#mes").html();
        var t = setTimeout("yylaqrb_run()", 1000);
        if(sum > 1 ){
            sum--;
            fatherBody.find("#mes").html(sum);
        }else{
            clearTimeout(t);
            /* 跳转到首页 */
            $('.tip_modal', window.parent.document).modal('hide');

             setTimeout(function(){
          window.location.href='/sfytj/dist/html/common/wdaj.html';
            },300);
      
        }
    }


// ajax提交立案信息
function submit_yyla_ajax(bg_list_data,dsr_list_data,yg_list_data,bg_dlr_list_data,yg_dlr_list_data,httpurl,form_data,user_token,if_zxaj, wyla_begintime){

  setTimeout(function(){
  $.ajax({
      timeout: 120000,
      type: "post",
      async: true,
      data: "bg_list_data="+bg_list_data+"&dsr_list_data="+dsr_list_data+"&yg_list_data="+yg_list_data+"&form_data="+form_data+"&user_token="+user_token+'&bg_dlr_list_data='+bg_dlr_list_data+'&yg_dlr_list_data='+yg_dlr_list_data+'&wyla_begintime='+wyla_begintime,
      url: ""+httpurl+"ssfw/wsla/yylasq/xxtj.php",
      dataType: "json",
      success: function(data){
        console.log("提交结果：");
        console.log(data);
            var qr_code_path = '';
			var tdh_case_num = '';
            if (data.state == 1) { 
              qr_code_path = global_data.httpurl + data.path;
			        tdh_case_num = data.case_num;

            }
            if(if_zxaj==0){
              localStorage.setItem("qr_code_path",qr_code_path);
			        localStorage.setItem("tdh_case_num",tdh_case_num);
              submit_success('/sfytj/dist/html/ssfw/wsla/yylasq/mssys/yylaqrb2.html');

              setTimeout(function(){
                $('.tip_modal', window.top.document).modal('hide');
              }, 300);

            
              $('.tip_modal', window.top.document).on('hidden.bs.modal', function () {
                window.location.href='/sfytj/dist/html/ssfw/wsla/yylasq/mssys/yylaqrb2.html';
              });

            }else if(if_zxaj==1){
              localStorage.setItem("qr_code_path_zxaj",qr_code_path);

			        localStorage.setItem("tdh_case_num",tdh_case_num);

              submit_success('/sfytj/dist/html/ssfw/wsla/yylasq/zxaj/yylaqrb2.html');

              setTimeout(function(){
                $('.tip_modal', window.top.document).modal('hide');
              }, 300);

            
              $('.tip_modal', window.top.document).on('hidden.bs.modal', function () {
                window.location.href='/sfytj/dist/html/ssfw/wsla/yylasq/zxaj/yylaqrb2.html';
              });
            }else if(if_zxaj==2){
              localStorage.setItem("qr_code_path_xzaj",qr_code_path);
              localStorage.setItem("tdh_case_num",tdh_case_num);
              submit_success('/sfytj/dist/html/ssfw/wsla/yylasq/xzaj/yylaqrb2.html');
              setTimeout(function(){
                $('.tip_modal', window.top.document).modal('hide');
              }, 300);
              $('.tip_modal', window.top.document).on('hidden.bs.modal', function () {
                window.location.href='/sfytj/dist/html/ssfw/wsla/yylasq/xzaj/yylaqrb2.html';
              });
            }
       
      },
      complete: function(XMLHttpRequest,status){
          if(status == "timeout"){
            var xmlhttp = window.XMLHttpRequest ? new window.XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHttp");
            xmlhttp.abort();
            console.log("错误，超时");
            submit_error();
            
          }
            return;
      },
       error: function(XMLHttpRequest, textStatus){
          console.log("服务器错误");
          submit_error();
          return;
      }

    }); 

},500);

}
// ======================================================
    function clear_xzaj_info(){
         // 清除行政案件相关cookie   
             clearCookie("last_step_xzaj");
             clearCookie("yylasq_form_base_xzaj");

             clearCookie("bg_list_data_xzaj");
             clearCookie("yg_list_data_xzaj");
             clearCookie("dsr_list_data_xzaj");
             clearCookie("yg_dlr_list_data_xzaj");
             clearCookie("bg_dlr_list_data_xzaj");
             clearCookie("yylasq_xzfy_xzaj");
             clearCookie("user_token");
             clearCookie("file_form");

             //清除保存的可选、必选材料文件名
             localStorage.removeItem("file_bxcl_list_xzaj");
             localStorage.removeItem("file_kxcl_list_xzaj");
             localStorage.removeItem('data_sum_max_xzaj');
             
             //清楚二维码图片信息
             localStorage.removeItem("qr_code_path_xzaj");

    }
    // ====================================================================
    function clear_zxaj_info(){
         // 清除执行案件相关cookie   
             clearCookie("last_step_zxaj");
             clearCookie("yylasq_form_base_zxaj");

             clearCookie("bg_list_data_zxaj");
             clearCookie("yg_list_data_zxaj");
             clearCookie("dsr_list_data_zxaj");
             clearCookie("yg_dlr_list_data_zxaj");
             clearCookie("bg_dlr_list_data_zxaj");
             clearCookie("yylasq_xzfy_zxaj");
             clearCookie("user_token");
             clearCookie("file_form");

             //清除保存的可选、必选材料文件名
             localStorage.removeItem("file_bxcl_list_zxaj");
             localStorage.removeItem("file_kxcl_list_zxaj");
             localStorage.removeItem('data_sum_max_zxaj');
             
             //清楚二维码图片信息
             localStorage.removeItem("qr_code_path_zxaj");

    }
    function clear_mssys_info(){
             // 清除民商事一审案件相关cookie   
             console.log("清除开始  ");
             clearCookie("last_step");
             clearCookie("yylasq_form_base");

             clearCookie("bg_list_data");
             clearCookie("dsr_list_data");
             clearCookie("yg_list_data");
             clearCookie("yg_dlr_list_data");
             clearCookie("bg_dlr_list_data");
             clearCookie("yylasq_xzfy");
             clearCookie("user_token");
             clearCookie("file_form");  
            // 清除保存的可选、必选材料文件名
             localStorage.removeItem("file_bxcl_list");
             localStorage.removeItem("file_kxcl_list");
             localStorage.removeItem('data_sum_max');

             //清楚二维码图片信息
             localStorage.removeItem("qr_code_path");
             console.log("清除结束");
    }