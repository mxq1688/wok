 'use strict'; 
/* 预约阅卷申请当事人登录 切换tab表方法 */
  function yyyjdl_login_type(type){

      /*设置cookie值*/
      setCookie("dl_type",type,1000);


    if(type==1){
        $('.dlfsright').children().eq(0).addClass('selected');
        $('#zhanghaotype').parent().show();
        $('#zhanghaotype').html('查询账号');

        $('.input_lsh').val(getCookie("sq_sqlsh"));


    }
    if(type==2){
        $('.dlfsright').children().eq(1).addClass('selected');
        $('#zhanghaotype').parent().show();
        $('#zhanghaotype').html('手机号码');

        $('.input_lsh').val(getCookie("sq_sjhm"));


    }

    
  }

/* 预约阅卷申请 确认身份和用途 切换tab表方法 */
    function yyyjyt_showtab(type){
        /*设置cookie值*/
        setCookie("sqyt_type",type,1000);
    
  }


 /* 预约阅卷申请 身份审核 切换tab表方法 */
 function yyyjsh_showtab(type){
     /*设置cookie值*/
     setCookie("sfsh",type,1000);
 }







