<div class="center"><br/><br/>&copy; <a href="http://www.guanggaoke.com/">广告客</a></div>
<?php
$is_h5=is_h5app()?1:0;
if(!isset($main))$main=$this->main->main();
if(!isset($hide_foot) || $hide_foot!=1){
?>
<div class="foot_menu bottom_menu">
	<a href="<?php echo getpageurl('home/'); ?>" data-id="0"><span><b>广告主</b></span></a>
	<a href="<?php echo getpageurl('topic/'); ?>" data-id="1"><span><b>广告客</b></span></a>
	<a href="<?php echo getpageurl('topic/'); ?>" data-id="2"><span><b>原创者</b></span></a>
	<a href="<?php echo getpageurl('user/'); ?>" data-id="3"><span style="border: 0;"><b>我的专区</b></span></a>
</div>
<div class="foot_smenu" id="smenu_0" style="left: 0;display: none;">
	<div id="smenum_0">
		<a href="<?php echo getpageurl('home/'); ?>" style="border: 0;">一键采集</a>
		<a href="<?php echo getpageurl('topic/'); ?>">网络文摘</a>
		<a href="<?php echo getpageurl('ad/'); ?>">广告素材</a>
	</div>
</div>
<div class="foot_smenu" id="smenu_1" style="left: 25%;display: none;">
	<div id="smenum_1">
		<a href="<?php echo getpageurl('user/share_link/'); ?>" style="border: 0;">推广链接</a>
	</div>
</div>
<div class="foot_smenu" id="smenu_2" style="left: 50%;display: none;">
	<div id="smenum_2">
		<a href="<?php echo getpageurl('user/cz/'); ?>" style="border: 0;">原创收益</a>
	</div>
</div>
<div class="foot_smenu" id="smenu_3" style="right: 0;display: none;">
	<div id="smenum_3">
		<a href="<?php echo getpageurl('user/cz/'); ?>" style="border: 0;">我的收益</a>
		<a href="<?php echo getpageurl('user/group/'); ?>">我的团队</a>
		<?php if($is_h5==0){ ?>
		<a href="http://pre.im/guanggaokeandroid">下载APP</a>
		<?php } ?>
		<a href="<?php echo getpageurl('user/'); ?>">个人信息</a>
		<a href="http://mp.weixin.qq.com/s?__biz=MzA3NTY2OTc1Ng==&mid=401217499&idx=1&sn=b33aa5dfcece286c543cf4d37051326c&scene=0#wechat_redirect">新手指南</a>
	</div>
</div>
<?php } ?>
<div style="display: none;">
	<input type="hidden" id="sm_c" value="n">
	<input type="hidden" id="sm_id" value="n">
	<input type="hidden" id="sm_cid" value="">
	<div id="wx_share_title"><?php
	if(!isset($m_title) || $m_title=='')$m_title=isset($page_title)?$page_title:'广告客-移动营销平台';
	echo $m_title;
	?></div>
	<div id="wx_share_content"><?php echo isset($m_content)?$m_content:''; ?></div>
	<div id="wx_share_url"><?php
	if(!isset($m_url) || $m_url==''){
		$rurl=$_SERVER['REQUEST_URI'];
		$a_glg=array('openid', 'openId', 'userId', 'bd_info', 'bd_sign', 'app_id', 'auth_code');
		foreach($a_glg as $v){
			if(isset($_GET[$v]))$rurl=str_replace($v.'='.$_GET[$v], '', $rurl);
		}
		$m_url='http://'.$_SERVER['HTTP_HOST'].$rurl;
	}
	echo isset($m_url)?$m_url:'';
	?></div>
	<div id="wx_share_pic"><?php echo isset($m_pic)?$m_pic:$this->config->item('base_url').'static/images/share.png'; ?></div>
	<iframe src="<?php echo getpageurl('home/wx_tx/'); ?>"></iframe>
