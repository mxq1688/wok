'use strict';

function txdlr_initview(yg_list_data, bg_list_data){
    var html_ygpannel=""; 
    var html_bgpannel="";
    //原告pannel添加 
    for(var i=0; i<yg_list_data.length; i++){
        html_ygpannel+= "<div class=\"panel panel-default yg_panel_"+i+" "+(i===0?" active_panel":"")+"\" id=\"yg_table_"+i+"\" data-dsr_id=\""+yg_list_data[i][0]+"\" data-dsr_name=\""+yg_list_data[i][2]+"\">";
        html_ygpannel+="<div class=\"panel-title font_h2 collapsed\" data-toggle=\"collapse\" data-parent=\"#panel-847609\" onclick=\"change_panel_dlr('yg_panel', "+i+")\" data-target=\"#panel-element-"+i+"\" value=\"原告\">";
        html_ygpannel+="<div class=\"panel-heading font_h1\">";
        html_ygpannel+="原告：<span class=\"show_dldsr\">"+yg_list_data[i][2]+"</span>";
        html_ygpannel+="<div class=\"title_line\"></div>";
        html_ygpannel+="<span class=\"badge\"></span>";
        html_ygpannel+="</div></div>";
        html_ygpannel+="<div id=\"panel-element-"+i+"\" class=\"panel-collapse collapse"+(i===0?" in":"")+"\">";
        html_ygpannel+="<div class=\"panel-body clearfix\">";
        html_ygpannel+="<div class=\"body_line\"></div>";
        html_ygpannel+="<div class=\"yg_list people_list fl\">";
        html_ygpannel+="<div class=\"list_title font_bigger center-block\">已添加的原告代理人</div>";
        html_ygpannel+="<div class=\"list_content font_bigger\">";
        html_ygpannel+="</div></div>";
        html_ygpannel+="<div class=\"input_list fr\">";
        html_ygpannel+="<div class=\"input_form\">";
        html_ygpannel+="<form class=\"form-horizontal font_bigger\" id=\"type_"+i+"\">";
        html_ygpannel+="<div class=\"choose_type clearfix\">";
        html_ygpannel+="<div class=\"form-group col-sm-6\">";
        html_ygpannel+="<label for=\"inputT_dlr\" class=\"col-sm-5 control-label font_bigger required\">代理人类型</label>";
        html_ygpannel+="<div class=\"col-sm-7\">";
        html_ygpannel+="<select class=\"form-control input_type input_person_type  hight font_bigger\" id=\"inputT_dlr\" onchange=\"changeRequire(this)\">";
        html_ygpannel+="<option value=\"1\">律师</option>";
        html_ygpannel+="<option value=\"2\">承担法律援助的律师</option>";
        html_ygpannel+="<option value=\"3\">监护人</option>";
        html_ygpannel+="<option value=\"4\">亲友</option>";
        html_ygpannel+="<option value=\"5\">人民团体推荐的人</option>";
        html_ygpannel+="<option value=\"6\">所在单位推荐的人</option>";
        html_ygpannel+="<option value=\"7\">法院许可的其他公民</option>";
        html_ygpannel+="<option value=\"8\">法律工作者</option>";
        html_ygpannel+="</select></div></div></div>";
        /*html_ygpannel+="<div class=\"input_list_content font_bigger\">";
        html_ygpannel+="<div class='form-group col-sm-6 font_bigger'>";
        html_ygpannel+="<label for='inputDwmc' class='col-sm-5 control-label required'>代理当事人</label>";
        html_ygpannel+="<div class='col-sm-7'>";
        html_ygpannel+="<input type='text' name='name' class='form-control hight font_bigger inputdwmc' id='inputDldsr'>";
        html_ygpannel+="</div></div>";*/
        html_ygpannel+="<div class='form-group col-sm-6 font_bigger'>";
        html_ygpannel+="<label for='inputFddbr' class='col-sm-5 control-label required'>代理人姓名</label>";
        html_ygpannel+="<div class='col-sm-7'>";
        html_ygpannel+="<input type='text' name='ID' class='form-control hight font_bigger inputDlrxm' id='inputDlrxm' placeholder=''>";
        html_ygpannel+="</div></div>";
        html_ygpannel+="<div class='form-group col-sm-6 font_bigger'>";
        html_ygpannel+="<label for='inputPhone' class='col-sm-5 control-label required'>联系电话</label>";
        html_ygpannel+="<div class='col-sm-7'>";
        html_ygpannel+="<input type='text' name='phone' class='form-control hight font_bigger inputphone' id='inputPhone' placeholder=''>";
        html_ygpannel+="</div></div>";
        html_ygpannel+="<div class='form-group col-sm-6 font_bigger'>";
        html_ygpannel+="<label for='inputZjzl' class='col-sm-5 control-label required'>证件种类</label>";
        html_ygpannel+="<div class='col-sm-7'>";
        html_ygpannel+="<select class='form-control hight font_bigger' id='inputZjzl' placeholder='' name='nation'>";
        html_ygpannel+="<option value='09_00015-1'>身份证</option><option value='09_00015-2'>军官证</option><option value='09_00015-3'>士兵证</option><option value='09_00015-4'>学生证</option>";
        html_ygpannel+="<option value='09_00015-5'>警官证</option><option value='09_00015-6'>工作证</option><option value='09_00015-7'>护照</option><option value='09_00015-8'>律师执业证</option>";
        html_ygpannel+="<option value='09_00015-255'>其他</option>";
        html_ygpannel+="</select></div></div>";
        html_ygpannel+="<div class='form-group col-sm-6 font_bigger'>";
        html_ygpannel+="<label for='inputZjhm' class='col-sm-5 control-label required'>证件号码</label>";
        html_ygpannel+="<div class='col-sm-7'>";
        html_ygpannel+="<input type='text' name='zjhm' class='form-control hight font_bigger inputZjhm' id='inputZjhm' placeholder=''>";
        html_ygpannel+="</div></div>";
        html_ygpannel+="<div class='form-group col-sm-6 font_bigger'><label for='inputAddress' class='col-sm-5 control-label required'>地址</label>";
        html_ygpannel+="<div class='col-sm-7'><input class='form-control hight font_bigger inputaddress' id='inputAddress' placeholder=''></div></div>";
        html_ygpannel+="<div class='form-group col-sm-6 font_bigger'>";
        html_ygpannel+="<label for='inputDwmc' class='col-sm-5 control-label required'>单位名称</label>";
        html_ygpannel+="<div class='col-sm-7'><input type='text' name='name' class='form-control hight font_bigger inputdwmc' id='inputDwmc'placeholder=''></div></div>";
        html_ygpannel+="</div></form></div></div></div></div></div>";
    }
    $("#panel-847609").append(html_ygpannel);

    //被告pannel添加
    for(var j=0; j<bg_list_data.length; j++){
        html_bgpannel+= "<div class=\"panel panel-default bg_panel_"+j+"\" id=\"bg_table_"+j+"\" data-dsr_id=\""+bg_list_data[j][0]+"\" data-dsr_name=\""+bg_list_data[j][2]+"\">";
        html_bgpannel+="<div class=\"panel-title font_h2 collapsed\" data-toggle=\"collapse\" data-parent=\"#panel-847609\" onclick=\"change_panel_dlr('bg_panel', "+j+")\" data-target=\"#panel-ele-"+j+"\" value=\"被告\">";
        html_bgpannel+="<div class=\"panel-heading font_h1\">";
        html_bgpannel+="被告：<span class=\"show_dldsr\">"+bg_list_data[j][2]+"</span>";
        html_bgpannel+="<div class=\"title_line\"></div>";
        html_bgpannel+="<span class=\"badge\"></span>";
        html_bgpannel+="</div></div>";
        html_bgpannel+="<div id=\"panel-ele-"+j+"\" class=\"panel-collapse collapse\">";
        html_bgpannel+="<div class=\"panel-body clearfix\">";
        html_bgpannel+="<div class=\"body_line\"></div>";
        html_bgpannel+="<div class=\"bg_list people_list fl\">";
        html_bgpannel+="<div class=\"list_title font_bigger center-block\">已添加的被告代理人</div>";
        html_bgpannel+="<div class=\"list_content font_bigger\">";
        html_bgpannel+="</div></div>";
        html_bgpannel+="<div class=\"input_list fr\">";
        html_bgpannel+="<div class=\"input_form\">";
        html_bgpannel+="<form class=\"form-horizontal font_bigger\" id=\"type_bg_"+j+"\">";
        html_bgpannel+="<div class=\"choose_type clearfix\">";
        html_bgpannel+="<div class=\"form-group col-sm-6\">";
        html_bgpannel+="<label for=\"inputT_dlr\" class=\"col-sm-5 control-label font_bigger required\">代理人类型</label>";
        html_bgpannel+="<div class=\"col-sm-7\">";
        html_bgpannel+="<select class=\"form-control input_type input_person_type  hight font_bigger\" id=\"inputT_dlr\" onchange=\"changeRequire(this)\">";
        html_bgpannel+="<option value=\"1\">律师</option>";
        html_bgpannel+="<option value=\"2\">承担法律援助的律师</option>";
        html_bgpannel+="<option value=\"3\">监护人</option>";
        html_bgpannel+="<option value=\"4\">亲友</option>";
        html_bgpannel+="<option value=\"5\">人民团体推荐的人</option>";
        html_bgpannel+="<option value=\"6\">所在单位推荐的人</option>";
        html_bgpannel+="<option value=\"7\">法院许可的其他公民</option>";
        html_bgpannel+="<option value=\"8\">法律工作者</option>";
        html_bgpannel+="</select></div></div></div>";
        /*html_bgpannel+="<div class=\"input_list_content font_bigger\">";
        html_bgpannel+="<div class='form-group col-sm-6 font_bigger'>";
        html_bgpannel+="<label for='inputDwmc' class='col-sm-5 control-label required'>代理当事人</label>";
        html_bgpannel+="<div class='col-sm-7'>";
        html_bgpannel+="<input type='text' name='name' class='form-control hight font_bigger inputdwmc' id='inputDldsr'>";
        html_bgpannel+="</div></div>";*/
        html_bgpannel+="<div class='form-group col-sm-6 font_bigger'>";
        html_bgpannel+="<label for='inputFddbr' class='col-sm-5 control-label required'>代理人姓名</label>";
        html_bgpannel+="<div class='col-sm-7'>";
        html_bgpannel+="<input type='text' name='ID' class='form-control hight font_bigger inputDlrxm' id='inputDlrxm' placeholder=''>";
        html_bgpannel+="</div></div>";
        html_bgpannel+="<div class='form-group col-sm-6 font_bigger'>";
        html_bgpannel+="<label for='inputPhone' class='col-sm-5 control-label required'>联系电话</label>";
        html_bgpannel+="<div class='col-sm-7'>";
        html_bgpannel+="<input type='text' name='phone' class='form-control hight font_bigger inputphone' id='inputPhone' placeholder=''>";
        html_bgpannel+="</div></div>";
        html_bgpannel+="<div class='form-group col-sm-6 font_bigger'>";
        html_bgpannel+="<label for='inputZjzl' class='col-sm-5 control-label required'>证件种类</label>";
        html_bgpannel+="<div class='col-sm-7'>";
        html_bgpannel+="<select class='form-control hight font_bigger' id='inputZjzl' placeholder='' name='nation'>";
        html_bgpannel+="<option value='09_00015-1'>身份证</option><option value='09_00015-2'>军官证</option><option value='09_00015-3'>士兵证</option><option value='09_00015-4'>学生证</option>";
        html_bgpannel+="<option value='09_00015-5'>警官证</option><option value='09_00015-6'>工作证</option><option value='09_00015-7'>护照</option><option value='09_00015-8'>律师执业证</option>";
        html_bgpannel+="<option value='09_00015-255'>其他</option>";
        html_bgpannel+="</select></div></div>";
        html_bgpannel+="<div class='form-group col-sm-6 font_bigger'>";
        html_bgpannel+="<label for='inputZjhm' class='col-sm-5 control-label required'>证件号码</label>";
        html_bgpannel+="<div class='col-sm-7'>";
        html_bgpannel+="<input type='text' name='zjhm' class='form-control hight font_bigger inputZjhm' id='inputZjhm' placeholder=''>";
        html_bgpannel+="</div></div>";
        html_bgpannel+="<div class='form-group col-sm-6 font_bigger'><label for='inputAddress' class='col-sm-5 control-label required'>地址</label>";
        html_bgpannel+="<div class='col-sm-7'><input class='form-control hight font_bigger inputaddress' id='inputAddress' placeholder=''></div></div>";
        html_bgpannel+="<div class='form-group col-sm-6 font_bigger'>";
        html_bgpannel+="<label for='inputDwmc' class='col-sm-5 control-label required'>单位名称</label>";
        html_bgpannel+="<div class='col-sm-7'><input type='text' name='name' class='form-control hight font_bigger inputdwmc' id='inputDwmc'placeholder=''></div></div>";
        html_bgpannel+="</div></form></div></div></div></div></div>";
    }
    $("#panel-847609").append(html_bgpannel);
}
var buttonL=$(".zscg_btn button");
function add_person_btn_dlr(){
    switch_to_save_btn_dlr(); 
    $(".active_panel .active_item").removeClass('active_item');
    init_inputlist_dlr(null);
}

