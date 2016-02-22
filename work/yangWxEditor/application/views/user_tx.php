<?php
$is_h5app=is_h5app()?1:0;
?>
<style type="text/css">
body {
	background: #f6f6f6;
}
</style>
<div class="my_list">
	<span>我的资金<b><?php echo $user->ye/100; ?>元</b></span>
	<?php
	if($user->tid>0){
		echo '<a href="'.getpageurl($cname.'/profile_edit/').'#mob">手机号<b>未绑定，点击绑定</b></a>';
	}else{
		echo '<span>手机号<b>'.$user->username.'</b></span>';
	}
	if($user->openid!=''){
		echo '<span>微信用户<b>'.$user->openid.'</b></span>';
	}else{
		if($is_h5app>0){
			echo '<span onclick="h5_login(\'weixin\');">微信用户<b id="wx_bd_b">未绑定</b></span>';
		}else{
			echo '<a href="'.getpageurl($cname.'/wx/').'">微信用户<b>未绑定，点击绑定</b></a>';
		}
	}
	?>
</div>
<?php
if($user->openid=='' || $user->tid>0){
	if($user->openid=='')$a_m[]='绑定微信用户';
	if($user->tid>0)$a_m[]='绑定手机号';
?>
<div class="center"><br/><br/>请先<?php echo join('、', $a_m); ?>后才可以申请提现</div>
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
<?php }elseif($user->ye<=$main->tx_fy){ ?>
<div class="center"><br/><br/>您的余额不足以支付提现手续费<br/>提现手续费：<?php echo $main->tx_qs/100; ?>以内<?php echo $main->tx_fy/100; ?>元/次，<?php echo $main->tx_qs/100; ?>以上免手续费</div>
<?php }else{ ?>
<form method="post" action="<?php echo getpageurl($cname.'/tx_post/'); ?>" class="content" id="lo_form">
	<div class="form_line">
		<input name="je" class="form_i" placeholder="请输入提现金额" require>
	</div>
	<div class="center"><?php echo $main->tx_qs/100; ?>以内<?php echo $main->tx_fy/100; ?>元/次，<?php echo $main->tx_qs/100; ?>以上免手续费</div>
	<input type="submit" class="form_bt" id="form_bt" value="提现">
</form>
<script type="text/javascript">
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
<?php } ?>