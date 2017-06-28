'use strict'; 
 /** 预约阅卷进展查询 切换登录tab方法*/
 function yyyjjzdl_login_type(type){
    $('.font_style').each(function(){
        $(this).removeClass('selected');
    });

    if(type==1){
        $('.dlfsright').children().eq(0).addClass('selected');
        $('#zhanghaotype').parent().show();
        $('#zhanghaotype').html('案件编码');

        $('.input_lsh').val(getCookie("jzdl_sqlsh"));

    }
    if(type==2){
        $('.dlfsright').children().eq(1).addClass('selected');
        $('#zhanghaotype').parent().show();
        $('#zhanghaotype').html('手机号码');

        $('.input_lsh').val(getCookie("jzdl_sjhm"));

    }

    
  }

function save_yyyjjz_login_form(form_data){
    console.log(form_data);
    setCookie("yyyjjz_login_form",JSON.stringify(form_data));
}


function get_yyyjjz_login_form(){
    var form_data = getCookie("yyyjjz_login_form");
    if(form_data == null){
        form_data = {};
    }else{
        form_data = JSON.parse(form_data);
    }
    return form_data;
}