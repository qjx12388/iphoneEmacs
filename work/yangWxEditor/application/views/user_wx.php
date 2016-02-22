<h2 class="center">绑定微信<br/></h2>
<?php if($main->wx_app_id!=''){ ?>
<div class="center" id="wx_login_v"></div>
<script type="text/javascript" src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
<script type="text/javascript">
var obj=new WxLogin({
	id: 'wx_login_v', 
	appid: '<?php echo $main->wx_app_id; ?>', 
	scope: 'snsapi_base,snsapi_userinfo', 
	redirect_uri: '<?php echo urlencode($rurl); ?>',
	state: '<?php echo $state; ?>',
	style: '',
	href: ''
});
</script>
<?php }else{ ?>
<div class="center"><br/><br/>缺少参数，无法绑定，请联系管理员</div>
<?php } ?>