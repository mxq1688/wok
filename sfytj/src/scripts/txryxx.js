'use strict';
//国家码和民族码变量
var nation_code = JSON.parse(localStorage.getItem("nation_code"));
var country_code = JSON.parse(localStorage.getItem("country_code"));
var buttonList=$(".zscg_btn button");
/*自然人table 原告*/
function show_zrr_table_yg(aj_type) {
    var table = "<div class='form-group col-sm-6 font_bigger'>";
    table += "<label for='inputName' class='col-sm-5 control-label required'>姓名</label>";
    table += "<div class='col-sm-7'>";
    table += "<input name='name' type='text' class='form-control hight font_bigger inputname' id='inputName' required placeholder=''>";
    table += " </div>";
    table += "</div>";
    table += "<div class='form-group col-sm-6'>";
    table += " <label for='inputID' class='col-sm-5 control-label required'>身份证号码</label>";
    table += "<div class='col-sm-7'>";
    table += "<input name='ID' type='text' class='form-control hight font_bigger inputid' id='inputID' placeholder=''>";
    table += " </div>";
    table += "</div>";
    table += "<div class='form-group col-sm-6'>";
    table += "<label for='inputNation' class='col-sm-5 control-label required nostar' >民族</label>";
    table += "<div class='col-sm-7'>";
    table += "<select class='form-control hight font_bigger inputnation' id='inputNation' placeholder=''>";
    for(var i=0; i<nation_code.length; i++){
        table += "<option value='"+nation_code[i].id+"'>"+nation_code[i].name+"</option>"
    }
    table += "</select>"
    table += "</div>";
    table += "</div>";
    table += "<div class='form-group col-sm-6'>";
    table += "<label for='inputSex' class='col-sm-5 control-label required'>性别</label>";
    table += "<div class='col-sm-7'>";
    table += "<select class='form-control hight font_bigger nostar' id='inputSex' placeholder=''>";
    table += "<option value='09_00003-1'>男</option>";
    table += "<option value='09_00003-2'>女</option>";
    table += "<option value='09_00003-255'>其他</option>";
    table += " </select>";
    table += "</div>";
    table += "</div>";
    table += "<div class='form-group col-sm-6'>";
    table += "<label for='inputPhone' class='col-sm-5 control-label required nostar'>联系电话</label>";
    table += "<div class='col-sm-7'>";
    table += " <input type='text' name='phone' class='form-control hight font_bigger inputphone' id='inputPhone' placeholder=''>";
    table += "</div>";
    table += "</div>";
    table += "<div class='form-group col-sm-6'>";
    table += "<label for='inputCountry' class='col-sm-5 control-label required nostar'>国籍</label>";
    table += "<div class='col-sm-7'>";
    table += "<select class='form-control hight font_bigger inputcountry' id='inputCountry' placeholder=''>";
    for(var j=0; j<country_code.length; j++){
        table += "<option value='"+country_code[j].id+"'>"+country_code[j].name+"</option>";
    }
    table += "</select>"
    table += "</div>";
    table += "</div>";
    // table += "<div class='form-group col-sm-6'>";
    table += "<div class='form-group col-sm-101'>";
    // table += "<label for='inputAddress' class='col-sm-5 control-label required nostar'>地址</label>";
    table += "<label for='inputAddress' class='col-sm-102 control-label required nostar'>地址</label>";
    // table += "<div class='col-sm-7'>";
    table += "<div class='col-sm-103'>";
    table += "<input type='text' name='nationality' class='form-control hight font_bigger inputaddress' id='inputAddress' placeholder=''>";
    table += "</div>";
    table += "</div>";

    if(aj_type=='zxaj'){
        table += " <div class='form-group col-sm-6 font_bigger'>";
        table += "<label for='inputSsdw' class='col-sm-5 control-label required nostar'>诉讼地位</label>";
        table += "<div class='col-sm-7'>";
        table += "<select class='form-control hight font_bigger' id='inputSsdw' placeholder=''>";
        table += "<option value='09_06306-1'>申请人</option>";
        table += "<option value='09_06306-2'>被申请人</option>";
        table += "<option value='09_06306-3'>异议人</option>";
        table += "</select></div></div>";
    }

    return table;
}

