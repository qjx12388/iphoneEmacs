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
	<?php
	if(isset($tu)){
		if($tu->name!=''){
			$tn=$tu->name.'（'.mocode($tu->username).'）';
		}else{
			$tn=mocode($tu->username);
		}
		echo '<span>推荐人<b>'.$tn.'</b></span>';
	}
	$is_hy=$user->hydate>time()?1:0;
	?>
	<span>会员状态<b><?php echo $is_hy>0?'付费会员':'免费会员'; ?></b></span>
	<?php if($is_hy>0){ ?>
	<span>到期时间<b><?php echo date('Y-n-j H:i', $user->hydate); ?></b></span>
	<?php } ?>
	<span><?php echo $is_hy?'续费':'升级'; ?>费用<b><?php echo $main->fy/100; ?>元/年</b></span>
</div>
<?php
if($main->fy>0){
	echo '<form method="post" action="'.getpageurl($cname.'/hy_post/').'">';
	if($user->ye>=$main->fy){
		echo '<div class="center">付费方式：<select name="fkfs"><option value="0">微信支付</option><option value="1">账户余额（'.($user->ye/100).'元）</option></select></div>';
	}
	echo '<input type="submit" value="支付服务费：'.($main->fy/100).'元/年" class="home_url_bt">';
	echo '</form>';
}
?>
<div class="content">
	<?php if($main->is_cs>0){ ?>
	<div class="center" style="color: #f00;"><br/>现在属于内测期间，免费用户可以使用所有的功能<br/><br/></div>
	<?php } ?>
	<h3>免费用户和付费用户区别</h3>
	<ul>
		<!--<li>免费用户不能导入外面的文章</li>-->
		<li>免费用户文章中会添加广告客推广广告</li>
		<li>免费用户可永久使用“好文章”中的文章</li>
		<li>免费用户不能获得推荐付费用户的收益</li>
	</ul>
</div>