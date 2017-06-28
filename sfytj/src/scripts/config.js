'use strict';
/*全局只读配置文件*/
var global_data = {
    fymc : '江苏省高级人民法院',
    httpurl: 'http://139.224.26.151/sfytjjk/' ,//默认的接口url
    //httpurl: 'http://192.168.1.148/sfytjxjk/' ,//默认的接口url
    httpprinturl: 'http://139.224.26.151/' ,//默认的接口url
	court_id:'58',
	ftpserverip: '139.224.26.151',			//ftp服务器IP
	ftpserverport: 21,
	ftpusername: 'ftp220',
	ftppassword: 'ftp220',
	PicDir: 'D:\\高拍仪图片',				//高拍仪图片保存在本地磁盘路径
	GsDir: 'D:\\高扫图片'					//高扫图片保存在本地磁盘路径
};	

/* 全局搜索的数据字典 */
 var search_data = 
{
   "projects":[
      {
        value: "法院概况",
        desc: "通过本功能，可以查看法院信息，包括：法院概况，法庭分布，管辖范围，法院部门及各部门职能，审委会人员信息，法院地址，投诉渠道，法官信息。",
        cat: "法院信息",
		url:'/sfytj/dist/html/ggxx/fyck/fyxx/index.html'
      },
      {
        value: "开庭公告",
        desc: "可通过本功能查看所有开庭公告时间，地点，具体公告内容等信息，还可以根据时间对庭审公告进行查询服务。",
        cat: "法院信息",
		url:'/sfytj/dist/html/ggxx/tsgk/ktgg_index.html'
      },
      {
        value: "失信人查询",
        desc: "失信人概念：最高人民法院执行局2013年11月14日与中国人民银行征信中心签署合作备忘录，共同明确失信被执行人名单信息纳入征信系统相关工作操作规程。今后，失信被执行人名单信息将被整合至被执行人的信用档案中，并以信用报告的形式向金融机构等单位提供，供有关单位在贷款等业务审核中予以衡量考虑。",
        cat: "法院信息",
		url:'/sfytj/dist/html/sxrcx/sxrcx.html'
      },
	  {
        value: "自助立案",
        desc: "民、商事一审、刑事自诉、行政、申请执行、申请再审等案件的当事人，可通过本功能申请网上案件立案预审查。我们通过网络接收您提交的属于本院管辖的案件、相关联的诉讼材料以及执行申请书，经过我们初步审查后，若您的材料基本齐全，我们将与您约定具体的立案接待时间。",
        cat: "诉讼服务",
		url:'/sfytj/dist/html/ssfw/wyla_index.html'
      },
      {
        value: "我要阅卷",
        desc: "根据当事人登录，选择您想要阅卷的对应案件，可以申请查看已受理案件的案件详情，卷宗等具体相关信息。",
        cat: "诉讼服务",
		url:'/sfytj/dist/html//ssfw/yyyj/yyyjsq/yyyjtk.html'
      },
      {
        value: "我要查询",
        desc: "可以根据立案，预约阅卷通过发送到您手机上的查询账户和密码等信息，查询您想了解立案进展，预约阅卷通过后查看卷宗等服务。",
        cat: "诉讼服务",
		url:'/sfytj/dist/html/wycx/index.html'
      },
	  {
        value: "诉讼引导",
        desc: "提供诉讼指引，窗口指南，工作流程，文书服务。具体包括：诉讼须知的一些基本概念；如何使用本机器进行立案，预约阅卷，失信人查询等服务；案件诉讼流程；起诉转，法定代表人身份证明等具体文书。",
        cat: "公共信息",
		url:'/sfytj/dist/html/ggxx/ygsf/ssyd/index.html'
      },
      {
        value: "法律法规",
        desc: "提供中华人民共和国现行有效的法律、行政法规、司法解释、地方法规等法律法规。",
        cat: "公共信息",
		url:'/sfytj/dist/html/ggxx/ygsf/flfg/flfg_index.html'
      },
      {
        value: "诉讼费计算",
        desc: "通过这里，您选择对应的案件类型，填入案件标的，自动帮您算出应缴纳多少诉讼费用",
        cat: "公共信息",
		url: '/sfytj/dist/html//ggxx/ygsf/ssfjs/sfjsq.html'
      }
    ],

 };


// 虚拟键盘设置
$(document).on('focus', 'input', function() {
    //function code here.
      if($(this).attr('type')!="button" && !$(this).hasClass("datetimepicker1")){
      console.log("开启键盘");
       OCX_AVF('AVF_Display,' + '1');
    }
});


$(document).on('blur', 'input', function() {
    //function code here.
      if($(this).attr('type')!="button" && !$(this).hasClass("datetimepicker1")){
       console.log("关闭键盘");
       OCX_AVF('AVF_Display,' + '2');
    }
});
// 监听input输入框更新倒计时
if(window.top!=window.self && !$(".login_html")[0]){
$(document).on('input propertychange', 'input', function(e) {
	window.top.restart_timer();
});
$(document).on('input propertychange', 'textarea', function() {
	window.top.restart_timer();
});
}

$(document).on('focus', 'textarea', function() {  
      console.log("开启键盘");
       OCX_AVF('AVF_Display,' + '1');
});


$(document).on('blur', 'textarea', function() {
       console.log("关闭键盘");
       OCX_AVF('AVF_Display,' + '2');  
});


function OCX_AVF(s)  {
    try{
        $("#AVFOCX", window.top.document)[0].Message_AVF(s);
        }
    catch(e){
        console.error("虚拟键盘加载失败");
    }   
}


// OCX调用
var LightControl =  window.top.document.LightControl;
// 关闭灯光
function close_light(n){
    window.top.document.LightControl.PowerOff(n); 
}

// 打开二代证
function open_IDCard(){
   //当前设备类型 S200 还是 S200E  高扫机型不亮灯 根据配置文件sftyj_config.ini
   // var machine_type = JSON.parse(getCookie("sftyj_config")).mid || ""; 
   // if (machine_type == 'S200E') {    
   // } else if (machine_type == 'S200') {
   //      LightControl.PowerOn(4);
   // }
   var light = getCookie("sfz_light") || "open";
   if (light == "open") {
        LightControl.PowerOn(4);
   }
   GGIDCard.OpenDevice();
   console.log("open_IDCard");
}

// 关闭二代证
function close_IDCard(){
    LightControl.PowerOff(4);
    GGIDCard.CloseDevice();
    console.log("close_IDCard");
}