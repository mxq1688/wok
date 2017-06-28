'use strict';

/* 查看案件详情方法 */
function ckajxq_lian(value, frame){
    
    localStorage.setItem("yslaj_case",value);  
    //这个value每次去请求后台是否已经绑定帐号，没有绑定就跳转到登录页面，有的话就直接跳转到详情页面
    var httpurl=global_data.httpurl;
    ajax(
            ""+httpurl+"wdaj/ajtz.php",
            "value="+value,
            function(defaultData){
                if(defaultData.state==1){
                    
                    var yslaj_ajxq = {}
                    yslaj_ajxq.data = defaultData.data.allinfo;
                    yslaj_ajxq.data.dsrdata = defaultData.data.allinfo.dsrdata;
                    yslaj_ajxq.data.mardata = defaultData.data.allinfo.mardata;

                    localStorage.setItem("yslaj_ajxq",JSON.stringify(yslaj_ajxq));
                    
                    frame.location.href="/sfytj/dist/html/wdaj/wdaj_ajxx.html";
                }else{
                    frame.location.href="/sfytj/dist/html/wdaj/yslaj/yslaj_login.html";
                }
            },
            null,
            null,
            null,
            false
    );
}
