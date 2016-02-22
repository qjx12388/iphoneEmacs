<?php
echo '<h2 class="center">个人资料</h2>';
echo '<form method="post" action="'.getpageurl($cname.'/profile_post/').'" class="content" id="lo_form">';
echo '<div class="form_line">姓名：<br/><input name="name" class="form_i" value="'.$user->name.'" placeholder="请输入姓名" require></div>';
echo '<div class="form_line">团队名称：<br/><input name="td_name" class="form_i" value="'.$user->td_name.'" placeholder="请输入团队名称"></div>';
echo '<input type="submit" class="form_bt" id="form_bt" value="修改">';
echo '</form>';
if($user->tid>0){
	echo '<h2 class="center" id="mob">绑定手机号</h2>';
	echo '<form method="post" action="'.getpageurl($cname.'/mob_post/').'" class="content" id="pw_form">';
	echo '<div class="form_line"><input name="mobile" class="form_i" id="mobile" placeholder="请输入手机号" require></div>';
	echo '<div class="form_line"><input type="button" class="form_bts" id="yzm_bt" value="获取手机验证码" require></div>';
	echo '<div class="form_line"><input name="yzm" class="form_i" id="yzm" placeholder="请输入手机验证码" require></div>';
	echo '<div class="form_line"><input name="password" type="password" class="form_i" id="password" placeholder="请输入登录密码" require></div>';
	echo '<div class="form_line"><input name="password_c" type="password" class="form_i" id="password_c" placeholder="请再次输入登录密码"></div>';
	echo '<input type="submit" class="form_bt" id="pw_form_bt" value="提交">';
	echo '</form>';
}else{
	echo '<h2 class="center">修改密码</h2>';
	echo '<form method="post" action="'.getpageurl($cname.'/password_post/').'" class="content" id="pw_form">';
	echo '<div class="form_line">用户名：'.$user->username.'</div>';
	echo '<div class="form_line"><input name="password_o" type="password" class="form_i" placeholder="请输入原密码" require></div>';
	echo '<div class="form_line"><input name="password_n" type="password" id="password_n" class="form_i" placeholder="请输入新密码" require></div>';
	echo '<div class="form_line"><input name="password_c" type="password" id="password_c" class="form_i" placeholder="请再次输入新密码"></div>';
	echo '<input type="submit" class="form_bt" id="pw_form_bt" value="修改">';
	echo '</form>';
}
?>
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
	<?php if($user->tid>0){ ?>
	$('#yzm_bt').click(function(){
		var m=$.trim($('#mobile').val());
		if(m!=''){
			$('#yzm_bt').attr('disabled', 'disabled');
			$('#yzm_bt').text('验证码已发送，请查看您的手机短信');
			$.getJSON('<?php echo getpageurl($cname.'/mob_yzm/'); ?>', {m:m}, function(data){
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
			$('#mobile').addClass('error');
		}
	});
	$('#pw_form').submit(function(){
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
			$('#pw_form_bt').attr('disabled', 'disabled');
		}else{
			return false;
		}
	});
	<?php }else{ ?>
	$('#pw_form').submit(function(){
		var is_jx=1;
		$(this).find("input[require]").each(function(){
			if($.trim($(this).val())==''){
				is_jx=0;
				$(this).addClass('error');
			}
		});
		if($.trim($('#password_n').val())!='' && $.trim($('#password_n').val())!=$.trim($('#password_c').val())){
			is_jx=0;
			$('#password_c').addClass('error');
		}
		if(is_jx>0){
			$('#pw_form_bt').attr('disabled', 'disabled');
		}else{
			return false;
		}
	});
	<?php } ?>
});
</script>