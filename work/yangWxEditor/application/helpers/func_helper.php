<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('getpagehtml')){
	function getpagehtml($u, $t, $p=0, $s=20, $m=4){
		$CI=& get_instance();
		$get=$CI->input->get(NULL, TRUE);
		if(isset($get['p']))unset($get['p']);
		if(is_array($get) && count($get)>0){
			$u.=(strstr($u, '?')?'&':'?').http_build_query($get);
		}
		$html='';
		$tp=ceil($t/$s);
		if($tp>1){
			if($p>$tp)$p=$tp;
			$html.='<div class="ywr_page">';
			if($p>$m){
				$html.='<a href="'.$u.'">&lsaquo; 首页</a>';
			}
			if($p>0)$html.='<a href="'.$u.(strstr($u, '?')?'&':'?').'p='.($p-1).'">&lt;</a>';
			for($i=0;$i<$m;$i++){
				$ci=$p-($m-$i);
				if($ci>=0){
					$html.='<a href="'.$u.(strstr($u, '?')?'&':'?').'p='.$ci.'">'.($ci+1).'</a>';
				}
			}
			$html.='<strong>'.($p+1).'</strong>';
			for($i=0;$i<$m;$i++){
				$ci=$p+$i+1;
				if($ci<$tp){
					$html.='<a href="'.$u.(strstr($u, '?')?'&':'?').'p='.$ci.'">'.($ci+1).'</a>';
				}
			}
			if($p<($tp-1))$html.='<a href="'.$u.(strstr($u, '?')?'&':'?').'p='.($p+1).'">&gt;</a>';
			if($p<($tp-$m-1)){
				$html.='<a href="'.$u.(strstr($u, '?')?'&':'?').'p='.($tp-1).'">末页 &rsaquo;</a>';
			}
			$html.='</div>';
		}
		return $html;
	}
}

if(!function_exists('getpagehtml_mini')){
	function getpagehtml_mini($u, $t, $p=0, $s=20, $sh=''){
		$CI=& get_instance();
		$get=$CI->input->get(NULL, TRUE);
		if(isset($get['p']))unset($get['p']);
		if(is_array($get) && count($get)>0){
			$u.=(strstr($u, '?')?'&':'?').http_build_query($get);
		}
		$html='';
		$tp=ceil($t/$s);
		if($tp>1){
			$html.='<div class="mini_p">';
			if($p>0)$html.='<a href="'.$u.(strstr($u, '?')?'&':'?').'p='.($p-1).($sh!=''?'#'.$sh:'').'">&lt; 上一页</a>';
			if($p<($tp-1))$html.='<a href="'.$u.(strstr($u, '?')?'&':'?').'p='.($p+1).($sh!=''?'#'.$sh:'').'">下一页 &gt;</a>';
			$html.='</div>';
		}
		return $html;
	}
}
if(!function_exists('getpagehtml_cp')){
	function getpagehtml_cp($u, $t, $p=0, $s=20, $m=4){
		$CI=& get_instance();
		$get=$CI->input->get(NULL, TRUE);
		if(isset($get['p']))unset($get['p']);
		if(is_array($get) && count($get)>0){
			$u.=(strstr($u, '?')?'&':'?').http_build_query($get);
		}
		$html='';
		$tp=ceil($t/$s);
		if($tp>1){
			$html.='<div class="row"><div class="col-sm-12"><div class="dataTables_paginate paging_simple_numbers"><ul class="pagination ywr_page">';
			if($p>$tp)$p=$tp;
			if($p>0){
				$html.='<li class="paginate_button previous"><a href="'.$u.'">首页</a></li>';
			}else{
				$html.='<li class="paginate_button previous disabled"><span>首页</span></li>';
			}
			for($i=0;$i<$m;$i++){
				$ci=$p-($m-$i);
				if($ci>=0){
					$html.='<li class="paginate_button"><a href="'.$u.(strstr($u, '?')?'&':'?').'p='.$ci.'">'.($ci+1).'</a></li>';
				}
			}
			$html.='<li class="paginate_button active"><span>'.($p+1).'</span></li>';
			for($i=0;$i<$m;$i++){
				$ci=$p+$i+1;
				if($ci<$tp){
					$html.='<li class="paginate_button"><a href="'.$u.(strstr($u, '?')?'&':'?').'p='.$ci.'">'.($ci+1).'</a></li>';
				}
			}
			if($p<($tp-1)){
				$html.='<li class="paginate_button next"><a href="'.$u.(strstr($u, '?')?'&':'?').'p='.($tp-1).'">末页</a></li>';
			}else{
				$html.='<li class="paginate_button next disabled"><span>末页</span></li>';
			}
			$html.='</ul></div></div></div>';
		}
		return $html;
	}
}

if(!function_exists('getpageurl')){
	function getpageurl($f='', $is_wx=0){
		$CI=& get_instance();
		if($is_wx==2){
			$u='http://'.$CI->config->item('kaka_domain').$CI->config->item('kaka_base');
		}else{
			$u=$CI->config->item('base_url');
		}
		$u.='index.php/'.$f;
		if($is_wx==1){
			$u.=strstr($u, '?')?'':'?';
			//if(is_wxrq() && isset($_GET['wxuid']) && trim($_GET['wxuid'])!='')$u.='&wxuid='.$_GET['wxuid'];
			$u.='&rand_string='.time();
		}
		return $u;
	}
}

