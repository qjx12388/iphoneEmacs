<style type="text/css">
body {
	background: #f6f6f6;
}
</style>
<div class="my_list">
	<span>订单名称<b><?php echo $dd->dd_name; ?></b></span>
	<span>订单费用<b><?php echo $dd->money/100; ?>元</b></span>
	<span>付费方式<b>微信支付</b></span>
</div>
<?php
$is_wxrq=is_wxrq()?1:0;
if($dd->isdh==0){
	$is_pay=0;
	if($main->wx_pay_o>0){
		if($main->wx_o_app_id!='' && $main->wx_o_app_secret!='' && $main->wx_o_pay_si!='' && $main->wx_o_pay_sk!='')$is_pay=1;
	}else{
		if($main->wx_app_id!='' && $main->wx_app_secret!='' && $main->wx_pay_si!='' && $main->wx_pay_sk!='')$is_pay=1;
	}
	if($main->fy>0 && $is_pay>0){
		if($is_wxrq>0 && isset($js_string) && $js_string!=''){
			echo '<span id="wx_bt_s"><input type="button" value="使用微信支付" class="home_url_bt" id="wxpay_bt"></span>';
			echo '<div class="center" id="wx_lo_s" style="display: none;"><br/><br/>交易成功，正在查询交易状态…</div><input type="hidden" id="is_wx" value="0">';
?><script type="text/javascript">
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady(){
	$('#is_wx').val('1');
}, false);

$(function(){
	$('#wxpay_bt').click(function(){
		if($('#is_wx').val()=='1'){
			WeixinJSBridge.invoke('getBrandWCPayRequest',
				<?php echo $js_string; ?>,
				function(res){
					if(res.err_msg=='get_brand_wcpay_request:ok'){
						$('#wx_bt_s').hide();
						$('#wx_lo_s').show();
						$('#wx_lo_s').load('<?php echo getpageurl($cname.'/wxpay_return/'.$dd->pay_id.'/'); ?>');
					}else{
						alert('交易失败');
					}
				}
			);
		}else{
			alert('请在微信界面使用微信支付功能');
		}
	});
});
</script><?php
		}elseif(isset($qr_url) && $qr_url!=''){
			echo '<div class="center"><br/>请使用微信扫描二维码完成支付';
			echo '<br/><br/>';
			echo '<span class="jqqr_v" data-u="'.$qr_url.'"></span>';
			echo '<br/><br/>';
			echo '支付完成后请刷新此页面';
			echo '</div>';
?>
<script type="text/javascript" src="static/js/jquery.qrcode.min.js"></script>
<script type="text/javascript">
function check_pay(){
	$.getJSON('<?php echo getpageurl($cname.'/pay_check/'.$dd->pay_id.'/'); ?>', function(data){
		console.log(data);
		if(data.success && data.success==1){
			location.href='<?php echo getpageurl($cname.'/pay_zf/'.$dd->pay_id.'/'); ?>';
		}else{
			setTimeout(function(){
				check_pay();
			}, 1000);
		}
	});
}
$(function(){
	$('.jqqr_v').qrcode($('.jqqr_v').data('u'));
	check_pay();
});
</script><?php
		}elseif($is_wxrq==0){
			echo '<div class="center"><br/><br/>请在微信界面使用微信支付功能<br/><br/>支付完成后请刷新此页面</div>';
		}else{
			echo '<div class="center"><br/><br/>支付信息错误</div>';
		}
	}else{
		echo '<div class="center"><br/><br/>付费方式错误</div>';
	}
}else{
	echo '<div class="center"><br/><br/>订单已支付成功</div>';
}
echo '<input type="button" value="返 回" class="home_url_bt" onclick="location.href=\''.getpageurl($cname.'/').'\';">';
?>