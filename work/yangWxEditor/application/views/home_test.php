<h2 contenteditable="true" class="edit_title_v">转发v啊嘎水电费</h2>
<div id="main_content">
	<p>asdasd</p>
	<p>asddddddddasd</p>
	<div>
		<table><tr><td>asdasda</td></tr></table>
		<blockquote>asdasccxxxx</blockquote>
		zzzzzzzz
		<p>asdasd</p>
	</div>
</div>
<input type="button" value="保存" id="save_bt">
<div id="a_menu" style="display: none;">
	<div class="a_menu_a"><a href="#">素材库</a></div>
	<div class="a_menu_a"><a href="#" id="am_del">删除本段</a></div>
	<div class="a_menu_a"><a href="#" id="am_ad_text">插文字广告</a></div>
	<div class="a_menu_a"><a href="#">插图片广告</a></div>
	<div class="a_menu_x"><a href="#" id="am_x">X</a></div>
</div>
<script type="text/javascript">
var current_o=$('#a_menu');
function edit_content(){
	$('#main_content').find('p').click(function(event){
		event.stopPropagation();
		edit($(this));
		return false;
	});
	$('#main_content').find('table').click(function(event){
		event.stopPropagation();
		edit($(this));
		return false;
	});
	$('#main_content').find('div').click(function(event){
		event.stopPropagation();
		edit($(this));
		return false;
	});
	$('#main_content').find('blockquote').click(function(event){
		event.stopPropagation();
		edit($(this));
		return false;
	});
	$('#main_content').find('img').click(function(event){
		event.stopPropagation();
		edit($(this));
		return false;
	});
}

function edit(o){
	current_o.removeClass('weimei_edit_v');
	current_o=o;
	current_o.addClass('weimei_edit_v');
	var co=current_o.offset();
	var h=current_o.outerHeight();
	var t=co.top+h+10;
	$('#a_menu').css('top', t+'px');
	$('#a_menu').show();
}

$(function(){
	edit_content();
	$('#am_del').click(function(){
		$('#a_menu').hide();
		current_o.remove();
		current_o=$('#a_menu');
		edit_content();
		return false;
	});
	$('#am_ad_text').click(function(){
		var html='<p><a href="http://www.abc.com/">aaaaaaa</a></p>';
		current_o.after(html);
		edit_content();
		return false;
	});
	$('#am_x').click(function(){
		$('#a_menu').hide();
		current_o.removeClass('weimei_edit_v');
		return false;
	});
	$('#save_bt').click(function(){
		$('#am_x').click();
		alert($('#main_content').html());
	});
});
</script>