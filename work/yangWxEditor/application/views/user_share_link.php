<?php
$is_h5app=is_h5app()?1:0;
echo '<h2 class="center">推广链接</h2>';
echo '<div class="form_line"><input class="form_i" id="qr_i" value="'.getpageurl($cname.'/reg/'.$user->code.'/').'" readonly></div>';
if($is_h5app>0)echo '<input type="button" value="复制网址" onclick="fzwz();" class="home_url_bt">';
echo '<div class="center" id="qr_v"></div>';
?>
<div class="content">
	<ul>
		<li>每推荐一位付费用户，你将获得<?php echo $main->fy_jl/100; ?>元的奖励</li>
		<li>软件服务费<?php echo $main->fy/100; ?>元/年</li>
		<li style="color: #f00;">免费用户或者付费状态到期的情况下不能获得当时推荐付费用户的收益</li>
	</ul>
</div>
<script type="text/javascript" src="static/js/jquery.qrcode.min.js"></script>
<script type="text/javascript">
function fzwz(){
	var url='<?php echo getpageurl($cname.'/reg/'.$user->code.'/'); ?>';
	if(plus.os.name=='iOS'){
		var UIPasteboard=plus.ios.importClass('UIPasteboard');
		var generalPasteboard=UIPasteboard.generalPasteboard();
		generalPasteboard.setValueforPasteboardType(url, 'public.utf8-plain-text');
	}else{
		var Context=plus.android.importClass('android.content.Context');
		var main=plus.android.runtimeMainActivity();
		var clip=main.getSystemService(Context.CLIPBOARD_SERVICE);
		plus.android.invoke(clip, 'setText', url);
	}
	plus.nativeUI.toast('网址已复制');
}

$(function(){
	$('#qr_v').qrcode($('#qr_i').val());
});
</script>