//初始化代理人列表input_list
function init_inputlist_dlr(target){
    var ele;
    if(target===null){
        ele = $(".active_panel");
    }else{
        ele = $(target);
    }

    ele.find(".input_person_type").val(1);
    ele.find("#inputDlrxm").val("");
    ele.find("#inputPhone").val("");
    ele.find("#inputZjzl").val("09_00015-1");
    ele.find("#inputZjhm").val("");
    ele.find("#inputAddress").val("");
    ele.find("#inputDwmc").val(""); 

    //初始化代理人列表，默认为律师，单位名称为必选 
    ele.find(".form-group").last().children("label").addClass("required");

    /*为其分配一个人员ID*/
    ele.find(".input_list").data('dlr_id', ++dlr_id);

    console.log("代理人id");
    console.log(dlr_id);
}

//更新按钮变为保存，方法变为add_person_dlr()
function switch_to_save_btn_dlr(){
    var ele = $(".savew_btn");
    ele.html("保存");
    buttonL.eq(1).html("清除");
    buttonL.eq(3).hide();
    ele.attr("onclick", "add_person_dlr()");
}
/*
* buttonL.eq(1).html("清除");
 buttonL.eq(3).hide();
 buttonL.eq(2).html("保存").attr("onclick", "add_person_dlr()");*/

