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
//国家码和民族码变量
var nation_code = JSON.parse(localStorage.getItem("nation_code"));
var country_code = JSON.parse(localStorage.getItem("country_code"));

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



    function get_lasq_form_base(){
    var form_data =localStorage.getItem("yylasq_form_base");
    if(form_data === null){
        form_data = {};
    }else{
        form_data = JSON.parse(form_data);
    }
    return form_data;
}