/* 自然人table  非原告*/
function show_zrr_table(aj_type) {
    var table = "<div class='form-group col-sm-6 font_bigger'>";
    table += "<label for='inputName' class='col-sm-5 control-label required'>姓名</label>";
    table += "<div class='col-sm-7'>";
    table += "<input name='name' type='text' class='form-control hight font_bigger inputname' id='inputName' required placeholder=''>";
    table += " </div>";
    table += "</div>";
    table += "<div class='form-group col-sm-6'>";
    table += " <label for='inputID' class='col-sm-5 control-label'>身份证号码</label>";
    table += "<div class='col-sm-7'>";
    table += "<input name='ID' type='text' class='form-control hight font_bigger inputid' id='inputID' placeholder=''>";
    table += " </div>";
    table += "</div>";
    table += "<div class='form-group col-sm-6'>";
    table += "<label for='inputNation' class='col-sm-5 control-label'>民族</label>";
    table += "<div class='col-sm-7'>";
    table += "<select class='form-control hight font_bigger inputnation' id='inputNation' placeholder=''>";
    for(var i=0; i<nation_code.length; i++){
        table += "<option value='"+nation_code[i].id+"'>"+nation_code[i].name+"</option>"
    }
    table += "</select>"
    table += "</div>";
    table += "</div>";
    table += "<div class='form-group col-sm-6'>";
    table += "<label for='inputSex' class='col-sm-5 control-label'>性别</label>";
    table += "<div class='col-sm-7'>";
    table += "<select class='form-control hight font_bigger nostar' id='inputSex' placeholder=''>";
    table += "<option value='09_00003-1'>男</option>";
    table += "<option value='09_00003-2'>女</option>";
    table += "<option value='09_00003-255'>其他</option>";
    table += " </select>";
    table += "</div>";
    table += "</div>";
    table += "<div class='form-group col-sm-6'>";
    table += "<label for='inputPhone' class='col-sm-5 control-label'>联系电话</label>";
    table += "<div class='col-sm-7'>";
    table += " <input type='text' name='phone' class='form-control hight font_bigger inputphone' id='inputPhone' placeholder=''>";
    table += "</div>";
    table += "</div>";
    table += "<div class='form-group col-sm-6'>";
    table += "<label for='inputCountry' class='col-sm-5 control-label'>国籍</label>";
    table += "<div class='col-sm-7'>";
    table += "<select class='form-control hight font_bigger inputcountry' id='inputCountry' placeholder=''>";
    for(var j=0; j<country_code.length; j++){
        table += "<option value='"+country_code[j].id+"'>"+country_code[j].name+"</option>";
    }
    table += "</select>"
    table += "</div>";
    table += "</div>";
    // table += "<div class='form-group col-sm-6'>";
     table += "<div class='form-group col-sm-101'>";
    // table += "<label for='inputAddress' class='col-sm-5 control-label required nostar'>地址</label>";
    table += "<label for='inputAddress' class='col-sm-102 control-label required nostar'>地址</label>";
    // table += "<div class='col-sm-7'>";
    table += "<div class='col-sm-103'>";
    table += "<input type='text' name='nationality' class='form-control hight font_bigger inputaddress' id='inputAddress' placeholder=''>";
    table += "</div>";
    table += "</div>";
    if(aj_type=='zxaj'){
        table += " <div class='form-group col-sm-6 font_bigger'>";
        table += "<label for='inputSsdw' class='col-sm-5 control-label'>诉讼地位</label>";
        table += "<div class='col-sm-7'>";
        table += "<select class='form-control hight font_bigger' id='inputSsdw' placeholder=''>";
        table += "<option value='09_06306-1'>申请人</option>";
        table += "<option value='09_06306-2'>被申请人</option>";
        table += "<option value='09_06306-3'>异议人</option>";
        table += "</select></div></div>";
    }

    return table;
}

/*法人,非法人  原告table*/
function show_fr_table_yg() {

    var table = "<div class='form-group col-sm-6 font_bigger'>";
    table += "<label for='inputDwmc' class='col-sm-5 control-label required'>单位名称 </label>";
    table += "<div class='col-sm-7'>";
    table += "<input type='text' name='name' class='form-control hight font_bigger inputdwmc' id='inputDwmc' placeholder=''>";
    table += "</div></div>";

    table += "<div class='form-group col-sm-6 font_bigger'>";
    table += "<label for='inputFddbr' class='col-sm-5 control-label required'>法定代表人</label>";
    table += "<div class='col-sm-7'>";
    table += "<input type='text' name='ID' class='form-control hight font_bigger inputFddbr' id='inputFddbr' placeholder=''>";
    table += "</div></div>";

    table += "<div class='form-group col-sm-6 font_bigger'>";
    table += "<label for='inputPhone' class='col-sm-5 control-label required'>联系电话</label>";
    table += "<div class='col-sm-7'>";
    table += " <input type='text' name='phone' class='form-control hight font_bigger inputphone' id='inputPhone' placeholder=''>";
    table += "</div>";
    table += "</div>";


    table += "<div class='form-group col-sm-6 font_bigger'>";
    table += "    <label for='inputAddress' class='col-sm-5 control-label required'>所在地址</label>";
    table += "    <div class='col-sm-7'>";
    table += "    <input class='form-control hight font_bigger inputaddress' id='inputAddress' placeholder=''>";
    table += "    </div>";
    table += "    </div>";

   table += "   <div class='form-group col-sm-6'>";
   // table += "    <label for='inputZjzl' class='col-sm-5 control-label required'>证件种类</label>";
   table += "    <label for='inputZjzl' class='col-sm-5 control-label'>证件种类</label>";
   table += "    <div class='col-sm-7'>";
   table += "    <select  class='form-control hight font_bigger inputZjzl' id='inputZjzl' placeholder=''>";
   table+="<option value='09_00015-1'>身份证</option><option value='09_00015-2'>军官证</option><option value='09_00015-3'>士兵证</option><option value='09_00015-4'>学生证</option>";
   table+="<option value='09_00015-5'>警官证</option><option value='09_00015-6'>工作证</option><option value='09_00015-7'>护照</option><option value='09_00015-8'>律师执业证</option>";
   table+="<option value='09_00015-255'>其他</option>";
   table += " </select></div></div>";


   table += "   <div class='form-group col-sm-6'>";
   // table += "    <label for='inputzjhm' class='col-sm-5 control-label  required'>证件号码</label>";
   table += "    <label for='inputzjhm' class='col-sm-5 control-label'>证件号码</label>";
   table += "    <div class='col-sm-7'>";
   table += "    <input  class='form-control hight font_bigger inputzjhm' id='inputzjhm' placeholder=''>";
   table += "    </div>";
   table += "    </div>";

    return table;
}