if(!function_exists('textlen')){
	function textlen($c){
		$t=strlen($c);
		$j=0;
		$h=0;
		for($i=0;$i<$t;$i++){
			if(ord(substr($c,$i,1))>127){
				if($h==0){
					$h=1;
				}elseif($h==1){
					$h=2;
				}else{
					$h=0;
				}
			}else{
				$h=0;
			}
			if($h==0)$j++;
		}
		return $j;
	}
}

if(!function_exists('rnencode')){
	function rnencode($c){
		$c=str_replace("\r\n", '<br/>', $c);
		$c=str_replace("\n\r", '<br/>', $c);
		$c=str_replace("\n", '<br/>', $c);
		$c=str_replace("\r", '<br/>', $c);
		return $c;
	}
}

if(!function_exists('getywtime')){
	function getywtime($t, $c=1){
		$y=date('Y', $t);
		$m=date('n', $t);
		$d=date('j', $t);
		$h=date('G', $t);
		$i=date('i', $t);
		$s=date('s', $t);
		$m+=$c;
		if($m>12){
			$yp=floor($m/12);
			$y+=$yp;
			$m=$m%12;
		}
		$nt=mktime(0,0,0,$m,1,$y);
		if(date('t', $nt)<$d)$d=date('t', $nt);
		return mktime($h,$i,$s,$m,$d,$y);
	}
}

if(!function_exists('getwdjl')){
	function getwdjl($lng0, $lat0, $lng1, $lat1){
		return 'floor(6378.138*2*asin(sqrt(pow(sin(('.$lat0.'*pi()/180-'.$lat1.'*pi()/180)/2),2)+cos('.$lat0.'*pi()/180)*cos('.$lat1.'*pi()/180)*pow(sin(('.$lng0.'*pi()/180-'.$lng1.'*pi()/180)/2),2)))*1000)';
	}
}

if(!function_exists('getcsvrow')){
	function getcsvrow($a){
		foreach($a as $v)$ac[]=iconv('UTF-8', 'GB2312//IGNORE', str_replace(',', '，', $v));
		return join(',', $ac)."\n";
	}
}

if(!function_exists('getxlsrow')){
	function getxlsrow($a){
		$c='<Row>';
		foreach($a as $v)$c.='<Cell><Data ss:Type="String">'.$v.'</Data></Cell>';
		$c.='</Row>';
		return $c;
	}
}

if(!function_exists('getxls')){
	function getxls($row, $name=''){
		$c='<?xml version="1.0" encoding="utf-8"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">
	<Worksheet ss:Name="'.($name!=''?$name:'表1').'">
		<Table>'.$row.'</Table>
	</Worksheet>
</Workbook>';
		return $c;
	}
}

