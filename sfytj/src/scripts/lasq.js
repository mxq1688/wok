'use strict';
/*立案申请的js*/

/*申请表基本部分*/
var yylasq_form_base_empty = {
    slfy: '', /*受理法院*/
    djaj: '', /*登记案件*/
    ajlx: '', /*案件类型*/
    ay: '', /*案由*/
    ajcxm: '', /*案件查询码*/
    ajbd: '',/*案件标的*/
    ssqq:'',/*诉讼请求*/
    ytjcl:'',/*已提交材料*/
};

/*申请表申请人部分*/
var yylasq_form_sqr_empty = {
    xm: '', /*姓名*/
    sfz: '', /*身份证*/
    lxfs: '', /*联系方式*/
    lasf: '', /*立案身份*/
    yx: ''/*邮箱*/
};
/*申请表代理人*/
var yylasq_form_dlr = {
    xm: '', /*姓名*/
    lx: '', /*代理类型*/
    zjzl: '', /*证件种类*/
    zjhm: '', /*证件号码*/
    lxfs: '', /*联系方式*/
    szdw: '', /*所在单位*/
    dz: '', /*地址*/
};
/*自然人*/
var yylasq_form_zrr = {
    xm: '', /*姓名*/
    sfz: '', /*身份证*/
    lxfs: '', /*联系方式*/
    lasf: '', /*立案身份*/
    gj: '', /*国籍*/
    mz: '', /*民族*/
    dz: '', /*地址*/
};

/*法人*/
var yylasq_form_fr = {
    dwmc:'',/*单位名称*/
    zzjgdm:'',/*组织机构代码*/

};

/*申请表原告部分*/
var yylasq_form_yg = {
    lx: '', /*原告类型*/
    info:'',/*详细信息，自然人、法人或法人*/
    dlr: '', /*代理人,json类型*/
};



/*申请表被告*/
var yylasq_form_bg = {
    lx: '', /*被告类型*/
    info:'',/*详细信息，字段与被告类型有关*/
    dlr: '', /*代理人,json类型*/
};


/*保存受理法院，案由，申请金额，立案身份，诉讼请求，事实请求*/
function save_lasq_form_base(form_data){

    console.log(form_data);
    setCookie("yylasq_form_base",JSON.stringify(form_data));
}

function get_lasq_form_base(){
    var form_data = getCookie("yylasq_form_base");
    if(form_data === null){
        form_data = {};
    }else{
        form_data = JSON.parse(form_data);
    }
    return form_data;
}


//下面两个方法是执行案件流程中，保存受理法院、案由、申请金额、立案身份、诉讼请求等数据
function save_lasq_form_base_zxaj(form_data_zxaj){

    console.log(form_data_zxaj);
    setCookie("yylasq_form_base_zxaj",JSON.stringify(form_data_zxaj));
}

function get_lasq_form_base_zxaj(){
    var form_data_zxaj = getCookie("yylasq_form_base_zxaj");
    if(form_data_zxaj === null){
        form_data_zxaj = {};
    }else{
        form_data_zxaj = JSON.parse(form_data_zxaj);
    }
    return form_data_zxaj;
}
// ========================================================================
//下面两个方法是行政案件流程中，保存受理法院、案由、申请金额、立案身份、诉讼请求等数据
function save_lasq_form_base_xzaj(form_data_xzaj){

    console.log(form_data_xzaj);
    setCookie("yylasq_form_base_xzaj",JSON.stringify(form_data_xzaj));
}

function get_lasq_form_base_xzaj(){
    var form_data_xzaj = getCookie("yylasq_form_base_xzaj");
    if(form_data_xzaj === null){
        form_data_xzaj = {};
    }else{
        form_data_xzaj = JSON.parse(form_data_xzaj);
    }
    return form_data_xzaj;
}



