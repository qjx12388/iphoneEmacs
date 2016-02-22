<style type="text/css">
body {
	background: #f6f6f6;
}
</style>
<div class="my_list">
	<a href="<?php echo getpageurl($cname.'/profile_edit/'); ?>">名称<b><?php
	if($user->td_name==''){
		if($user->name=='')$user->name=mocode($user->username);
		$user->td_name=$user->name.'的团队';
	}
	echo $user->td_name;
	?></b></a>
	<span>成员<b><?php echo $user->c_td; ?>人</b></span>
	<span>收益<b><?php echo $user->c_tdsy/100; ?>元</b></span>
	<?php if($user->c_td>0){ ?>
	<a href="<?php echo getpageurl($cname.'/group_pk/'); ?>">团队PK</a>
	<?php } ?>
</div>
<?php if($user->c_td==0){ ?>
	<div class="center"><br/><br/>您的团队还没有成员，快去<a href="<?php echo getpageurl($cname.'/share_link/'); ?>">邀请</a></div>
<?php } ?>