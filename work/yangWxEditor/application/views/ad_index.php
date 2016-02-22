<?php
echo '<div class="content">';
echo '<div class="center"><br/>';
echo '<a href="'.getpageurl($cname.'/add/').'">添加文字广告</a>';
echo ' | <a href="'.getpageurl($cname.'/add/1/').'">添加图片广告</a>';
echo ' | <a href="'.getpageurl($cname.'/setting/').'">广告设置</a>';
echo '</div>';
if(isset($sql)){
	foreach($sql as $v){
		echo '<div class="topic_list">';
		echo '<b>链接：'.get_furl($v->url).'<br/>';
		if($v->oss!='')$v->pic=$this->main->oss_url($v->oss);
		if($v->pic!=''){
			echo '<img src="'.$v->pic.'" style="width: 100%;">';
		}else{
			echo '文字：'.$v->title;
		}
		echo '</b>';
		echo '<span>';
		if($v->is_wz0>0){
			echo '文章头部默认广告 <a href="'.getpageurl($cname.'/wz/'.$v->ad_id.'/0/0/').'?'.http_build_query($search).'">取消</a>';
		}else{
			echo '<a href="'.getpageurl($cname.'/wz/'.$v->ad_id.'/0/1/').'?'.http_build_query($search).'">设置为文章头部默认广告</a>';
		}
		echo ' | ';
		if($v->is_wz1>0){
			echo '文章尾部默认广告 <a href="'.getpageurl($cname.'/wz/'.$v->ad_id.'/1/0/').'?'.http_build_query($search).'">取消</a>';
		}else{
			echo '<a href="'.getpageurl($cname.'/wz/'.$v->ad_id.'/1/1/').'?'.http_build_query($search).'">设置为文章尾部默认广告</a>';
		}
		echo '<br/>';
		echo '<a href="'.getpageurl($cname.'/edit/'.$v->ad_id.'/').'">修改</a>';
		echo ' | <a href="#" onclick="if(confirm(\'确定要删除？\'))location.href=\''.getpageurl($cname.'/del/'.$v->ad_id.'/').'?'.http_build_query($search).'\';return false;">删除</a>';
		echo '</span>';
		echo '</div>';
	}
	if(isset($page) && $page!='')echo $page;
}else{
	echo '<div class="center"><br/><br/>没有符合条件的广告</div>';
}
echo '</div>';
?>