<?php
$is_h5app=is_h5app()?1:0;
$is_login=(isset($user->user_id) && $user->user_id>0)?1:0;
//if(isset($user->user_id) && $user->user_id==12)$is_h5app=1;
?><h2 class="view_title_v"><?php echo $topic->title; ?></h2>
<div class="view_title_info">
浏览：<?php echo $topic->c_read; ?>，转发：<span id="c_zf"><?php echo $topic->c_zf; ?></span>
<?php
if($topic->is_rw>0){
	echo '<br/>';
	echo '【推广】分享朋友圈可得 '.($topic->rw_fxjg/100).'元';
	if(($topic->rw_datee==0 || $topic->rw_datee>time()) && $topic->rw_fxc>$topic->c_rwzf){
		echo '，每天可有效转发'.$topic->rw_fxd.'次';
	}elseif($topic->rw_fxc<=$topic->c_rwzf){
		echo '（已超过最大转发次数，转发没有奖励）';
	}else{
		echo '（已超过有效期，转发没有奖励）';
	}
}
$ycff_c='';
if($topic->is_yc>0){
	echo '<br/>这是一篇原创文章';
	if($topic->yc_fxt==0 || $topic->yc_fxjg==0){
		echo '，您可以免费修改插入广告';
	}elseif($is_login==0){
		echo '，请先<a href="'.getpageurl('user/login/').'" style="color: #00f;text-decoration: underline;">登录</a>后再修改插入广告';
	}elseif($user->user_id!=$topic->user_id){
		if($topic->yc_fxt==1){
			if($is_fx>0){
				echo '，您已购买过转发权限，可以免费修改插入广告';
			}else{
				echo '，请先<a href="#" onclick="$(\'#ff_v\').show();return false;" style="color: #00f;text-decoration: underline;">付费'.($topic->yc_fxjg/100).'元购买修改权限</a>后才能修改插入广告';
				$ycff_c.='<div class="zfff_v" id="ff_v" style="display: none;">';
				$ycff_c.='<form method="post" action="'.getpageurl($cname.'/zfff_post/'.$topic->topic_id.'/').'">';
				if($user->ye>=$topic->yc_fxjg){
					$ycff_c.='<div class="center">付费方式：<select name="fkfs"><option value="0">微信支付</option><option value="1">账户余额（'.($user->ye/100).'元）</option></select></div>';
				}
				$ycff_c.='<input type="submit" value="支付：'.($topic->yc_fxjg/100).'元" class="home_url_bt">';
				$ycff_c.='<div class="center"><a href="#" onclick="$(\'#ff_v\').hide();return false;">取消</a></div>';
				$ycff_c.='</form>';
				$ycff_c.='</div>';
			}
		}else{
			if(isset($cl) && $cl->c_fx>$cl->c_fxyy){
				echo '，您还有'.($cl->c_fx-$cl->c_fxyy).'次修改插入广告的权限';
			}
			echo '，<a href="#" onclick="$(\'#ff_v\').show();return false;" style="color: #00f;text-decoration: underline;">付费'.($topic->yc_fxjg/100).'元/次购买修改权限</a>';
			$ycff_c.='<div class="zfff_v" id="ff_v" style="display: none;">';
			$ycff_c.='<form method="post" action="'.getpageurl($cname.'/zfff_post/'.$topic->topic_id.'/').'">';
			if($user->ye>=$topic->yc_fxjg){
				$ycff_c.='<div class="center">付费方式：<select name="fkfs"><option value="0">微信支付</option><option value="1">账户余额（'.($user->ye/100).'元）</option></select></div>';
			}
			$ycff_c.='<div class="center">单价：'.($topic->yc_fxjg/100).'元/次</div>';
			$ycff_c.='<div class="center">购买次数：<input name="cs" size="5" value="1" class="form_si" require></div>';
			$ycff_c.='<input type="submit" value="支付" class="home_url_bt">';
			$ycff_c.='<div class="center"><a href="#" onclick="$(\'#ff_v\').hide();return false;">取消</a></div>';
			$ycff_c.='</form>';
			$ycff_c.='</div>';
		}
	}
}
?></div>
<div id="main_content"><?php
if(isset($tu) && $tu->hydate<time()){
	if($main->ad_oss!='')$main->ad_pic=$this->main->oss_url($main->ad_oss);
	if($main->ad_pic!=''){
		echo '<p>';
		if($main->ad_u!='')echo '<a href="'.$main->ad_u.'">';
		echo '<img src="'.$main->ad_pic.'" style="width: 100%;">';
		if($main->ad_u!='')echo '</a>';
		echo '</p>';
	}
}
$content=str_replace(' ggkjs=', ' onclick=', $topic->content);
echo $content;
echo '</div>';
if($topic->is_yc>0){
	echo '<input type="button" value="打赏" class="home_url_bt" onclick="$(\'#ds_v\').show();">';
	$ycff_c.='<div class="zfff_v" id="ds_v" style="display: none;">';
	$ycff_c.='<form method="post" action="'.getpageurl($cname.'/dsff_post/'.$topic->topic_id.'/').'">';
	$ycff_c.='<div class="center">打赏金额：<input name="je" size="5" value="1" class="form_si" require>元</div>';
	if($is_login>0 && $user->ye>0){
		$ycff_c.='<div class="center">付费方式：<select name="fkfs"><option value="0">微信支付</option><option value="1">账户余额（'.($user->ye/100).'元）</option></select></div>';
	}
	$ycff_c.='<input type="submit" value="打赏" class="home_url_bt">';
	$ycff_c.='<div class="center"><a href="#" onclick="$(\'#ds_v\').hide();return false;">取消</a></div>';
	$ycff_c.='</form>';
	$ycff_c.='</div>';
}
if(isset($tl_0) || isset($tl_1) || isset($tl_2)){
	echo '<div class="content tl_v" id="tl_0">';
	echo '<div class="content_menu">';
	echo '<a href="#" onclick="return false;"><span class="current">最新</span></a>';
	echo '<a href="#" onclick="show_tl(\'1\');return false;" style="width: 34%;"><span style="border-left: 1px solid #ccc;border-right: 1px solid #ccc;">最多浏览</span></a>';
	echo '<a href="#" onclick="show_tl(\'2\');return false;"><span>最多转发</span></a>';
	echo '</div>';
	if(isset($tl_0)){
		foreach($tl_0 as $v){
			echo '<a href="'.getpageurl($cname.'/view/'.$v->topic_id.'/').'" class="topic_list">';
			echo '<b>'.$v->title.'</b>';
			echo '<span>'.date('Y-n-j H:i', $v->datetime).'，转发：'.$v->c_zf.'，浏览：'.$v->c_read.'</span>';
			echo '</a>';
		}
	}
	echo '</div>';
	echo '<div class="content tl_v" id="tl_1" style="display: none;">';
	echo '<div class="content_menu">';
	echo '<a href="#" onclick="show_tl(\'0\');return false;"><span>最新</span></a>';
	echo '<a href="#" onclick="return false;" style="width: 34%;"><span style="border-left: 1px solid #ccc;border-right: 1px solid #ccc;" class="current">最多浏览</span></a>';
	echo '<a href="#" onclick="show_tl(\'2\');return false;"><span>最多转发</span></a>';
	echo '</div>';
	if(isset($tl_1)){
		foreach($tl_1 as $v){
			echo '<a href="'.getpageurl($cname.'/view/'.$v->topic_id.'/').'" class="topic_list">';
			echo '<b>'.$v->title.'</b>';
			echo '<span>'.date('Y-n-j H:i', $v->datetime).'，转发：'.$v->c_zf.'，浏览：'.$v->c_read.'</span>';
			echo '</a>';
		}
	}
	echo '</div>';
	echo '<div class="content tl_v" id="tl_2" style="display: none;">';
	echo '<div class="content_menu">';
	echo '<a href="#" onclick="show_tl(\'0\');return false;"><span>最新</span></a>';
	echo '<a href="#" onclick="show_tl(\'1\');return false;" style="width: 34%;"><span style="border-left: 1px solid #ccc;border-right: 1px solid #ccc;">最多浏览</span></a>';
	echo '<a href="#" onclick="return false;"><span class="current">最多转发</span></a>';
	echo '</div>';
	if(isset($tl_2)){
		foreach($tl_2 as $v){
			echo '<a href="'.getpageurl($cname.'/view/'.$v->topic_id.'/').'" class="topic_list">';
			echo '<b>'.$v->title.'</b>';
			echo '<span>'.date('Y-n-j H:i', $v->datetime).'，转发：'.$v->c_zf.'，浏览：'.$v->c_read.'</span>';
			echo '</a>';
		}
	}
	echo '</div>';
}
if($share_code!=''){
	echo '<br/><br/><div class="center">文中广告由 广告客 文章编辑器插入';
	echo '<div id="qr_v" style="padding: 10px;"></div>';
	if($is_h5app==0)echo '长按扫描二维码，让你转发的文章也带上你的广告';
	echo '</div>';
}
$is_share=0;
if(isset($session['is_share']) && $session['is_share']==1){
	$this->session->unset_userdata('is_share');
	$is_share=1;
}
if($is_fx>0){
?>
<img src="static/images/edit_bt.png" id="edit_bt" onclick="location.href='<?php echo getpageurl($cname.'/edit/').'?id='.($topic->utid>0?$topic->utid:$topic->topic_id); ?>';">
<?php } ?>
<img src="static/images/share_bt.png" id="share_bt"<?php
//if($is_h5app>0)echo ' style="display: none;"';
?>>
<div class="share_v" style="display: none;"></div>
<?php
echo $ycff_c;
if($share_code!=''){
?>
<script type="text/javascript" src="static/js/jquery.qrcode.min.js"></script>
<?php } ?>
<script type="text/javascript">
function openu(u){
	<?php if($is_h5app>0){ ?>
	return true;
	<?php }else{ ?>
	location.href=u;
	<?php } ?>
}

