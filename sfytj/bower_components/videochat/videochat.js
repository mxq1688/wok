/*视频通话脚本*/

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
    '高版本Chrome用户没有打开摄像头权限，换用44版本以下Chrome或其他浏览器';
var tips_msg_video_end = '视频中断';

var tips_msg_online = '您已处于在线状态,接受用户视频请求';
var tips_msg_offline = '您已处于离线状态,不接受用户视频请求';

var offline_client = -9527;

/*开启视频通话*/
function openVideoChat(isCustomer) {
    if (typeof isCustomer == 'undefined') {
        isCustomer = false;
    }
    $('.news_container').hide();
    /*显示遮罩层*/
    /*暂停3D画廊*/
    pauseGallery();
    /*如果视频新闻正在播放，需暂停并隐藏*/

    if (isPlaying == true) {
        $('.fullscreen_video').hide();
        $('.fullscreen_video')[0].pause();
    }
    //showMask();
    _videochat_time = $('.video_container .time');
    //时间清零
    showVideoChatTime(0, true);

    $('.video_chat').show();
    var videochat_ele = $('.video_container');
    console.log(videochat_ele.width());
    videochat_ele.height(videochat_ele.width() / 1.333);
    console.log(videochat_ele.height());

    /*更新提示*/
    //XXX
    if(isCustomer){
        showTips(tips_msg_prepare_customer);        
    }else{
        showTips(tips_msg_prepare_visitor);        
    }
    //XXX

    if (localStream) {
        if (!isCustomer) {
            sendMessage({type: 'call'});
        }
        displayStream('local_video', localStream);
    } else {
        //打开本地摄像头
        initStream({video: true, audio: true, data: true/*,ratio:1.77*/}, function (stream) {
            initWebSocket(isCustomer);
            if (!isCustomer) {
                sendMessage({type: 'call'});
            }
            displayStream('local_video', stream);
        });

    }

}
/*关闭视频通话*/
function closeVideoChat() {

    //hideMask();
    hideTips();
    hideQueueTips();
    $('.video_chat').hide();
    $('.news_container').show();
    /*如果视频通话前，视频新闻是播放状态，则恢复播放*/
    if (isPlaying == true) {
        $('.fullscreen_video').show();
        $('.fullscreen_video')[0].play();
    } else {
        refreshGallery();
    }
    if (_isCustomer == false) {
        sendMessage({type: 'cancel'});
    }

    if (_isCustomer == true && localStream) {
        localStream.stop();
        console.log('关闭流');
        localStream = null;
    }
    if (session) {
        session.disconnect();
        console.log('断开连接');
        session = null;
    }
}

// 初始化流
function initStream(options, callback) {
    localStream = new RTCat.Stream(options);
    localStream.on('access-accepted', function () {
            //session.send({stream: localStream, data: true});
            callback(localStream);
        }
    );
    localStream.on('access-failed', function (err) {

        showTips(tips_msg_access_error);
        console.log(err);
    });

    localStream.on('play-error', function (err) {
        console.log(err);
    });

    localStream.on('video-end', function (err) {
        $('.video_chat .local_video').empty();
        showTips(tips_msg_video_end);
        console.log(err);
        localStream = null;
        sendMessage({type:"cancel"});
    });

    localStream.init();
}
/*显示流*/
function displayStream(id, stream) {
    stream.play(id, {width: '100%', height: '100%'});
}

function onVideChatError(code, msg) {
    showTips(msg, 1000);
}

function onVideoChatWait(count) {
    var msg = tips_msg_busy_visitor;
    if(_isCustomer){
        msg = tips_msg_busy_customer;
    }
    msg = msg.replace('n', count);
    showQueueTips(msg);
}
function onVideoChatConnecting(wait_time) {
    var tips_msg_connecting = tips_msg_connecting_visitor;
    if(_isCustomer){
        tips_msg_connecting = tips_msg_connecting_customer;
    }
    showTips(tips_msg_connecting);
}
function onVideoChatToken(token, session) {
    initSession(token);
}

