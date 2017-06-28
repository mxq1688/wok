'use strict';
// 倒计时
var timout_timer = null;
var countdown_timer = null;

function restart_timer() {
    clearTimeout(timout_timer);
    clearTimeout(countdown_timer);
    timout_timer = setTimeout("check_useroper()", 300000);
    var countdown_num = 300;
    countdown_timer = setInterval(function() {
        countdown_num--;
        // console.log("还剩"+countdown_num+"秒退出系统");
    }, 1000);
}
/*每次跳转页面的时候，如果菜单打开则关闭菜单*/
$(function() {
    $('.loading_index', window.top.document).hide();
    var open_menu = $(window.top.document.getElementById("menu")).hasClass("active_menu");
    if (!$(".login_html")[0] && !$(".index_html")[0]) {
        if (open_menu) $(window.top.document.getElementById("menu")).removeClass("active_menu");
    }

    if (!$(".index_html")[0]) {
        $("body").click(function() {
            $(window.top.document.getElementById("menu")).removeClass("active_menu");
        });
    }
    //除登录页面、外层index页面之外，将body绑定点击、鼠标、键盘事件
    //并且开启定时器
    if (!$(".index_html")[0] && !$(".login_html")[0]) {
        // 判断不是登入页面
        if (window.top != window.self) {
            window.top.restart_timer();
            $("html").click(function() {
                window.top.restart_timer();
            });
        }
    }
    // tab切换去除url
    if ($('.my_tab_menu')[0]) {
        $('.my_tab_menu li').click(function() {
            $('.my_tab_menu .active').removeClass('active');
            var tab = $(this).data('id');
            $(".my_tab_content .tab-pane.active").removeClass('active in');
            $(".my_tab_content #" + tab).addClass('active in');
        })
    }
});
/* 页面头部退出系统方法 */
function menu_exit(title, second) {
    var httpurl = global_data.httpurl;
    //链接、按钮查看次数
    var fygk_cs = localStorage.getItem("fygk_cs") || 0;
    var ktgg_cs = localStorage.getItem("ktgg_cs") || 0;
    var ssyd_cs = localStorage.getItem("ssyd_cs") || 0;
    var flfg_cs = localStorage.getItem("flfg_cs") || 0;
    var ajsc_cs = localStorage.getItem("ajsc_cs") || 0;
    var grzx_cs = localStorage.getItem("grzx_cs") || 0;
    var qhfy_cs = localStorage.getItem("qhfy_cs") || 0;
    var sxrcx_cs = localStorage.getItem("sxrcx_cs") || 0;
    var ssfjs_cs = localStorage.getItem("ssfjs_cs") || 0;
    var znss_cs = localStorage.getItem("znss_cs") || 0;
    //用户登入时间/user_id/court_id
    var signin_time = localStorage.getItem("signin_time");
    var user_id = localStorage.getItem("user_id");
    var court_id = localStorage.getItem("court_id");
    //提交退出请求，提交失信人查询次数、法院概况查看次数等 
    ajax("" + httpurl + "log/logout.php", "signin_time=" + signin_time + "&user_id=" + user_id + "&court_id=" + court_id + "&fygk_cs=" + fygk_cs + "&ktgg_cs=" + ktgg_cs + "&ssyd_cs=" + ssyd_cs + "&flfg_cs=" + flfg_cs + "&ajsc_cs=" + ajsc_cs + "&grzx_cs=" + grzx_cs + "&qhfy_cs=" + qhfy_cs + "&sxrcx_cs=" + sxrcx_cs + "&ssfjs_cs=" + ssfjs_cs + "&znss_cs=" + znss_cs, function(data) {
        console.log(data);
        if (data.state == 1) {
            var seconds = second ? second : 3;
            open_modal(" <span id='test' class='font_bigger'><span id='mes'>" + seconds + "</span>秒后将退出系统！</span>", title, function() {
                if (timer) {
                    clearTimeout(timer);
                    window.top.restart_timer();
                    console.log(444444);
                    /* 跳转到首页 */
                    $('.tip_modal').modal('hide');
                }
            }, "取消", "static");
            var sum_ele = $("#mes");
            var timer;
            close_modal_delay(seconds);

            function close_modal_delay(sum) {
                timer = setTimeout(function() {
                    if (sum > 1) {
                        sum_ele.html(--sum);
                        close_modal_delay(sum);
                    } else {
                        clearTimeout(timer);
                        $('#tipinfo_modal').modal('hide');
                        timer = null;
                        /* 跳转到首页 */
                        clear_cookie();
                    }
                }, 1000);
            }
        } else if (data.state == 0) {
            open_modal("请求服务器失败！");
        }
    });
}
/*退出系统，清除cookie*/
function clear_cookie() {
    //清除立案阅卷查询状态
    clearCookie("la_yj_cx");
    clearCookie("user_id");
    /* 清除绑定的人员手机号（演示代码） */
    clearCookie("phonenumber");
    clearCookie("user_info");
    /*申请立案-民商事一审*/
    clearCookie("last_step");
    clearCookie("yylasq_form_base");
    clearCookie("yylasq_xzfy");
    clearCookie("yg_list_data");
    clearCookie("bg_list_data");
    clearCookie("dsr_list_data");
    clearCookie("yg_dlr_list_data")
    clearCookie("bg_dlr_list_data")
    clearCookie("user_token");
    clearCookie("file_bxcl_list");
    clearCookie("file_kxcl_list");
    clearCookie("data_sum_max");
    /*申请立案-执行案件*/
    clearCookie("last_step_zxaj");
    clearCookie("yylasq_form_base_zxaj");
    clearCookie("yylasq_xzfy_zxaj");
    clearCookie("yg_list_data_zxaj");
    clearCookie("bg_list_data_zxaj");
    clearCookie("dsr_list_data_zxaj");
    clearCookie("yg_dlr_list_data_zxaj")
    clearCookie("bg_dlr_list_data_zxaj")
    clearCookie("file_bxcl_list_zxaj");
    clearCookie("file_kxcl_list_zxaj");
    clearCookie("data_sum_max_zxaj");
    /*申请立案-行政案件*/
    clearCookie("last_step_xzaj");
    clearCookie("yylasq_form_base_xzaj");
    clearCookie("yylasq_xzfy_xzaj");
    clearCookie("yg_list_data_xzaj");
    clearCookie("bg_list_data_xzaj");
    clearCookie("dsr_list_data_xzaj");
    clearCookie("yg_dlr_list_data_xzaj")
    clearCookie("bg_dlr_list_data_xzaj")
    clearCookie("file_bxcl_list_xzaj");
    clearCookie("file_kxcl_list_xzaj");
    clearCookie("data_sum_max_xzaj");
    /*申请预约阅卷*/
    clearCookie("wyyj_begintime");
    clearCookie("sq_sqlsh");
    clearCookie("sq_sjhm");
    clearCookie("dl_type");
    clearCookie("yue_type");
    clearCookie("yue_account");
    clearCookie("yue_pwd");
    clearCookie("sqyt");
    clearCookie("sqyt_type");
    clearCookie("input_name");
    clearCookie("yyyjsq_last_step");
    clearCookie("case_ah");
    clearCookie("case_title");
    clearCookie("yyyjsq_data");
    clearCookie("sqlsh");
    /*法院概况*/
    clearCookie("selected_fygk_info");
    /*我的案件*/
    clearCookie("myyslaj");
    clearCookie("myyyla");
    clearCookie("wdaj_index");
    clearCookie("yslaj_data");
    clearCookie("yyla_case");
    clearCookie("yyla_data");
    clearCookie("yylacx_data");
    clearCookie("yyyjjz_data");
    clearCookie("login_type");
    clearCookie("yyla_ajxq");
    clearCookie("yslaj_case");
    clearCookie("yslaj_ajxq");
    clearCookie("yyla_login_type");
    clearCookie("ckwsla_jz");
    clearCookie("wycx_yyyj_case");
    clearCookie("yyyj_case");
    clearCookie("img");
    /*查看评价*/
    clearCookie("cklajzpj");
    clearCookie("yylapj_gz");
    clearCookie("yylapj_td");
    clearCookie("yylapj_xl");
    clearCookie("ckwjjzpj");
    clearCookie("yyyjpj_gz");
    clearCookie("yyyjpj_td");
    clearCookie("yyyjpj_xl");
    /*导航条*/
    clearCookie("yylacx_last_step");
    clearCookie("last_step");
    clearCookie("yyyjcx_last_step");
    /*失信人查询*/
    clearCookie("sxrxq");
    clearCookie("bzxrname");
    clearCookie("province");
    clearCookie("sfzhm");
    /*审判庭*/
    clearCookie("spt_name");
    clearCookie("fl_num");
    /* 清除个人中心，切换法院等链接、诉讼费计算，失信人查询等功能按钮的使用次数 */
    clearCookie("fygk_cs");
    clearCookie("ktgg_cs");
    clearCookie("ssyd_cs");
    clearCookie("flfg_cs");
    clearCookie("ajsc_cs");
    clearCookie("grzx_cs");
    clearCookie("qhfy_cs");
    clearCookie("sxrcx_cs");
    clearCookie("ssfjs_cs");
    clearCookie("znss_cs");
    /*清除我要立案、我要阅卷、用户登入记录时间*/
    clearCookie("wyla_begintime");
    clearCookie("wyyj_begintime");
    clearCookie("signin_time");
    /*开庭公告*/
    clearCookie("ktgg_infomation");
    /*选择法院信息*/
    clearCookie("ggxx_xzfy");
    //机器配置信息
    clearCookie('sftyj_config');
    clearCookie("status");
    if(court_id){
	  if(court_id==86){
		   window.location.href="/sfytj/dist/html/common/index.html";
	   }else{
		   window.location.href="/sfytj/dist/html/common/index.html";
	   }
   }else if(court_id){
          if(court_id==96){
               window.location.href="/sfytj/dist/html/common/index.html";
           }else{
               window.location.href="/sfytj/dist/html/common/index.html";
           }
       }
}
/*自动弹出虚拟键盘*/
/*
 $(function () {
 return;
 //if(!$("#ime_container")){
 var html = '<div id="ime_container"></div>';
 $("body").append(html);
 //}
 /!*加载虚拟键盘库*!/
 $("body").append('<script type="text/javascript" src="/sfytj/bower_components/SoftKey/vk_loader.js"></script>');

 $("input").focus(function(){
 console.log('正在弹出输入法');
 var ele = $(this);
 VirtualKeyboard.toggle(ele.attr('id'), 'ime_container');
 var offset = ele.offset();
 var height = ele.height();
 var width = ele.width();
 var ime_width = 652;//$("#virtualKeyboard").width();//输入法宽度
 var ime_height = 196;
 var screen_width = $("body").width();
 //调整输入法的位置
 /!*如果目标位置超出屏幕，则输入法贴在右侧，间距30px*!/
 if(offset.left + ime_width > screen_width){
 offset.left = screen_width - ime_width -30;
 }else if(ime_width > width){//如果输入法宽度大于输入框宽度，则输入法与输入框对称
 offset.left = offset.left - (ime_width - width) / 2.0;
 }
 offset.top +=height+30;
 $("#ime_container").offset(offset);
 console.log('已弹出输入法');
 });
 $("input[type='text'],input[type='password'],textarea").blur(function(){
 VirtualKeyboard.toggle($(this).attr('id'), 'ime_container');
 console.log('关闭输入法');
 });
 });
 */
