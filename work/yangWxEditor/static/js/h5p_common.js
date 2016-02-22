(function(w){
	function shield(){
		return false;
	}
	//document.addEventListener('touchstart',shield,false);
	//document.oncontextmenu=shield;
	
	function checkArguments(){
		var sk='';
		if(plus.runtime.launcher=='shortcut'){
			try{
				var cmd=JSON.parse(plus.runtime.arguments);
				var type=cmd&&cmd.type;
				switch(type){
					case 'shortcut_0':
						sk='shortcut_0';
					break;
					case 'shortcut_1':
						sk='shortcut_1';
					break;
					case 'shortcut_2':
						sk='shortcut_2';
					break;
					case 'shortcut_3':
						sk='shortcut_3';
					break;
					default:
					break;
				}
			}catch(e){
			}
		}
		if(sk!=''){
			var is_sck=0;
			var sc_k='shortcut_id';
			var s_length=plus.storage.getLength();
			if(s_length>0){
				for(var i=0;i<s_length;i++){
					var key=plus.storage.key(i);
					if(key==sc_k){
						var value=plus.storage.getItem(key);
						if(value==sk)is_sck=1;
					}
				}
			}
			if(is_sck==0){
				plus.storage.setItem(sc_k, sk);
				var u=$('#'+sk+'_u').val();
				location.href=u;
			}
		}
	}

	var ws=null;
	function plusReady(){
		ws=plus.webview.currentWebview();
		plus.key.addEventListener('backbutton',function(){
			back();
		},false);
		checkArguments();
		var uk='login_uid';
		if($('#h5p_logout').length>0 && $('#h5p_logout').val()=='1'){
			plus.storage.clear();
		}else if($('#h5p_uid').length>0 && $('#h5p_uid').val()!=''){
			var is_setli=0;
			var uv=$('#h5p_uid').val();
			var s_length=plus.storage.getLength();
			if(s_length>0){
				for(var i=0;i<s_length;i++){
					var key=plus.storage.key(i);
					if(key==uk){
						var value=plus.storage.getItem(key);
						if(value==uv){
							is_setli=1;
						}else{
							plus.storage.removeItem(key);
						}
					}
				}
			}
			if(is_setli==0)plus.storage.setItem(uk, uv);
		}else if($('#h5p_login').length>0 && $('#h5p_login').val()=='1'){
			var is_setli=0;
			var uv='0';
			var s_length=plus.storage.getLength();
			if(s_length>0){
				for(var i=0;i<s_length;i++){
					var key=plus.storage.key(i);
					if(key==uk){
						var value=plus.storage.getItem(key);
						if(value!='' && parseInt(value)>0){
							is_setli=1;
							uv=parseInt(value);
						}
					}
				}
			}
			if(is_setli>0)$.get($('#h5p_login_u').val()+uv);
		}
		if(plus.navigator.isImmersedStatusbar()){
			var bt=plus.navigator.getStatusbarHeight();
			$('body').css('padding-top', bt+'px');
		}
		if(typeof h5_ready==='function')h5_ready();
		if(typeof h5_ready_msg==='function')h5_ready_msg();
	}
	if(w.plus){
		plusReady();
	}else{
		document.addEventListener('plusready',plusReady,false);
	}

	document.addEventListener('DOMContentLoaded',function(){
		//document.body.onselectstart=shield;
	},false);

	document.addEventListener('newintent',function(){
		checkArguments();
	},false);

	w.back=function(hide){
		if(history.length>1){
			history.back();
		}else{
			w.close();
		}
	};
})(window);