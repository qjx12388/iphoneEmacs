<h2 class="center">登录</h2>
<form method="post" action="<?php echo getpageurl($cname.'/login_post/'); ?>" id="lo_form">
	<div class="form_line">
		<input name="username" class="form_i" placeholder="输入手机号" require>
	</div>
	<div class="form_line">
		<input name="password" type="password" class="form_i" placeholder="输入密码" require>
	</div>
	<input type="submit" class="form_bt" id="form_bt" value="提交">
</form>
<div class="center">
	<br/><br/>
	<a href="<?php echo getpageurl($cname.'/reg/'); ?>">注册新用户</a>
	<br/><br/>
	<a href="<?php echo getpageurl($cname.'/reset_pwd/'); ?>">忘记密码？</a>
</div>
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