/*公共js部分，注意页面加载运行的函数写在页面中，不要写在单独的js文件里，变量，方法命名 “页面地址”加下划线”变量/方法“*/
/*预约立案-填写人员信息保存的cookie值*/
var ry_id = 0;
/*添加删除人员的标识符*/
var yg_list = [];
var bg_list = [];
var dsr_list = [];
/* 代理人list数据 */
var dlr_id = 0;
var yg_dlr_list = [];
var bg_dlr_list = [];
/* 预约立案流程为执行案件,人员信息保存的变量名 */
var ry_id_zxaj = 0;
var yg_list_zxaj = [];
var bg_list_zxaj = [];
var dsr_list_zxaj = [];
/* 预约立案流程为执行案件,代理人信息保存的变量名 */
var dlr_id_zxaj = 0;
var yg_dlr_list_zxaj = [];
var bg_dlr_list_zxaj = [];
// ====================================================================
/* 预约立案流程为行政案件,人员信息保存的变量名 */
var ry_id_xzaj = 0;
var yg_list_xzaj = [];
var bg_list_xzaj = [];
var dsr_list_xzaj = [];
/* 预约立案流程为行政案件,代理人信息保存的变量名 */
var dlr_id_xzaj = 0;
var yg_dlr_list_xzaj = [];
var bg_dlr_list_xzaj = [];
/*数组存储自然人信息依次为id 类型 名字 身份证 民族 性别 电话 国籍 地址 诉讼地位 生日*/
var zrr = ["10000", "自然人", "小张", "3202981199011233241", "汉族", "男", "13392288675", "中国", "翔宇大厦", "申请人", "1990-1-1"];
/*数组存储法人信息依次为id 类型 单位名称 组织机构代码 电话 国家或地区 电话 国籍 地址 诉讼地位 生日*/
var fr = ["10001", "法人", "南京天宇", "3981191233241", "中国", "翔宇大厦"];
/*数组存储非法人信息依次为id 类型 单位名称 组织机构代码 电话 国家或地区 电话 国籍 地址 诉讼地位 生日*/
var ffr = ["10002", "非法人", "南京极光", "31990112241", "中国", "雨花台西路"];
/*数组存储代理人信息依次为id 类型  名字,代理人类别 电话 地址 证件类型 证件号*/
//var dlr = ["10003", "代理人", "小吴", "律师", "13392288675", "雨花台西路", "军官证", "32029811990154333233"];
var dlrt = ["10003", "代理人", "小田", "律师", "13392288675", "雨花台西路", "军官证", "32029811990154333233"];
//代理人list数据：
//代理人id，代理当事人id，代理当事人姓名， 代理人类型， 代理人姓名， 电话， 证件种类， 证件号码， 地址， 单位名称
var dlr = [1, 4, "程裕", "律师", "黄三", "15856920021", "身份证", "342921199010040311", "安徽省", "黄山旅游局"];
// yg_list.push(zrr, fr);
// bg_list.push(ffr, dlr);
// dsr_list.push(fr, zrr);
// bg_list.push(ffr,zrr);
// dsr_list.push(fr,zrr);
// clearCookie("yyla_yg_list");
// clearCookie("yyla_bg_list");
// clearCookie("yyla_dsr_list");
// setCookie("yyla_yg_list",yg_list,1000);
// setCookie("yyla_bg_list",bg_list,1000);
// setCookie("yyla_dsr_list",dsr_list,1000);
/*删除array列表中指定id的元素*/
function del_list_ele(array, ID) {
    var len = array.length;
    var if_success = false;
    if (len > 0) {
        for (var i = 0; i < len; i++) {
            if (array[i][0] == ID) {
                if_success = true;
                array.splice(i, 1);
                break;
            }
        }
    }
    return if_success;
}
/*返回数组指定id的元素 参数：所属数组，ID*/
function find_ele(array, ID) {
    ID = "" + ID;
    var len = array.length;
    var ele = null;
    if (len > 0) {
        for (var i = 0; i < len; i++) {
            if (array[i][0] == ID) {
                ele = array[i];
            }
        }
    }
    return ele;
}
/*更新数组指定id的元素,参数：修改后的数组，ID，所属哪类数组（yg_list,bg_list,dsr_list）*/
function update_ele(array, ID, list) {
    ID = "" + ID;
    var len = list.length;
    var id = null;
    /*记录数组第几条*/
    if (len > 0) {
        for (var i = 0; i < len; i++) {
            if (list[i][0] == ID) {
                id = i;
            }
        }
    }
    for (var j = 0; j < array.length; j++) {
        list[id][j] = array[j];
    }
}
/*取得cookie*/
function getCookie(name) {
    return localStorage.getItem(name);
}
/*清除cookie  */
function clearCookie(name) {
    localStorage.removeItem(name);
}
/*设置cookie，默认时间7200秒*/
function setCookie(name, value) {
    localStorage.removeItem(name);
    localStorage.setItem(name, value);
}
/*带有蓝色钩子形状的元素选择事件*/
var choice_box = $(".choice_box");
choice_box.click(function() {
    $(".active_choice_box").removeClass("active_choice_box");
    $(this).addClass("active_choice_box");
});
/*底部菜单点击事件*/
var button = $(".cn-button");
button.click(function() {
    $(".footerwrapper").toggleClass("open");
});
/*底部菜单点击效果事件*/
$(".wrapperinsidehover").click(function() {
    console.log($(this));
    $(this).toggleClass("hover");
});
$(".wrapperinsidehover1").click(function() {
    console.log($(this));
    $(this).toggleClass("hover1");
});
$(".wrapperinsidehover2").click(function() {
    console.log($(this));
    $(this).toggleClass("hover2");
});
$(".wrapperinsidehover3").click(function() {
    console.log($(this));
    $(this).toggleClass("hover3");
});
$(".wrapperouterhover").click(function() {
    console.log($(this));
    $(this).toggleClass("hover4");
});
$(".wrapperouterhover1").click(function() {
    console.log($(this));
    $(this).toggleClass("hover5");
});
$(".wrapperouterhover2").click(function() {
    console.log($(this));
    $(this).toggleClass("hover6");
});
$(".wrapperouter1hover").click(function() {
    console.log($(this));
    $(this).toggleClass("hover7");
});
$(".wrapperouter1hover1").click(function() {
    console.log($(this));
    $(this).toggleClass("hover8");
});
$(".wrapperouter1hover2").click(function() {
    console.log($(this));
    $(this).toggleClass("hover9");
});
$(".wrapperouter2hover").click(function() {
    console.log($(this));
    $(this).toggleClass("hover10");
});
$(".wrapperouter3hover").click(function() {
    console.log($(this));
    $(this).toggleClass("hover11");
});
//民商事一审类型案件 导航条记录的方法
/* 记录导航条步数的方法 last_step_cookie为存入的实际步数cookie值，n步数 */
function nav_step(last_step_cookie, n) {
    var last_step = getCookie(last_step_cookie);
    if (last_step === null) {
        last_step = 0;
        setCookie('' + last_step_cookie, last_step);
    }
    last_step = parseInt(last_step);
    for (var i = 1; i <= last_step; i++) {
        $(".process" + i + "").addClass("active");
    }
    for (i = last_step + 1; i <= n; i++) {
        // $(".process" + i + "").children("a").attr("href", "javascript:;");
        $(".process" + i + "").children("a").removeAttr("onclick");
    }
}
/* 申请预约立案 导航步骤 记录当前页面步数 */
function next_step(cur_step) {
    var last_step;
    last_step = getCookie("last_step");
    //当前步数如果等于实际步数，实际步数+1
    if (cur_step == last_step) {
        last_step = parseInt(last_step);
        last_step += 1;
        setCookie("last_step", last_step);
        console.log(getCookie("last_step"));
    }
    if (cur_step == 0) {
        window.location.href = 'xzfy.html';
    }
    if (cur_step == 1) {
        window.location.href = 'txaj.html';
    }
    if (cur_step == 2) {
        window.location.href = 'txryxx.html';
    }
    if (cur_step == 3) {
        window.location.href = 'txdlr.html';
    }
    if (cur_step == 4) {
        window.location.href = 'tjcl.html';
    }
    if (cur_step == 5) {
        window.location.href = 'yylaqrb.html';
    }
}
//执行案件类型 导航条记录的方法
/* 记录导航条步数的方法 last_step_cookie为存入的实际步数cookie值，n步数 */
function nav_step_zxaj(last_step_cookie, n) {
    var last_step = getCookie(last_step_cookie);
    if (last_step === null) {
        last_step = 0;
        setCookie('' + last_step_cookie, last_step);
    }
    last_step = parseInt(last_step);
    for (var i = 1; i <= last_step; i++) {
        $(".process" + i + "").addClass("active");
    }
    for (i = last_step + 1; i <= n; i++) {
        // $(".process" + i + "").children("a").attr("href", "javascript:;");
        $(".process" + i + "").children("a").removeAttr("onclick");
    }
}
/* 申请预约立案 导航步骤 记录当前页面步数 */
function next_step_zxaj(cur_step) {
    var last_step_zxaj;
    last_step_zxaj = getCookie("last_step_zxaj");
    //当前步数如果等于实际步数，实际步数+1
    if (cur_step == last_step_zxaj) {
        last_step_zxaj = parseInt(last_step_zxaj);
        last_step_zxaj += 1;
        setCookie("last_step_zxaj", last_step_zxaj);
        console.log(getCookie("last_step_zxaj"));
    }
    if (cur_step == 0) {
        window.location.href = 'xzfy.html';
    }
    if (cur_step == 1) {
        window.location.href = 'txaj_zxaj.html';
    }
    if (cur_step == 2) {
        window.location.href = 'txryxx_zxaj.html';
    }
    if (cur_step == 3) {
        window.location.href = 'txdlr_zxaj.html';
    }
    if (cur_step == 4) {
        window.location.href = 'tjcl.html';
    }
    if (cur_step == 5) {
        window.location.href = 'yylaqrb.html';
    }
}
// ===========================================================================
//行政案件类型 导航条记录的方法
/* 记录导航条步数的方法 last_step_cookie为存入的实际步数cookie值，n步数 */
function nav_step_xzaj(last_step_cookie, n) {
    var last_step = getCookie(last_step_cookie);
    if (last_step === null) {
        last_step = 0;
        setCookie('' + last_step_cookie, last_step);
    }
    last_step = parseInt(last_step);
    for (var i = 1; i <= last_step; i++) {
        $(".process" + i + "").addClass("active");
    }
    for (i = last_step + 1; i <= n; i++) {
        $(".process" + i + "").children("a").removeAttr("onclick");
    }
}
/* 申请预约立案 导航步骤 记录当前页面步数 */
function next_step_xzaj(cur_step) {
    var last_step_xzaj;
    last_step_xzaj = getCookie("last_step_xzaj");
    //当前步数如果等于实际步数，实际步数+1
    if (cur_step == last_step_xzaj) {
        last_step_xzaj = parseInt(last_step_xzaj);
        last_step_xzaj += 1;
        setCookie("last_step_xzaj", last_step_xzaj);
        console.log(getCookie("last_step_xzaj"));
    }
    if (cur_step == 0) {
        window.location.href = 'xzfy.html';
    }
    if (cur_step == 1) {
        window.location.href = 'txaj_xzaj.html';
    }
    if (cur_step == 2) {
        window.location.href = 'txryxx_xzaj.html';
    }
    if (cur_step == 3) {
        window.location.href = 'txdlr_xzaj.html';
    }
    if (cur_step == 4) {
        window.location.href = 'tjcl.html';
    }
    if (cur_step == 5) {
        window.location.href = 'yylaqrb.html';
    }
}
// ==========================================================================
/* 预约立案进展查询 导航步骤 记录当前页面步数 yylacx_cur_step为当前页面步骤；yylacx_last_step为用户实际操作的步骤 */
function yylacx_next_step(yylacx_cur_step) {
    var yylacx_last_step;
    yylacx_last_step = getCookie("yylacx_last_step");
    //当前步数如果等于实际步数，实际步数+1
    if (yylacx_cur_step == yylacx_last_step) {
        yylacx_last_step = parseInt(yylacx_last_step);
        yylacx_last_step += 1;
        setCookie("yylacx_last_step", yylacx_last_step);
        console.log(getCookie("yylacx_last_step"));
    }
    if (yylacx_cur_step == 1) {
        window.location.href = 'cklajz.html';
    }
    if (yylacx_cur_step == 2) {
        window.location.href = 'txcxpj.html';
    }
}
/* 预约阅卷申请 导航步骤 记录当前页面步数 yyyjsq_cur_step为当前页面步骤；yyyjsq_last_step为用户实际操作的步骤 */
function yyyjsq_next_step(yyyjsq_cur_step) {
    var yyyjsq_last_step;
    yyyjsq_last_step = getCookie("yyyjsq_last_step");
    //当前步数如果等于实际步数，实际步数+1
    if (yyyjsq_cur_step == yyyjsq_last_step) {
        yyyjsq_last_step = parseInt(yyyjsq_last_step);
        yyyjsq_last_step += 1;
        setCookie("yyyjsq_last_step", yyyjsq_last_step);
        console.log(getCookie("yyyjsq_last_step"));
    }
    if (yyyjsq_cur_step == 0) {
        window.location.href = 'yyyjdl.html';
    }
    if (yyyjsq_cur_step == 1) {
        window.location.href = 'yyyjxzaj.html';
    }
    if (yyyjsq_cur_step == 2) {
        window.location.href = 'yyyjyt.html';
    }
    if (yyyjsq_cur_step == 3) {
        window.location.href = 'yyyjqr.html';
    }
}
/* 预约阅卷进展查询 导航步骤 记录当前页面步数 yyyjcx_cur_step为当前页面步骤；yyyjcx_last_step为用户实际操作的步骤 */
function yyyjcx_next_step(yyyjcx_cur_step) {
    var yyyjcx_last_step;
    yyyjcx_last_step = getCookie("yyyjcx_last_step");
    //当前步数如果等于实际步数，实际步数+1
    if (yyyjcx_cur_step == yyyjcx_last_step) {
        yyyjcx_last_step = parseInt(yyyjcx_last_step);
        yyyjcx_last_step += 1;
        setCookie("yyyjcx_last_step", yyyjcx_last_step);
        console.log(getCookie("yyyjcx_last_step"));
    }
    if (yyyjcx_cur_step == 1) {
        window.location.href = 'yyyjjzck.html';
    }
    if (yyyjcx_cur_step == 2) {
        window.location.href = 'yyyjjzpj.html';
    }
}

