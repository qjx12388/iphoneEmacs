<?php
if($user->name=='')$user->name=$user->username;
$a_side['home'][0]=array('主页', 'admin/', 'fa-th-large');
$a_side['topic'][0]=array('好文章管理', 'admin/topic/', 'fa-list');
$a_side['user'][0]=array('用户管理', 'admin/user/', 'fa-users');
$a_side['utopic'][0]=array('文章管理', 'admin/utopic/', 'fa-bars');
$a_side['tx'][0]=array('提现管理', 'admin/tx/', 'fa-money');
$a_side['pay_log'][0]=array('支付记录', 'admin/pay_log/', 'fa-cc');
if($user->tid>0)$a_side['setting'][0]=array('系统设置', 'admin/setting/', 'fa-cogs');
$a_side['profile'][0]=array('个人资料', 'admin/profile/', 'fa-dashboard');
?>
	<nav class="navbar-default navbar-static-side" role="navigation">
		<div class="sidebar-collapse">
			<ul class="nav" id="side-menu">
				<li class="nav-header">
					<div class="dropdown profile-element">
						<a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">
							<span class="clear">
								<span class="block m-t-xs">
									<strong class="font-bold"><?php echo $user->name; ?></strong>
							 	</span>
							 	<span class="text-muted text-xs block">
							 		管理员
							 		<b class="caret"></b>
							 	</span>
						 	</span>
						</a>
						<ul class="dropdown-menu animated fadeInRight m-t-xs">
							<li><a href="<?php echo getpageurl('admin/profile/'); ?>">个人资料</a></li>
							<li><a href="<?php echo getpageurl('admin/logout/'); ?>">安全退出</a></li>
						</ul>
					</div>
					<div class="logo-element">传</div>
				</li>
				<?php
				foreach($a_side as $k=>$v){
					echo '<li'.((isset($side) && $side==$k)?' class="active"':'').'>';
					echo '<a href="'.getpageurl($v[0][1]).'"><i class="fa '.$v[0][2].'"></i> <span class="nav-label">'.$v[0][0].'</span>';
					if(isset($v[1])){
						echo ' <span class="fa arrow"></span></a>';
						echo '<ul class="nav nav-second-level">';
						foreach($v[1] as $sk=>$sv){
							echo '<li'.((isset($side) && $side==$k && isset($side_s) && $side_s==$sk)?' class="active"':'').'><a href="'.getpageurl($sv[1]).'">'.$sv[0].'</a></li>';
						}
						echo '</ul>';
					}else{
						echo '</a>';
					}
					echo '</li>';
				}
				?>
			</ul>
		</div>
	</nav>
	<div id="page-wrapper" class="gray-bg dashbard-1">
		<div class="row border-bottom">
			<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
				<div class="navbar-header">
					<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="javascript:void(0);"><i class="fa fa-bars"></i> </a>
				</div>
				<ul class="nav navbar-top-links navbar-right">
					<li>
						<span class="m-r-sm text-muted welcome-message"><a href="<?php echo getpageurl('admin/'); ?>" title="返回首页"><i class="fa fa-home"></i></a>欢迎使用文章传播系统</span>
					</li>
					<li>
						<a href="<?php echo getpageurl('admin/logout/'); ?>">
							<i class="fa fa-sign-out"></i> 退出
						</a>
					</li>
				</ul>
			</nav>
		</div>