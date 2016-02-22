<?php
$is_h5app=is_h5app()?1:0;
?>
<p></p><div class="center"><br>自媒体时代的营销利器——让转发的文章带上你的广告</div><br>广告客平台是一款嵌入式广告编辑平台，可以帮助企业、商家及个人在好文章中嵌入自己的图文、文字等广告信息的平台。它不仅让你在转发文章时快速嵌入你自己的广告，更可以通过推荐他人注册成为付费会员而获得额外收益。现仅开放100个注册名额，请立即注册：<h2 class="center">我要成为注册用户</h2>
<form method="post" action="<?php echo getpageurl($cname.'/reg_post/'); ?>" id="lo_form">
	<div class="form_line">
		<input name="username" class="form_i" id="username" placeholder="输入正确的手机号" require>
	</div>
	<div class="form_line">
		<input type="button" class="form_bts" id="yzm_bt" value="获取手机验证码" require>
	</div>
	<div class="form_line">
		<input name="yzm" class="form_i" id="yzm" placeholder="输入手机验证码" require>
	</div>
	<div class="form_line">
		<input name="password" type="password" class="form_i" id="password" placeholder="输入登录密码" require>
	</div>
	<div class="form_line">
		<input name="password_c" type="password" class="form_i" id="password_c" placeholder="再次输入登录密码">
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
	<a href="<?php echo getpageurl($cname.'/login/'); ?>">已注册，请登录</a>  |  <a href="http://mp.weixin.qq.com/s?__biz=MzA3NTY2OTc1Ng==&mid=401217499&idx=1&sn=b33aa5dfcece286c543cf4d37051326c&scene=0#wechat_redirect">查看帮助</a>
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
	$('#yzm_bt').click(function(){
		var m=$.trim($('#username').val());
		if(m!=''){
			$('#yzm_bt').attr('disabled', 'disabled');
			$('#yzm_bt').text('验证码已发送，请查看您的手机短信');
			$.getJSON('<?php echo getpageurl($cname.'/reg_yzm/'); ?>', {m:m}, function(data){
				console.log(data);
				if(data.success && data.success==1){
					$('#yzm').focus();
					setTimeout(function(){
						$('#yzm_bt').removeAttr('disabled');
						$('#yzm_bt').text('获取验证码');
					}, 300000);
				}else{
					$('#yzm_bt').removeAttr('disabled');
					$('#yzm_bt').text('获取验证码');
				}
				if(data.msg && data.msg!='')alert(data.msg);
			});
		}else{
			$('#username').addClass('error');
		}
	});
	$('#lo_form').submit(function(){
		var is_jx=1;
		$(this).find("input[require]").each(function(){
			if($.trim($(this).val())==''){
				is_jx=0;
				$(this).addClass('error');
			}
		});
		if($.trim($('#password').val())!='' && $.trim($('#password').val())!=$.trim($('#password_c').val())){
			is_jx=0;
			$('#password_c').addClass('error');
		}
		if(is_jx>0){
			$('#form_bt').attr('disabled', 'disabled');
		}else{
			return false;
		}
	});
});
</script>