function open_modal(string, string1, callback, btn_string, backdrop) {
    btn_string = btn_string || '确定';
    var fatherBody = $(window.top.document.body);
    var dialog = fatherBody.find('#tipinfo_modal');
    var content = fatherBody.find('.tip_modal .modal_info');
    // var header = fatherBody.find('.tip_modal .modal_title');
    var header = fatherBody.find('.tip_modal .modal_title');
    var modal_confirm = fatherBody.find('.tip_modal .modal_confirm');
    var modal_close = fatherBody.find('.tip_modal .modal_close');
    // 每次初始化
    var header_string = "提示消息";
    modal_confirm.attr("data-dismiss", "modal");
    modal_confirm.off();
    if (typeof string1 == 'function') { //第二个参数是回调的情况，即传入内容和确定按钮回调，不传标题
        callback = string1;
        modal_confirm.removeAttr("data-dismiss");
        modal_confirm.on('click', callback);
    } else if (string1) {
        header_string = string1;
    }
    if (callback) {
        modal_confirm.removeAttr("data-dismiss");
        modal_confirm.on('click', callback);
    }
    // if(btn_string){
    modal_confirm.html(btn_string);
    //  }
    //if(!!string1){//这有可能造成使用之前的标题
    header.html("<p>" + header_string + "</p>");
    //}
    content.html("<p>" + string + "</p>");
    if (backdrop) {
        dialog.modal({
            backdrop: 'static'
        });
        return;
    }
    dialog.modal();
}

