<?php
$is_h5app=is_h5app()?1:0;
?>
<style type="text/css">
body {
	background: #f6f6f6;
}
</style>
<div class="my_list">
	<span>用户名<b><?php echo $user->tid>0?'-':$user->username; ?></b></span>
	<span>类型<b><?php echo $al[$user->tid]; ?>用户</b></span>
	<?php
	if($user->tid>0){
		echo '<a href="'.getpageurl($cname.'/profile_edit/').'#mob">手机号<b>未绑定，点击绑定</b></a>';
	}else{
		echo '<span>手机号<b>'.$user->username.'</b></span>';
	}
	if($user->tid!=$wx_tid){
		if($user->openid!=''){
			echo '<span>微信用户<b>'.$user->openid.'</b></span>';
		}else{
			if($is_h5app>0){
				echo '<span onclick="h5_login(\'weixin\');">微信用户<b id="wx_bd_b">未绑定</b></span>';
			}else{
				echo '<a href="'.getpageurl($cname.'/wx/').'">微信用户<b>未绑定，点击绑定</b></a>';
			}
		}
	}
	?>
	<a href="<?php echo getpageurl($cname.'/profile_edit/'); ?>">姓名<b><?php echo $user->name; ?></b></a>
	<a href="<?php echo getpageurl($cname.'/profile_edit/'); ?>">密码<b>******</b></a>
	<a href="<?php echo getpageurl($cname.'/profile_edit/'); ?>">团队<b><?php echo $user->td_name; ?></b></a>
	<?php
	//if($user->user_id==12)echo '<a href="'.getpageurl($cname.'/h5p/').'">Html5+</a>';
	if(isset($tu)){
		if($tu->name!=''){
			$tn=$tu->name.'（'.mocode($tu->username).'）';
		}else{
			$tn=mocode($tu->username);
		}
		echo '<span>推荐人<b>'.$tn.'</b></span>';
	}
	?>
</div>
<?php if($is_h5app>0){ ?>
<script type="text/javascript">
var is_wxbd=0;
var auths={};
function h5_ready(){
	if(plus.os.name=='iOS'){
		plus.oauth.getServices(function(services){
			for(var i in services){
				var service=services[i];
				if(service.id=='weixin'){
					is_wxbd=1;
					$('#wx_bd_b').html('未绑定，点击绑定');
				}
				auths[service.id]=service;
			}
		},function(e){
		});
	}
}

function h5_login(id){
	if(is_wxbd>0){
		var auth=auths[id];
		if(auth){
			is_wxbd=0;
			var w=plus.nativeUI.showWaiting();
			document.addEventListener('pause',function(){
				setTimeout(function(){
					w&&w.close();
					w=null;
				}, 10000);
			}, false);
			auth.login(function(){
				if(id=='weixin'){
					if(auth.authResult.openid && auth.authResult.openid!=''){
						$.getJSON('<?php echo getpageurl($cname.'/h5p_login/'); ?>?t=wx&sid='+auth.authResult.openid, function(data){
							w&&w.close();
							w=null;
							if(data.success && data.success==1){
								if(data.text)$('#wx_bd_b').html(data.text);
							}else{
								plus.nativeUI.alert('绑定失败，请重试', null, '登录');
								is_wxbd=1;
							}
						});
					}else{
						w&&w.close();
						w=null;
						plus.nativeUI.alert('绑定失败，请重试', null, '登录');
						is_wxbd=1;
					}
				}
			},function(e){
				w&&w.close();
				w=null;
				plus.nativeUI.alert('绑定失败，请重试', null, '登录');
				is_wxbd=1;
			});
		}else{
			plus.nativeUI.alert('绑定失败', null, '登录');
		}
	}
}
</script>
<?php } ?>