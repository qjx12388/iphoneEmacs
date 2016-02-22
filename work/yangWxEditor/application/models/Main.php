<?php
class Main extends CI_Model {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Shanghai');
	}

	public function main(){
		$s_query='select *
		from main
		limit 1';
		$main_query=$this->db->query($s_query);
		if($main_query->num_rows()>0)return $main_query->row();
		$main_query->free_result();
	}

	public function admin($is_login=0){
		$user=new stdClass();
		$user->admin_id=0;
		$session=$this->session->all_userdata();
		if(isset($session['login_admin_id']) && intval($session['login_admin_id'])>0){
			$admin_id=intval($session['login_admin_id']);
			$s_query='select *
			from admin
			where admin_id='.$admin_id.'
			limit 1';
			$user_query=$this->db->query($s_query);
			if($user_query->num_rows()>0){
				$user=$user_query->row();
			}else{
				$this->session->unset_userdata('login_admin_id');
			}
			$user_query->free_result();
		}
		if($user->admin_id==0 && $is_login==0){
			$this->session->set_userdata('login_url', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			redirect('admin/login/');
			exit();
		}else{
			$user->main=$this->main();
			return $user;
		}
	}

	public function user($is_login=0){
		$user=new stdClass();
		$user->user_id=0;
		$session=$this->session->all_userdata();
		$get=$this->input->get(NULL, TRUE);
		if(isset($get['share_c']) && trim($get['share_c'])!=''){
			$sc=trim($get['share_c']);
			$s_query='select user_id
			from user
			where code=\''.$sc.'\'
			limit 1';
			$tu_query=$this->db->query($s_query);
			if($tu_query->num_rows()>0){
				$tu=$tu_query->row();
				$this->session->set_userdata('share_code', $sc);
			}
			$tu_query->free_result();
		}
		if(isset($session['login_user_id']) && intval($session['login_user_id'])>0){
			$user_id=intval($session['login_user_id']);
			$s_query='select * 
			from user
			where user_id='.$user_id.'
			limit 1';
			$user_query=$this->db->query($s_query);
			if($user_query->num_rows()>0){
				$cu=$user_query->row();
				if(substr($cu->username, -4)!='_del'){
					$user=$cu;
				}
			}else{
				$this->session->unset_userdata('login_user_id');
			}
			$user_query->free_result();
		}
		if($user->user_id==0 && isset($_COOKIE['login_user_n']) && $_COOKIE['login_user_n']!='' && isset($_COOKIE['login_user_p']) && $_COOKIE['login_user_p']!=''){
			$un=$_COOKIE['login_user_n'];
			$s_query='select * 
			from user
			where username=\''.$un.'\'
			limit 1';
			$user_query=$this->db->query($s_query);
			if($user_query->num_rows()>0){
				$cu=$user_query->row();
				if(md5($cu->password)==$_COOKIE['login_user_p'] && substr($cu->username, -4)!='_del'){
					$user=$cu;
				}
			}
			$user_query->free_result();
			if($user->user_id==0){
				setcookie('login_user_n', '', time()-3600, '/');
				setcookie('login_user_p', '', time()-3600, '/');
			}
		}
		$main=$this->main();
		if($user->user_id==0){
			$is_wxrq=is_wxrq()?1:0;
			$burl='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			if($is_wxrq>0 && $main->wx_app_id!=''){
				$uc=md5(trim($burl));
				$s_query='select *
				from url
				where code=\''.$uc.'\'
				limit 1';
				$url_query=$this->db->query($s_query);
				if($url_query->num_rows()==0){
					$udata['url']=$burl;
					$udata['code']=$uc;
					$this->db->insert('url', $udata);
				}
				$url_query->free_result();
				$ua['appid']=$main->wx_app_id;
				$ua['redirect_uri']=getpageurl('home/wx_callback/');
				$ua['response_type']='code';
				$ua['scope']='snsapi_base';
				$ua['state']=$uc;
				$url='https://open.weixin.qq.com/connect/oauth2/authorize?'.http_build_query($ua).'#wechat_redirect';
				redirect($url);
				exit();
			}
			if($is_login==0){
				$this->session->set_userdata('wx_login_url', $burl);
				redirect('user/login/');
				exit();
			}
		}
		$user->main=$main;
		return $user;
	}

	public function action_log($content, $admin_id, $adata=array()){
		$adata['admin_id']=$admin_id;
		$adata['datetime']=time();
		$adata['content']=$content;
		$this->db->insert('log_action', $adata);
	}

	public function oss_url($oss_f){
		$url='';
		$main=$this->main();
		if($main->cos_aid!='' && $main->cos_sid!='' && $main->cos_key!='' && $main->cos_b!=''){
			$cos['accessId']=$main->cos_aid;
			$cos['secretKey']=$main->cos_key;
			$cos['secretId']=$main->cos_sid;
			$this->load->library('qqcos', $cos);
			$url=$this->qqcos->url($main->cos_b, $oss_f, false);
		}
		return $url;
	}

	public function pic_upload($f_a, $uid, $fjc='', $is_cos=1, $no_pic=0, $a_ext=array(), $is_jd=0){
		$pic='';
		$oss='';
		$jd=0;
		if(isset($f_a['tmp_name']) && is_uploaded_file($f_a['tmp_name']) && $f_a['error']==0){
			$a_fn=explode('.', $f_a['name']);
			$c_fn=count($a_fn);
			$ext=strtolower($a_fn[($c_fn-1)]);
			if($no_pic==0)$a_ext=array('gif', 'jpg', 'jpeg', 'png');
			if(in_array($ext, $a_ext)){
				$fo='static/file/'.$uid.'/';
				if(!is_dir($fo))mkdir($fo);
				$fn='a_'.date('YmdHis').'_'.substr(md5(time().','.rand(0,9999).','.$fjc), 16).'.'.$ext;
				$addf=$fo.$fn;
				if(copy($f_a['tmp_name'], $addf)){
					if($no_pic==0 && $is_jd>0 && $ext=='jpg'){
						$ae=@exif_read_data($addf, 'IFD0');
						if(isset($ae['Orientation']) && ($ae['Orientation']==3 || $ae['Orientation']==6 || $ae['Orientation']==8)){
							switch($ae['Orientation']){
								case 3:
									$jd=180;
									break;
								case 6:
									$jd=90;
									break;
								case 8:
									$jd=-90;
									break;
							}
						}
					}
					if($is_cos>0){
						$ua=$this->oss_upload($fn, $addf);
						$pic=$ua[0];
						$oss=$ua[1];
					}else{
						$base_url=$this->config->item('base_url');
						$pic=$base_url.$addf;
					}
				}
			}
		}
		return array($pic, $oss, $jd);
	}

	public function oss_upload($fn, $addf){
		//echo $addf;
		$main=$this->main();
		$pic='';
		$oss='';
		$is_u=0;
		if($main->cos_aid!='' && $main->cos_sid!='' && $main->cos_key!='' && $main->cos_b!=''){
			$cos['accessId']=$main->cos_aid;
			$cos['secretKey']=$main->cos_key;
			$cos['secretId']=$main->cos_sid;
			$this->load->library('qqcos', $cos);
			$this->qqcos->upload($main->cos_b, $fn, file_get_contents($addf));
			$is_u=1;
		}
		if($is_u>0){
			$oss=$fn;
			unlink($addf);
		}else{
			$base_url=$this->config->item('base_url');
			$pic=$base_url.$addf;
		}
		return array($pic, $oss);
	}

	public function is_oss($main){
		$is_oss=($main->is_cos==1 && $main->cos_aid!='' && $main->cos_sid!='' && $main->cos_key!='' && $main->cos_b!='')?1:0;
		return $is_oss;
	}
	
	public function img_upload($post, $uid, $n='pic', $i='', $is_jd=0){
		$oss='';
		$pic='';
		$jd=0;
		$ic=$i!==''?'_'.$i:'';
		if(isset($_FILES[$n.'_file'.$ic]) && isset($_FILES[$n.'_file'.$ic]['name']) && $_FILES[$n.'_file'.$ic]['name']!=''){
			$f_a=$_FILES[$n.'_file'.$ic];
			$a_ext=array();
			$ua=$this->pic_upload($f_a, $uid, $n.','.$uid.','.$i, 1, 0, $a_ext, $is_jd);
			$pic=$ua[0];
			$oss=$ua[1];
			if($is_jd>0)$jd=$ua[2];
		}elseif(isset($post[$n.'_pic'.$ic]) && trim($post[$n.'_pic'.$ic])!=''){
			$pic=trim($post[$n.'_pic'.$ic]);
		}
		if($oss=='' && $pic==''){
			if(isset($post[$n.'_pico'.$ic]) && trim($post[$n.'_pico'.$ic])!='')$pic=trim($post[$n.'_pico'.$ic]);
			if(isset($post[$n.'_oss'.$ic]) && trim($post[$n.'_oss'.$ic])!='')$oss=trim($post[$n.'_oss'.$ic]);
		}
		return array($pic, $oss, $jd);
	}

	public function send_sms($mob, $msg, $n, $p, $qm){
		$main=$this->main();
		$a['status']=0;
		$a['info']='';
		if($main->api_u!=''){
			$msg.='【'.$qm.'】';
			$umsg=iconv('UTF-8', 'GB2312', $msg);
			$url='http://sdk2.entinfo.cn:8060/z_send.aspx';
			$pf['sn']=$n;
			$pf['pwd']=$p;
			$pf['mobile']=$mob;
			$pf['content']=$umsg;
			$r=$this->main->http($url, http_build_query($pf), 'POST');
			$a['status']=0;
			if($r['ywr_http_code']==200 && $r['ywr_response']==1){
				$a['status']=1;
			}
			if(isset($r['ywr_response']) && $r['ywr_response']!=''){
				$a['info']=$r['ywr_response'];
			}else{
				$a['info']='服务器连接错误';
			}
			/*
			$pf['username']=$n;
			$pf['password']=$p;
			$pf['method']='sendsms';
			$pf['mobile']=$mob;
			$pf['msg']=$msg;
			$ci=curl_init();
			curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ci, CURLOPT_TIMEOUT, 30);
			curl_setopt($ci, CURLOPT_POST, TRUE);
			curl_setopt($ci, CURLOPT_POSTFIELDS, http_build_query($pf));
			curl_setopt($ci, CURLOPT_URL, $main->api_u);
			$response=curl_exec($ci);
			curl_close($ci);
			if($response!=''){
				$return=simplexml_load_string($response);
				foreach($return as $k=>$v)$are[$k]=$v;
				$a['status']=$return->error==0?1:0;
				$a['info']=trim($return->message);
			}else{
				$a['info']='服务器连接错误';
			}
			*/
			$ldata['datetime']=time();
			$ldata['mobile']=$mob;
			$ldata['content']=$msg;
			$ldata['is_cg']=(isset($a['status']) && $a['status']==1)?1:0;
			$ldata['info']=$a['info'];
			$this->db->insert('log_sms', $ldata);
		}else{
			$a['info']='缺少配置';
		}
		return $a;
	}

	public function wxtoken($appid, $secret, $main){
		$token='';
		if($main->wx_access_token!='' && time()<$main->wx_at_time){
			$token=$main->wx_access_token;
		}else{
			if($appid!='' && $secret!=''){
				$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
				$r=$this->http($url);
				if(isset($r['access_token']) && $r['access_token']!=''){
					$token=$r['access_token'];
					$mdata['wx_access_token']=$token;
					$mdata['wx_at_time']=time()+$r['expires_in'];
					$this->db->update('main', $mdata);
				}
				if(isset($r['errcode']))$a['errcode']=$r['errcode'];
				if(isset($r['errmsg']))$a['errmsg']=$r['errmsg'];
			}
		}
		$a['token']=$token;
		return $a;
	}

	public function wxjsticket($appid, $secret, $main){
		$jsticket='';
		if($main->wx_js_ticket!='' && time()<$main->wx_jt_time){
			$jsticket=$main->wx_js_ticket;
		}else{
			$a=$this->wxtoken($appid, $secret, $main);
			if(isset($a['token']) && $a['token']!=''){
				$url='http://api.weixin.qq.com/cgi-bin/ticket/getticket?type=1&access_token='.$a['token'];
				$r=$this->http($url);
				if(isset($r['ticket']) && $r['ticket']!=''){
					$jsticket=$r['ticket'];
					$mdata['wx_js_ticket']=$jsticket;
					$mdata['wx_jt_time']=time()+7200;
				}elseif(isset($r['errcode']) && ($r['errcode']=='40001' || $r['errcode']=='42001')){
					$mdata['wx_access_token']='';
				}
				if(isset($mdata))$this->db->update('main', $mdata);
			}
		}
		return $jsticket;
	}

	public function http($url, $postfields='', $method='GET', $headers=array()){
		$ci=curl_init();
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ci, CURLOPT_TIMEOUT, 30);
		if($method=='POST'){
			curl_setopt($ci, CURLOPT_POST, TRUE);
			if($postfields!='')curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
		}
		$headers[]='User-Agent: guanggaoke';
		curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ci, CURLOPT_URL, $url);
		$response=curl_exec($ci);
		$http_code=curl_getinfo($ci, CURLINFO_HTTP_CODE);
		curl_close($ci);
		$json_r['ywr_http_code']=$http_code;
		$json_r['ywr_url']=$url;
		$json_r['ywr_response']=$response;
		$json_r['ywr_method']=$method;
		$json_r['ywr_postfield']=$postfields;
		$json_r['ywr_header']=$headers;
		if($response!=''){
			$ar=array();
			$ar=@json_decode($response, true);
			if(is_array($ar) && count($ar)){
				foreach($ar as $k=>$v)$json_r[$k]=$v;
			}
		}
		return $json_r;
	}

	public function gethtml($u){
		$ca=$this->http($u);
		$t='';
		$c='';
		if(isset($ca['ywr_response']) && trim($ca['ywr_response'])!=''){
			$html=trim($ca['ywr_response']);
			preg_match("/<head.*>(.*)<\/head>/smUi", $html, $ah);
			if(isset($ah[1]) && trim($ah[1])!=''){
				if(preg_match("/<title>(.*)<\/title>/Ui", trim($ah[1]), $at)){
					if(isset($at) && trim($at[1])!='')$t=trim($at[1]);
				}
			}
			preg_match("/<body.*>(.*)<\/body>/smUi", $html, $ab);
			if(isset($ab[1]) && trim($ab[1])!=''){
				$s0=array("'<script[^>]*?>.*?</script>'si", "'<style[^>]*?>.*?</style>'si", "'<!--[/!]*?[^<>]*?>'si", "'<h1[^>]*?>.*?</h1>'si", "'<h2[^>]*?>.*?</h2>'si");
				$s1=array('', '', '', '', '');
				$c=trim(preg_replace($s0, $s1, trim($ab[1])));
				//$c=str_replace(' data-src=', ' src=', $c);
				$c=str_replace('/0?wx_fmt=png', '/640?tp=jpg', $c);
				$c=str_replace('onclick', '_c', $c);
				$c=str_replace('onClick', '_c', $c);
				$c=str_replace('onkey', '_k', $c);
				$c=str_replace('onKey', '_k', $c);
				$c=str_replace('onmouse', '_m', $c);
				$c=str_replace('onMouse', '_m', $c);
				$c=str_replace('onload', '_l', $c);
				$c=str_replace('onLoad', '_l', $c);
			}
			if($t==''){
				$t=substrs(trim(strip_tags($c)));
			}
		}
		return array($t, $c);
	}

}
