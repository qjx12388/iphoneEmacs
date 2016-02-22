<?php
$is_h5app=is_h5app()?1:0;
?>
<h2 class="center">登录</h2>
<div class="center" style="padding: 20px;">已经发放<span style="color: #f00;"><?php echo floor(time()/30000); ?></span>元奖金</div>
<form method="post" action="<?php echo getpageurl($cname.'/login_post/'); ?>" id="lo_form">
	<div class="form_line">
		<input name="username" class="form_i" placeholder="输入手机号" require>
	</div>
	<div class="form_line">
		<input name="password" type="password" class="form_i" placeholder="输入密码" require>
	</div>
	<div class="center">
		<input name="reme" type="checkbox" value="1">保存帐号密码
	</div>
	<input type="submit" class="form_bt" id="form_bt" value="提交">
</form>
<div class="center">
	<?php
	if($is_h5app>0){
		echo '<span id="wx_login_v" style="display: none;"><br/><br/><a href="#" onclick="h5_login(\'weixin\');return false;">微信一键登录</a></span>';
	}else{
		echo '<br/><br/><a href="'.getpageurl($cname.'/wx/').'">微信一键登录</a>';
	}
	?>
	<br/><br/>
	<a href="<?php echo getpageurl($cname.'/reg/'); ?>">注册新用户</a>
	<br/><br/>
	<a href="<?php echo getpageurl($cname.'/reset_pwd/'); ?>">忘记密码？</a>
</div>
<script type="text/javascript">
<?php if($is_h5app>0){ ?>
var is_wxbd=0;
var auths={};
function h5_ready(){
	if(plus.os.name=='iOS'){
		plus.oauth.getServices(function(services){
			for(var i in services){
				var service=services[i];
				if(service.id=='weixin'){
					is_wxbd=1;
					$('#wx_login_v').show();
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
								location.href='<?php echo getpageurl($cname.'/'); ?>';
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
<?php } ?>
$(function(){
	$('#lo_form').submit(function(){
		var is_jx=1;
		$(this).find("input[require]").each(function(){
			if($.trim($(this).val())==''){
				is_jx=0;
				$(this).addClass('error');
			}
		});
		if(is_jx>0){
			$('#form_bt').attr('disabled', 'disabled');
		}else{
			return false;
		}
	});
});
</script>