</div>
<?php
if(!isset($is_home) || $is_home!=1){
	echo '<img src="static/images/home_bt.png" id="home_bt" onclick="location.href=\''.getpageurl('').'\';">';
}
if($is_h5>0){
	if(isset($is_logout) && $is_logout==1){
		echo '<input type="hidden" id="h5p_logout" value="1">';
	}elseif(isset($user->user_id) && $user->user_id>0){
		echo '<input type="hidden" id="h5p_uid" value="'.$user->user_id.'">';
	}else{
		echo '<input type="hidden" id="h5p_login" value="1">';
		echo '<input type="hidden" id="h5p_login_u" value="'.getpageurl('user/h5p_login/').'?id=">';
	}
	echo '<script type="text/javascript" src="static/js/h5p_common.js?'.time().'"></script>';
	echo '<link href="static/css/h5.css?'.time().'" rel="stylesheet" type="text/css" />';
	echo '<input type="hidden" id="shortcut_0_u" value="'.getpageurl('/').'">';
	echo '<input type="hidden" id="shortcut_1_u" value="'.getpageurl('topic/').'">';
	echo '<input type="hidden" id="shortcut_2_u" value="'.getpageurl('ad/').'">';
	echo '<input type="hidden" id="shortcut_3_u" value="'.getpageurl('user/').'">';
}
?>
<script type="text/javascript">
<?php
$is_hide_menu=0;
if(isset($hide_menu) && $hide_menu>0)$is_hide_menu=1;
if(isset($show_menu) && $show_menu>0)$is_hide_menu=0;
if(is_wxrq()){
	$jsticket=$this->main->wxjsticket($main->wx_app_id, $main->wx_app_secret, $main);
	$package=wx_js_package($jsticket);
?>
wx.config({
	<?php if(isset($wx_js_debug) && $wx_js_debug>0){ ?>
	debug: true,
	<?php } ?>
	appId: '<?php echo $main->wx_app_id;?>',
	timestamp: <?php echo $package['timestamp'];?>,
	nonceStr: '<?php echo $package['nonce'];?>',
	signature: '<?php echo $package['sign'];?>',
	jsApiList: [
		'onMenuShareTimeline',
		'onMenuShareAppMessage',
		'onMenuShareQQ',
		'onMenuShareWeibo',
		'showOptionMenu',
		'hideMenuItems',
		'previewImage'<?php
		if(isset($wx_js_api)){
			foreach($wx_js_api as $v)echo ', \''.$v.'\'';
		}
		?>
	]
});
wx.ready(function(){
	<?php if($is_hide_menu>0){ ?>
	wx.hideOptionMenu();
	<?php }else{ ?>
	wx.showOptionMenu();
	<?php } ?>
	set_wx_share();
	if(typeof wx_ready==='function')wx_ready();
});
<?php } ?>

function set_wx_share(){
	<?php if(is_wxrq()){ ?>
	wx.onMenuShareTimeline({
		title: $('#wx_share_title').text(),
		link: $('#wx_share_url').text(),
		imgUrl: $('#wx_share_pic').text(),
		success: function(){
			if(typeof wx_share_f==='function')wx_share_f();
			if(typeof wx_sharetl_f==='function')wx_sharetl_f();
		},
		cancel: function(){ }
	});
	wx.onMenuShareAppMessage({
		title: $('#wx_share_title').text(),
		desc: $('#wx_share_content').text(),
		link: $('#wx_share_url').text(),
		imgUrl: $('#wx_share_pic').text(),
		type: 'link',
		dataUrl: '',
		success: function(){
			if(typeof wx_share_f==='function')wx_share_f();
		},
		cancel: function(){ }
	});
	wx.onMenuShareQQ({
		title: $('#wx_share_title').text(),
		desc: $('#wx_share_content').text(),
		link: $('#wx_share_url').text(),
		imgUrl: $('#wx_share_pic').text(),
		type: 'link',
		dataUrl: '',
		success: function(){
			if(typeof wx_share_f==='function')wx_share_f();
		},
		cancel: function(){ }
	});
	wx.onMenuShareWeibo({
		title: $('#wx_share_title').text(),
		desc: $('#wx_share_content').text(),
		link: $('#wx_share_url').text(),
		imgUrl: $('#wx_share_pic').text(),
		type: 'link',
		dataUrl: '',
		success: function(){
			if(typeof wx_share_f==='function')wx_share_f();
		},
		cancel: function(){ }
	});
	<?php } ?>
}

function show_smenu(id){
	var mid=$('#sm_id').val();
	if(mid!=id){
		if(mid!='n')$('#smenu_'+mid).hide();
		$('#smenu_'+id).show();
		mid=id;
	}else{
		$('#smenu_'+id).hide();
		mid='n';
	}
	$('#sm_id').val(mid);
}

function show_sm(){
	setTimeout(function(){
		var mc=$('#sm_c').val();
		if(mc=='n'){
			$('.foot_smenu').hide();
		}else{
			show_smenu(mc);
		}
	}, 200);
}

<?php
if(isset($session['msg']) && $session['msg']!=''){
	$this->session->unset_userdata('msg');
	if($is_h5>0){
?>
function h5_ready_msg(){
	plus.nativeUI.alert('<?php echo $session['msg']; ?>', null, '信息');
}
<?php
	}else{
?>
alert('<?php echo $session['msg']; ?>');
<?php
	}
}
?>

$(function(){
	$('*').click(function(){
		$('#sm_c').val('n');
		show_sm();
	});
	$('.foot_menu a').click(function(e){
		e.stopPropagation();
		var id=$(this).data('id');
		$('#sm_cid').val(id);
		setTimeout(function(){
			$('#sm_c').val($('#sm_cid').val());
		}, 100);
		return false;
	});
})
</script>
<div style="display:none">
<script language="javascript" type="text/javascript" src="http://js.users.51.la/18767407.js"></script>
<noscript><a href="http://www.51.la/?18767407" target="_blank"><img alt="我要啦免费统计" src="http://img.users.51.la/18767407.asp" style="border:none" /></a></noscript>
</div>
</body>
</html>
