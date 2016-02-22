<?php
//加密方式：php源码混淆类加密。免费版地址:http://www.zhaoyuanma.com/phpjm.html 免费版不能解密,可以使用VIP版本。

//发现了time,请自行验证这套程序是否有时间限制.
//此程序由【找源码】http://Www.ZhaoYuanMa.Com (免费版）在线逆向还原，QQ：7530782 
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		header('P3P: CP=CAO PSA OUR');
		$this->c_name='home';
		$data['cname']=$this->c_name;
		$this->data=$data;
	}
	public function index(){
		require('application/config/autoload.php');
		if(!isset($autoload['libraries']) ||!in_array('database',$autoload['libraries'])){
			redirect('mysql/setup/');
			exit();
		}
		$user=$this->main->user(1);
		$data=$this->data;
		$session=$this->session->all_userdata();
		$data['session']=$session;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$data['is_home']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_index');
		$this->load->view('m_foot');
	}
	public function page_404(){
		$data=$this->data;
		$session=$this->session->all_userdata();
		$data['session']=$session;
		$data['body_class']='gray-bg';
		$data['no_side']=1;
		$this->load->view('admin_head',$data);
		$this->load->view($this->c_name.'_page_404');
		$this->load->view('admin_foot');
	}
	public function wx_callback(){
		$gourl='/';
		$get=$this->input->get(NULL,TRUE);
		$is_oauth_e=0;
		$main=$this->main->main();
		$data=$this->data;
		$session=$this->session->all_userdata();
		if(isset($get['code']) &&$get['code']!=''&&$main->wx_app_id!=''&&$main->wx_app_secret!=''){
			if(isset($get['state']) &&trim($get['state'])!=''){
				$s_query='select *
				from url
				where code=\''.trim($get['state']).'\'
				limit 1';
				$url_query=$this->db->query($s_query);
				if($url_query->num_rows()>0){
					$gu=$url_query->row();
					$gourl=$gu->url;
				}
				$url_query->free_result();
			}
			$ua['appid']=$main->wx_app_id;
			$ua['secret']=$main->wx_app_secret;
			$ua['code']=$get['code'];
			$ua['grant_type']='authorization_code';
			$url='https://api.weixin.qq.com/sns/oauth2/access_token?'.http_build_query($ua);
			$r=$this->main->http($url);
			if(isset($r['access_token']) &&trim($r['access_token'])!=''&&isset($r['openid']) &&trim($r['openid'])!=''){
				$openid=trim($r['openid']);
				if(isset($session['login_user_id']) &&intval($session['login_user_id'])>0){
					$user_id=intval($session['login_user_id']);
					$s_query='select * 
					from user
					where user_id='.$user_id.'
					limit 1';
					$user_query=$this->db->query($s_query);
					if($user_query->num_rows()>0){
						$user=$user_query->row();
					}else{
						$this->session->unset_userdata('login_user_id');
					}
					$user_query->free_result();
				}
				$wx_tid=$this->config->item('wx_tid');
				if(isset($user) &&$user->tid!=$wx_tid){
					$udata['openid']=$openid;
					$udata['wxdate']=time();
					$this->db->update('user',$udata,array('user_id'=>$user_id));
				}else{
					$s_query='select * 
					from user 
					where openid=\''.$openid.'\' 
					order by tid desc, wxdate desc, user_id
					limit 1';
					$wu_query=$this->db->query($s_query);
					if($wu_query->num_rows()>0){
						$user=$wu_query->row();
						$uid=$user->user_id;
						$udata['lastdate']=time();
						$udata['logincount']=$user->logincount+1;
						$udata['lastip']=$this->input->ip_address();
						$this->db->update('user',$udata,array('user_id'=>$uid));
					}else{
						$wudata['username']=$openid;
						$wudata['password']=md5($wudata['username'].','.time().','.rand(1,9999));
						$wudata['tid']=$wx_tid;
						$wudata['openid']=$openid;
						$wudata['regdate']=time();
						if(isset($session['share_code']) &&trim($session['share_code'])!=''){
							$sc=trim($session['share_code']);
							$s_query='select *
							from user
							where code=\''.$sc.'\'
							limit 1';
							$tu_query=$this->db->query($s_query);
							if($tu_query->num_rows()>0){
								$tu=$tu_query->row();
								$wudata['uid']=$tu->user_id;
								$tudata['c_td']=$tu->c_td+1;
								$this->db->update('user',$tudata,array('user_id'=>$tu->user_id));
							}else{
								$this->session->unset_userdata('share_code');
							}
							$tu_query->free_result();
						}
						$wudata['code']=substr(md5(time().','.$wudata['username'].','.$wudata['password']),16);
						$this->db->insert('user',$wudata);
						$uid=$this->db->insert_id();
					}
					$wu_query->free_result();
					$this->session->set_userdata('login_user_id',$uid);
				}
			}else{
				$is_oauth_e=1;
				if(isset($r['errcode']) &&$r['errcode']!='')$ae[]=$r['errcode'];
				if(isset($r['errmsg']) &&$r['errmsg']!='')$ae[]=$r['errmsg'];
			}
		}else{
			$is_oauth_e=1;
			$ae[]='缺少参数';
		}
		if($is_oauth_e>0){
			$msg='网页授权错误';
			if(isset($ae))$msg.='，错误原因：'.join('，',$ae);
			$this->session->set_userdata('msg',$msg);
		}
		redirect($gourl);
	}
	public function wx_tx(){
		$s_query='select * 
		from tx_info
		where isfs=0
		order by datetime
		limit 1';
		$tx_query=$this->db->query($s_query);
		if($tx_query->num_rows()>0){
			$tx=$tx_query->row();
			$tdata['isfs']=1;
			$this->db->update('tx_info',$tdata,array('tx_id'=>$tx->tx_id));
			$main=$this->main->main();
			$tx_config['mch_id']=$main->wx_pay_si;
			$tx_config['app_id']=$main->wx_app_id;
			$tx_config['app_key']=$main->wx_pay_sk;
			$this->load->library('wxtx',$tx_config);
			$param['openid']=$tx->openid;
			$param['money']=$tx->money_s;
			$param['desc']='账户提现';
			$fo='static/key/';
			if(!is_dir($fo))mkdir($fo);
			$k_ext='pem';
			$this->load->helper('file');
			$f_cert=$fo.md5(time().','.rand(0,9999).','.$tx->tx_id.',cert').'.'.$k_ext;
			write_file($f_cert,$main->wx_pay_cert);
			$f_key=$fo.md5(time().','.rand(0,9999).','.$tx->tx_id.',key').'.'.$k_ext;
			write_file($f_key,$main->wx_pay_key);
			$c_res=$this->wxtx->send($param,$f_cert,$f_key);
			unlink($f_cert);
			unlink($f_key);
			$tdata['res']=$c_res;
			$tdata['datetime']=time();
			if($c_res!='')$a_res=json_decode($c_res,true);
			if(isset($a_res['return_code']) &&$a_res['return_code']=='SUCCESS'&&isset($a_res['result_code']) &&$a_res['result_code']=='SUCCESS')$tdata['iscg']=1;
			$this->db->update('tx_info',$tdata,array('tx_id'=>$tx->tx_id));
			$get=$this->input->get(NULL,TRUE);
			$p=(isset($get['p']) &&intval($get['p'])>0)?intval($get['p']):1;
			$p++;
			echo '<script type="text/javascript">location.href=\''.getpageurl($this->c_name.'/wx_tx/').'?p='.$p.'\';</script>';
		}
		$tx_query->free_result();
	}
	public function file_url(){
		$get=$this->input->get(NULL,TRUE);
		if(isset($get['f']) &&trim($get['f'])!=''){
			$url=$this->main->oss_url($get['f']);
			redirect($url);
		}
	}
}
?>