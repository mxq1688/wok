/**
 * Created by PC on 2015/12/30.
 */
'use strict';
/*头部的获取当前时间*/
var days=new  Array ("日", "一", "二", "三", "四", "五", "六");
function showDT() {
    var currentDT = new Date();
    var y,m,date,day,hs,ms,ss,theDateStr,theTimeStr;
    y = currentDT.getFullYear(); //四位整数表示的年份
    m = currentDT.getMonth()+1; //月
    date = currentDT.getDate(); //日
    day = currentDT.getDay(); //星期
    hs = currentDT.getHours(); //时
    ms = currentDT.getMinutes(); //分
    ss = currentDT.getSeconds(); //秒
    //date
    if (m >= 0 && m <= 9) {
        m = "0" + m;
    }
    if (date >= 0 && date <= 9) {
        date = "0" + date;
    }
    //time
    if (hs >= 0 && hs <= 9) {
        hs = "0" + hs;
    }
    if (ms >= 0 && ms <= 9) {
        ms = "0" + ms;
    }
    if (ss >= 0 && ss <= 9) {
        ss = "0" + ss;
    }
    theDateStr = y+"年"+  m +"月"+date+"日";
    theTimeStr = hs+":"+ms+":"+ss;
    document.getElementById("theClock_d").innerHTML =theDateStr;
    document.getElementById("theClock_t").innerHTML =theTimeStr;
    // setTimeout 在执行时,是在载入后延迟指定时间后,去执行一次表达式,仅执行一次
    window.setTimeout( showDT, 1000);
}

//获取当前日期，格式2016-01-01
function getDate(){
    var currentDT = new Date();
    var y,m,date,day,theDateStr;

    y = currentDT.getFullYear(); //四位整数表示的年份
    m = currentDT.getMonth()+1; //月
    date = currentDT.getDate(); //日

    if (m >= 0 && m <= 9) {
        m = "0" + m;
    }
    if (date >= 0 && date <= 9) {
        date = "0" + date;
    }

    theDateStr = y+"-"+  m +"-"+date;

    return theDateStr;
}

//获取当前时间,格式05:02:02
function getTime(){
    var currentDT = new Date();
    var hs,ms,ss,theTimeStr;

    hs = currentDT.getHours(); //时
    ms = currentDT.getMinutes(); //分
    ss = currentDT.getSeconds(); //秒

    if (hs >= 0 && hs <= 9) {
        hs = "0" + hs;
    }
    if (ms >= 0 && ms <= 9) {
        ms = "0" + ms;
    }
    if (ss >= 0 && ss <= 9) {
        ss = "0" + ss;
    }

    theTimeStr = hs+":"+ms+":"+ss;

    return theTimeStr;
}

//获取日期和时间，格式2016-01-01 05:02:02
function getDateTime(){
    var date = getDate();
    var time = getTime();

    var date_time = date+" "+time;

    return date_time;
}