/*法人,非法人  非原告table*/
function show_fr_table() {

    var table = "<div class='form-group col-sm-6 font_bigger'>";
    table += "<label for='inputDwmc' class='col-sm-5 control-label required'>单位名称 </label>";
    table += "<div class='col-sm-7'>";
    table += "<input type='text' name='name' class='form-control hight font_bigger inputdwmc' id='inputDwmc' placeholder=''>";
    table += "</div></div>";

    table += "<div class='form-group col-sm-6 font_bigger'>";
    table += "<label for='inputFddbr' class='col-sm-5 control-label'>法定代表人</label>";
    table += "<div class='col-sm-7'>";
    table += "<input type='text' name='ID' class='form-control hight font_bigger inputFddbr' id='inputFddbr' placeholder=''>";
    table += "</div></div>";

    table += "<div class='form-group col-sm-6 font_bigger'>";
    table += "<label for='inputPhone' class='col-sm-5 control-label'>联系电话</label>";
    table += "<div class='col-sm-7'>";
    table += " <input type='text' name='phone' class='form-control hight font_bigger inputphone' id='inputPhone' placeholder=''>";
    table += "</div>";
    table += "</div>";


    table += "</div></div>";
    table += "<div class='form-group col-sm-6 font_bigger'>";
    table += "    <label for='inputAddress' class='col-sm-5 control-label required'>所在地址</label>";
    table += "    <div class='col-sm-7'>";
    table += "    <input class='form-control hight font_bigger inputaddress' id='inputAddress' placeholder=''>";
    table += "    </div>";
    table += "    </div>";

     table += "   <div class='form-group col-sm-6'>";
   table += "    <label for='inputZjzl' class='col-sm-5 control-label '>证件种类</label>";
   table += "    <div class='col-sm-7'>";
   table += "    <select  class='form-control hight font_bigger inputZjzl' id='inputZjzl' placeholder=''>";
    table+="<option value='09_00015-1'>身份证</option><option value='09_00015-2'>军官证</option><option value='09_00015-3'>士兵证</option><option value='09_00015-4'>学生证</option>";
   table+="<option value='09_00015-5'>警官证</option><option value='09_00015-6'>工作证</option><option value='09_00015-7'>护照</option><option value='09_00015-8'>律师执业证</option>";
   table+="<option value='09_00015-255'>其他</option>";
   table += " </select></div></div>";


   table += "   <div class='form-group col-sm-6'>";
   table += "    <label for='inputzjhm' class='col-sm-5 control-label '>证件号码</label>";
   table += "    <div class='col-sm-7'>";
   table += "    <input  class='form-control hight font_bigger inputzjhm' id='inputzjhm' placeholder=''>";
   table += "    </div>";
   table += "    </div>";

    return table;
}

/*右边选择人员类型时候加载不同的填写表单*/
function show_input_tab(aj_type) {
    var type = $(".active_panel .panel-title").attr("value");
    // var val = $(event.target).val();
    var val = $(".active_panel .input_person_type").val();
    var html;
    if(type=='原告'){
        if (val == "09_01001-2" || val == "09_01001-3") {
            html = show_fr_table_yg();
        } else if (val == "09_01001-4") {
            html = show_dlr_table();
        } else if (val == "09_01001-1") {
            html = show_zrr_table_yg(aj_type);
        }
    }else{
        if (val == "09_01001-2" || val == "09_01001-3") {
            html = show_fr_table();
        }else if (val == "09_01001-1") {
            html = show_zrr_table(aj_type);
        }
    }
   
    var input_list_content = $(".active_panel .input_list_content");
    input_list_content.html(html);
}


/*添加人员按钮*/
function add_person_btn(aj_type) {
    /*更新按钮文字变成保存，方法改成save*/
    switch_to_save_btn(aj_type); 
    var type = $(".active_panel .panel-title").attr("value");
    var target = "";
    if(type=='原告'){
        target = "#yg_table";
    }else if(type=='被告'){
        target = "#bg_table";
    }else if(type=='第三人'){
        target = "#dsr_table";
    }

    $(".active_item").removeClass('active_item');
    input_list_init(target, aj_type);
}

function switch_to_save_btn(aj_type) {
    var ele = $(".savew_btn");
    ele.html("保存");
    ele.attr("onclick", "add_person('"+aj_type+"')");
    buttonList.eq(1).html("清除");
    buttonList.eq(3).hide();
}
function switch_to_update_btn(aj_type) {
    /*更新按钮文字变成保存，方法改成update*/
    var ele = $(".savew_btn");
    ele.html("更新");
    ele.attr("onclick", "update_person('"+aj_type+"')");
    buttonList.eq(1).html("取消");
    buttonList.eq(3).show();
}

/**
 * 将表单内容保存或添加到人员列表中
 * @param type 人员类型，'原告'\'被告'\'第三人'
 * @returns {*} true 数据合法,数据保存成功，false 数据不合法 -1 空表单
   aj_type 表示当前是哪个案件类型流程，是mssys还是zxaj
 */
function save_or_update_person(type, aj_type) {
    var id, person_type, table_id, ry_list, store_key;
    switch (type) {
        case '原告':
            table_id = '#yg_table';
            if(aj_type=='mssys'){
                ry_list = yg_list;
                store_key = 'yg_list_data';
            }else if(aj_type=='zxaj'){
                ry_list = yg_list_zxaj;
                store_key = 'yg_list_data_zxaj';
            }else if(aj_type=='xzaj'){
                ry_list = yg_list_xzaj;
                store_key = 'yg_list_data_xzaj';
            }  
            break;
        case '被告':
            table_id = '#bg_table';
            if(aj_type=='mssys'){
                ry_list = bg_list;
                store_key = 'bg_list_data';
            }else if(aj_type=='zxaj'){
                ry_list = bg_list_zxaj;
                store_key = 'bg_list_data_zxaj';
            }else if(aj_type=='xzaj'){
                ry_list = bg_list_xzaj;
                store_key = 'bg_list_data_xzaj';
            }
            break;
        case '第三人':
            table_id = '#dsr_table';
            if(aj_type=='mssys'){
                ry_list = dsr_list;
                store_key = 'dsr_list_data';
            }else if(aj_type=='zxaj'){
                ry_list = dsr_list_zxaj;
                store_key = 'dsr_list_data_zxaj';
            }else if(aj_type=='xzaj'){
                ry_list = dsr_list_xzaj;
                store_key = 'dsr_list_data_xzaj';
            }
            break;
    }

    id = $(table_id + " .input_list_content").data('ry_id');
    person_type = $(table_id + " .input_person_type").val();  // 自然人、法人...      '09_01001-1'       

    var ret = check_form(type, person_type);
    if (ret == true) {
        var list = create_list(id, person_type, table_id, aj_type);
        if (find_ele(ry_list, id) == null) {        //不在已有列表中,插入新数据
            ry_list.push(list);
        } else {                                    //已在已有列表中，更新数据
            update_ele(list, id, ry_list);
        }
        people_list_init(type, aj_type);
        input_list_init(table_id, aj_type);
    }
    setCookie(store_key, JSON.stringify(ry_list));
    return ret;
}


