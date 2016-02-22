<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ad extends CI_Controller {
	public function __construct(){
		parent::__construct();
		header('P3P: CP=CAO PSA OUR');
		$this->c_name='ad';
		$session=$this->session->all_userdata();
		$data['session']=$session;
		$data['cname']=$this->c_name;
		$this->data=$data;
	}
	public function index(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$get=$this->input->get(NULL,TRUE);
		$s_query='select *
		from ad 
		where user_id='.$user->user_id.' 
		order by ad_id desc';
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
		$data['hide_menu']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_index');
		$this->load->view('m_foot');
	}
	public function setting(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$data['hide_menu']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_setting');
		$this->load->view('m_foot');
	}
	public function setting_post(){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		$post=$this->input->post(NULL,TRUE);
		$udata['is_ad_wz0']=(isset($post['is_ad_wz0']) &&$post['is_ad_wz0']==1)?1:0;
		$udata['is_ad_wz1']=(isset($post['is_ad_wz1']) &&$post['is_ad_wz1']==1)?1:0;
		$this->db->update('user',$udata,array('user_id'=>$user->user_id));
		$msg='设置已保存';
		if(isset($msg))$this->session->set_userdata('msg',$msg);
		redirect($this->c_name.'/');
	}
	public function add($tid=0){
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		if($tid!=1)$tid=0;
		$data['tid']=$tid;
		$data['hide_menu']=1;
		$this->load->view('m_head',$data);
		$this->load->view($this->c_name.'_add');
		$this->load->view('m_foot');
	}
	public function add_post(){
		$user=$this->main->user();
		$main=$user->main;
		$post=$this->input->post(NULL,TRUE);
		$is_jx=0;
		if(isset($post['url']) &&trim($post['url'])!=''){
			$is_jx=1;
			$adata['url']=trim($post['url']);
		}
		$tid=0;
		if(isset($post['t']) &&$post['t']==1)$tid=1;
		if($is_jx>0){
			$is_jx=0;
			if($tid==1){
				$ua=$this->main->img_upload($post,$udb->user_id);
				$adata['pic']=$ua[0];
				$adata['oss']=$ua[1];
				if($adata['pic']!=''||$adata['oss']!='')$is_jx=1;
			}else{
				if(isset($post['title']) &&trim($post['title'])!=''){
					$adata['title']=trim($post['title']);
					$is_jx=1;
				}
			}
		}
		if($is_jx>0){
			$adata['user_id']=$user->user_id;
			$this->db->insert('ad',$adata);
			$msg='广告已添加';
			if(isset($msg))$this->session->set_userdata('msg',$msg);
			redirect($this->c_name.'/');
			exit();
		}else{
			$msg='链接、内容不能为空';
		}
		if(isset($msg))$this->session->set_userdata('msg',$msg);
		redirect($this->c_name.'/add/'.$tid.'/');
	}
	public function edit($id=''){
		if($id==''||intval($id)<=0)exit();
		$cid=intval($id);
		$user=$this->main->user();
		$data=$this->data;
		$main=$user->main;
		$data['user']=$user;
		$data['main']=$main;
		$get=$this->input->get(NULL,TRUE);
		$s_query='select *
		from ad 
		where user_id='.$user->user_id.' and ad_id='.$cid.' 
		limit 1';
		$ct_query=$this->db->query($s_query);
		if($ct_query->num_rows()>0){
			$ad=$ct_query->row();
			$data['ad']=$ad;
			$data['hide_menu']=1;
			$this->load->view('m_head',$data);
			$this->load->view($this->c_name.'_edit');
			$this->load->view('m_foot');
		}
		$ct_query->free_result();
	}
	public function edit_post($id=''){
		if($id==''||intval($id)<=0)exit();
		$cid=intval($id);
		$user=$this->main->user();
		$main=$user->main;
		$s_query='select *
		from ad 
		where user_id='.$user->user_id.' and ad_id='.$cid.' 
		limit 1';
		$ct_query=$this->db->query($s_query);
		if($ct_query->num_rows()>0){
			$ad=$ct_query->row();
			$post=$this->input->post(NULL,TRUE);
			$is_jx=0;
			if(isset($post['url']) &&trim($post['url'])!=''){
				$is_jx=1;
				$adata['url']=trim($post['url']);
			}
			if($is_jx>0){
				$is_jx=0;
				if(isset($post['t']) &&$post['t']==1){
					$ua=$this->main->img_upload($post,$udb->user_id);
					$adata['pic']=$ua[0];
					$adata['oss']=$ua[1];
					if($adata['pic']!=''||$adata['oss']!='')$is_jx=1;
				}else{
					if(isset($post['title']) &&trim($post['title'])!=''){
						$adata['title']=trim($post['title']);
						$is_jx=1;
					}
				}
			}
			if($is_jx>0){
				$this->db->update('ad',$adata,array('ad_id'=>$cid));
				$msg='修改已提交';
			}else{
				$msg='链接、内容不能为空';
			}
			if(isset($msg))$this->session->set_userdata('msg',$msg);
			redirect($this->c_name.'/edit/'.$cid.'/');
		}
		$ct_query->free_result();
	}
	public function wz($id='',$wid=0,$v=0){
		if($id==''||intval($id)<=0)exit();
		$cid=intval($id);
		$user=$this->main->user();
		$main=$user->main;
		$s_query='select *
		from ad 
		where user_id='.$user->user_id.' and ad_id='.$cid.' 
		limit 1';
		$ct_query=$this->db->query($s_query);
		if($ct_query->num_rows()>0){
			$ad=$ct_query->row();
			$k=(intval($wid)>0 &&intval($wid)<=1)?intval($wid):0;
			$v=$v==1?1:0;
			if($v>0){
				$this->db->update('ad',array('is_wz'.$k=>0),array('is_wz'.$k=>1));
			}
			$adata['is_wz'.$k]=$v;
			$this->db->update('ad',$adata,array('ad_id'=>$cid));
			$msg='广告已修改';
		}
		$ct_query->free_result();
		if(isset($msg))$this->session->set_userdata('msg',$msg);
		$get=$this->input->get(NULL,TRUE);
		redirect($this->c_name.'/?'.http_build_query($get));
	}
	public function del($id=''){
		if($id==''||intval($id)<=0)exit();
		$cid=intval($id);
		$user=$this->main->user();
		$main=$user->main;
		$s_query='select *
		from ad 
		where user_id='.$user->user_id.' and ad_id='.$cid.' 
		limit 1';
		$ct_query=$this->db->query($s_query);
		if($ct_query->num_rows()>0){
			$ad=$ct_query->row();
			$this->db->delete('ad',array('ad_id'=>$cid));
			$msg='广告已删除';
		}
		$ct_query->free_result();
		if(isset($msg))$this->session->set_userdata('msg',$msg);
		$get=$this->input->get(NULL,TRUE);
		redirect($this->c_name.'/?'.http_build_query($get));
	}
}
?>