<?php
$is_h5app=is_h5app()?1:0;
?>
<style type="text/css">
body {
	background: #f6f6f6;
}
</style>
<div class="my_list">
	<a href="<?php echo getpageurl('topic/my/'); ?>">我的文章</a>
	<a href="<?php echo getpageurl('ad/'); ?>">广告素材</a>
</div>
<div class="my_list">
	<a href="<?php echo getpageurl($cname.'/cz/'); ?>">我的资金<b><?php echo $user->ye/100; ?>元</b></a>
	<?php
	/*
	if($main->hl_td>0 && $user->is_hl_td==0 && $user->regdate>(time()-(86400*$main->hl_td_d))){
		echo '<a href="#" onclick="show_hl_msg();return false;">待激活红利<b>'.($main->hl_td/100).'元</b></a>';
	}
	*/
	?>
	<a href="<?php echo getpageurl($cname.'/tx/'); ?>">申请提现</a>
	<a href="<?php echo getpageurl($cname.'/hy/'); ?>">会员升级</a>
	<a href="<?php echo getpageurl($cname.'/group/'); ?>">我的团队</a>
</div>
<div class="my_list">
	<a href="<?php echo getpageurl($cname.'/profile/'); ?>">个人资料</a>
	<a href="<?php echo getpageurl($cname.'/share_link/'); ?>">推广链接</a>
</div>