/**************************************/
/**
 * [open_modal_video description]
 * @param  {[type]}   string     [内容]
 * @param  {[type]}   string1    [url]
 * @param  {Function} callback   [function]
 * @param  {[type]}   btn_string [取消]
 * @param  {[type]}   backdrop   [static]
 */
function open_modal_video(string, string1, callback, backdrop) {

    var url = string1;

    var fatherBody = $(window.top.document.body);
    var dialog = fatherBody.find('#tipinfo_modal');
    var content = fatherBody.find('.tip_modal .modal_info');
    // var header = fatherBody.find('.tip_modal .modal_title');
    var header = fatherBody.find('.tip_modal .modal_title');
    var modal_confirm = fatherBody.find('.tip_modal .modal_confirm');
    var modal_close = fatherBody.find('.tip_modal .modal_close');
    // 每次初始化
    var header_string = '<img class="video" style="width:82%" src="' + url + '"/>';
    modal_confirm.attr("data-dismiss", "modal");
    modal_confirm.off();
    if (typeof string1 == 'function') { //第二个参数是回调的情况，即传入内容和确定按钮回调，不传标题
        callback = string1;
        modal_confirm.removeAttr("data-dismiss");
        modal_confirm.on('click', callback);
    }
    if (callback) {
        modal_confirm.removeAttr("data-dismiss");
        modal_confirm.on('click', callback);
    }
    //if(!!string1){//这有可能造成使用之前的标题
    header.html(header_string);
    content.html("<p>" + string + "</p>");
    if (backdrop) {
        dialog.modal({
            backdrop: 'static'
        });
        return;
    }
    dialog.modal();
}
/**************************************/

