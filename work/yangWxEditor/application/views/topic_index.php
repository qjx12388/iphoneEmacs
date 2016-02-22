<?php
$is_login=(isset($user->user_id) && $user->user_id>0)?1:0;
$is_ffgn=0;
if($is_login>0 && ($user->hydate>time() || $main->is_cs>0 || ($main->mfts>0 && ($user->regdate+($main->mfts*86400))>time()))){
	$is_ffgn=1;
}
if($is_login>0)$is_ffgn=1;
if($is_ffgn>0){
	echo '<form method="post" action="'.getpageurl($cname.'/edit/').'?p=1">';
}else{
	echo '<div onclick="'.($is_login>0?'alert(\'只有付费用户才可以使用本功能\');':'location.href=\''.getpageurl('user/login/').'\';').'">';
}
echo '<input name="url" placeholder="点击一下，键盘出现后，再长按粘贴文章链接" class="home_url_i">';
echo '<input type="'.($is_ffgn>0?'submit':'button').'" value="打 开" class="home_url_bt">';
if($is_ffgn>0){
	echo '</form>';
}else{
	echo '</div>';
}
echo '<div class="content">';
echo '<div class="content_menu">';
echo '<a href="'.getpageurl($cname.'/').'"><span'.($search['oid']==0?' class="current"':'').'>最新</span></a>';
echo '<a href="'.getpageurl($cname.'/').'?o=1" style="width: 34%;"><span style="border-left: 1px solid #ccc;border-right: 1px solid #ccc;"'.($search['oid']==1?' class="current"':'').'>最多浏览</span></a>';
echo '<a href="'.getpageurl($cname.'/').'?o=2"><span'.($search['oid']==2?' class="current"':'').'>最多转发</span></a>';
echo '</div>';
if(isset($sql)){
	foreach($sql as $v){
		echo '<a href="'.getpageurl($cname.'/edit/').'?id='.$v->topic_id.'" class="topic_list">';
		echo '<b>'.$v->title.'</b>';
		echo '<span>'.date('Y-n-j H:i', $v->datetime).'，转发：'.$v->c_zf.'，浏览：'.$v->c_read.'</span>';
		echo '</a>';
	}
	if(isset($page) && $page!='')echo $page;
}else{
	echo '<div class="center"><br/><br/>没有符合条件的文章</div>';
}
echo '</div>';
?>