//保存按钮变为更新，方法变为update_person_dlr
function switch_to_update_btn_dlr() {
    var ele = $(".savew_btn");
    ele.html("更新");
    buttonL.eq(1).html("取消");
    buttonL.eq(3).css("display","block");
    ele.attr("onclick", "update_person_dlr()");
}

//点击panel 增加active-panel class, 并且按钮文字改变
function change_panel_dlr(active_panel, num){
    $(".active_panel").removeClass("active_panel");
    switch(active_panel){
        case "yg_panel":
            $("."+active_panel+"_"+num).addClass("active_panel");
            break;
        case "bg_panel":
            $("."+active_panel+"_"+num).addClass("active_panel");
            break;
    }

    if($(".active_panel .active_item")[0]){
        switch_to_update_btn_dlr();
    }else{
        switch_to_save_btn_dlr();
    }
    
}

//代理人类型下拉框change事件，如果是律师，单位名称非必填
function changeRequire(th){
    var dlr_lx = $(th).val();
    var parent = $(th).closest(".form-horizontal");
    var child = $(parent).children().last();

    if(dlr_lx != 1){
        $(child).find("label").removeClass("required");
    }else{
        $(child).find("label").addClass("required");
    }
}

//返回代理人证件种类
function get_dlr_zjzl(val){
    if(val=="09_00015-1"){
        return "身份证";
    }else if(val=="09_00015-2"){
        return "军官证";
    }else if(val=="09_00015-3"){
        return "士兵证";
    }else if(val=="09_00015-4"){
        return "学生证";
    }else if(val=="09_00015-5"){
        return "警官证";
    }else if(val=="09_00015-6"){
        return "工作证";
    }else if(val=="09_00015-7"){
        return "护照";
    }else if(val=="09_00015-8"){
        return "律师执业证";
    }else if(val=="09_00015-255"){
        return "其他";
    }
}