/*保存添加的人员*/
function add_person(aj_type) {

    var type = $(".active_panel .panel-title").attr("value");
    var res = save_or_update_person(type, aj_type);

    if (res == true) {
        if (type == "原告") {
            open_modal("添加原告成功！");
        } else if (type == "被告") {
            open_modal("添加被告成功！");
        }
        else if (type == "第三人") {
            open_modal("添加第三人成功！");
        }
    } else if (res == -1) {
        open_modal("表单为空");
    }
    console.log('aaa');
}


// 刷身份证填入人员信息
function get_txryxx(data) {
    var id = $(".active_panel .input_list_content").data("ry_id");
    var type = $(".active_panel .panel-title").attr("value");
    /*判断打开的是那个列表*/
    var person_type = $(".active_panel .input_person_type").val();
    /*更新人员类型*/
   var sfzxx;
    if(data){
        sfzxx = data;
    }
    // }else{
    //     sfzxx = {
    //         "name": "小王",
    //         "identity_card": 342921199010040316,
    //         "nationality": "汉",
    //         "gender": "男",
    //         "country": "09_00004-1",
    //         "address": "江苏省苏州市工业区",
    //     }
    // }

    if (!id) {
        ry_id += 1;
        id = ry_id;
        id = "" + id;
        console.log(id);
    }
    if (type == "原告") {
        if (person_type == '09_01001-1') {
            $(".active_panel #inputName").val(sfzxx.name);
            $(".active_panel #inputID").val(sfzxx.identity_card);
            $(".active_panel #inputCountry").val(sfzxx.country);
            $(".active_panel #inputAddress").val(sfzxx.address);
            //$(".active_panel #inputNation").val(sfzxx.nationality);  //民族
            $(".active_panel #inputNation option").each(function(){
                if($.trim($(this).text()) == sfzxx.nationality+"族"){
                    $(this).attr("selected","selected");
                }
             });   
            //$(".active_panel #inputSex").val(sfzxx.gender);          //性别
            $(".active_panel #inputSex option").each(function(){
                if($(this).text() == sfzxx.gender){
                    $(this).attr("selected", "selected");
                }
            });
            
            //演示代码，给手机号码赋值：
            $(".active_panel #inputPhone").val(localStorage.getItem("phonenumber"));

            console.log(sfzxx);
        } else if (person_type == '09_01001-2') {
            open_modal('此相关信息内容无法从身份证读入，请手动输入！');

        } else if (person_type == '09_01001-3') {
            open_modal('此相关信息内容无法从身份证读入，请手动输入！');

        } else if (person_type == '代理人') {
            $(".active_panel #inputName").val(sfzxx.name);
            $(".active_panel #inputAddress").val(sfzxx.address);
        }
    } else if (type == "被告") {
        if (person_type == '09_01001-1') {
            $(".active_panel #inputName").val(sfzxx.name);
            $(".active_panel #inputID").val(sfzxx.identity_card);
            $(".active_panel #inputCountry").val(sfzxx.country);
            $(".active_panel #inputAddress").val(sfzxx.address);

            //$(".active_panel #inputNation").val(sfzxx.nationality);  //民族
            $(".active_panel #inputNation option").each(function(){
                if($.trim($(this).text()) == sfzxx.nationality+"族"){
                    $(this).attr("selected","selected");
                }
             });   
            //$(".active_panel #inputSex").val(sfzxx.gender);          //性别
            $(".active_panel #inputSex option").each(function(){
                if($(this).text() == sfzxx.gender){
                    $(this).attr("selected", "selected");
                }
            });

            //演示代码，给手机号码赋值：
            $(".active_panel #inputPhone").val(localStorage.getItem("phonenumber"));

        } else if (person_type == '09_01001-2') {
            open_modal('此相关信息内容无法从身份证读入，请手动输入！');

        } else if (person_type == '非法人') {
            open_modal('此相关信息内容无法从身份证读入，请手动输入！');

        } else if (person_type == '09_01001-3') {
            $(".active_panel #inputName").val(sfzxx.name);
            $(".active_panel #inputAddress").val(sfzxx.address);
        }
    }
    else if (type == "第三人") {
        if (person_type == '09_01001-1') {
            $(".active_panel #inputName").val(sfzxx.name);
            $(".active_panel #inputID").val(sfzxx.identity_card);
            $(".active_panel #inputCountry").val(sfzxx.country);
            $(".active_panel #inputAddress").val(sfzxx.address);

            //$(".active_panel #inputNation").val(sfzxx.nationality);  //民族
            $(".active_panel #inputNation option").each(function(){
                if($.trim($(this).text()) == sfzxx.nationality+"族"){
                    $(this).attr("selected","selected");
                }
             });   
            //$(".active_panel #inputSex").val(sfzxx.gender);          //性别
            $(".active_panel #inputSex option").each(function(){
                if($(this).text() == sfzxx.gender){
                    $(this).attr("selected", "selected");
                }
            });

            //演示代码，给手机号码赋值：
            $(".active_panel #inputPhone").val(localStorage.getItem("phonenumber"));

        } else if (person_type == '09_01001-2') {
            open_modal('此相关信息内容无法从身份证读入，请手动输入！');

        } else if (person_type == '09_01001-3') {
            open_modal('此相关信息内容无法从身份证读入，请手动输入！');

        } else if (person_type == '代理人') {
            $(".active_panel #inputName").val(sfzxx.name);
            $(".active_panel #inputAddress").val(sfzxx.address);
        }

    }
}

