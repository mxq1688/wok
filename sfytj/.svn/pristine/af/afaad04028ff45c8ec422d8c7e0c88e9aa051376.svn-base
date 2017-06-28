// 视频通话
var session;
var localStream;
var ws;
var _videochat_time;
/*提示语*/
var tips_msg_prepare_visitor = '正在为您匹配客服';
var tips_msg_prepare_customer = '正在等待用户接入';

var tips_msg_connecting_visitor = '客服即将为您服务，正在建立视频连接';
var tips_msg_connecting_customer = '正在建立视频连接';
//var tips_msg_busy = '客服繁忙，您前面还有n人排队';
var tips_msg_busy_visitor = '客服繁忙，您前面还有n人排队，请耐心等待';
var tips_msg_busy_customer = '当前排队人数为n';
var tips_msg_network_error = '网络错误';
var tips_msg_disconnect = '视频结束，感谢您的使用';
var tips_msg_access_error = '请确认设备具有摄像头且未被其他程序占用，' +
    '或者换用其他浏览器';
var tips_msg_video_end = '视频中断';

var tips_msg_online = '您已处于在线状态,接受用户视频请求';
var tips_msg_offline = '您已处于离线状态,不接受用户视频请求';

function sendMessage(msg) {
    if (ws && ws.readyState == 1) {
        if (typeof msg == 'object') {
            msg = JSON.stringify(msg);
        }
        console.log('sendmsg : ' + msg);

        ws.send(msg);
    } else {
        setTimeout(function () {
            sendMessage(msg);
        }, 500);
    }
}
function displayStream(id,stream,width,height){
     stream.play(id);
     stream.resize({width: width, height: height})
}

function onVideChatError(code, msg) {
    showTips(msg, 1000);
}

function onVideoChatWait(count) {
    var msg = tips_msg_busy_customer;
    msg = msg.replace('n', count);
    showQueueTips(msg);
}
function onVideoChatConnecting(wait_time) {
    var tips_msg_connecting = tips_msg_connecting_customer;
    showTips(tips_msg_connecting);
}
function hideTips() {
    $('.video_chat .tips').hide();
}

function hideQueueTips() {
    $('.video_chat .queue_tips').hide();
}
var _tip_timeout;
function showTips(msg, delay) {
    console.log('tips: ' + msg);
    var tips = $('.video_chat .tips');
    tips.show();
    if (_tip_timeout) {
        clearTimeout(_tip_timeout);
        _tip_timeout = null;
    }
    if (delay) {
        _tip_timeout = setTimeout(hideTips, delay);
    }
    tips.html(msg);
}

function showQueueTips(msg) {
    var tips = $('.video_chat .queue_tips');
    tips.show();
    tips.html(msg);
}
function pauseGallery() {
    var gallery = $('.news_container').data('gallery');
    if (gallery) {
        if (gallery.options.autoplay) {
            clearTimeout(gallery.slideshow);
        }
    }
}
function refreshGallery() {
    var gallery = $('.news_container').data('gallery');
    if (gallery) {
        if (gallery.options.autoplay) {
            clearTimeout(gallery.slideshow);
            gallery._startSlideshow();
        }
    }
}

var _show_video_chat_time_timer = null;
var time_temp = null;
function showVideoChatTime(time, pause) {
    time = time || 0;
    var hour = parseInt(time / 3600);
    time_temp = time%3600;
    var min = parseInt(time_temp / 60);
    time_temp %= 60;
    var sec = parseInt(time_temp);
    hour = hour < 10 ? '0' + hour : '' + hour;
    min = min < 10 ? '0' + min : '' + min;
    sec = sec < 10 ? '0' + sec : '' + sec;
    var str = hour + ':' + min + ':' + sec;

    if (_videochat_time) {
        _videochat_time.html(str);
    }
    if (pause != true) {
        _show_video_chat_time_timer = setTimeout(function () {
            showVideoChatTime(time + 1);
        }, 1000);
    }else{
        if(_show_video_chat_time_timer){
            clearTimeout(_show_video_chat_time_timer);
            _show_video_chat_time_timer = null;
        }
    }

}

function GetRequest() {

   var url = location.search; //获取url中"?"符后的字串

   var theRequest = new Object();

   if (url.indexOf("?") != -1) {

      var str = url.substr(1);

      strs = str.split("&");

      for(var i = 0; i < strs.length; i ++) {
         theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
      }
   }
   return theRequest;
}
function notifyMe() {
  // Let's check if the browser supports notifications
  if (!("Notification" in window)) {
    console.log("This browser does not support desktop notification");
  }

  // Let's check whether notification permissions have already been granted
  else if (Notification.permission === "granted") {
    // If it's okay let's create a notification
    var notification = new Notification("诉讼服务自助终端发来了诉讼咨询请求");
  }

  // Otherwise, we need to ask the user for permission
  else if (Notification.permission !== 'denied') {
    Notification.requestPermission(function (permission) {
      // If the user accepts, let's create a notification
      if (permission === "granted") {
        var notification = new Notification("诉讼服务自助终端发来了诉讼咨询请求");
      }
    });
  }

  // At last, if the user has denied notifications, and you 
  // want to be respectful there is no need to bother them any more.
}Notification.requestPermission().then(function(result) {
  console.log(result);
});function spawnNotification(theBody,theIcon,theTitle) {
  var options = {
      body: theBody,
      icon: theIcon
  }
  var n = new Notification(theTitle,options);
}