if(!function_exists('htmleditor')){
	function htmleditor($user_id, $name, $value=''){
		return '<textarea name="'.$name.'" id="'.$name.'" cols="100" rows="20">'.htmlspecialchars($value, ENT_QUOTES).'</textarea>
<script type="text/javascript">
var options= {
	imageUrl: \''.getpageurl('admin/upload_file/'.$user_id.'/img/').'\',
	imagePath: \'\',
	catchRemoteImageEnable: false,
	toolbars: [
		[\'fullscreen\', \'source\', \'|\', \'undo\', \'redo\', \'|\',
		\'bold\', \'italic\', \'underline\', \'fontborder\', \'strikethrough\', \'superscript\', \'subscript\', \'removeformat\', \'formatmatch\', \'autotypeset\', \'blockquote\', \'pasteplain\', \'|\',
		\'forecolor\', \'backcolor\', \'insertorderedlist\', \'insertunorderedlist\', \'selectall\', \'cleardoc\', \'|\',
		\'rowspacingtop\', \'rowspacingbottom\', \'lineheight\'],
		[\'customstyle\', \'paragraph\', \'fontfamily\', \'fontsize\', \'indent\', \'|\',
		\'justifyleft\', \'justifycenter\', \'justifyright\', \'justifyjustify\', \'|\',
		\'link\', \'unlink\', \'anchor\', \'|\', \'imagenone\', \'imageleft\', \'imageright\', \'imagecenter\'],
		[\'insertimage\', \'emotion\', \'insertvideo\', \'music\', \'|\',
		\'horizontal\', \'date\', \'time\', \'spechars\', \'map\', \'gmap\', \'|\',
		\'inserttable\', \'deletetable\', \'insertparagraphbeforetable\', \'insertrow\', \'deleterow\', \'insertcol\', \'deletecol\', \'mergecells\', \'mergeright\', \'mergedown\', \'splittocells\', \'splittorows\', \'splittocols\', \'|\',
		\'preview\', \'searchreplace\']
	],
	initialFrameWidth: \'100%\',
	initialFrameHeight: 500,
	wordCount: false
};
var editor=new UE.ui.Editor(options);
editor.render(\''.$name.'\');
</script>';
	}
}

if(!function_exists('htmleditor_mini')){
	function htmleditor_mini($user_id, $name, $value='<p></p>'){
		return '<textarea name="'.$name.'" id="'.$name.'" cols="100" rows="20">'.htmlspecialchars($value, ENT_QUOTES).'</textarea>
<script type="text/javascript">
var options= {
	serverUrl: \''.getpageurl('user/upload_mini/'.$user_id.'/').'\',
	toolbars: [
		[\'forecolor\', \'backcolor\', \'simpleupload\', \'|\', \'bold\', \'italic\', \'underline\', \'|\', \'undo\', \'redo\'],
		[\'justifyleft\', \'justifycenter\', \'justifyright\', \'justifyjustify\', \'|\', \'imagenone\', \'imageleft\', \'imageright\', \'imagecenter\']
	],
	initialFrameWidth: \'100%\',
	initialFrameHeight: 300,
	wordCount: false
};
var editor=new UE.ui.Editor(options);
editor.render(\''.$name.'\');
</script>';
	}
}

if(!function_exists('chk_mobile')){
	function chk_mobile($mobile){
		$a_pf=array('13', '14', '15', '17', '18', '19');
		if(intval(substr($mobile, 2))!=substr($mobile, 2) || strlen($mobile)<>11 || !in_array(substr($mobile, 0, 2), $a_pf)){
			return false;
		}else{
			return true;
		}
	}
}

if(!function_exists('getmkey')){
	function getmkey($c){
		return md5(strtoupper(trim($c)));
	}
}

if(!function_exists('substrs')){
	function substrs($c, $l=16){
		$lc=strlen($c);
		$n=0;
		$m=0;
		$p='';
		for($i=0;$i<$lc;$i++){
			if($m<$l){
				$p.=$c[$i];
				if(ord($c[$i])>127){
					$n++;
					if($n%3==0)$m++;
				}else{
					$m++;
				}
			}
		}
		if($p!=$c)$p.='…';
		return $p;
	}
}

if(!function_exists('aliydurl')){
	function aliydurl($url, $topic){
		$app_id=$topic->fwc_appid;
		$name=iconv('UTF-8', 'GB2312//IGNORE', $topic->name);
		$desc='';
		$logo='';
		$aid='';
		$awid='';
		$u='http://d.alipay.com/share/index.htm?';

		$s='alipays://platformapi/startapp?appId='.$aid.'&publicId='.$app_id.'&followType=PUBLIC&actionType=gotoPublicDetail&direction=PPChat&sourceId=platform_wb';
		$u.='s='.urlencode($s);
		$s='http://d.alipay.com/gzhfx/index.htm?appName='.urlencode($name).'&appDesc='.urlencode($desc).'&publicId='.$app_id.'&followCount=0&logoUrl='.urlencode($logo).'&msgUrl='.urlencode($url);
		$u.='&u='.urlencode($s);
		$u.='&awid='.$awid;
		return $u;
	}
}

if(!function_exists('fx_content')){
	function fx_content($c){
		$c=strip_tags($c);
		$c=str_replace("\r", '', $c);
		$c=str_replace("\n", '', $c);
		$c=str_replace('"', '', $c);
		$c=trim($c);
		$c=substrs($c, 30);
		return $c;
	}
}

if(!function_exists('fx_img')){
	function fx_img($c){
		$i='';
		if(strstr($c, '<img ')){
			$a=explode('<img ', $c);
			if(isset($a[1]) && trim($a[1])!=''){
				if(strstr($a[1], 'src="')){
					$a1=explode('src="', $a[1]);
					if(isset($a1[1]) && trim($a1[1])!=''){
						$a2=explode('"', $a1[1]);
						$i=trim($a2[0]);
					}
				}
				if($i==''){
					if(strstr($a[1], "src='")){
						$a1=explode("src='", $a[1]);
						if(isset($a1[1]) && trim($a1[1])!=''){
							$a2=explode("'", $a1[1]);
							$i=trim($a2[0]);
						}
					}
				}
			}
		}
		return $i;
	}
}

if(!function_exists('yxsj')){
	function yxsj($a, $t=0){
		$is_yx=0;
		if(count($a)>0){
			foreach($a as $v){
				if($v[0]<time() && $v[1]>time())$is_yx=1;
				if($t==0){
					if($v[1]>time()){
						$c='';
						if($v[0]>time()){
							$c.=date('Y年n月j日 H:i', $v[0]);
						}else{
							$c.='现在';
						}
						$c.=' - ';
						$c.=date('Y年n月j日 H:i', $v[1]);
						$m[]=$c;
					}
				}
			}
		}
		if($t>0){
			return $is_yx;
		}else{
			if(!isset($m)){
				$m[]='已过期';
			}elseif($is_yx==0){
				$m[]='无效';
			}
			return join('，', $m);
		}
	}
}

if(!function_exists('getxml')){
	function getxml($r){
		$c='<?xml version="1.0" encoding="utf-8"?><response>';
		foreach($r as $k=>$v){
			if(is_array($v)){
				foreach($v as $vv){
					$c.='<'.$k.'>';
					if(is_array($vv)){
						foreach($vv as $vvk=>$vvv){
							$c.='<'.$vvk.'>';
							if(is_array($vvv) && $vvv[1]>0){
								$c.='<![CDATA['.$vvv[0].']]>';
							}else{
								$c.=$vvv;
							}
							$c.='</'.$vvk.'>';
						}
					}else{
						$c.=$vv;
					}
					$c.='</'.$k.'>';
				}
			}else{
				$c.='<'.$k.'>'.$v.'</'.$k.'>';
			}
		}
		$c.='</response>';
		return $c;
	}
}

if(!function_exists('getgbxml')){
	function getgbxml($r){
		$c='<?xml version="1.0" encoding="gb2312"?><response>';
		foreach($r as $k=>$v){
			if(is_array($v)){
				foreach($v as $vv){
					$c.='<'.$k.'>';
					if(is_array($vv)){
						foreach($vv as $vvk=>$vvv){
							$c.='<'.$vvk.'>';
							if(is_array($vvv) && $vvv[1]>0){
								$c.='<![CDATA['.iconv('UTF-8', 'GB2312//IGNORE', $vvv[0]).']]>';
							}else{
								$c.=iconv('UTF-8', 'GB2312//IGNORE', $vvv);
							}
							$c.='</'.$vvk.'>';
						}
					}else{
						$c.=iconv('UTF-8', 'GB2312//IGNORE', $vv);
					}
					$c.='</'.$k.'>';
				}
			}else{
				$c.='<'.$k.'>'.iconv('UTF-8', 'GB2312//IGNORE', $v).'</'.$k.'>';
			}
		}
		$c.='</response>';
		return $c;
	}
}

if(!function_exists('wxuidurl')){
	function wxuidurl($u){
		return $u;
		if(substr($u, 0, strlen('tel:'))!='tel:' && substr($u, 0, strlen('sms:'))!='sms:'){
			if(isset($_GET['wxuid'])){
				if(strstr($u, '#')){
					$ua=explode('#', $u);
					$u=$ua[0];
				}
				if(is_wxrq()){
					$u.=strstr($u, '?')?'&':'?';
					//$u.='wxuid='.$_GET['wxuid'];
				}
				if(isset($ua[1]))$u.='#'.$ua[1];
			}
		}
		return $u;
	}
}

if(!function_exists('mocode')){
	function mocode($c, $m=4){
		if(strlen($c)<=$m){
			return $c;
		}elseif(strlen($c)==($m+1)){
			return substr($c, 0, 1).str_repeat('*', $m);
		}elseif(strlen($c)<=($m*3)){
			$a=(strlen($c)-$m)/2;
			return substr($c, 0, floor($a)).str_repeat('*', $m).substr($c, (0-ceil($a)));
		}else{
			return substr($c, 0, $m).str_repeat('*', $m).substr($c, (0-$m));
		}
	}
}

if(!function_exists('bu_decode')){
	function bu_decode($u){
		if(strstr($u, '#')){
			$ua=explode('#', $u);
			$ua[0].=(strstr($ua[0], '?')?'&':'?').'rand_string='.time();
			$u=join('#', $ua);
		}else{
			$u.=(strstr($u, '?')?'&':'?').'rand_string='.time();
		}
		return $u;
	}
}

if(!function_exists('json_zh_encode')){
	function json_zh_encode($c){
		$c=trim($c);
		$c=json_encode($c);
		$l=strlen($c);
		$c=substr($c, 1);
		$c=substr($c, 0, -1);
		$c=str_replace('\\', '\\\\\\\\', $c);
		return $c;
	}
}

if(!function_exists('zc_decode')){
	function zc_decode($c, $t){
		$td_n='';
		switch($t){
			case 5:
				$td_n=$c['y'].'年'.$c['m'].'月'.$c['d'].'日';
				break;
			case 4:
				$td_n=join('、', $c);
				break;
			case 3:
				if($c>0){
					$td_h=str_pad(floor($c/60), 2, '0', STR_PAD_LEFT);
					$td_i=str_pad(($c%60), 2, '0', STR_PAD_LEFT);
					$td_n=$td_h.':'.$td_i;
				}
				break;
			case 2:
				if($c>0)$td_n=date('Y年n月j日', $c);
				break;
			default:
				if($c!='')$td_n=$c;
				break;
		}
		return $td_n;
	}
}

if(!function_exists('zf_info')){
	function zf_info($main, $topic, $shop='', $is_shop=0){
		$is_alipay=0;
		$is_tenpay=0;
		$is_wxpay=0;
		$is_yeepay=0;
		$is_aipay=0;
		$is_ylpay=0;
		if($is_shop>0){
			if($shop->is_wx_ali==2){
				$a['is_kaka_ali']=2;
				if($topic->is_kaka_ali==0 && $topic->alipay_s!='' && $topic->alipay_k!='' && $topic->alipay_e!=''){
					$a['alipay']['s']=$topic->alipay_s;
					$a['alipay']['k']=$topic->alipay_k;
					$a['alipay']['e']=$topic->alipay_e;
					$is_alipay=1;
				}
			}elseif($shop->is_wx_ali==1){
				$a['is_kaka_ali']=1;
				if($main->d_alipay_s!='' && $main->d_alipay_k!='' && $main->d_alipay_e!=''){
					$a['alipay']['s']=$main->d_alipay_s;
					$a['alipay']['k']=$main->d_alipay_k;
					$a['alipay']['e']=$main->d_alipay_e;
					$is_alipay=1;
				}
			}else{
				if($shop->alipay_s!='' && $shop->alipay_k!='' && $shop->alipay_e!=''){
					$a['alipay']['s']=$shop->alipay_s;
					$a['alipay']['k']=$shop->alipay_k;
					$a['alipay']['e']=$shop->alipay_e;
					$is_alipay=1;
				}
			}
		}else{
			if($topic->is_kaka_ali>0){
				$a['is_kaka_ali']=1;
				if($main->d_alipay_s!='' && $main->d_alipay_k!='' && $main->d_alipay_e!=''){
					$a['alipay']['s']=$main->d_alipay_s;
					$a['alipay']['k']=$main->d_alipay_k;
					$a['alipay']['e']=$main->d_alipay_e;
					$is_alipay=1;
				}
			}else{
				if($topic->alipay_s!='' && $topic->alipay_k!='' && $topic->alipay_e!=''){
					$a['alipay']['s']=$topic->alipay_s;
					$a['alipay']['k']=$topic->alipay_k;
					$a['alipay']['e']=$topic->alipay_e;
					$is_alipay=1;
				}
			}
		}

		if($is_shop>0){
			if($shop->is_wx_ten==2){
				$a['is_kaka_ten']=2;
				if($topic->is_kaka_ten==0 && $topic->tenpay_p!='' && $topic->tenpay_k!=''){
					$a['tenpay']['p']=$topic->tenpay_p;
					$a['tenpay']['k']=$topic->tenpay_k;
					$is_tenpay=1;
				}
			}elseif($shop->is_wx_ten==1){
				$a['is_kaka_ten']=1;
				if($main->d_tenpay_p!='' && $main->d_tenpay_k!=''){
					$a['tenpay']['p']=$main->d_tenpay_p;
					$a['tenpay']['k']=$main->d_tenpay_k;
					$is_tenpay=1;
				}
			}else{
				if($shop->tenpay_p!='' && $shop->tenpay_k!=''){
					$a['tenpay']['p']=$shop->tenpay_p;
					$a['tenpay']['k']=$shop->tenpay_k;
					$is_tenpay=1;
				}
			}
		}else{
			if($topic->is_kaka_ten>0){
				$a['is_kaka_ten']=1;
				if($main->d_tenpay_p!='' && $main->d_tenpay_k!=''){
					$a['tenpay']['p']=$main->d_tenpay_p;
					$a['tenpay']['k']=$main->d_tenpay_k;
					$is_tenpay=1;
				}
			}else{
				if($topic->tenpay_p!='' && $topic->tenpay_k!=''){
					$a['tenpay']['p']=$topic->tenpay_p;
					$a['tenpay']['k']=$topic->tenpay_k;
					$is_tenpay=1;
				}
			}
		}

		if($topic->appid!='' && $topic->wxpay_s==0 && $topic->wxpay_pk!='' && $topic->wxpay_p!='' && $topic->wxpay_k!=''){
			$a['wxpay']['id']=$topic->appid;
			$a['wxpay']['pk']=$topic->wxpay_pk;
			$a['wxpay']['p']=$topic->wxpay_p;
			$a['wxpay']['k']=$topic->wxpay_k;
			$a['wxpay']['s']=0;
			$is_wxpay=1;
		}
		if($topic->appid!='' && $topic->appsecret!='' && $topic->wxpay_s==1 && $topic->wxpay_sk!='' && $topic->wxpay_si!=''){
			$a['wxpay']['id']=$topic->appid;
			$a['wxpay']['secret']=$topic->appsecret;
			$a['wxpay']['sk']=$topic->wxpay_sk;
			$a['wxpay']['si']=$topic->wxpay_si;
			$a['wxpay']['s']=1;
			$is_wxpay=1;
		}

		if($is_shop>0){
			if($shop->is_wx_yee==2){
				$a['is_kaka_yee']=2;
				if($topic->is_kaka_yee==0 && $topic->yeepay_a!='' && $topic->yeepay_r!='' && $topic->yeepay_u!='' && $topic->yeepay_y!=''){
					$a['yeepay']['a']=$topic->yeepay_a;
					$a['yeepay']['r']=$topic->yeepay_r;
					$a['yeepay']['u']=$topic->yeepay_u;
					$a['yeepay']['y']=$topic->yeepay_y;
					$is_yeepay=1;
				}
			}elseif($shop->is_wx_yee==1){
				$a['is_kaka_yee']=1;
				if($main->d_yeepay_a!='' && $main->d_yeepay_r!='' && $main->d_yeepay_u!='' && $main->d_yeepay_y!=''){
					$a['yeepay']['a']=$main->d_yeepay_a;
					$a['yeepay']['r']=$main->d_yeepay_r;
					$a['yeepay']['u']=$main->d_yeepay_u;
					$a['yeepay']['y']=$main->d_yeepay_y;
					$is_yeepay=1;
				}
			}else{
				if($shop->yeepay_a!='' && $shop->yeepay_r!='' && $shop->yeepay_u!='' && $shop->yeepay_y!=''){
					$a['yeepay']['a']=$shop->yeepay_a;
					$a['yeepay']['r']=$shop->yeepay_r;
					$a['yeepay']['u']=$shop->yeepay_u;
					$a['yeepay']['y']=$shop->yeepay_y;
					$is_yeepay=1;
				}
			}
		}else{
			if($topic->is_kaka_yee>0){
				$a['is_kaka_yee']=1;
				if($main->d_yeepay_a!='' && $main->d_yeepay_r!='' && $main->d_yeepay_u!='' && $main->d_yeepay_y!=''){
					$a['yeepay']['a']=$main->d_yeepay_a;
					$a['yeepay']['r']=$main->d_yeepay_r;
					$a['yeepay']['u']=$main->d_yeepay_u;
					$a['yeepay']['y']=$main->d_yeepay_y;
					$is_yeepay=1;
				}
			}else{
				if($topic->yeepay_a!='' && $topic->yeepay_r!='' && $topic->yeepay_u!='' && $topic->yeepay_y!=''){
					$a['yeepay']['a']=$topic->yeepay_a;
					$a['yeepay']['r']=$topic->yeepay_r;
					$a['yeepay']['u']=$topic->yeepay_u;
					$a['yeepay']['y']=$topic->yeepay_y;
					$is_yeepay=1;
				}
			}
		}

		if($is_shop>0){
			if($shop->is_wx_ai==2){
				$a['is_kaka_ai']=2;
				if($topic->is_kaka_ai==0 && $topic->aipay_i!='' && $topic->aipay_k!=''){
					$a['aipay']['i']=$topic->aipay_i;
					$a['aipay']['k']=$topic->aipay_k;
					$is_aipay=1;
				}
			}elseif($shop->is_wx_ai==1){
				$a['is_kaka_ai']=1;
				if($main->d_aipay_i!='' && $main->d_aipay_k!=''){
					$a['aipay']['i']=$main->d_aipay_i;
					$a['aipay']['k']=$main->d_aipay_k;
					$is_aipay=1;
				}
			}else{
				if($shop->aipay_i!='' && $shop->aipay_k!=''){
					$a['aipay']['i']=$shop->aipay_i;
					$a['aipay']['k']=$shop->aipay_k;
					$is_aipay=1;
				}
			}
		}else{
			if($topic->is_kaka_ai>0){
				$a['is_kaka_ai']=1;
				if($main->d_aipay_i!='' && $main->d_aipay_k!=''){
					$a['aipay']['i']=$main->d_aipay_i;
					$a['aipay']['k']=$main->d_aipay_k;
					$is_aipay=1;
				}
			}else{
				if($topic->aipay_i!='' && $topic->aipay_k!=''){
					$a['aipay']['i']=$topic->aipay_i;
					$a['aipay']['k']=$topic->aipay_k;
					$is_aipay=1;
				}
			}
		}

		if($is_shop>0){
			if($shop->is_wx_yl==2){
				$a['is_kaka_yl']=2;
				if($topic->is_kaka_yl==0 && $topic->ylpay_i!='' && $topic->ylpay_k!=''){
					$a['ylpay']['i']=$topic->ylpay_i;
					$a['ylpay']['k']=$topic->ylpay_k;
					$is_ylpay=1;
				}
			}elseif($shop->is_wx_yl==1){
				$a['is_kaka_yl']=1;
				if($main->d_ylpay_i!='' && $main->d_ylpay_k!=''){
					$a['ylpay']['i']=$main->d_ylpay_i;
					$a['ylpay']['k']=$main->d_ylpay_k;
					$is_ylpay=1;
				}
			}else{
				if($shop->ylpay_i!='' && $shop->ylpay_k!=''){
					$a['ylpay']['i']=$shop->ylpay_i;
					$a['ylpay']['k']=$shop->ylpay_k;
					$is_ylpay=1;
				}
			}
		}else{
			if($topic->is_kaka_yl>0){
				$a['is_kaka_yl']=1;
				if($main->d_ylpay_i!='' && $main->d_ylpay_k!=''){
					$a['ylpay']['i']=$main->d_ylpay_i;
					$a['ylpay']['k']=$main->d_ylpay_k;
					$is_ylpay=1;
				}
			}else{
				if($topic->ylpay_i!='' && $topic->ylpay_k!=''){
					$a['ylpay']['i']=$topic->ylpay_i;
					$a['ylpay']['k']=$topic->ylpay_k;
					$is_ylpay=1;
				}
			}
		}
		if(is_bdzdh())$is_wxpay=0;

		$a['is_alipay']=$is_alipay;
		$a['is_tenpay']=$is_tenpay;
		$a['is_wxpay']=$is_wxpay;
		$a['is_yeepay']=$is_yeepay;
		$a['is_aipay']=$is_aipay;
		$a['is_ylpay']=$is_ylpay;
		return $a;
	}
}

if(!function_exists('yee_mac')){
	function yee_mac(){
		$c=strtoupper(md5(time()));
		return substr($c, 0, 2).'-'.substr($c, 2, 2).'-'.substr($c, 4, 2).'-'.substr($c, 5, 2).'-'.substr($c, 8, 2).'-'.substr($c, 10, 2);
	}
}

if(!function_exists('is_bdzdh')){
	function is_bdzdh(){
		if((isset($_SERVER['HTTP_USER_AGENT']) && stristr($_SERVER['HTTP_USER_AGENT'], 'baiduboxapp')) || (isset($_GET['bd_source_light']) && $_GET['bd_source_light']!='')){
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists('is_wxrq')){
	function is_wxrq(){
		if(isset($_SERVER['HTTP_USER_AGENT']) && stristr($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')){
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists('is_fwcrq')){
	function is_fwcrq(){
		if(isset($_SERVER['HTTP_USER_AGENT']) && stristr($_SERVER['HTTP_USER_AGENT'], 'AlipayClient')){
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists('is_h5app')){
	function is_h5app(){
		if(isset($_SERVER['HTTP_USER_AGENT']) && stristr($_SERVER['HTTP_USER_AGENT'], 'Html5Plus')){
			return true;
		}else{
			return false;
		}
	}
}

if(!function_exists('get_furl')){
	function get_furl($u){
		if($u!='' && !strstr($u, '://'))$u='http://'.$u;
		$u=str_replace('&amp;', '&', $u);
		return $u;
	}
}

if(!function_exists('cn_json_encode')){
	function cn_json_encode($a){
		if(defined('JSON_UNESCAPED_UNICODE')){
			return json_encode($a,JSON_UNESCAPED_UNICODE);
		}else{
			return urldecode(json_encode(array_urlencode($a)));
		}
	}
}

if(!function_exists('array_urlencode')){
	function array_urlencode($v){
		if(is_array($v)) {
			return array_map('array_urlencode', $v);
		}elseif (is_bool($v) || is_numeric($v)){
			return $v;
		}else{
			return urlencode($v);
		}
	}
}

if(!function_exists('app_v')){
	function app_v($v, $topic, $cname){
		$c='<div class="app_info'.($v->tid>0?' app_theme_info':'').'" data-id="'.$v->app_id.'" title="'.$v->name.'">';
		if($v->oss!=''){
			$CI=& get_instance();
			$v->pic=$CI->main->oss_url($v->oss);
		}
		if($v->pic=='')$v->pic='static/images/d_photo_'.$v->tid.'.gif';
		$c.='<a href="'.getpageurl($cname.'/app/'.$topic->topic_id.'/'.$v->app_id.'/').'"><img src="'.$v->pic.'"><span>'.$v->name.'</span></a><span class="app_i">';
		$c.='<a href="'.getpageurl($cname.'/cate/'.$topic->topic_id.'/'.$v->cate_id.'/').'">'.$v->c_name.'</a><br/>';
		if($v->jg>0){
			$c.=($v->jg/100).'元/30天';
		}else{
			$c.='免费';
		}
		$c.='</span>';
		$c.='<a href="'.getpageurl($cname.'/app_buy/'.$topic->topic_id.'/'.$v->app_id.'/').'" class="app_ba app_ba_1_'.$v->app_id.'" style="display: none;">购买</a>';
		$c.='<a href="'.getpageurl($cname.'/app_buy/'.$topic->topic_id.'/'.$v->app_id.'/').'" class="app_ba app_ba_2_'.$v->app_id.'" style="display: none;">续费</a>';
		$c.='</div>';
		return $c;
	}
}

if(!function_exists('tuser_n')){
	function tuser_n($v, $show_all=0){
		$n='';
		if($show_all==0)$n.='<span title="'.$v->openid.'">';
		switch($v->tid){
			case 2:
				$n.='支付宝openid';
				break;
			case 1:
				$n.='百度id';
				break;
			default:
				$n.='微信openid';
				break;
		}
		$n.='：';
		if($show_all>0){
			$n.=$v->openid;
		}else{
			if(strlen($v->openid)>12){
				$n.=substr($v->openid, 0, 10).'…';
			}else{
				$n.=$v->openid;
			}
			$n.='</span>';
		}
		return $n;
	}
}

if(!function_exists('wx_js_package')){
	function wx_js_package($jsticket){
		$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$timestamp=time();
		$nonce=substr(md5(time()), 0, 16);
		$string='jsapi_ticket='.$jsticket.'&noncestr='.$nonce.'&timestamp='.$timestamp.'&url='.$url;
		$sign=sha1($string);
		$package=array(
			'nonce'=>$nonce,
			'timestamp'=>$timestamp,
			'sign'=>$sign,
			'url'=>$url,
			'jsticket'=>$jsticket
		);
		return $package;
	}
}

if(!function_exists('hd_yx_se')){
	function hd_yx_se($main, $topic, $is_yx=1, $hd=''){
		$is_jy=0;
		$msg='';
		if($topic->is_yun>0){
			if($is_yx==0)$is_jy=1;
		}else{
			if(is_object($hd) && isset($hd->lxid)){
				if($main->jg!='')$jg=json_decode($main->jg, true);
				if($hd->lxid>=2){
					if(isset($jg['k'.$hd->lxid]))$kjg=$jg['k'.$hd->lxid][1];
				}elseif($hd->lxid==0){
					if(isset($jg['hd'][$hd->type]))$kjg=$jg['hd'][$hd->type][1];
				}
				$mfts=$hd->mfts;
			}elseif($hd=='kf'){
				if(isset($jg['kf']))$kjg=$jg['kf'][1];
				$mfts=$topic->kf_mfts;
			}
			if($topic->isjy==1){
				$msg='此公众帐号已禁用';
				$is_jy=1;
			}elseif(($topic->edate<=time() && $topic->mfts>=$main->mfts) || ($is_yx==0 && isset($kjg) && $mfts>=$kjg)){
				$msg='该活动交互次数已超标，请联系管理员升级。';
				$is_jy=1;
			}
		}
		return array($is_jy, $msg);
	}
}

if(!function_exists('xx_lx')){
	function xx_lx($t){
		switch($t){
			case 5:
				return '生日';
				break;
			case 4:
				return '多选选项';
				break;
			case 3:
				return '时间';
				break;
			case 2:
				return '日期';
				break;
			case 1:
				return '下拉选项';
				break;
			default:
				return '单行文字';
				break;
		}
	}
}

if(!function_exists('xx_html')){
	function xx_html($v, $s=array(), $t=0){
		$c='';
		switch($v['type']){
			case 5:
				$cy=date('Y');
				$c.='<select name="'.$v['id'].'_y">';
				for($i=1900;$i<=$cy;$i++)$c.='<option value="'.$i.'"'.((isset($s[$v['id']]['y']) && $s[$v['id']]['y']==$i)?' selected="selected"':'').'>'.$i.'</option>';
				$c.='</select>年<select name="'.$v['id'].'_m">';
				for($i=1;$i<=12;$i++)$c.='<option value="'.$i.'"'.((isset($s[$v['id']]['m']) && $s[$v['id']]['m']==$i)?' selected="selected"':'').'>'.$i.'</option>';
				$c.='</select>月<select name="'.$v['id'].'_d">';
				for($i=1;$i<=31;$i++)$c.='<option value="'.$i.'"'.((isset($s[$v['id']]['d']) && $s[$v['id']]['d']==$i)?' selected="selected"':'').'>'.$i.'</option>';
				$c.='</select>日';
				break;
			case 4:
				$a_seo=explode('|', $v['v']);
				foreach($a_seo as $sev)echo '<input type="checkbox" name="'.$v['id'].'[]" value="'.$sev.'"'.((isset($s[$v['id']]) &&is_array($s[$v['id']]) && in_array($sev, $s[$v['id']]))?' checked="checked"':'').'>'.$sev.' ';
				break;
			case 3:
				$xx_h=intval(date('H'));
				$xx_i=intval(date('i'));
				if(isset($s[$v['id']])){
					$xx_h=floor($s[$v['id']]/60);
					$xx_i=($s[$v['id']]%60);
				}
				$c.='<select name="'.$v['id'].'_h">';
				for($i=0;$i<=23;$i++)$c.='<option value="'.$i.'"'.($i==$xx_h?' selected="selected"':'').'>'.str_pad($i, 2, '0', STR_PAD_LEFT).'</option>';
				$c.='</select>:<select name="'.$v['id'].'_i">';
				for($i=0;$i<=59;$i++)$c.='<option value="'.$i.'"'.($i==$xx_i?' selected="selected"':'').'>'.str_pad($i, 2, '0', STR_PAD_LEFT).'</option>';
				$c.='</select>';
				break;
			case 2:
				if($t==1){
					$c.='<input id="'.$v['id'].'" value="'.(isset($s[$v['id']])?date('Y-n-j', $s[$v['id']]):'').'" readonly="readonly" class="set_input cal_input" size="10"/>';
				}else{
					$c.='<span class="date_pick_s" data-id="'.$v['id'].'"><span id="'.$v['id'].'">'.(isset($s[$v['id']])?date('Y年n月j日', $s[$v['id']]):'').'</span> 选择日期</span>';
				}
				$c.='<input type="hidden" id="'.$v['id'].'_y" name="'.$v['id'].'_y" value="'.(isset($s[$v['id']])?date('Y', $s[$v['id']]):'').'" />';
				$c.='<input type="hidden" id="'.$v['id'].'_m" name="'.$v['id'].'_m" value="'.(isset($s[$v['id']])?date('n', $s[$v['id']]):'').'" />';
				$c.='<input type="hidden" id="'.$v['id'].'_d" name="'.$v['id'].'_d" value="'.(isset($s[$v['id']])?date('j', $s[$v['id']]):'').'" />';
				break;
			case 1:
				$csn=' class="dropdown_select"';
				if($t>0)$csn='';
				if($t==4)$csn=' class="dropdown_select"';
				$c.='<select name="'.$v['id'].'"'.$csn.'>';
				$a_seo=explode('|', $v['v']);
				foreach($a_seo as $sev)$c.='<option value="'.$sev.'"'.((isset($s[$v['id']]) && $s[$v['id']]==$sev)?' selected="selected"':'').'>'.$sev.'</option>';
				$c.='</select>';
				break;
			default:
				$csn='project_text';
				if($t==1)$csn='set_input" size="30';
				if($t==2)$csn='set_input';
				if($t==3)$csn='xmz_fl_i';
				if($t==4)$csn='" placeholder="请输入'.$v['k'];
				$c.='<input class="'.$csn.'" name="'.$v['id'].'" id="'.$v['id'].'" value="'.(isset($s[$v['id']])?$s[$v['id']]:'').'"/>';
				break;
		}
		return $c;
	}
}

if(!function_exists('xx_post')){
	function xx_post($s, $post, $t=0){
		$isjx=1;
		$usz=array();
		foreach($s as $v){
			if($isjx>0){
				$xx_bt=(isset($v['nbt']) && $v['nbt']==1)?0:1;
				if($t>0)$xx_bt=0;
				switch($v['type']){
					case 5:
						if(isset($post[$v['id'].'_y']) && $post[$v['id'].'_y']!='' && isset($post[$v['id'].'_m']) && $post[$v['id'].'_m']!='' && isset($post[$v['id'].'_d']) && $post[$v['id'].'_d']!=''){
							$usz[$v['id']]['y']=$post[$v['id'].'_y'];
							$usz[$v['id']]['m']=$post[$v['id'].'_m'];
							$usz[$v['id']]['d']=$post[$v['id'].'_d'];
						}else{
							if($xx_bt>0)$isjx=0;
						}
						break;
					case 4:
						if(isset($post[$v['id']]) && is_array($post[$v['id']]) && count($post[$v['id']])>0){
							$usz[$v['id']]=$post[$v['id']];
						}else{
							if($xx_bt>0)$isjx=0;
						}
						break;
					case 3:
						if(isset($post[$v['id'].'_h']) && intval($post[$v['id'].'_h'])>=0 && isset($post[$v['id'].'_i']) && intval($post[$v['id'].'_i'])>=0){
							$usz[$v['id']]=$post[$v['id'].'_h']*60+$post[$v['id'].'_i'];
						}else{
							if($xx_bt>0)$isjx=0;
						}
						break;
					case 2:
						if(isset($post[$v['id'].'_y']) && intval($post[$v['id'].'_y'])>0 && isset($post[$v['id'].'_m']) && intval($post[$v['id'].'_m'])>0 && isset($post[$v['id'].'_d']) && intval($post[$v['id'].'_d'])>0){
							$usz[$v['id']]=mktime(0, 0, 0, intval($post[$v['id'].'_m']), intval($post[$v['id'].'_d']), intval($post[$v['id'].'_y']));
						}else{
							if($xx_bt>0)$isjx=0;
						}
						break;
					case 1:
						$a_seo=explode('|', $v['v']);
						if(isset($post[$v['id']]) && trim($post[$v['id']])!='' && in_array($post[$v['id']], $a_seo)){
							$usz[$v['id']]=trim($post[$v['id']]);
						}else{
							if($xx_bt>0)$isjx=0;
						}
						break;
					default:
						if(isset($post[$v['id']]) && trim($post[$v['id']])!=''){
							$usz[$v['id']]=trim($post[$v['id']]);
						}else{
							if($xx_bt>0)$isjx=0;
						}
						break;
				}
			}
		}
		return array($isjx, $usz);
	}
}

if(!function_exists('tudb')){
	function tudb($topic_id=''){
		if($topic_id!='' && $topic_id>11003){
			$n='wx_topic_user_2';
		}else{
			$n='wx_topic_user';
		}
		return $n;
	}
}