// 全局弹窗 内容，标题，回调方法，btn文字，是否可点击遮罩
function open_modal_close(string, string1, callback, btn_string, backdrop, btn_close) {
    btn_string = btn_string || '确定';
    var fatherBody = $(window.top.document.body);
    var dialog = fatherBody.find('.id_modal_close .tip_modal');
    var content = fatherBody.find('.id_modal_close .tip_modal .modal_info');
    // var header = fatherBody.find('.tip_modal .modal_title');
    var header = fatherBody.find('.id_modal_close .tip_modal .modal_title');
    var modal_confirm = fatherBody.find('.id_modal_close .tip_modal .modal_confirm');
    var modal_close = fatherBody.find(' .id_modal_close .tip_modal .modal_close');
    // 每次初始化
    var header_string = "提示消息";
    modal_confirm.attr("data-dismiss", "modal");
    modal_confirm.off();
    if (typeof string1 == 'function') { //第二个参数是回调的情况，即传入内容和确定按钮回调，不传标题
        callback = string1;
        modal_confirm.removeAttr("data-dismiss");
        modal_confirm.on('click', callback);
    } else if (string1) {
        header_string = string1;
    }
    if (callback) {
        modal_confirm.removeAttr("data-dismiss");
        modal_confirm.on('click', callback);
    }
    // if(btn_string){
    modal_confirm.html(btn_string);
    //  }
    //if(!!string1){//这有可能造成使用之前的标题
    header.html("<p>" + header_string + "</p>");
    //}
    content.html("<p>" + string + "</p>");
    if (backdrop) {
        dialog.modal({
            backdrop: 'static'
        });
        return;
    }
    if (btn_close) {
        modal_close.show();
        modal_close.html(btn_close);
    }
    dialog.modal();
}
/*禁用页面的右键菜单和文本选中*/
/* 禁用ctrl+w等快捷键 */
$(function() {
    //$(document).bind("contextmenu",function(){return false;});
    $(document).bind("selectstart", function() {
        return false;
    });
    $(document).bind("dragstart", function() {
        return false;
    });
    document.addEventListener('keydown', function(e) {
        e = window.event || e;
        var keycode = e.keyCode || e.which;
        if (e.ctrlKey && keycode == 87) { //屏蔽Ctrl+w  
            e.preventDefault();
            window.event.returnValue = false;
        }
        if (e.ctrlKey && keycode == 82) { //Ctrl + R 
            e.preventDefault();
            window.event.returnValue = false;
        }
        if (e.ctrlKey && keycode == 83) { //Ctrl + S  
            e.preventDefault();
            window.event.returnValue = false;
        }
        if (e.ctrlKey && keycode == 72) { //Ctrl + H 
            e.preventDefault();
            window.event.returnValue = false;
        }
        if (e.ctrlKey && keycode == 74) { //Ctrl + J
            e.preventDefault();
            window.event.returnValue = false;
        }
        if (e.ctrlKey && keycode == 75) { //Ctrl + K 
            e.preventDefault();
            window.event.returnValue = false;
        }
        if (e.ctrlKey && keycode == 78) { //Ctrl + N
            e.preventDefault();
            window.event.returnValue = false;
        }
        if (e.ctrlKey && e.shiftKey && keycode == 46) { //ctrl+shift+delete
            e.preventDefault();
            window.event.returnValue = false;
        }
    })
});
/**
 * ajax封装
 * url 发送请求的地址
 * data 发送到服务器的数据，数组存储，如：{"date": new Date().getTime(), "state": 1}
 * async 默认值: true。默认设置下，所有请求均为异步请求。如果需要发送同步请求，请将此选项设置为 false。
 *       注意，同步请求将锁住浏览器，用户其它操作必须等待请求完成才可以执行。
 * type 请求方式("POST" 或 "GET")， 默认为 "GET"
 * dataType 预期服务器返回的数据类型，常用的如：xml、html、json、text
 * successfn 成功回调函数
 * errorfn 失败回调函数
    
   timeout:超时时间设置，如果不传此参数，默认10s
 */
