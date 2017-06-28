'use strict';


/* 执行案件的两个方法 */
/* 添加按钮动作 */
function add_person_btn_dlr_zxaj(){
    switch_to_save_btn_dlr(); 
    $(".active_panel .active_item").removeClass('active_item');
    init_inputlist_dlr_zxaj(null);
}

//初始化代理人列表input_list
function init_inputlist_dlr_zxaj(target){
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

    /*为其分配一个人员ID*/
    ele.find(".input_list").data('dlr_id', ++dlr_id_zxaj);

    console.log("代理人id(执行案件)");
    console.log(dlr_id_zxaj);
}

/* 行政案件的两个方法 */
/* 添加按钮动作 */
function add_person_btn_dlr_xzaj(){
    switch_to_save_btn_dlr();
    $(".active_panel .active_item").removeClass('active_item');
    init_inputlist_dlr_xzaj(null);
}

//初始化代理人列表input_list
function init_inputlist_dlr_xzaj(target){
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

    /*为其分配一个人员ID*/
    ele.find(".input_list").data('dlr_id', ++dlr_id_xzaj);

    console.log("代理人id(执行案件)");
    console.log(dlr_id_xzaj);
}