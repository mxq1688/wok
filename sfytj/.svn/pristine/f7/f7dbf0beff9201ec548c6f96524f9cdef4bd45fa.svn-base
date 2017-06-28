/**
 * Created by PC on 2015/12/31.
 */
'use strict';
/*选中查询账号*/
function show_ajbh_table() {
    var table = " <div class='title'>查询账号</div>";
    table += "    <div>";
    table += "    <input class='input_lsh input_bj'>";
    table += "    </div>";
    return table;
}
/*选中手机号码*/
function show_sjhm_table() {
    var table = "  <div class='title'>手机号码</div>";
    table += "    <div>";
    table += "    <input class='input_lsh input_bj'>";
    table += "    </div>";
    table += "    </div>";
    return table;
}
/*选中流水号*/
function show_lsh_table() {
    var table = "  <div class='title'>流水号</div>";
    table += "    <div>";
    table += "    <input class='input_lsh input_bj'>";
    table += "    </div>";
    table += "    </div>";
    return table;
}

//选择的登录方式：val : 3案件编码 1查询账号 2手机号码
//cx_type:     1 立案查询 2 阅卷查询 3 已受理查询
function wycx_login_type(val){
    var cx_type = $("#myTab .active").attr("cx_type");  
    if(cx_type == 1){ 
        $(".active_choice_box_la").removeClass("active_choice_box_la");
        $("#yylacx .input_lsh").val(null);  //清空输入框值；
        $("#yylacx_mm").val(null);
        if(val==3){
            $("#yylacx .anbm").addClass("active_choice_box_la");
            $("#yylacx .cx_title").text("查询账号");
        }else if(val==2){
            $("#yylacx .sjhm").addClass("active_choice_box_la");
            $("#yylacx .cx_title").text("手机号码");
        }
        localStorage.setItem("yyla_login_type", val);
    }else if(cx_type == 2){
        $(".active_choice_box_yj").removeClass("active_choice_box_yj");
        if(val==1){
            $("#yyyjcx .anbm").addClass("active_choice_box_yj");
            $("#yyyjcx .cx_title").text("查询账号");
        }else if(val==2){
            $("#yyyjcx .sjhm").addClass("active_choice_box_yj");
            $("#yyyjcx .cx_title").text("手机号码");
        }
        setCookie("cx_type", 2);
        localStorage.setItem("yyyj_login_type", val);
    }else if(cx_type ==3 ){
        $(".active_choice_box_ysl").removeClass("active_choice_box_ysl");
        $("#yslajcx .input_lsh").val(null);
        $("#yslaj_mm").val(null);
        if(val==1){
            $("#yslajcx .anbm").addClass("active_choice_box_ysl");
            $("#yslajcx .cx_title").text("查询账号");
        }else if(val==2){
            $("#yslajcx .sjhm").addClass("active_choice_box_ysl");
            $("#yslajcx .cx_title").text("手机号码");
        }
        localStorage.setItem("ysl_login_type", val);
    }
}


//切换登录方式
function show_login_type(val){
    var html="";
    /*设置cookie值 login_type*/
    // setCookie("login_type",val);
        localStorage.setItem("login_type", val);

    if(val=="1"){ //查询账号
        html= show_ajbh_table();
        $(".sqlsh").empty();
        $(".sqlsh").append(html);
        $(".input_mm").val(null);

    }else if(val=="2"){  //手机号码
        html= show_sjhm_table();
        $(".sqlsh").empty();
        $(".sqlsh").append(html);
        $(".input_mm").val(null);
        
    }else if(val==3){   //流水号
        html=show_lsh_table();
        $(".sqlsh").empty();
        $(".sqlsh").append(html);
        $(".input_mm").val(null);
    }
}