/*更新选中的人员*/
function update_person(aj_type) {
    if ($(".active_panel .active_item")[0]) {
        var type = $(".active_panel .panel-title").attr("value");
        var res = save_or_update_person(type, aj_type);
        if (res == true) {
            open_modal("更新成功！");
        } else if (res == -1) {
            open_modal('表单为空');
        }
    }
    else {
        open_modal("您还没有选中需要更新的人员！");
    }
    switch_to_save_btn(aj_type);
}

/*删除选中的人员*/
function delete_person(aj_type) {
    if ($(".active_panel .active_item")[0]) {
        var id = $(".active_panel .active_item").data("ry_id");
        var type = $(".active_panel .panel-title").attr("value");
        var table_id; 
        var yg_list_, bg_list_, dsr_list_;
        var YgcokieKey=null;
        var BgcokieKey=null;
        var DsrcokieKey=null;
        if(aj_type=='mssys'){
            YgcokieKey="yg_list_data";
            BgcokieKey="bg_list_data";
            DsrcokieKey="dsr_list_data";
            yg_list_ = yg_list;
            bg_list_ = bg_list;
            dsr_list_ = dsr_list;
        }else if(aj_type=='zxaj'){
            YgcokieKey="yg_list_data_zxaj";
            BgcokieKey="bg_list_data_zxaj";
            DsrcokieKey="dsr_list_data_zxaj";
            yg_list_ = yg_list_zxaj;
            bg_list_ = bg_list_zxaj;
            dsr_list_ = dsr_list_zxaj;
        }else if(aj_type=='xzaj'){
            YgcokieKey="yg_list_data_xzaj";
            BgcokieKey="bg_list_data_xzaj";
            DsrcokieKey="dsr_list_data_xzaj";
            yg_list_ = yg_list_xzaj;
            bg_list_ = bg_list_xzaj;
            dsr_list_ = dsr_list_xzaj;
        }
        /*判断打开的是那个列表*/
        /*页面重绘*/

        /*从原告列表中删除*/
        if (type == "原告") {
            table_id = "#yg_table";
            del_list_ele(yg_list_, id);
            setCookie(YgcokieKey, JSON.stringify(yg_list_));
            open_modal("删除成功！");
            people_list_init("原告", aj_type);

        } else if (type == "被告") {
            table_id = "#bg_table";
            del_list_ele(bg_list_, id);
            setCookie(BgcokieKey, JSON.stringify(bg_list_));
            open_modal("删除成功！");
            people_list_init("被告", aj_type);
        }
        else if (type == "第三人") {
            table_id = "#dsr_table";
            del_list_ele(dsr_list_, id);
            setCookie(DsrcokieKey, JSON.stringify(dsr_list_));
            open_modal("删除成功！");
            people_list_init("第三人", aj_type);
        }

        input_list_init(table_id, aj_type);
        buttonList.eq(1).html("清除");
        buttonList.eq(2).html("保存").attr("onclick", "add_person('"+aj_type+"')");
        buttonList.eq(3).hide();
    }
    else {
        open_modal("您还没有选中需要删除的人员！");
    }


}


/*显示选择的人员信息*/
function txryxx_choose_person(id, list_id, aj_type) {
    switch_to_update_btn(aj_type);
    id = id + "";
    var list = [];
    var target = '';
    if (list_id == 1) {
        if(aj_type=='mssys'){
            list = yg_list;
        }else if(aj_type=='zxaj'){
            list = yg_list_zxaj;
        }else if(aj_type=='xzaj'){
            list = yg_list_xzaj;
        }
        target = '.yg_panel';
    }

    else if (list_id == 2) {
        if(aj_type=='mssys'){
            list = bg_list;
        }else if(aj_type=='zxaj'){
            list = bg_list_zxaj;
        }else if(aj_type=='xzaj'){
            list = bg_list_xzaj;
        }
        target = '.bg_panel';
    }
    else if (list_id == 3) {
        if(aj_type=='mssys'){
            list = dsr_list;
        }else if(aj_type=='zxaj'){
            list = dsr_list_zxaj;
        }else if(aj_type=='xzaj'){
            list = dsr_list_xzaj;
        }
        target = '.dsr_panel';
    }

    $(target + " .active_item").removeClass('active_item');
    $(event.target).addClass("active_item");
    var current_person = find_ele(list, id);

    show_person(current_person, target, aj_type);

}

/*显示选中人员的信息*/
function show_person(person, target_panel, aj_type) {
    $(target_panel + "  .input_list_content").data('ry_id', person[0]);
    var html;
    if (person[1] == "09_01001-1") {              //自然人
        if(target_panel == '.yg_panel'){
            html = show_zrr_table_yg(aj_type);
        }else if(target_panel=='.bg_panel' || target_panel=='.dsr_panel'){
            html = show_zrr_table(aj_type);
        }
        $(target_panel + " .input_list_content").empty();
        $(target_panel + "  .input_list_content").append(html);

        /*载入信息*/
        $(target_panel + "  .input_person_type").val("09_01001-1");
        $(target_panel + "  #inputName").val(person[2]);
        $(target_panel + "  #inputID").val(person[3]);
        $(target_panel + "  #inputNation").val(person[4]);
        $(target_panel + "  #inputSex").val(person[5]);
        $(target_panel + "  #inputPhone").val(person[6]);
        $(target_panel + "  #inputCountry").val(person[7]);
        $(target_panel + "  #inputAddress").val(person[8]);
        if(aj_type=='zxaj'){
            console.log("诉讼地位:");
            console.log(person[9]);
            $(target_panel + "  #inputSsdw").val(person[9]);
        }
    }
    if (person[1] == "09_01001-2") {
        if(target_panel == '.yg_panel'){
            html = show_fr_table_yg();
        }else if(target_panel=='.bg_panel' || target_panel=='.dsr_panel'){
            html = show_fr_table();
        }
        $(target_panel + " .input_list_content").empty();
        $(target_panel + " .input_list_content").append(html);
        /*载入信息*/
        /*数组存储法人信息依次为id 类型 单位名称 组织机构代码 电话 国家或地区 电话 国籍 地址 诉讼地位 生日*/
        $(target_panel + " .input_person_type").val("09_01001-2");
        $(target_panel + " #inputDwmc").val(person[2]);
        $(target_panel + " #inputPhone").val(person[3]);
        $(target_panel + " #inputAddress").val(person[4]);
        $(target_panel + " #inputFddbr").val(person[5]);
        $(target_panel + " #inputZjzl").val(person[6]);
        $(target_panel + " #inputzjhm").val(person[7]);
    }
    if (person[1] == "09_01001-3") {
        if(target_panel == '.yg_panel'){
            html = show_fr_table_yg();
        }else if(target_panel=='.bg_panel' || target_panel=='.dsr_panel'){
            html = show_fr_table();
        }
        $(target_panel + " .input_list_content").empty();
        $(target_panel + " .input_list_content").append(html);
        /*载入信息*/
        $(target_panel + " .input_person_type").val("09_01001-3");
        $(target_panel + " #inputDwmc").val(person[2]);
        $(target_panel + " #inputPhone").val(person[3]);
        $(target_panel + " #inputAddress").val(person[4]);
        $(target_panel + " #inputFddbr").val(person[5]);
        $(target_panel + " #inputZjzl").val(person[6]);
        $(target_panel + " #inputzjhm").val(person[7]);

    }
}

