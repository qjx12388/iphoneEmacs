<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['page_size']=20;

$config['maxsms']=70;

$config['user_type']=array(1=>'企业', '代理', '投资人', '投资机构', '服务机构', '创业导师');
$config['user_type'][90]='客服';
$config['user_type'][99]='子管理员';
$config['user_type'][100]='超级管理员';

$wx_tid=1000;
$config['wx_tid']=$wx_tid;
$config['user_lx'][$wx_tid]='微信';
$config['user_lx'][0]='手机';
