<?php
//加密方式：php源码混淆类加密。免费版地址:http://www.zhaoyuanma.com/phpjm.html 免费版不能解密,可以使用VIP版本。

//发现了time,请自行验证这套程序是否有时间限制.
//此程序由【找源码】http://Www.ZhaoYuanMa.Com (免费版）在线逆向还原，QQ：7530782 
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Topic extends CI_Controller {
	public function __construct(){
		parent::__construct();
		header('P3P: CP=CAO PSA OUR');
		$this->c_name='topic';
		$session=$this->session->all_userdata();
		$data['session']=$session;
		$data['cname']=$this->c_name;
		$this->data=$data;
	}
	public function index(){
		$user=$this->main->user(1);
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$get=$this->input->get(NULL,TRUE);
		$o_db='datetime desc, topic_id desc';
		$oid=0;
		if(isset($get['o'])){
			switch($get['o']){
			case 2:
				$oid=2;
				$o_db='c_zf desc, datetime desc, topic_id desc';
				break;
			case 1:
				$oid=1;
				$o_db='c_read desc, datetime desc, topic_id desc';
				break;
			}
		}
		$search['oid']=$oid;
		$data['search']=$search;
		$s_query='select *
		from topic 
		where user_id=0 
		order by '.$o_db;
		$ct_query=$this->db->query($s_query);
		$p_total=$ct_query->num_rows();
		if($p_total>0){
			$c_page=(isset($get['p']) &&intval($get['p'])>0)?intval($get['p']):0;
			$data['search']['p']=$c_page;
			$page_size=$this->config->item('page_size');
			$data['page_size']=$page_size;
			$data['page']=getpagehtml_mini(getpageurl($this->c_name.'/'),$p_total,$c_page,$page_size);
			$ct_l_query=$this->db->query($s_query.' limit '.($c_page*$page_size).', '.$page_size);
			$data['sql']=$ct_l_query->result();
			$ct_l_query->free_result();
		}
		$ct_query->free_result();
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_index');
		$this->load->view('m_foot');
	}
	public function edit(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$get=$this->input->get(NULL,TRUE);
		$pt='';
		$pc='';
		$is_jx=0;
		if(isset($get['p']) &&$get['p']==1){
			$post=$this->input->post(NULL,TRUE);
			$url='';
			if(isset($post['url']) &&trim($post['url'])!=''){
				$url=get_furl(trim($post['url']));
			}elseif(isset($get['url']) &&trim($get['url'])!=''){
				$url=get_furl(trim($get['url']));
			}
			if($url!=''){
				$wa=$this->main->gethtml($url);
				$pt=$wa[0];
				$pc=$wa[1];
				if($pt!=''&&$pc!=''){
					$is_jx=1;
				}else{
					$msg='没有抓取到内容，或者文章受到保护无法抓取内容';
				}
			}
		}elseif(isset($get['id']) &&intval($get['id'])>0){
			$cid=intval($get['id']);
			$s_query='select *
			from topic 
			where topic_id='.$cid.' 
			limit 1';
			$ct_query=$this->db->query($s_query);
			if($ct_query->num_rows()>0){
				$topic=$ct_query->row();
				if($topic->user_id==0 ||$topic->user_id==$user->user_id){
					$is_jx=1;
				}elseif($topic->is_yc==0 ||$topic->yc_fxt==0){
					$is_jx=1;
				}else{
					$s_query='select *
					from user_topic 
					where tid=0 and user_id='.$user->user_id.' and topic_id='.$topic->topic_id.' 
					limit 1';
					$cl_query=$this->db->query($s_query);
					if($cl_query->num_rows()>0){
						if($topic->yc_fxt==1){
							$is_jx=1;
						}else{
							$cl=$cl_query->row();
							if($cl->c_fx>$cl->c_fxyy)$is_jx=1;
						}
					}
					$cl_query->free_result();
				}
				if($is_jx>0){
					$data['topic']=$topic;
					$pt=$topic->title;
					$pc=$topic->content;
				}
			}
			$ct_query->free_result();
		}
		if($is_jx==0){
			if(isset($msg))$this->session->set_userdata('msg',$msg);
			redirect($this->c_name.'/');
			exit();
		}
		$data['pt']=$pt;
		$data['pc']=$pc;
		$s_query='select *
		from ad 
		where user_id='.$user->user_id.' 
		order by ad_id desc';
		$ca_query=$this->db->query($s_query);
		if($ca_query->num_rows()>0){
			$ad=$ca_query->result();
			$data['ad']=$ad;
		}
		$ca_query->free_result();
		$data['hide_foot']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_edit');
		$this->load->view('m_foot');
	}
	public function edit_post(){
		$user=$this->main->user();
		$main=$user->main;
		$post=$this->input->post(NULL,TRUE);
		if(isset($post['id']) &&intval($post['id'])>0){
			$cid=intval($post['id']);
			$s_query='select *
			from topic 
			where topic_id='.$cid.' 
			limit 1';
			$ct_query=$this->db->query($s_query);
			if($ct_query->num_rows()>0){
				$ct=$ct_query->row();
				$is_jx=0;
				if($ct->user_id==0 ||$ct->user_id==$user->user_id){
					$is_jx=1;
				}elseif($ct->is_yc==0 ||$ct->yc_fxt==0){
					$is_jx=1;
				}else{
					$s_query='select *
					from user_topic 
					where tid=0 and user_id='.$user->user_id.' and topic_id='.$ct->topic_id.' 
					limit 1';
					$cl_query=$this->db->query($s_query);
					if($cl_query->num_rows()>0){
						if($ct->yc_fxt==1){
							$is_jx=1;
						}else{
							$cl=$cl_query->row();
							if($cl->c_fx>$cl->c_fxyy)$is_jx=1;
						}
					}
					$cl_query->free_result();
				}
				if($is_jx>0){
					$topic=$ct;
				}
			}
			$ct_query->free_result();
		}
		$is_jx=1;
		if(!isset($topic) &&$user->hydate<=time() &&$main->is_cs==0){
		}
		if($is_jx>0){
			$tdata['title']=isset($post['title'])?trim($post['title']):'';
			if($tdata['title']!=''){
				$tdata['content']=isset($_POST['content'])?trim($_POST['content']):'';
				if(isset($topic) &&$topic->user_id==$user->user_id){
					$this->db->update('topic',$tdata,array('topic_id'=>$topic->topic_id));
					$tid=$topic->topic_id;
				}else{
					$tdata['datetime']=time();
					$tdata['user_id']=$user->user_id;
					if(isset($topic)){
						$tdata['utid']=$topic->topic_id;
						if($topic->is_yc>0 &&$topic->yc_fxt==2){
							$cldata['c_fxyy']=$cl->c_fxyy+1;
							$this->db->update('user_topic',$cldata,array('utopic_id'=>$cl->utopic_id));
						}
					}
					$this->db->insert('topic',$tdata);
					$tid=$this->db->insert_id();
					$udata['c_topic']=$user->c_topic+1;
					$this->db->update('user',$udata,array('user_id'=>$user->user_id));
				}
			}else{
				$msg='标题不能为空';
			}
		}
		if(isset($msg))$this->session->set_userdata('msg',$msg);
		if(isset($tid)){
			$this->session->set_userdata('is_share',1);
			redirect($this->c_name.'/view/'.$tid.'/');
		}elseif(isset($topic)){
			redirect($this->c_name.'/edit/?id='.$topic->topic_id);
		}else{
			redirect($this->c_name.'/');
		}
	}
	public function ad_pic_post(){
		$user=$this->main->user();
		$main=$user->main;
		$post=$this->input->post(NULL,TRUE);
		$ua=$this->main->img_upload($post,$user->user_id,'ad');
		$data['pic']=$ua[0];
		$data['oss']=$ua[1];
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_ad_pic');
		$this->load->view('m_foot');
	}
	public function pic_view(){
		$get=$this->input->get(NULL,TRUE);
		if(isset($get['p']) &&trim($get['p'])!=''){
			$pu=get_furl(trim($get['p']));
			$au=parse_url($pu);
			if(isset($au['host']) &&strtolower($au['host'])=='mmbiz.qpic.cn'){
				$fu='static/file/'.md5($pu).'.png';
				if(file_exists($fu)){
					redirect($this->config->item('base_url').$fu);
				}else{
					$r=$this->main->http($pu);
					if(isset($r['ywr_response']) &&$r['ywr_response']!=''){
						$this->load->helper('file');
						write_file($fu,$r['ywr_response']);
						$this->output->set_header("Content-Disposition:image/png; filename=pic.png");
						$this->output->set_content_type('png');
						$this->output->set_output($r['ywr_response']);
					}
				}
			}else{
				redirect($pu);
			}
		}
	}
	public function view($id=''){
		if($id==''||intval($id)<=0)exit();
		$cid=intval($id);
		$user=$this->main->user(1);
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$s_query='select *
		from topic 
		where (is_rw=0 or rw_isff>0) and topic_id='.$cid.' 
		limit 1';
		$ct_query=$this->db->query($s_query);
		if($ct_query->num_rows()>0){
			$topic=$ct_query->row();
			$tdata['c_read']=$topic->c_read+1;
			$this->db->update('topic',$tdata,array('topic_id'=>$cid));
			if($topic->utid>0){
				$u_query='update topic set c_read=c_read+1 where topic_id='.$topic->utid;
				$this->db->query($u_query);
			}
			if($topic->user_id>0){
				$u_query='update user set c_read=c_read+1 where user_id='.$topic->user_id;
				$this->db->query($u_query);
			}
			$sc='';
			if($topic->user_id>0){
				$s_query='select *
				from user
				where user_id='.$topic->user_id.'
				limit 1';
				$tu_query=$this->db->query($s_query);
				if($tu_query->num_rows()>0){
					$tu=$tu_query->row();
					$data['tu']=$tu;
					$sc=$tu->code;
				}
				$tu_query->free_result();
			}
			$is_fx=1;
			if($topic->is_yc>0 &&$topic->yc_fxt>0 &&$topic->yc_fxjg>0){
				$is_fx=0;
				if(isset($user->user_id) &&$user->user_id>0){
					if($user->user_id==$topic->user_id){
						$is_fx=1;
					}else{
						$s_query='select *
						from user_topic 
						where tid=0 and user_id='.$user->user_id.' and topic_id='.$topic->topic_id.' 
						limit 1';
						$cl_query=$this->db->query($s_query);
						if($cl_query->num_rows()>0){
							if($topic->yc_fxt==1){
								$is_fx=1;
							}else{
								$cl=$cl_query->row();
								$data['cl']=$cl;
								if($cl->c_fx>$cl->c_fxyy)$is_fx=1;
							}
						}
						$cl_query->free_result();
					}
				}
			}
			$data['is_fx']=$is_fx;
			if(isset($user->code))$sc=$user->code;
			$cl=6;
			$s_query='select *
			from topic 
			where (is_rw=0 or (rw_isff>0 && (rw_datee=0 or rw_datee>'.time().') && rw_fxc>c_rwzf)) and user_id>0 and topic_id<>'.$cid.' 
			order by datetime desc, topic_id desc 
			limit '.$cl;
			$cl_query=$this->db->query($s_query);
			if($cl_query->num_rows()>0){
				$data['tl_0']=$cl_query->result();
			}
			$cl_query->free_result();
			$s_query='select *
			from topic 
			where (is_rw=0 or (rw_isff>0 && (rw_datee=0 or rw_datee>'.time().') && rw_fxc>c_rwzf)) and user_id>0 and topic_id<>'.$cid.' 
			order by c_read desc, datetime desc, topic_id desc 
			limit '.$cl;
			$cl_query=$this->db->query($s_query);
			if($cl_query->num_rows()>0){
				$data['tl_1']=$cl_query->result();
			}
			$cl_query->free_result();
			$s_query='select *
			from topic 
			where (is_rw=0 or (rw_isff>0 && (rw_datee=0 or rw_datee>'.time().') && rw_fxc>c_rwzf)) and user_id>0 and topic_id<>'.$cid.' 
			order by c_zf desc, datetime desc, topic_id desc 
			limit '.$cl;
			$cl_query=$this->db->query($s_query);
			if($cl_query->num_rows()>0){
				$data['tl_2']=$cl_query->result();
			}
			$cl_query->free_result();
			$data['topic']=$topic;
			$data['m_title']=$topic->title;
			$data['page_title']=$topic->title;
			$data['m_content']='这个不错哟！我推荐下。已有'.rand(51,9999).'个朋友阅读并果断转发朋友圈了';
			$mu=getpageurl($this->c_name.'/view/'.$cid.'/');
			if($sc!='')$mu.='?share_c='.$sc;
			$data['m_url']=$mu;
			$data['share_code']=$sc;
			$this->load->view('m_head',$data);
			$this->load->view($this->c_name.'_view');
			$this->load->view('m_foot');
		}else{
			redirect();
		}
		$ct_query->free_result();
	}
	public function zf($id=''){
		if($id==''||intval($id)<=0)exit();
		$cid=intval($id);
		$user=$this->main->user(1);
		$main=$user->main;
		$s_query='select *
		from topic 
		where topic_id='.$cid.' 
		limit 1';
		$ct_query=$this->db->query($s_query);
		if($ct_query->num_rows()>0){
			$topic=$ct_query->row();
			$tdata['c_zf']=$topic->c_zf+1;
			$this->db->update('topic',$tdata,array('topic_id'=>$cid));
			if($topic->utid>0){
				$u_query='update topic set c_zf=c_zf+1 where topic_id='.$topic->utid;
				$this->db->query($u_query);
			}
			if($topic->user_id>0){
				$u_query='update user set c_zf=c_zf+1 where user_id='.$topic->user_id;
				$this->db->query($u_query);
			}
			echo $tdata['c_zf'];
		}
		$ct_query->free_result();
	}
	public function rw_zf($id=''){
	}
	public function my(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$get=$this->input->get(NULL,TRUE);
		$o_db='datetime desc, topic_id desc';
		$oid=0;
		if(isset($get['o'])){
			switch($get['o']){
			case 2:
				$oid=2;
				$o_db='c_zf desc, datetime desc, topic_id desc';
				break;
			case 1:
				$oid=1;
				$o_db='c_read desc, datetime desc, topic_id desc';
				break;
			}
		}
		$search['oid']=$oid;
		$data['search']=$search;
		$s_query='select *
		from topic 
		where is_yc=0 and is_rw=0 and user_id='.$user->user_id.' 
		order by '.$o_db;
		$ct_query=$this->db->query($s_query);
		$p_total=$ct_query->num_rows();
		if($p_total>0){
			$c_page=(isset($get['p']) &&intval($get['p'])>0)?intval($get['p']):0;
			$data['search']['p']=$c_page;
			$page_size=$this->config->item('page_size');
			$data['page_size']=$page_size;
			$data['page']=getpagehtml_mini(getpageurl($this->c_name.'/my/'),$p_total,$c_page,$page_size);
			$ct_l_query=$this->db->query($s_query.' limit '.($c_page*$page_size).', '.$page_size);
			$data['sql']=$ct_l_query->result();
			$ct_l_query->free_result();
		}
		$ct_query->free_result();
		$data['hide_menu']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_my');
		$this->load->view('m_foot');
	}
	public function del($id=''){
		if($id==''||intval($id)<=0)exit();
		$cid=intval($id);
		$user=$this->main->user();
		$main=$user->main;
		$s_query='select *
		from topic 
		where user_id='.$user->user_id.' and topic_id='.$cid.' 
		limit 1';
		$ct_query=$this->db->query($s_query);
		if($ct_query->num_rows()>0){
			$topic=$ct_query->row();
			$this->db->update('topic',array('utid'=>0),array('utid'=>$cid));
			$this->db->delete('topic',array('topic_id'=>$cid));
			$msg='文章已删除';
		}
		$ct_query->free_result();
		if(isset($msg))$this->session->set_userdata('msg',$msg);
		$get=$this->input->get(NULL,TRUE);
		redirect($this->c_name.'/my/?'.http_build_query($get));
	}
}
?>