var _isCustomer = false;
var _to_client_id = null;
//XXX
var _remote_status = null;
//XXX
function initWebSocket(isCustomer) {
    console.log("创建socket");
    if (ws != null && typeof ws != "undefined" && ws.readyState == 1) {
       return;
    }
    console.log("创建socket");
    _isCustomer = isCustomer;

    //ws = new WebSocket('ws://115.28.73.220:8000');
    // ws = new WebSocket('ws://192.168.31.222:8080/video/VideoChat');
    var Request = new Object();
    Request = GetRequest();
    // var fid = Request['fid'];

    var fid = "";
    try{
          var fso = new ActiveXObject("Scripting.FileSystemObject");
          var sfytj_config = fso.OpenTextFile("c:\\sfytj_config.ini", 1);
          sfytj_config.ReadLine();
          fid= sfytj_config.ReadLine().substr(4,6);    //法院代码
          console.log(court_id);
    }
   catch(e){
          console.error("配置文件读取出错");
   }

   if (fid=="") {
        fid = Request['fid'];
   }
    
    var fydm = fid || $('#fydm').val() || 9527;
    fydm = '?fid=' + fydm;

    // ws = new WebSocket('ws://' + window.location.hostname + ':9595/VideoChat' + fydm);
    ws = new WebSocket('ws://118.190.64.87:9595/VideoChat' + fydm);
    ws.onopen = function (e) {
        //客服登录
        if (isCustomer) {
            sendMessage({type: 'customer'});
        } else {
            sendMessage({type: 'visitor'});
        }
        ws.onmessage = function (e) {

            var res = JSON.parse(e.data);
            console.log('onMessage');
            console.log(res);
            if (res.type) {
                switch (res.type) {
                    case 'error':
                        var error_code = res.error_code;
                        var msg = res.data;
                        onVideChatError(error_code, msg);
                        hideQueueTips();
                        break;
                    case 'answer':
                        var msg = res.data;
                        onVideChatError(error_code, msg);
                        //TODO 停留几秒
                        break;
                    //等待
                    case 'wait':
                        if(_isCustomer){
                            var count = res.data;//等待人数
                            onVideoChatWait(parseInt(count) + 1);
                            // onVideoChatWait(parseInt(count));
                        }else{
                            _to_client_id = res.to_client_id;
                            if (_to_client_id == -1) {//在排队状态
                                var count = res.data;//等待人数
                                onVideoChatWait(parseInt(count) + 1);
                                // onVideoChatWait(parseInt(count));
                            } else {
                                var wait_time = res.data;//建议超时时间
                                onVideoChatConnecting(wait_time);
                                hideQueueTips();
                            }
                        }
                        break;

                    case 'call':
                        _to_client_id = res.to_client_id;
                        var wait_time = res.data;//建议超时时间
                        clearTimeout(wait_time);
                        //这里立即应答，实际应用中可以提示客服用新的来电，点击接听后回复此消息
                        //XXX
                        var answer = 'accept';
                        notifyMe();
                        if(!window.confirm("是否接入用户视频请求？")){
                            answer = 'refuse';
                        }
                        console.log("2." + _to_client_id);
                        sendMessage({type: 'response', to_client_id: _to_client_id, data: answer});                        
                        //XXX
                        //sendMessage({type:'response',to_client_id:_to_client_id, data:'refuse'});
                        break;
                    case 'token'://收到聊天室的token
                        //XXX
                        //_to_client_id = res.to_client_id;
                        //XXX
                        var session_id = res.session_id;//聊天室id
                        var token = res.data;//聊天账号token
                        onVideoChatToken(token, session_id);
                        break;
                }

            }
        };

        ws.onerror = function (e) {
            console.log('WebSocket发生错误', e);

        };
        ws.onclose = function (e) {
            console.log('WebSocket断开连接', e);
            //reconnect(isCustomer);
        };
    };


}
var _ws_reconnect_timer = null;
//3秒后重新建立
function reconnect(isCustomer) {

    ws = null;
    if (_ws_reconnect_timer) {
        clearTimeout(_ws_reconnect_timer);
    }
    _ws_reconnect_timer = setTimeout(initWebSocket(isCustomer), 3000);
}
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
function initSession(token) {
    // 使用token新建会话，请将此处的Token替换为
    // 从http://dashboard.shishimao.com/生成的Token
    //870031d6-40d0-4597-a1e8-048221148bbf
    //session = new RTCat.Session("80670399-feb2-483c-9fc2-90507fdecba0");
    console.log('token: ' + token);
    if (session) {
        if (session.getState() == 1 || session.getState() == 2) {
            //如果已经处于连接中或者已连接状态则断开已有连接
            console.log("断开已有连接");
            //时间清零
            showVideoChatTime(0, true);
            session.disconnect();
            session = null;
        }
    }
    session = new RTCat.Session(token);
    session.connect();

    session.on('connected', function (users) {
        console.log('Session connected');
        console.log(users);
        if (localStream) {
            session.send({stream: localStream, data: true});
        }
        $('.video_chat .remote_video').empty();
    });

    /*403错误，说明该token已被使用，也即该聊天室的客服已和其他人建立连接*/
    session.on('connect_error', function () {
        showTips(tips_msg_busy, 3000);
        //时间清零
        showVideoChatTime(0, true);
        //setTimeout(closeVideoChat,1000);
        console.log("该token已被使用");
        if (_isCustomer == true) {
            sendMessage({type: 'update',to_client_id:_to_client_id, data: 'idle'});
        }
    });
    /*对方进入聊天室，将本地视频流发送给对方。
     暂时未考虑对方是第三方监管还是客服，当客服处理。*/
    session.on('in', function (token) {
        console.log('someone in');

        if (localStream) {
            console.log('发送自己的视频 token: ' + token);
            session.sendTo({to: token, stream: localStream, data: true});
        }
    });

    session.on('out', function (token) {

        showTips(tips_msg_disconnect);
        //时间清零
        showVideoChatTime(0, true);
        console.log('someone out');
        /*if (_isCustomer == true) {
            sendMessage({type: 'update', to_client_id:_to_client_id,data: 'idle'});
        }*/
    });

    session.on('remote', function (r_channel) {
        var id = r_channel.getId();
        r_channel.on('stream', function (stream) {
            console.log('接收到远程视频,id: ' + id);
            displayStream('remote_video', stream);
            //显示时间
            showVideoChatTime(0);

            hideTips();
            hideQueueTips();
            //XXX
            if (_isCustomer == true) {
                sendMessage({type: 'update',to_client_id: _to_client_id, data: 'busy'});
            }
            _remote_status = 'stream';
            //XXX
        });
        /*对方视频已关闭*/
        r_channel.on('close', function () {
            //$('#peer-' + id).parent().remove();
            //XXX
            if(_remote_status != 'stream'){
                return;
            }
            //XXX
            var id = r_channel.getId();
            console.log('视频断开,id: ' + id);
            if (_isCustomer == true) {
                sendMessage({type: 'update',to_client_id: _to_client_id, data: 'idle'});
            }
            showTips(tips_msg_disconnect, 3000);
            $('.video_chat .remote_video').empty();
            //时间清零
            showVideoChatTime(0, true);

            //XXX
            _remote_status = 'close';
            //XXX
        });

        r_channel.on('message', function (msg) {
            console.log('收到消息：' + msg);
        });
    });
}

function online(){
    sendMessage({type: 'update',to_client_id: offline_client, data: 'idle'});
    showTips(tips_msg_online);
}

function offline(){
    sendMessage({type: 'update',to_client_id: offline_client, data: 'busy'});
    showTips(tips_msg_offline);
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

function toggleVideo() {
    localStream.toggleVideo();
}
function toggleAudio() {
    localStream.toggleAudio();
}

function showMask() {
    $('.mask').show();
}
function hideMask() {
    $(".mask").hide();
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
