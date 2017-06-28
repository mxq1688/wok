'use strict';

// 刷身份证填入人员信息
function get_txryxx_zxaj(data) {
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
    //     sfzxx = 
    //     {
    //         "name": "程裕",
    //         "identity_card": 342921199010040316,
    //         "nationality": "汉",
    //         "gender": "男",
    //         "country": "09_00004-1",
    //         "address": "安徽省池州市东至县昭潭镇昭潭村建立组34号",
    //     }
    // } 
    if (!id) {
        ry_id_zxaj += 1;
        id = ry_id_zxaj;
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

        } else if (person_type == '09_01001-3') {
            open_modal('此相关信息内容无法从身份证读入，请手动输入！');

        } else if (person_type == '代理人') {
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



