<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mysql extends CI_Controller {
	public function __construct(){
		parent::__construct();
		header('P3P: CP=CAO PSA OUR');
		$this->c_name='mysql';
		$data['cname']=$this->c_name;
		$this->data=$data;
	}
	public function setup(){
		require('application/config/autoload.php');
		if(isset($autoload['libraries']) &&in_array('database',$autoload['libraries'])){
			redirect();
			exit();
		}
		$data=$this->data;
		$data['body_class']='gray-bg';
		$data['no_side']=1;
		$this->load->view('admin_head',$data);
		$this->load->view($this->c_name.'_setup');
		$this->load->view('admin_foot');
	}
	public function setup_post(){
		$al_f='application/config/autoload.php';
		require($al_f);
		if(isset($autoload['libraries']) &&in_array('database',$autoload['libraries'])){
			redirect('');
			exit();
		}
		$post=$this->input->post(NULL,TRUE);
		$sn=isset($post['sn'])?trim($post['sn']):'';
		$db_h=isset($post['db_h'])?trim($post['db_h']):'';
		$db_u=isset($post['db_u'])?trim($post['db_u']):'';
		$db_p=isset($post['db_p'])?trim($post['db_p']):'';
		$db_n=isset($post['db_n'])?trim($post['db_n']):'';
		if($sn!=''&&$db_h!=''&&$db_u!=''&&$db_n!=''){
			$domain=$_SERVER['HTTP_HOST'];
			$is_jx=0;
			$dj=0;
			$api_u='http://www.weixinkaka.com/index.php/guanggaoke/api/';
			$pa['sn']=$sn;
			$pa['domain']=$domain;
			$api_p=http_build_query($pa);
			$ci=curl_init();
			curl_setopt($ci,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ci,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ci,CURLOPT_CONNECTTIMEOUT,30);
			curl_setopt($ci,CURLOPT_TIMEOUT,30);
			curl_setopt($ci,CURLOPT_POST,TRUE);
			curl_setopt($ci,CURLOPT_POSTFIELDS,$api_p);
			$api_h[]='User-Agent: guanggaoke';
			curl_setopt($ci,CURLOPT_HTTPHEADER,$api_h);
			curl_setopt($ci,CURLOPT_URL,$api_u);
			$api_r=curl_exec($ci);
			curl_close($ci);
			if($api_r!=''){
				$api_a=array();
				$api_a=@json_decode($api_r,true);
			}
			/*if(isset($api_a['error']) &&$api_a['error']==0 &&isset($api_a['dj']) &&$api_a['dj']>=0){
				$is_jx=1;
				$dj=$api_a['dj'];
			}else{
				$msg='验证授权SN码错误';
				if(isset($api_a['msg']) &&$api_a['msg']!='')$msg.='：'.$api_a['msg'];
			}*/
			$is_jx=1;
			if($is_jx>0){
				$db_c['hostname']=$db_h;
				$db_c['username']=$db_u;
				$db_c['password']=$db_p;
				$db_c['database']=$db_n;
				$db_c['dbdriver']='mysqli';
				$db_c['dbprefix']='';
				$db_c['pconnect']=FALSE;
				$db_c['db_debug']=TRUE;
				$db_c['cache_on']=FALSE;
				$db_c['cachedir']='';
				$db_c['char_set']='utf8';
				$db_c['dbcollat']='utf8_general_ci';
				$this->load->database($db_c);
				$this->load->helper('file');
				for($i=0;$i<=0;$i++){
					$db_f='static/sql/mysql_'.$i.'.sql';
					if(file_exists($db_f)){
						$db_c=read_file($db_f);
						if($db_c!=''){
							$db_a=explode(';',$db_c);
							foreach($db_a as $v){
								if(trim($v)!=''){
									$this->db->query(trim($v));
								}
							}
						}
					}
				}
				$mdata['sn']=$sn;
				$mdata['ad_u']='http://www.guanggaoke.com/';
				$mdata['ad_pic']='static/images/ad.jpg';
				$this->db->insert('main',$mdata);
				$admin_name='admin';
				$admin_password='123456';
				$adata['username']=$admin_name;
				$adata['password']=md5($admin_password);
				$adata['name']='管理员';
				$adata['tid']=1;
				$adata['regdate']=time();
				$this->db->insert('admin',$adata);
				$al_c='<?php'."\r\n";
				$al_c.='defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');'."\r\n";
				$al_c.='$autoload[\'packages\']=array();'."\r\n";
				$al_c.='$autoload[\'libraries\']=array(\'database\', \'session\');'."\r\n";
				$al_c.='$autoload[\'drivers\']=array();'."\r\n";
				$al_c.='$autoload[\'helper\']=array(\'url\', \'func\');'."\r\n";
				$al_c.='$autoload[\'config\']=array(\'conf\');'."\r\n";
				$al_c.='$autoload[\'language\']=array();'."\r\n";
				$al_c.='$autoload[\'model\']=array(\'main\');'."\r\n";
				write_file($al_f,$al_c);
				$dbc_f='application/config/database.php';
				$dbc_c='<?php'."\r\n";
				$dbc_c.='defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');'."\r\n";
				$dbc_c.='$active_group=\'default\';'."\r\n";
				$dbc_c.='$query_builder=TRUE;'."\r\n";
				$dbc_c.='$db[\'default\'] = array('."\r\n";
				$dbc_c.="\t".'\'dsn\'=>\'\','."\r\n";
				$dbc_c.="\t".'\'hostname\'=>\''.$db_h.'\','."\r\n";
				$dbc_c.="\t".'\'username\'=>\''.$db_u.'\','."\r\n";
				$dbc_c.="\t".'\'password\'=>\''.$db_p.'\','."\r\n";
				$dbc_c.="\t".'\'database\'=>\''.$db_n.'\','."\r\n";
				$dbc_c.="\t".'\'dbdriver\'=>\'mysqli\','."\r\n";
				$dbc_c.="\t".'\'dbprefix\'=>\'\','."\r\n";
				$dbc_c.="\t".'\'pconnect\'=>FALSE,'."\r\n";
				$dbc_c.="\t".'\'db_debug\'=>(ENVIRONMENT!==\'production\'),'."\r\n";
				$dbc_c.="\t".'\'cache_on\'=>FALSE,'."\r\n";
				$dbc_c.="\t".'\'cachedir\'=>\'\','."\r\n";
				$dbc_c.="\t".'\'char_set\'=>\'utf8\','."\r\n";
				$dbc_c.="\t".'\'dbcollat\'=>\'utf8_general_ci\','."\r\n";
				$dbc_c.="\t".'\'swap_pre\'=>\'\','."\r\n";
				$dbc_c.="\t".'\'encrypt\'=>FALSE,'."\r\n";
				$dbc_c.="\t".'\'compress\'=>FALSE,'."\r\n";
				$dbc_c.="\t".'\'stricton\'=>FALSE,'."\r\n";
				$dbc_c.="\t".'\'failover\'=>array(),'."\r\n";
				$dbc_c.="\t".'\'save_queries\'=>TRUE'."\r\n";
				$dbc_c.=');'."\r\n";
				write_file($dbc_f,$dbc_c);
				$msg='安装完成，管理员账号：'.$admin_name.'，密码：'.$admin_password;
			}
		}else{
			$msg='必填项不能为空';
		}
		echo '<meta charset="utf-8"><script type="text/javascript">';
		if(isset($msg)){
			echo 'alert(\''.$msg.'\');';
		}
		echo 'location.href=\''.getpageurl($this->c_name.'/setup/').'\';';
		echo '</script>';
	}
	public function update($d=''){
		$is_sj=0;
		if($d!=''){
			$f_lock='static/sql/update_'.$d.'.lock';
			$f_sql='static/sql/update_'.$d.'.sql';
			if(!file_exists($f_lock) &&file_exists($f_sql)){
				$is_sj=1;
			}
		}
		if($is_sj>0){
			$content='<meta charset="utf-8"><h1>升级数据库</h1><ul>';
			$this->load->helper('file');
			$query=read_file($f_sql);
			if($query!=''){
				$a_query=explode(';',$query);
				foreach($a_query as $v){
					if(trim($v)!=''){
						$this->db->query(trim($v));
						$content.='<li>升级数据表</li>';
					}
				}
				write_file($f_lock,time());
			}else{
				$content.='<li>加载数据库文件出错，请检查</li>';
			}
			$content.='</ul><input type="button" value="返回" onclick="location.href=\''.getpageurl().'\';"/>';
			echo $content;
		}else{
		}
	}
}
?>