<?php
$ad_wz0='';
$ad_wz1='';
$ad_vc='';
if(isset($ad)){
	foreach($ad as $v){
		$ad_c='<p>';
		if($v->oss!='')$v->pic=$this->main->oss_url($v->oss);
		if($v->pic!=''){
			$ad_c.='<img src="'.$v->pic.'" style="width: 100%;" ggkjs="openu(\''.get_furl($v->url).'\');">';
		}else{
			$ad_c.='<a href="#" ggkjs="openu(\''.get_furl($v->url).'\');return false;">'.$v->title.'</a>';
		}
		$ad_c.='</p>';
		if($v->is_wz0>0)$ad_wz0=$ad_c;
		if($v->is_wz1>0)$ad_wz1=$ad_c;
		$ad_vc.='<div class="ad_ad_v">'.$ad_c.'</div>';
	}
}
?>
<h2 contenteditable="true" class="edit_title_v"><?php echo $pt; ?></h2>
<div id="main_content"><?php
if($user->is_ad_wz0>0)echo $ad_wz0;
echo $pc;
if($user->is_ad_wz1>0)echo $ad_wz1;
?></div>
<div id="a_menu" style="display: none;">
	<div class="a_menu_a"><a href="#" id="am_ad">广告素材</a></div>
	<div class="a_menu_a"><a href="#" id="am_del">删除本段</a></div>
	<div class="a_menu_a"><a href="#" id="am_ad_text">插文字广告</a></div>
	<div class="a_menu_a"><a href="#" id="am_ad_pic">插图片广告</a></div>
	<div class="a_menu_x"><a href="#" id="am_x">X</a></div>
</div>
<div class="ad_v" id="ad_ad" style="display: none;">
	<div class="center"><a href="#" class="ad_v_ba">返回</a></div>
	<?php
	if($ad_vc!=''){
		echo $ad_vc;
	}else{
		echo '<br/><br/>没有广告素材';
	}
	?>
</div>
<div class="ad_v" id="ad_text" style="display: none;">
	<div class="form_line">
		<input id="ad_text_t" class="form_i" placeholder="请输入广告文字">
	</div>
	<div class="form_line">
		<input id="ad_text_u" class="form_i" placeholder="请输入广告链接">
	</div>
	<input type="button" class="form_bt" id="ad_text_bt" value="添加">
	<div class="center"><a href="#" class="ad_v_ba">返回</a></div>
</div>
<div class="ad_v" id="ad_pic" style="display: none;">
	<div class="form_line">
		<input id="ad_pic_u" class="form_i" placeholder="请输入广告链接">
		<input id="ad_pic_p" type="hidden">
	</div>
	<div class="form_line">
		<form method="post" action="<?php echo getpageurl($cname.'/ad_pic_post/'); ?>" id="ad_pic_f" target="ad_pic_if" enctype="multipart/form-data">
			<input id="ad_pic_f" type="file" class="form_i" name="ad_file" accept="image/*">
		</form>
		<input id="ad_pic_pl" class="form_i" value="图片上传中……" readonly style="display: none;">
		<div id="ad_pic_pv" style="display: none;"></div>
	</div>
	<input type="button" class="form_bt" id="ad_pic_bt" value="添加">
	<div class="center"><a href="#" class="ad_v_ba">返回</a></div>
</div>
<div class="ad_menu bottom_menu">
	<b></b>
	<a href="#" id="save_bt"><span style="border-color: #036;border-right: 0;background: #036;color: #fff;">保存</span></a>
	<a href="<?php echo getpageurl($cname.'/'); ?>"><span>放弃</span></a>
	<b></b>
</div>
<div style="display: none;">
	<form method="post" action="<?php echo getpageurl($cname.'/edit_post/'); ?>" id="lo_form">
		<input id="i_title" name="title">
		<textarea name="content" id="i_content"></textarea>
		<?php if(isset($topic))echo '<input type="hidden" name="id" value="'.$topic->topic_id.'">'; ?>
	</form>
	<iframe src="about:blank" id="ad_pic_if" name="ad_pic_if"></iframe>
</div>
<script type="text/javascript">
var current_o=$('#a_menu');
var is_save=0;
var is_up=0;

function openu(u){
	return true;
}

function edit_content(){
	<?php
	$a_blo=array('p', 'div', 'table', 'blockquote', 'img', 'fieldset', 'section');
	foreach($a_blo as $v){
	?>
	$('#main_content').find('<?php echo $v; ?>').click(function(event){
		event.stopPropagation();
		edit($(this));
		return false;
	});
	<?php } ?>
}

