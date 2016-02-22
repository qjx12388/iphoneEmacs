<?php
echo '<h2 class="center">手机号重复绑定</h2>';
echo '<div class="content">';
echo '您提交的手机号（'.$user->tel.'）已被以下用户绑定<br/><br/>';
echo '手机：'.$mu->username.'<br/>';
echo '姓名：'.$mu->name.'<br/>';
echo '账户余额：'.($mu->ye/100).'元<br/><br/>';
echo '如果要继续绑定将会<b style="color: #f00;">删除该用户</b>，是否继续绑定？';
echo '</div>';
echo '<div class="center">';
echo '<input type="button" class="form_bt" value="继续绑定" onclick="location.href=\''.getpageurl($cname.'/mob_cf_post/').'\';">';
echo '<input type="button" class="form_bt" value="取消绑定" onclick="location.href=\''.getpageurl($cname.'/profile/').'\';">';
echo '</div>';
?>