/*点击改变panel,改变底部按钮文字，及active_panel类*/
function change_panel(active_panel, aj_type) {
    $(".active_panel").removeClass("active_panel");
    var id, list;
    switch (active_panel) {
        case "yg_panel":
        case 'yg_table':
            $(".yg_panel").addClass("active_panel");
            id = $(".yg_panel .input_list_content").data('ry_id');
            if(aj_type=='mssys'){
                list = yg_list;
            }else if(aj_type=='zxaj'){
                list = yg_list_zxaj;
            }else if(aj_type=='xzaj'){
                list = yg_list_xzaj;
            }
            
            break;
        case "bg_panel":
        case "bg_table":
            $(".bg_panel").addClass("active_panel");
            id = $(".bg_panel .input_list_content").data('ry_id');
            if(aj_type=='mssys'){
                list = bg_list;
            }else if(aj_type=='zxaj'){
                list = bg_list_zxaj;
            }else if(aj_type=='xzaj'){
                list = bg_list_xzaj;
            }
            
            break;
        case "dsr_panel":
        case "dsr_table":
            $(".dsr_panel").addClass("active_panel");
            id = $(".dsr_panel .input_list_content").data('ry_id');
            if(aj_type=='mssys'){
                list = dsr_list;
            }else if(aj_type=='zxaj'){
                list = dsr_list_zxaj;
            }else if(aj_type=='xzaj'){
                list = dsr_list_xzaj;
            }
            
            break;
    }
    if (id) {
        if (find_ele(list, id) == null) {
            switch_to_save_btn(aj_type);
        } else {
            switch_to_update_btn(aj_type);
        }
    }
}


/*人员列表初始化
  根据案件流程aj_type是mssys还是zxaj初始化
*/
function people_list_init(list, aj_type) {
    var yg_list_, bg_list_, dsr_list_;             
    if(aj_type=='mssys'){
        yg_list_ = yg_list;
        bg_list_ = bg_list;
        dsr_list_ = dsr_list;
    }else if(aj_type=='zxaj'){
        yg_list_ = yg_list_zxaj;
        bg_list_ = bg_list_zxaj;
        dsr_list_ = dsr_list_zxaj;
    }else if(aj_type=='xzaj'){
        yg_list_ = yg_list_xzaj;
        bg_list_ = bg_list_xzaj;
        dsr_list_ = dsr_list_xzaj;
    }
    /*读取原告列表*/
    if (list == "原告") {
        $(".yg_panel .badge").empty();
        $(".yg_panel .list_content").empty();
        if (yg_list_.length > 0) {
            for (var i = 0; i < yg_list_.length; i++) {
                $(".yg_panel .list_content").append("<div class='list_content_item' data-ry_id='" + yg_list_[i][0] + "' onclick='txryxx_choose_person(" + yg_list_[i][0] + ",1, \"" + aj_type + "\")'><p>" + yg_list_[i][2] + "<span class='list_person_type font_common'>" + check_type(yg_list_[i][1]) + "</span></p></div>");
            }
            $(".yg_panel .badge").html(yg_list_.length);
        }
    }
    /*读取被告列表*/
    if (list == "被告") {
        $(".bg_panel .badge").empty();
        $(".bg_panel .list_content").empty();
        if (bg_list_.length > 0) {
            for (var j = 0; j < bg_list_.length; j++) {
                $(".bg_panel .list_content").append("<div class='list_content_item' data-ry_id='" + bg_list_[j][0] + "' onclick='txryxx_choose_person(" + bg_list_[j][0] + ",2, \"" + aj_type + "\")'><p>" + bg_list_[j][2] + "<span class='list_person_type font_common'>" + check_type(bg_list_[j][1]) + "</span></p></div>");
            }
            $(".bg_panel .badge").html(bg_list_.length);
        }
    }
    /*读取第三人列表*/
    if (list == "第三人") {
        $(".dsr_panel .badge").empty();
        $(".dsr_panel .list_content").empty();
        if (dsr_list_.length > 0) {
            for (var k = 0; k < dsr_list_.length; k++) {
                $(".dsr_panel .list_content").append("<div class='list_content_item' data-ry_id='" + dsr_list_[k][0] + "' onclick='txryxx_choose_person(" + dsr_list_[k][0] + ",3, \"" + aj_type + "\")'><p>" + dsr_list_[k][2] + "<span class='list_person_type font_common'>" + check_type(dsr_list_[k][1]) + "</span></p></div>");
            }
            $(".dsr_panel .badge").html(dsr_list_.length);
        }
    }

}
/*input列表初始化*/
function input_list_init(target, aj_type) {
    if (!target) {
        target = '.active_panel';
    }
    var ele = $(target);
    if(aj_type=='mssys' || aj_type=='zxaj'){
        ele.find(".input_type").val("09_01001-1"); //赋值select自然人
        if(target == "#yg_table"){
            ele.find(".input_list_content").html(show_zrr_table_yg(aj_type));
        }else if(target=="#bg_table" || target=="#dsr_table"){
            ele.find(".input_list_content").html(show_zrr_table(aj_type));
        }
    }else if(aj_type=='xzaj'){
        if(target=="#yg_table"){
            ele.find(".input_list_content").html(show_zrr_table_yg(aj_type));
            ele.find(".input_type").val("09_01001-1"); //赋值select自然人
        }else if(target=="#bg_table"){
            ele.find(".input_list_content").html(show_fr_table());
            ele.find(".input_type").val("09_01001-2"); //赋值select法人
        }else if(target=="#dsr_table"){
            ele.find(".input_list_content").html(show_zrr_table(aj_type));
            ele.find(".input_type").val("09_01001-1"); //赋值select自然人
        }
        // if(target=="#bg_table"){
        //    ele.find(".input_type").val("09_01001-2"); //赋值select法人
        // }else{
        //    ele.find(".input_type").val("09_01001-1"); //赋值select自然人

        // }
    }

    // if(target == "#yg_table"){
    //     ele.find(".input_list_content").html(show_zrr_table_yg(aj_type));
    // }else if(target=="#bg_table" || target=="#dsr_table"){
    //     ele.find(".input_list_content").html(show_zrr_table(aj_type));
    // }
    
    /*为其分配一个人员ID*/
    if(aj_type=='mssys'){
        ele.find(".input_list_content").data('ry_id', ++ry_id);
        console.log("人员id");
        console.log(ry_id);
    }else if(aj_type=='zxaj'){
        ele.find(".input_list_content").data('ry_id', ++ry_id_zxaj);
        console.log("人员id");
        console.log(ry_id_zxaj);
    }else if(aj_type=='xzaj'){
        ele.find(".input_list_content").data('ry_id', ++ry_id_xzaj);
        console.log("人员id");
        console.log(ry_id_xzaj);
    }
  
}


