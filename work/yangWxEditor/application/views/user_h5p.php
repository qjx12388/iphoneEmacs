<script type="text/javascript">
var auths={};
var shares=null;

function h5_ready(){
	outLine(plus.runtime.version);
	plus.oauth.getServices(function(services){
		outLine(JSON.stringify(services));
		for(var i in services){
			var service=services[i];
			if(service.id=='weixin'){
				$('#weixin_login_a').show();
			}
			auths[service.id]=service;
		}
	},function(e){
		outLine("获取登录认证失败："+e.message);
	});
	/*
	outLine("----- 分享列表 -----");
	plus.share.getServices( function(s){
		shares={};
		for(var i in s){
			var t=s[i];
			if(t.id=='weixin'){
				shares[t.id]=t;
				$('#h5_share_a').show();
			}
			outLine(t.id);
		}
	}, function(e){
		outLine( "获取分享服务列表失败："+e.message );
	});
	*/
}

function sns_login(id){
	outLine("----- 登录认证 -----");
	var auth=auths[id];
	if(auth){
		outLine("开始登录1");
		var w=plus.nativeUI.showWaiting();
		document.addEventListener("pause",function(){
			setTimeout(function(){
				w&&w.close();w=null;
			},10000);
		}, false);
		outLine("开始登录2");
		outLine(id);
			outLine(JSON.stringify(auth));
		auth.login(function(){
			w&&w.close();w=null;
			outLine("登录认证成功：");
			outLine(auth.authResult.openid);
			outLine(JSON.stringify(auth.authResult));
			//sns_user(auth);
		},function(e){
			w&&w.close();w=null;
			outLine("登录认证失败：");
			outLine("["+e.code+"]："+e.message);
			plus.nativeUI.alert("登录失败，请重试",null,"登录失败["+e.code+"]："+e.message);
		});
		outLine("开始登录3");
	}else{
		outLine("无效的登录认证通道！");
		plus.nativeUI.alert("无效的登录认证通道！",null,"登录");
	}
}

function sns_user(a){
	outLine("----- 获取用户信息 -----");
	a.getUserInfo(function(){
		outLine("获取用户信息成功：");
		outLine(JSON.stringify(a.userInfo));
		var nickname=a.userInfo.nickname||a.userInfo.name;
		plus.nativeUI.alert("欢迎“"+nickname+"”登录！");
	},function(e){
		outLine("获取用户信息失败：");
		outLine("["+e.code+"]："+e.message);
		plus.nativeUI.alert("获取用户信息失败！",null,"登录");
	});
}

var share_content='分享内容';
var share_url='http://www.i9chou.com/';
var share_title='分享标题';
var share_img='http://www.i9chou.com/static/zhongchou/logo.jpg';

function h5_share(){
	var ids=[];
	var bts=[];
	var i=0;
	if(shares['weixin']){
		ids.push({id: 'weixin', ex: 'WXSceneSession'});
		bts.push({title: '发送给微信好友'});
		i++;
		ids.push({id: 'weixin', ex: 'WXSceneTimeline'});
		bts.push({title: '分享到微信朋友圈'});
		i++;
	}
	outLine("iiii: "+i);
	outLine(JSON.stringify(bts));
	if(i>0){
		plus.nativeUI.actionSheet({cancel: '取消', buttons: bts}, function(e){
			var i=e.index;
			if(i>0){
				shareAction(ids[i-1].id, ids[i-1].ex);
			}
		});
	}
}

function shareAction(id, ex) {
	var s=null;
	outLine( "分享操作：" );
	outLine( id );
	if(!id || !(s=shares[id])){
		outLine( "无效的分享服务！" );
		return;
	}
	if ( s.authenticated ) {
		outLine( "---已授权---" );
		shareMessage(s, ex);
	} else {
		outLine( "---未授权---" );
		s.authorize( function(){
				shareMessage(s, ex);
			},function(e){
			outLine( "认证授权失败："+e.code+" - "+e.message );
		});
	}
}

function shareMessage(s, ex){
	var msg={content: share_content, extra: {scene: ex}};
	msg.href=share_url;
	msg.title=share_title;
	msg.content=share_content;
	msg.thumbs=[share_img];
	msg.pictures=[share_img];
	outLine(JSON.stringify(msg));
	s.send( msg, function(){
		outLine( "分享到\""+s.description+"\"成功！ " );
	}, function(e){
		outLine( "分享到\""+s.description+"\"失败: "+e.code+" - "+e.message );
	} );
}

function outLine(c){
	$('#output').append(c+'<hr>');
}

function fz(){
	if(plus.os.name=='iOS'){
		var UIPasteboard=plus.ios.importClass('UIPasteboard');
		var generalPasteboard=UIPasteboard.generalPasteboard();
		generalPasteboard.setValueforPasteboardType('http://www.abcdefg.com', 'public.utf8-plain-text');
		//var value=generalPasteboard.valueForPasteboardType('public.utf8-plain-text');
	}else{
		var Context=plus.android.importClass('android.content.Context');
		var main=plus.android.runtimeMainActivity();
		var clip=main.getSystemService(Context.CLIPBOARD_SERVICE);
		plus.android.invoke(clip, 'setText', 'http://www.abcdefg.com');
	}
	plus.nativeUI.toast('已复制');
}
</script>
<span onclick="sns_login('weixin');" id="weixin_login_a">微信登录</span><br/><br/>
<span onclick="fz();" id="weixin_fz_a">复制</span><br/><br/>
<span onclick="h5_share();" id="h5_share_a">share</span>
<div id="output" style="border: 1px solid #f00;padding: 10px;margin: 10px;"></div>
<?php var_dump($_SERVER); ?>