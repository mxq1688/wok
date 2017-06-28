/*开启视频通话*/
function openVideoChat() {
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
    showTips(tips_msg_prepare_customer);
    //XXX

    if (localStream) {
        displayStream('local_video', localStream,220,166);
        
    } else {
        //打开本地摄像头
        initStream(function (stream) {
            initWebSocket();
            displayStream('local_video', stream,220,166);
        });
    }
}
//初始化流
function initStream(callback) {
    localStream = new RTCat.Stream();
    localStream.on('access-accepted', function () {
            //session.send({stream: localStream, data: true});
            callback(localStream);
        }
    );
    localStream.on('access-failed', function (err) {
        showTips(tips_msg_access_error);
        console.log(err);
    });

    localStream.on('error', function (err) {
        console.log(err);
    });

    localStream.on('video-end', function (err) {
        $('.video_chat .local_video').empty();
        showTips(tips_msg_video_end);
        console.log(err);
        localStream = null;
    });

    localStream.init();
}

var res = '';

function initWebSocket() {
    if (ws != null && typeof ws != "undefined" && ws.readyState == 1) {
       return;
    }
    console.log("创建socket");

//TODO 获得法院id river
    var Request = new Object();
    Request = GetRequest();
    var fid = Request['fid'];
    if (fid=="") {
        alert('请输入法院代码');
        return;
   }

    //ws = new WebSocket('ws://115.28.73.220:8000');
    //ws = new WebSocket('wss://115.28.73.220:8444/VS/VS?fid='+fid);
    ws = new WebSocket('wss://spth.njxnet.com:8444/VS/VS?fid='+fid);
    //http://118.190.64.87/
//  ws = new WebSocket('ws://' + window.location.host + '/VideoChat' + fydm);
    ws.onopen = function (e) {
        
        sendMessage({type: 'customer'});
        
        ws.onmessage = function (e) {

            res = JSON.parse(e.data);
            console.log('onMessage');
            console.log(res);
            if (res.type) {
                switch (res.type) {
                    case 'error'://有人离线或者网络错误，无法建立连接
                        var error_code = res.error_code;
                        var msg = res.data;
                        onVideChatError(error_code, msg);
                        hideQueueTips();
                        break;
                    case 'call':
                        
                        $("#myModal").modal();
                         //if(!window.confirm("是否接入用户视频请求？")){
                         //    answer = 'refuse';
                        // }
                        var myAuto = document.getElementById('audio');  
                        myAuto.play(); 
                        
                    case 'token'://收到聊天室的token
                        var token = res.data;//聊天账号token
                        console.log("在为您匹配客户。。。");
                        initSession(token);
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
function initSession(token) {
    console.log('token: ' + token);
    if (session) {
        if (session.getState() == 1 || session.getState() == 2) {
            console.log("断开已有连接");
            showVideoChatTime(0, true);
            session.disconnect();
            session = null;
        }
    }
    session = new RTCat.Session(token);
    
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
        console.log("该token已被使用");
        sendMessage({type:"_cancel"});
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
    });

    session.on('remote', function (r_channel) {
        var id = r_channel.getId();
        r_channel.on('stream', function (stream) {
            console.log('接收到远程视频,id: ' + id);
            var videochat_ele = $('.video_container');
            displayStream('remote_video', stream,videochat_ele.width(),videochat_ele.height());
            //显示时间
            showVideoChatTime(0);

            hideTips();
            hideQueueTips();
        });
        /*对方视频已关闭*/
        r_channel.on('close', function () {
            showTips(tips_msg_disconnect, 3000);
            //时间清零
            showVideoChatTime(0, true);
            $('.video_chat .remote_video').empty();
            sendMessage({type:"_cancel"});
        });

        r_channel.on('message', function (msg) {
            console.log('收到消息：' + msg);
        });
    });
    session.connect();
}

// 拒绝视频请求
function refuse_video(){
    var _to_client_id = res.to_client_id;
    var answer = 'accept';
    console.log("2." + _to_client_id);
    sendMessage({type: 'response', to_client_id: _to_client_id, data: answer});
     window.location.reload();
}

function agree_video(){
    var _to_client_id = res.to_client_id;
    var answer = 'accept';
    console.log("2." + _to_client_id);
    sendMessage({type: 'response', to_client_id: _to_client_id, data: answer});
}

// 挂断音频
function stop_aud(){
    var myAuto = document.getElementById('audio');  
    myAuto.pause(); 
}