/*验证表单填写是法人，代理人，自然人，非法人中的哪个*/
function check_form(type, type_id) {
    /*验证自然人*/
    var index = 1;
    var ele ;
    if(type == '原告'){
        ele = $('#yg_table');
    }else if(type == '被告'){
        ele = $('#bg_table');
    }else if(type == '第三人'){
        ele = $('#dsr_table');
    }

    var isAllowEmpty = type != '原告';//当前验证表单是否是针对原告的,原告false

    if (type_id == "09_01001-1") {                //自然人
        var zrrname = ele.find(".inputname");
        var zrrnamecs = '姓名';
        var zrrnation = ele.find(".inputnation");
        var zrrnationcs = '民族';
        var zrrphone = ele.find(".inputphone");
        var zrraddress = ele.find(".inputaddress");
        var zrrid = ele.find(".inputid");

        var zrrcountry = ele.find(".inputcountry");
        var zrrcountrycs = '国籍';
        if (zrrname.val() == '' && zrrphone.val() == '' && zrraddress.val() == '' && zrrid.val() == '' ) {
            return -1;
        }
        if (checkname(zrrname.val(), zrrnamecs, false) == false) {
            zrrname.parent().parent().addClass('has-error');
            index = 0;
        } else {
            zrrname.parent().parent().removeClass('has-error');
        }

        if (checkname(zrrnation.val(), zrrnationcs,isAllowEmpty) == false) {
            zrrnation.parent().parent().addClass('has-error');
            index = 0;
        } else {
            zrrnation.parent().parent().removeClass('has-error');
        }
        if (validatemobile(zrrphone.val(),isAllowEmpty) == false) {
            zrrphone.parent().parent().addClass('has-error');
            index = 0;
        } else {
            zrrphone.parent().parent().removeClass('has-error');
        }
        if (checkaddress(zrraddress.val(), false) == false) {
            zrraddress.parent().parent().addClass('has-error');
            index = 0;
        } else {
            zrraddress.parent().parent().removeClass('has-error');
        }
        if (isIdCardNo(zrrid.val(),isAllowEmpty) == false) {
            zrrid.parent().parent().addClass('has-error');
            index = 0;
        } else {
            zrrid.parent().parent().removeClass('has-error');
        }
        if (checkname(zrrcountry.val(), zrrcountrycs,isAllowEmpty) == false) {
            zrrcountry.parent().parent().addClass('has-error');
            index = 0;
        } else {
            zrrcountry.parent().parent().removeClass('has-error');
        }
        if (index == 1) {
            return true;
        }

    }
    /*验证法人*/
    else if (type_id == "09_01001-2" || type_id == "09_01001-3") {           //法人、非法人
        var frdwmc = ele.find(".inputdwmc");
        var frdwmccs = '单位名称';
        var frphone = ele.find(".inputphone");
        var fraddress = ele.find(".inputaddress");
        var fddbr = ele.find(".inputFddbr");
        var frzjzl = ele.find(".inputZjzl");
        var frzjhm = ele.find(".inputzjhm");
        var fddbrcs = "法定代表人";

        //去掉验证法人身份证
        // if (frdwmc.val() == '' && frphone.val() == '' && fraddress.val() == '' && fddbr.val() == '' && frzjhm.val() == '') {
        if (frdwmc.val() == '' && frphone.val() == '' && fraddress.val() == '' && fddbr.val() == '') {
            return -1;
        }

        if (checkname(frdwmc.val(), frdwmccs, false) == false) {
            frdwmc.parent().parent().addClass('has-error');
            index = 0;
        } else {
            frdwmc.parent().parent().removeClass('has-error');
        }
        if (validatemobile(frphone.val(), isAllowEmpty) == false) {
            frphone.parent().parent().addClass('has-error');
            index = 0;
        } else {
            frphone.parent().parent().removeClass('has-error');
        }
        if (checkaddress(fraddress.val(), false) == false) {
            fraddress.parent().parent().addClass('has-error');
            index = 0;
        } else {
            fraddress.parent().parent().removeClass('has-error');
        }
        if (checkname(fddbr.val(), fddbrcs, isAllowEmpty) == false) {
            fddbr.parent().parent().addClass('has-error');
            index = 0;
        } else {
            fddbr.parent().parent().removeClass('has-error');
        }
        // if(frzjzl.val()=='09_00015-1'&&isIdCardNo(frzjhm.val(),isAllowEmpty) == false){
        //      frzjhm.parent().parent().addClass('has-error');
        //     index = 0;
        // }

        if (index == 1) {
            return true;
        }

    }
    /*验证代理人*/
    else if (type_id == "代理人") {
        var dlrname = ele.find(".inputname");

        var dlrnamecs = '姓名';
        var dlrphone = ele.find(".inputphone");

        var dlraddress = ele.find(".inputaddress");

        var dlrzjhm = ele.find(".inputzjhm");

        var dlrzjhmcs = '证件号码';

        if (dlrname.val() == '' && dlrphone.val() == '' && dlraddress.val() == '' && dlrzjhm.val() == '') {
            return -1;
        }
        if (checkname(dlrname.val(), dlrnamecs) == false) {
            dlrname.parent().parent().addClass('has-error');
            index = 0;
        } else {
            dlrname.parent().parent().removeClass('has-error');
        }
        if (validatemobile(dlrphone.val()) == false) {
            dlrphone.parent().parent().addClass('has-error');
            index = 0;
        } else {
            dlrphone.parent().parent().removeClass('has-error');
        }
        if (checkaddress(dlraddress.val()) == false) {
            dlraddress.parent().parent().addClass('has-error');
            index = 0;
        } else {
            dlraddress.parent().parent().removeClass('has-error');
        }
        //???证件号码不一定是数字
        /*if (checknumber(dlrzjhm.val()) == false) {
            dlrzjhm.parent().parent().addClass('has-error');
            index = 0;
        } else {
            dlrzjhm.parent().parent().removeClass('has-error');
        }*/
        if (index == 1) {
            return true;
        }

    }

    return false;
}