function ajax(url, data, successfn, errorfn, type, dataType, async, timeout, completefn) {
    async = (async === null || async === "" || typeof(async) == "undefined") ? "true" : async;
    type = (type === null || type === "" || typeof(type) == "undefined") ? "post" : type;
    dataType = (dataType === null || dataType === "" || typeof(dataType) == "undefined") ? "json" : dataType;
    data = (data === null || data === "" || typeof(data) == "undefined") ? {
        "date": new Date().getTime()
    } : data;
    timeout = (timeout === null || timeout === "" || typeof(timeout) == "undefined") ? 30000 : timeout;
    completefn = (typeof(completefn) != "function") ? completefn_ : completefn;
    $.ajax({
        timeout: timeout,
        type: type,
        async: async,
        data: data,
        url: url,
        dataType: dataType,
        success: function(d) {
            /** 如果是json格式的话，默认转成js数组对象**/
            if (dataType == 'json') {
                var data = eval(d);
                successfn(data);
            } else {
                successfn(d);
            }
        },
        complete: function(XMLHttpRequest, textStatus) {
            completefn(XMLHttpRequest, textStatus);
        },
        error: function(XMLHttpRequest, textStatus) {
            console.log("服务器错误！状态text：");
            console.log(textStatus);
        }
    });
    //默认超时函数
    function completefn_(XMLHttpRequest, textStatus) {
        if (textStatus == "timeout") {
            var xmlhttp = window.XMLHttpRequest ? new window.XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHttp");
            xmlhttp.abort();
            if ($(".modal.fade.tip_modal.in", window.top.document)[0]) {
                $('.tip_modal .modal_info', window.top.document).html("<span class='font_bigger'>网络超时！</span>");
                $('.tip_modal .modal_title', window.top.document).html("<p>提示消息</p>");
                $('.tip_modal .modal_confirm', window.top.document).text("确定");
                $('.loading_index', window.top.document).hide();
                $('.tip_modal .modal_confirm').off();
                $('.tip_modal .modal_confirm', window.top.document).attr("data-dismiss", "modal");
            } else {
                open_modal("<span class='font_bigger'>网络超时！</span>");
            }
        } else if (textStatus == "success") {} else if (textStatus == "error") {
            var xmlhttp = window.XMLHttpRequest ? new window.XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHttp");
            xmlhttp.abort();
            if ($(".modal.fade.tip_modal.in", window.top.document)[0]) {
                $('.tip_modal .modal_info', window.top.document).html("<span class='font_bigger'>服务器请求错误！</span>");
                $('.tip_modal .modal_title', window.top.document).html("<p>提示消息</p>");
                $('.tip_modal .modal_confirm', window.top.document).text("确定");
                $('.tip_modal .modal_confirm').off();
                $('.tip_modal .modal_confirm', window.top.document).attr("data-dismiss", "modal");
            } else {
                open_modal("<span class='font_bigger'>服务器请求错误！</span>");
            }
            console.log("请求error");
        } else {
            console.log("其他");
        }
    }
}
/*获取get参数*/
/*方法1使用getPar("name") 例如url="Default.html?id=10&name=zhangsan";*/
function getPar(par) {
    //获取当前URL
    var local_url = document.location.href;
    //获取要取得的get参数位置
    var get = local_url.indexOf(par + "=");
    if (get == -1) {
        return false;
    }
    //截取字符串
    var get_par = local_url.slice(par.length + get + 1);
    //判断截取后的字符串是否还有其他get参数
    var nextPar = get_par.indexOf("&");
    if (nextPar != -1) {
        get_par = get_par.slice(0, nextPar);
    }
    return get_par;
}
/*方法2使用$_GET['id']*/
var $_GET = (function() {
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if (typeof(u[1]) == "string") {
        u = u[1].split("&");
        var get = {};
        for (var i in u) {
            var j = u[i].split("=");
            get[j[0]] = j[1];
        }
        return get;
    } else {
        return {};
    }
})();
/*验证身份证ID*/
/*function isIdCardNo(num) {
    if (isNaN(num)) {
        open_modal("输入的身份证不是数字！");
        return false;
    }
    var len = num.length, re;
    if (len == 15)
        re = new RegExp(/^(\d{6})()?(\d{2})(\d{2})(\d{2})(\d{3})$/);
    else if (len == 18)
        re = new RegExp(/^(\d{6})()?(\d{4})(\d{2})(\d{2})(\d{3})(\d)$/);
    else {
        open_modal("输入的身份证号码数字位数不对！");
        return false;
    }
    var a = num.match(re);
    if (a !== null) {
        if (len == 15) {
            var D = new Date("19" + a[3] + "/" + a[4] + "/" + a[5]);
            var B = D.getYear() == a[3] && (D.getMonth() + 1) == a[4] && D.getDate() == a[5];
        }
        else {
            var D = new Date(a[3] + "/" + a[4] + "/" + a[5]);
            var B = D.getFullYear() == a[3] && (D.getMonth() + 1) == a[4] && D.getDate() == a[5];
        }
        if (!B) {
            open_modal("输入的身份证号" + a[0] + " 里出生日期不对！");
            return false;
        }
    }
    return true;
}*/
function isIdCardNo(code, empty) {
    var city = {
        11: "北京",
        12: "天津",
        13: "河北",
        14: "山西",
        15: "内蒙古",
        21: "辽宁",
        22: "吉林",
        23: "黑龙江 ",
        31: "上海",
        32: "江苏",
        33: "浙江",
        34: "安徽",
        35: "福建",
        36: "江西",
        37: "山东",
        41: "河南",
        42: "湖北 ",
        43: "湖南",
        44: "广东",
        45: "广西",
        46: "海南",
        50: "重庆",
        51: "四川",
        52: "贵州",
        53: "云南",
        54: "西藏 ",
        61: "陕西",
        62: "甘肃",
        63: "青海",
        64: "宁夏",
        65: "新疆",
        71: "台湾",
        81: "香港",
        82: "澳门",
        91: "国外 "
    };
    var tip = "";
    var pass = true;
    var isIDCard1 = /^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/;
    if (empty != true && !code) {
        tip = "请输入身份证号！";
        pass = false;
    } else if (code != "" && !/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/i.test(code)) {
        tip = "身份证号格式错误";
        pass = false;
    } else if (code != "" && !city[code.substr(0, 2)]) {
        tip = "地址编码错误";
        pass = false;
    } else {
        //18位身份证需要验证最后一位校验位
        if (code.length == 18) {
            code = code.toUpperCase();
            code = code.split('');
            //∑(ai×Wi)(mod 11)
            //加权因子
            var factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
            //校验位
            var parity = [1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2];
            var sum = 0;
            var ai = 0;
            var wi = 0;
            for (var i = 0; i < 17; i++) {
                ai = code[i];
                wi = factor[i];
                sum += ai * wi;
            }
            var last = parity[sum % 11];
            if (last != code[17]) {
                tip = "校验位错误";
                pass = false;
            }
        }
    }
    /*if(!pass) alert(tip);*/
    if (!pass) open_modal(tip);
    return pass;
}
/*验证输入的护照*/
function checkpassport(passport, empty) {
    if (empty != true && passport.length === 0) {
        open_modal("请输入护照编号!");
        return false;
    }
    var myreg = /^[a-zA-Z0-9]{3,21}$/;
    var hz = /^(P\d{7})|(G\d{8})$/;
    if (!myreg.test(passport)) {
        open_modal("您输入的护照编号不正确!");
        return false;
    }
    if (!hz.test(passport)) {
        open_modal("您输入的护照编号不正确!");
        return false;
    } else {
        return true;
    }
}
/*验证军官证*/
function checkofficer(jgzh, empty) {
    if (empty != true && jgzh.length === 0) {
        open_modal("请输入军官证号码！");
        return false;
    }
    var jgz = /^[a-zA-Z0-9]{7,21}$/;
    if (!jgz.test(jgzh)) {
        open_modal("请输入有效的军官证号码！");
        return false;
    } else {
        return true;
    }
}
/*验证输入的手机号*/
function validatemobile(mobile, empty) {
    if (empty != true && mobile.length === 0) {
        open_modal("请输入手机号码！");
        // document.form1.mobile.focus();
        return false;
    }
    if (mobile != "" && mobile.length != 11) {
        open_modal("请输入有效的手机号码！");
        //  document.form1.mobile.focus();
        return false;
    }
    //  var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
    var myreg = /^0?1[3|4|5|7|8][0-9]\d{8}$/;
    if (mobile != "" && !myreg.test(mobile)) {
        open_modal("请输入有效的手机号码！");
        //  document.form1.mobile.focus();
        return false;
    } else {
        return true;
    }
}
/*验证姓名，可能包含中文，数字，下划线和字母等*/
function checkname(name, canshu, empty) {
    if (empty != true && name.length === 0) {
        open_modal("请输入" + canshu + "!");
        return false;
    }
    var Name = /([^\x00-\xff]|[A-Za-z0-9_])+/;
    if (name != "" && !Name.test(name)) {
        open_modal("请输入正确" + canshu + "!");
        return false;
    } else {
        return true;
    }
}
/*验证输入的地址是否正确，可以包含中文，字母，数字和下划线*/
function checkaddress(name, empty) {
    if (empty != true && name.length === 0) {
        open_modal("请输入地址!");
        return false;
    }
    var Name = /([^\x00-\xff]|[A-Za-z0-9_])+/;
    if (name != "" && !Name.test(name)) {
        open_modal("请输入正确地址!");
        return false;
    } else {
        return true;
    }
}
/*验证组织机构代码是否正确*/
function checkorgcode(code) {
    //机构代码
    var ws = [3, 7, 9, 10, 5, 8, 4, 2];
    var str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var reg = /^([0-9A-Z]){8}-[0-9|X]$/;
    var sum = 0;
    for (var i = 0; i < 8; i++) {
        sum += str.indexOf(code.charAt(i)) * ws[i];
    }
    var c9 = 11 - (sum % 11);
    if (!reg.test(code)) {
        open_modal("组织机构代码不正确！");
        return false;
    } else if (c9 == 10) {
        c9 = 'X';
    } else if (c9 == 11) {
        c9 = '0';
    } else if (c9 != code.charAt(9)) {
        open_modal("组织机构代码不正确，请输入正确的组织机构代码！");
        return false;
    } else {
        return true;
    }
}
/*验证输入是否为数字*/
function checknumber(name, empty) {
    if (empty != true && name.length === 0) {
        open_modal("请输入证件号码!");
        return false;
    }
    var Name = /([^\x00-\xff]|[A-Za-z0-9_])+/;
    if (!Name.test(name)) {
        open_modal("请输入正确证件号码!");
        return false;
    } else {
        return true;
    }
}
/*完成后倒计时*/
//取随机数
var chars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

