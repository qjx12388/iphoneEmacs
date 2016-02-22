<h2 class="center">重置密码</h2>
<form method="post" action="<?php echo getpageurl($cname.'/reset_pwd_post/'); ?>" id="lo_form">
	<div class="form_line">
		<input name="username" class="form_i" id="username" placeholder="输入手机号" require>
	</div>
	<div class="form_line">
		<input type="button" class="form_bts" id="yzm_bt" value="获取验证码" require>
	</div>
	<div class="form_line">
		<input name="yzm" class="form_i" id="yzm" placeholder="输入验证码" require>
	</div>
	<div class="form_line">
		<input name="password" type="password" class="form_i" id="password" placeholder="输入新密码" require>
	</div>
	<div class="form_line">
		<input name="password_c" type="password" class="form_i" id="password_c" placeholder="再次输入新密码">
	</div>
	<input type="submit" class="form_bt" id="form_bt" value="提交">
</form>
<div class="center">
	<br/><br/>
	<a href="<?php echo getpageurl($cname.'/login/'); ?>">登录</a>
</div>
<script type="text/javascript">
$(function(){
	$('#yzm_bt').click(function(){
		var m=$.trim($('#username').val());
		if(m!=''){
			$('#yzm_bt').attr('disabled', 'disabled');
			$('#yzm_bt').text('验证码已发送');
			$.getJSON('<?php echo getpageurl($cname.'/reset_pwd_yzm/'); ?>', {m:m}, function(data){
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