function wx_share_f(){
	$('#c_zf').load('<?php echo getpageurl($cname.'/zf/'.$topic->topic_id.'/'); ?>');
	$('.share_v').hide();
}

function wx_sharetl_f(){
	$.get('<?php echo getpageurl($cname.'/rw_zf/'.$topic->topic_id.'/'); ?>');
}

function show_tl(id){
	$('.tl_v').hide();
	$('#tl_'+id).show();
}

<?php if($is_h5app>0){ ?>
var shares=null;
function h5_ready(){
	plus.share.getServices(function(s){
		shares={};
		for(var i in s){
			var t=s[i];
			if(t.id=='weixin'){
				shares[t.id]=t;
				$('#share_bt').show();
				<?php if($is_share>0){ ?>
				open_share();
				<?php } ?>
			}
		}
	}, function(e){
	});
}

var h5_share_c='<?php
$m_content=str_replace("\r", '', $m_content);
$m_content=str_replace("\n", '', $m_content);
echo $m_content;
?>';
var h5_share_u='<?php echo $m_url; ?>';
var h5_share_t='<?php
$m_title=str_replace("\r", '', $m_title);
$m_title=str_replace("\n", '', $m_title);
echo $m_title;
?>';
var h5_share_p='<?php echo isset($m_pic)?$m_pic:$this->config->item('base_url').'static/images/share.png'; ?>';

function h5_share(){
	var ids=[];
	var bts=[];
	var i=0;
	if(shares['weixin']){
		ids.push({id: 'weixin', ex: 'WXSceneSession'});
		bts.push({title: '发送给微信好友'});
		i++;
		ids.push({id: 'weixin', ex: 'WXSceneTimeline'});
		bts.push({title: '分享到微信朋友圈'});
		i++;
	}
	if(i>0){
		plus.nativeUI.actionSheet({cancel: '取消', buttons: bts}, function(e){
			var i=e.index;
			if(i>0){
				h5_share_action(ids[i-1].id, ids[i-1].ex);
			}
		});
	}
}

function h5_share_action(id, ex) {
	var s=null;
	if(!id || !(s=shares[id])){
		return;
	}
	if(s.authenticated) {
		h5_share_msg(s, ex);
	}else{
		s.authorize(function(){
			h5_share_msg(s, ex);
		},function(e){
		});
	}
}

function h5_share_msg(s, ex){
	var msg={content: h5_share_c, extra: {scene: ex}};
	msg.href=h5_share_u;
	msg.title=h5_share_t;
	msg.content=h5_share_c;
	msg.thumbs=[h5_share_p];
	msg.pictures=[h5_share_p];
	s.send(msg, function(){
		if(ex=='WXSceneTimeline')wx_sharetl_f();
		wx_share_f();
	}, function(e){
	});
}
<?php } ?>

function open_share(){
	<?php if($is_h5app>0){ ?>
	h5_share();
	<?php }else{ ?>
	$('.share_v').show();
	<?php } ?>
}

$(function(){
	<?php if($is_h5app>0){ ?>
	$('#main_content').click(function(){
		return false;
	});
	<?php } ?>
	console.log('<?php echo $is_h5app; ?>');
	<?php
	if($is_share>0 && $is_h5app==0){
		echo 'open_share();';
	}
	?>
	if($('img[data-src]').length>0){
		$('img[data-src]').each(function(){
			var p=$(this).data('src');
			if(p!=''){
				$(this).attr('src', '<?php echo getpageurl($cname.'/pic_view/'); ?>?p='+encodeURI(p));
			}
		});
	}
	$('#share_bt').click(function(){
		open_share();
	});
	$('.share_v').click(function(){
		$(this).hide();
	});
	<?php if($share_code!=''){ ?>
	$('#qr_v').qrcode('<?php echo getpageurl('user/reg/'.$share_code.'/'); ?>');
	<?php } ?>
});
</script>