function generateMixed(n) {
    var res = "";
    for (var i = 0; i < n; i++) {
        var id = Math.ceil(Math.random() * 35);
        res += chars[id];
    }
    return res;
}
// 提交成功跳转需要先申明modal_btn，modal_title，modal_content
function submit_success(url) {
    var modal_content = $('.tip_modal .modal_info', window.top.document);
    var modal_title = $('.tip_modal .modal_title', window.top.document);
    var modal_btn = $('.tip_modal .modal_confirm', window.top.document);
    console.log("提交成功!");
    // modal_content.html("<p><span id='mes' class='font_bigger'>3</span>秒后将跳转到个人中心！</span></p>");
    modal_content.html("提交成功，正在为您跳转...</span></p>");
    modal_btn.html("确定");
    modal_title.html("<p>提交成功</p>");
    modal_btn.click(function() {
        $('.tip_modal', window.top.document).modal('hide');
        $('.tip_modal', window.top.document).on('hidden.bs.modal', function() {
            window.location.href = url;
        });
    });
}

function submit_error() {
    var modal_content = $('.tip_modal .modal_info', window.top.document);
    var modal_title = $('.tip_modal .modal_title', window.top.document);
    var modal_btn = $('.tip_modal .modal_confirm', window.top.document);
    console.log("提交案件超时!");
    modal_content.html("<p>网络错误!</p>");
    modal_btn.html("确定");
    modal_btn.click(function() {
        $('.tip_modal', window.top.document).modal('hide');
    });
}

