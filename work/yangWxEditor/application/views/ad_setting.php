<?php
echo '<form method="post" action="'.getpageurl($cname.'/setting_post/').'" class="content" enctype="multipart/form-data" id="lo_form"><br/><br/>';
echo '<div class="form_line"><input name="is_ad_wz0" type="checkbox" value="1"'.($user->is_ad_wz0>0?' checked':'').'>开启文章头部默认广告</div>';
echo '<div class="form_line"><input name="is_ad_wz1" type="checkbox" value="1"'.($user->is_ad_wz1>0?' checked':'').'>开启文章尾部默认广告</div>';
echo '<input type="submit" class="form_bt" id="form_bt" value="提交">';
echo '<div class="center"><a href="'.getpageurl($cname.'/').'">返回</a></div>';
echo '</form>';
?>