function edit(o){
	if(is_save==0){
		current_o.removeClass('weimei_edit_v');
		current_o=o;
		current_o.addClass('weimei_edit_v');
		var co=current_o.offset();
		var h=current_o.outerHeight();
		var t=co.top+h+10;
		$('#a_menu').css('top', t+'px');
		$('#a_menu').show();
	}
}

function ue(){
	alert('上传错误');
	$('#ad_pic_pl').hide();
	$('#ad_pic_f').val('');
	$('#ad_pic_f').show();
	is_up=0;
}

function uf(u){
	$('#ad_pic_pl').hide();
	var html='<a href="#" onclick="re_upload();return false;">重新上传</a><br/><img src="'+u+'" style="width: 100%;">';
	$('#ad_pic_pv').html(html);
	$('#ad_pic_pv').show();
	$('#ad_pic_p').val(u);
	is_up=0;
}

function re_upload(){
	$('#ad_pic_pv').hide();
	$('#ad_pic_f').val('');
	$('#ad_pic_f').show();
	$('#ad_pic_pv').html('');
}

$(function(){
	edit_content();
	$('#am_del').click(function(){
		if(is_save==0){
			$('#a_menu').hide();
			current_o.remove();
			current_o=$('#a_menu');
			edit_content();
		}
		return false;
	});
	$('#am_ad').click(function(){
		if(is_save==0){
			$('#ad_ad').show();
		}
		return false;
	});
	$('#am_ad_text').click(function(){
		if(is_save==0){
			$('#ad_text').show();
		}
		return false;
	});
	$('#am_ad_pic').click(function(){
		if(is_save==0){
			$('#ad_pic').show();
		}
		return false;
	});
	$('#am_x').click(function(){
		if(is_save==0){
			$('#a_menu').hide();
			current_o.removeClass('weimei_edit_v');
		}
		return false;
	});
	$('.ad_ad_v').click(function(){
		if(is_save==0){
			var html=$(this).html();
			current_o.after(html);
			edit_content();
			$('.ad_v').hide();
		}
		return false;
	});
	$('#ad_text_bt').click(function(){
		if(is_save==0){
			var u=$.trim($('#ad_text_u').val());
			var t=$.trim($('#ad_text_t').val());
			if(u=='')$('#ad_text_u').addClass('error');
			if(t=='')$('#ad_text_t').addClass('error');
			if(u!='' && t!=''){
				var html='<p><a href="#" ggkjs="openu(\''+u+'\');return false;">'+t+'</a></p>';
				current_o.after(html);
				edit_content();
				$('#ad_text_u').val('');
				$('#ad_text_t').val('');
				$('.ad_v').hide();
			}
		}
	});
	$('#ad_pic_f').change(function(){
		if(is_up==0){
			$('#ad_pic_f').submit();
			$('#ad_pic_f').hide();
			$('#ad_pic_pl').show();
			is_up=1;
		}else{
			alert('图片正在上传');
		}
	});
	$('#ad_pic_bt').click(function(){
		if(is_save==0 && is_up==0){
			var u=$.trim($('#ad_pic_u').val());
			var p=$.trim($('#ad_pic_p').val());
			if(u=='')$('#ad_pic_u').addClass('error');
			if(p=='')$alert('请选取图片');
			if(u!='' && p!=''){
				var html='<p><img src="'+p+'" style="width: 100%;" ggkjs="openu(\''+u+'\');"></p>';
				current_o.after(html);
				edit_content();
				$('#ad_pic_u').val('');
				$('#ad_pic_p').val('');
				$('#ad_pic_f').val('');
				$('.ad_v').hide();
				re_upload();
			}
		}else{
			alert('图片正在上传');
		}
	});
	$('.ad_v_ba').click(function(){
		if(is_save==0){
			$('.ad_v').hide();
		}
		return false;
	});
	$('#save_bt').click(function(){
		if(is_save==0){
			$('#am_x').click();
			is_save=1;
			var t=to_txt($('.edit_title_v').text());
			t=$.trim(t);
			if(t!=''){
				$('#i_title').val(t);
				$('#i_content').val($('#main_content').html());
				$('#lo_form').submit();
			}else{
				is_save=0;
				alert('标题不能为空');
			}
		}
		return false;
	});
	if($('img[data-src]').length>0){
		$('img[data-src]').each(function(){
			var p=$(this).data('src');
			if(p!=''){
				$(this).attr('src', '<?php echo getpageurl($cname.'/pic_view/'); ?>?p='+encodeURI(p));
			}
		});
	}
});
</script>