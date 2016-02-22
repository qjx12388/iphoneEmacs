<?php
echo '<div class="content">';
echo '<div class="content_menu">';
echo '<a href="'.getpageurl($cname.'/my/').'"><span'.($search['oid']==0?' class="current"':'').'>最新</span></a>';
echo '<a href="'.getpageurl($cname.'/my/').'?o=1" style="width: 34%;"><span style="border-left: 1px solid #ccc;border-right: 1px solid #ccc;"'.($search['oid']==1?' class="current"':'').'>最多浏览</span></a>';
echo '<a href="'.getpageurl($cname.'/my/').'?o=2"><span'.($search['oid']==2?' class="current"':'').'>最多转发</span></a>';
echo '</div>';
if(isset($sql)){
	foreach($sql as $v){
		echo '<div class="topic_list">';
		echo '<a href="'.getpageurl($cname.'/view/'.$v->topic_id.'/').'" class="topic_list_t">'.$v->title.'</a>';
		echo '<span>'.date('Y-n-j H:i', $v->datetime).'，转发：'.$v->c_zf.'，浏览：'.$v->c_read;
		echo '<br/><a href="'.getpageurl($cname.'/edit/').'?id='.$v->topic_id.'">修改</a>';
		echo ' | <a href="#" onclick="if(confirm(\'确定要删除？\'))location.href=\''.getpageurl($cname.'/del/'.$v->topic_id.'/').'?'.http_build_query($search).'\';return false;">删除</a>';
		echo '</span>';
		echo '</div>';
	}
	if(isset($page) && $page!='')echo $page;
}else{
	echo '<div class="center"><br/><br/>没有符合条件的文章</div>';
}
echo '</div>';
?>