/*判断保存人员类型*/
function check_type(input_val) {
    if (input_val == '09_01001-1') {
        return "自然人";
    }
    else if (input_val == '09_01001-2') {
        return "法人";
    } else if (input_val == '09_01001-3') {
        return "非法人";
    } else if (input_val == 4) {
        return "代理人";
    }

}

/*根据输入信息拼接数组*/
function create_list(id, person_type, target, aj_type) {
    if (!target) {
        target = '.active_panel';
    }
    var person_info;
    /*返回的人员信息数组*/
    if (person_type == "09_01001-1") {/*自然人*/
        if(aj_type=='mssys'){
            person_info = [id, person_type, $(target + "  #inputName").val(), $(target + "  #inputID").val(), $(target + "  #inputNation").val(), $(target + "  #inputSex").val(), $(target + "  #inputPhone").val(), $(target + "  #inputCountry").val(), $(target + "  #inputAddress").val()];
        }else if(aj_type=='zxaj'){
            person_info = [id, person_type, $(target + "  #inputName").val(), $(target + "  #inputID").val(), $(target + "  #inputNation").val(), $(target + "  #inputSex").val(), $(target + "  #inputPhone").val(), $(target + "  #inputCountry").val(), $(target + "  #inputAddress").val(), $(target + "  #inputSsdw").val()];
        }else if(aj_type=='xzaj'){
            person_info = [id, person_type, $(target + "  #inputName").val(), $(target + "  #inputID").val(), $(target + "  #inputNation").val(), $(target + "  #inputSex").val(), $(target + "  #inputPhone").val(), $(target + "  #inputCountry").val(), $(target + "  #inputAddress").val()];
        }
    } else if (person_type == "09_01001-2" || person_type == "09_01001-3") {/*法人，非法人*/
        person_info = [id, person_type, $(target + "  #inputDwmc").val(), $(target + "  #inputPhone").val(), $(target + "  #inputAddress").val(), $(target + "  #inputFddbr").val(), $(target + "  #inputZjzl").val(), $(target + "  #inputzjhm").val()];
    } else if (person_type == "代理人") {/*代理人*/
        person_info = [id, person_type, $(target + "  #inputName").val(), $(target + "  #inputDlrzl").val(), $(target + "  #inputPhone").val(), $(target + "  #inputAddress").val(), $(target + "  #inputZjzl").val(), $(target + "  #inputzjhm").val()];
    }

    return person_info;
}

//返回诉讼地位字符串-民商事一审
function check_ssdw(val){
    if(val=="09_03207-1"){
        return "原告";
    }else if(val=="09_03207-2"){
        return "被告";
    }else if(val=="09_03207-3"){
        return "第三人";
    }
}

//返回诉讼地位字符串-执行案件
function check_ssdw_zxaj(val){
    if(val=="09_06306-1"){
        return "申请人";
    }else if(val=="09_06306-2"){
        return "被申请人";
    }else if(val=="09_06306-3"){
        return "异议人";
    }
}

//返回国籍字符串
function check_country(val){
    var country;
    for(var i=0; i<country_code.length;i++){
        if(country_code[i].id == val){
            country = country_code[i].name;
            break;
        }
    }
    return country;
}

//返回民族字符串
function check_nation(val){
    var nation;
    for(var i=0; i<nation_code.length;i++){
        if(nation_code[i].id == val){
            nation = nation_code[i].name;
            break;
        }
    }
    return nation;
}