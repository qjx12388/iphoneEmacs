<style type="text/css">
body {
	background: #f6f6f6;
}
</style>
<div class="my_list">
	<span>类型<b><?php echo $al[$user->tid]; ?>用户</b></span>
	<?php
	$kn='手机号';
	switch($user->tid){
		case $wx_tid:
			$kn='Openid';
			break;
	}
	?>
	<span><?php echo $kn; ?><b><?php echo $user->username; ?></b></span>
	<span>姓名<b><?php echo $user->name; ?></b></span>
	<span>账户余额<b><?php echo $user->ye/100; ?>元</b></span>
</div>
<?php
	echo '<form method="post" action="'.getpageurl($cname.'/cz_post/').'" id="lo_form">';
	echo '<div class="center">充值金额：<input name="je" size="5" class="form_si" require>元</div>';
	echo '<input type="submit" value="账户充值" class="home_url_bt" id="form_bt">';
	echo '</form>';
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
});
</script>