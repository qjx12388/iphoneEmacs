<?php
echo '<form method="post" action="'.getpageurl($cname.'/add_post/').'" class="content" enctype="multipart/form-data" id="lo_form">';
echo '<div class="form_line"><input name="url" class="form_i" placeholder="请输入广告链接" require></div>';
if($tid>0){
	echo '<div class="form_line"><input type="file" class="form_i" name="pic_file" accept="image/*"></div>';
}else{
	echo '<div class="form_line"><input name="title" class="form_i" placeholder="请输入广告文字" require></div>';
}
echo '<input type="submit" class="form_bt" id="form_bt" value="添加"><input type="hidden" name="t" value="'.$tid.'">';
echo '<div class="center"><a href="'.getpageurl($cname.'/').'">返回</a></div>';
echo '</form>';
?>
<script type="text/javascript">
$(function(){
	$('#lo_form').submit(function(){
		var is_jx=1;
		$(this).find("input[require]").each(function(){
			if($.trim($(this).val())==''){
				is_jx=0;
				$(this).addClass('error');
			}
		});
		if(is_jx>0){
			$('#form_bt').attr('disabled', 'disabled');
		}else{
			return false;
		}
	});
});
</script>