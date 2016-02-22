<?php
$is_h5=is_h5app()?1:0;
$is_login=(isset($user->user_id) && $user->user_id>0)?1:0;
$is_ffgn=0;
echo '<div class="center"><br>自媒体时代的营销利器——让转发的文章带上你的广告</div>';
if($is_login>0 && ($user->hydate>time() || $main->is_cs>0 || ($main->mfts>0 && ($user->regdate+($main->mfts*86400))>time()))){
	$is_ffgn=1;
}
if($is_login>0)$is_ffgn=1;
if($is_ffgn>0){
	echo '<form method="post" action="'.getpageurl('topic/edit/').'?p=1">';
}else{
	echo '<div onclick="'.($is_login>0?'alert(\'只有付费用户才可以使用本功能\');':'location.href=\''.getpageurl('user/login/').'\';').'">';
}
echo '<textarea name="url" id="url_i" placeholder="点击一下，键盘出现后，再长按粘贴文章链接" style="height: 120px;" class="home_url_i"'.($is_ffgn>0?'':' readonly').'></textarea>';
echo '<input type="'.($is_ffgn>0?'submit':'button').'" value="提交并编辑" class="home_url_bt" style="height: 40px;font-size: 18px;">';
if($is_ffgn>0){
	echo '</form>';
}else{
	echo '</div>';
}
?>
<div class="content">
	<?php if($is_h5==0){ ?>
	<div class="center">
	<a href="http://mp.weixin.qq.com/s?__biz=MzA3NTY2OTc1Ng==&mid=401217499&idx=1&sn=b33aa5dfcece286c543cf4d37051326c&scene=0#wechat_redirect">不会操作请查看使用帮助</a>
	</div>
	<?php } ?>
	<h3>在微信文章中插广告的三步骤</h3>
	<ol>
		<li>从“好文章”中选中文章、朋友圈或<a href="http://weixin.sogou.com/" style="color: #f00;">微信聚合平台</a>找出好文章。（高质量的文章可以带着你的广告实现病毒式营销）</li>
		<li>在朋友圈文章中点击右角的点号，点击”复制链接“获得文章链接。（可以关注”广告客“微信公众号，直接将网址发送即可进入编辑模式）</li>
		<li>在上方的框中粘贴网址链接，然后提交进入编辑功能，在文章中点击任何段落即会显示广告编辑功能，可以插入文字、图片等广告。（建议事先编辑好，就可以直接调用了）</li>
		<li>高效提示：第一步：收藏好本页面，每次用时直接在收藏中打开；第二步：在QQ浏览器中打开<a href="http://weixin.sogou.com/" style="color: #f00;">微信聚合平台</a>找到好文章复制网址；苹果手机双按HOME键/三星手机按左健切换，快速在两个窗口中交换可以大大提升效率。（以上反之亦可）</li>
	</ol>
	<?php if($main->is_cs>0){ ?>
	<div class="center" style="color: #f00;"><br/>现在属于内测期间，免费用户可以使用所有的功能<br/><br/></div>
	<?php } ?>
	<h3>免费用户和付费用户区别</h3>
	<ul>
		<!--<li>免费用户不能导入外面的文章</li>-->
		<li>免费用户文章中会添加广告客推广广告</li>
		<li>免费用户不能获得推荐付费用户的收益</li>
		<li>正式用户每推荐一个付费用户可以获得<font color=#f00><?php echo $main->fy_jl/100; ?>元</font></a>收益。</li>
		<?php if($main->mfts>0){ ?>
		<!--<li style="color: #f00;">免费用户注册后可以试用<?php echo $main->mfts; ?>天导入文章功能</li>-->
		<?php } ?>
	</ul>
</div>
<?php
if($main->fy>0 && ($is_login==0 || $user->hydate<=time())){
	echo '<input type="button" value="支付服务费：'.($main->fy/100).'元/年" class="home_url_bt" onclick="location.href=\''.getpageurl('user/hy/').'\';">';
}
if($is_h5==0){
	echo '<input type="button" value="下载APP" class="home_url_bt" onclick="location.href=\'http://pre.im/guanggaokeandroid\';">';
}
?>