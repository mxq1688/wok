// WebSocket
var ws;
/*放下话筒*/
function putDown() {
    sendMessage({type: 'cancel',to_client_id:pid+''});
}
/*提起话筒*/
function hangOn() {
    var fso = new ActiveXObject("Scripting.FileSystemObject");
             var sfytj_config = fso.OpenTextFile("c:\\sfytj_config.ini", 1);
             pid = sfytj_config.ReadLine().substr(4, 18); //设备id
             fid = sfytj_config.ReadLine().substr(4, 6); //法院代码
             console.log('pid'+pid+'fid'+fid);
	if (ws != null && typeof ws != "undefined" && ws.readyState == 1) {
    	sendMessage({type:'call',to_client_id:pid+''});
    	return;
    }
    console.log("创建socket");
    ws = new WebSocket('wss://spth.njxnet.com:9595/VS/VS?fid='+fid);
    ws.onopen = function (e) {
        console.log("websocket open",e);
        sendMessage({type:'call',to_client_id:pid+''});
    };
    ws.onmessage = function (e) {
        var res = JSON.parse(e.data);
        console.log('websocket onMessage:'+res);
    };

    ws.onerror = function (e) {
        console.log('WebSocket发生错误', e);

    };
    ws.onclose = function (e) {
        console.log('WebSocket断开连接', e);
    };
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