function url_load(url) {
    window.location.href = url;
}
/*
记录以下链接点击的次数:点击页面链接的时候做累加
法院概况
开庭公告
诉讼引导
法律法规
案件收藏
个人中心
切换法院

记录以下功能按钮的点击次数：点击功能按钮累加
失信人查询
诉讼费计算
智能搜索记录
*/
function record_clicknum(href) {
    switch (href) {
        //法院概况
        case '/sfytj/dist/html/ggxx/fyck/fyxx/index.html':
            var fygk_cs = localStorage.getItem("fygk_cs") || 0;
            localStorage.setItem("fygk_cs", ++fygk_cs);
            break;
            //开庭公告
        case '/sfytj/dist/html/ggxx/tsgk/ktgg_index.html':
            var ktgg_cs = localStorage.getItem("ktgg_cs") || 0;
            localStorage.setItem("ktgg_cs", ++ktgg_cs);
            break;
            //诉讼引导
        case '/sfytj/dist/html/ggxx/ygsf/ssyd/index.html':
            var ssyd_cs = localStorage.getItem("ssyd_cs") || 0;
            localStorage.setItem("ssyd_cs", ++ssyd_cs);
            break;
            //法律法规
        case '/sfytj/dist/html/ggxx/ygsf/flfg/flfg_index.html':
            var flfg_cs = localStorage.getItem("flfg_cs") || 0;
            localStorage.setItem("flfg_cs", ++flfg_cs);
            break;
            //案件收藏
        case 'ajsc_record':
            var ajsc_cs = localStorage.getItem("ajsc_cs") || 0;
            localStorage.setItem("ajsc_cs", ++ajsc_cs);
            break;
            //个人中心    
        case '/sfytj/dist/html/common/wdaj.html':
            var grzx_cs = localStorage.getItem("grzx_cs") || 0;
            localStorage.setItem("grzx_cs", ++grzx_cs);
            break;
            //切换法院    
        case '/sfytj/dist/html/common/xzfy.html':
            var qhfy_cs = localStorage.getItem("qhfy_cs") || 0;
            localStorage.setItem("qhfy_cs", ++qhfy_cs);
            break;
            //失信人查询
        case 'sxrcx_record':
            var sxrcx_cs = localStorage.getItem("sxrcx_cs") || 0;
            localStorage.setItem("sxrcx_cs", ++sxrcx_cs);
            break;
            //诉讼费计算
        case 'ssfjs_record':
            var ssfjs_cs = localStorage.getItem("ssfjs_cs") || 0;
            localStorage.setItem("ssfjs_cs", ++ssfjs_cs);
            break;
            //智能搜索记录
        case 'znss_record':
            var znss_cs = localStorage.getItem("znss_cs") || 0;
            localStorage.setItem("znss_cs", ++znss_cs);
            break;
        default:
            console.log("没有符合的链接");
    }
}