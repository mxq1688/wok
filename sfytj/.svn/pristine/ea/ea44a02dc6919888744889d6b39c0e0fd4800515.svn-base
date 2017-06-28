
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
    var pid = Request['pid'];
    if (pid=="") {
        alert('请输入设备id');
        return;
    }
    ws = new WebSocket('wss://spth.njxnet.com:8444/VS/VS?fid='+fid);
    ws.onopen = function (e) {
    	console.log('onopen');
        sendMessage({type: 'visitor',data:pid+""});
    };
    ws.onmessage = function (e) {
        var res = JSON.parse(e.data);
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
                case 'cancel'://电话挂机，关闭session连
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
    if(session){
        session.disconnect();
        session=null;
    }
                    break;
                case 'wait'://打开本地视频流
                    var count = res.data;//等待人数
                    onVideoChatWait(parseInt(count) + 1);
                    openStream();
                    break;
                case 'update'://等待人数更新
                    var count = res.data;//等待人数
                    onVideoChatWait(parseInt(count) + 1);
                    break;
                case 'token'://收到聊天室的token
                    var token = res.data;//聊天账号token
                    console.log("在为您匹配客服。。。");
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
        setTimeout(function () {
            initWebSocket();
        }, 3000);
    };
}
function openStream(){
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

    showTips(tips_msg_prepare_visitor);

    //

	if (localStream) {
        // localStream.play('local_video');
        // localStream.resize({width:'100%',height:'100%'});
      //  $('.video_chat .remote_video').empty();
	//	displayStream('local_video', localStream,220,166);
    } else {
    	localStream = new RTCat.Stream();
    	localStream.on('access-accepted', function () {
            // localStream.play('local_video');
            // localStream.resize({width:'100%',height:'100%'});
            displayStream('local_video', localStream,220,166);
    		});
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
//    	        sendMessage({type:"cancel"});
    	    });
    	localStream.init();
    }
}

function initSession(token) {
    console.log('token: ' + token);
    if (session) {
        if (session.getState() == 1 || session.getState() == 2) {
            //如果已经处于连接中或者已连接状态则断开已有连接
            console.log("断开已有连接");
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
//        sendMessage({type:"cancel"});
    });
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
    displayStream('remote_video',stream,videochat_ele.width(),videochat_ele.height());
           // stream.play('remote_video');
           // stream.resize({width:stream,videochat_ele.width(),height:videochat_ele.height()})
           //显示时间
            showVideoChatTime(0);

            hideTips();
            hideQueueTips();
        });
        /*对方视频已关闭*/
        r_channel.on('close', function () {
            showTips(tips_msg_disconnect, 3000);
            $('.video_chat .remote_video').empty();
            //时间清零
            showVideoChatTime(0, true);
        	console.log('客服断开');
        });
        r_channel.on('message', function (msg) {
            console.log('收到消息：' + msg);
        });
    });
    session.connect();
}

