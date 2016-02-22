DROP TABLE IF EXISTS main;

CREATE TABLE `main` (
 `sn` varchar(255) DEFAULT NULL,
 `is_cs` int(5) NOT NULL DEFAULT '0',
 `wx_name` varchar(255) DEFAULT NULL,
 `wx_pic` varchar(255) DEFAULT NULL,
 `wx_oss` varchar(255) DEFAULT NULL,
 `wx_app_id` varchar(255) DEFAULT NULL,
 `wx_app_secret` varchar(255) DEFAULT NULL,
 `wx_access_token` varchar(255) DEFAULT NULL,
 `wx_at_time` int(15) NOT NULL DEFAULT '0',
 `wx_js_ticket` varchar(255) DEFAULT NULL,
 `wx_jt_time` int(15) NOT NULL DEFAULT '0',
 `wx_pay_pk` varchar(255) DEFAULT NULL,
 `wx_pay_p` varchar(255) DEFAULT NULL,
 `wx_pay_k` varchar(255) DEFAULT NULL,
 `wx_pay_si` varchar(255) DEFAULT NULL,
 `wx_pay_sk` varchar(255) DEFAULT NULL,
 `wx_pay_sid` varchar(255) DEFAULT NULL,
 `wx_pay_cert` longtext,
 `wx_pay_key` longtext,
 `wx_pay_o` int(5) NOT NULL DEFAULT '0',
 `wx_o_app_id` varchar(255) DEFAULT NULL,
 `wx_o_app_secret` varchar(255) DEFAULT NULL,
 `wx_o_pay_si` varchar(255) DEFAULT NULL,
 `wx_o_pay_sk` varchar(255) DEFAULT NULL,
 `api_u` text,
 `api_n` varchar(255) DEFAULT NULL,
 `api_p` varchar(255) DEFAULT NULL,
 `api_qm` varchar(255) DEFAULT NULL,
 `reg_t` int(5) NOT NULL DEFAULT '0',
 `reg_u` text,
 `is_cos` int(5) NOT NULL DEFAULT '0',
 `cos_aid` varchar(255) DEFAULT NULL,
 `cos_sid` varchar(255) DEFAULT NULL,
 `cos_key` varchar(255) DEFAULT NULL,
 `cos_b` varchar(255) DEFAULT NULL,
 `fy` int(10) NOT NULL DEFAULT '0',
 `fy_jl` int(10) NOT NULL DEFAULT '0',
 `fy_tdjl` int(10) NOT NULL DEFAULT '0',
 `hl_zc` int(10) NOT NULL DEFAULT '0',
 `hl_td` int(10) NOT NULL DEFAULT '0',
 `hl_td_d` int(10) NOT NULL DEFAULT '0',
 `tx_qs` int(10) NOT NULL DEFAULT '0',
 `tx_fy` int(10) NOT NULL DEFAULT '0',
 `mfts` int(10) NOT NULL DEFAULT '0',
 `ad_u` varchar(255) DEFAULT NULL,
 `ad_pic` varchar(255) DEFAULT NULL,
 `ad_oss` varchar(255) DEFAULT NULL,
 `fy_jfx` int(10) NOT NULL DEFAULT '0',
 `jfx_mfc` int(10) NOT NULL DEFAULT '0',
 `jfx_ad_u` varchar(255) DEFAULT NULL,
 `jfx_ad_pic` varchar(255) DEFAULT NULL,
 `jfx_ad_oss` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS admin;

CREATE TABLE `admin` (
 `admin_id` int(10) NOT NULL AUTO_INCREMENT,
 `username` varchar(255) DEFAULT NULL,
 `password` varchar(255) DEFAULT NULL,
 `name` varchar(255) DEFAULT NULL,
 `tid` int(10) NOT NULL DEFAULT '0',
 `regdate` int(15) NOT NULL DEFAULT '0',
 `lastdate` int(15) NOT NULL DEFAULT '0',
 `logincount` int(10) NOT NULL DEFAULT '0',
 `lastip` varchar(50) DEFAULT NULL,
 PRIMARY KEY (`admin_id`),
 UNIQUE (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS user;

CREATE TABLE `user` (
 `user_id` int(10) NOT NULL AUTO_INCREMENT,
 `username` varchar(255) DEFAULT NULL,
 `password` varchar(255) DEFAULT NULL,
 `name` varchar(255) DEFAULT NULL,
 `tid` int(5) NOT NULL DEFAULT '0',
 `wxdate` int(15) NOT NULL DEFAULT '0',
 `openid` varchar(255) DEFAULT NULL,
 `tel` varchar(255) DEFAULT NULL,
 `code` varchar(255) DEFAULT NULL,
 `uid` int(10) NOT NULL DEFAULT '0',
 `regdate` int(15) NOT NULL DEFAULT '0',
 `hydate` int(15) NOT NULL DEFAULT '0',
 `lastdate` int(15) NOT NULL DEFAULT '0',
 `logincount` int(10) NOT NULL DEFAULT '0',
 `lastip` varchar(50) DEFAULT NULL,
 `ye` int(10) NOT NULL DEFAULT '0',
 `bz` varchar(255) DEFAULT NULL,
 `c_topic` int(10) NOT NULL DEFAULT '0',
 `c_rw` int(10) NOT NULL DEFAULT '0',
 `c_yc` int(10) NOT NULL DEFAULT '0',
 `c_jfx` int(10) NOT NULL DEFAULT '0',
 `c_zf` int(10) NOT NULL DEFAULT '0',
 `c_read` int(10) NOT NULL DEFAULT '0',
 `c_jfxzf` int(10) NOT NULL DEFAULT '0',
 `c_jfxcg` int(10) NOT NULL DEFAULT '0',
 `c_sy` int(10) NOT NULL DEFAULT '0',
 `c_tdsy` int(10) NOT NULL DEFAULT '0',
 `c_td` int(10) NOT NULL DEFAULT '0',
 `td_name` varchar(255) DEFAULT NULL,
 `is_ad_wz0` int(5) NOT NULL DEFAULT '0',
 `is_ad_wz1` int(5) NOT NULL DEFAULT '0',
 `is_hl_td` int(5) NOT NULL DEFAULT '0',
 PRIMARY KEY (`user_id`),
 UNIQUE (`username`),
 UNIQUE (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ad;

CREATE TABLE `ad` (
 `ad_id` int(10) NOT NULL AUTO_INCREMENT,
 `user_id` int(10) NOT NULL DEFAULT '0',
 `name` varchar(255) DEFAULT NULL,
 `title` varchar(255) DEFAULT NULL,
 `url` varchar(255) DEFAULT NULL,
 `pic` varchar(255) DEFAULT NULL,
 `oss` varchar(255) DEFAULT NULL,
 `is_wz0` int(5) NOT NULL DEFAULT '0',
 `is_wz1` int(5) NOT NULL DEFAULT '0',
 PRIMARY KEY (`ad_id`),
 KEY `user_id` (`user_id`),
 KEY `is_wz0` (`is_wz0`),
 KEY `is_wz1` (`is_wz1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS topic;

CREATE TABLE `topic` (
 `topic_id` int(10) NOT NULL AUTO_INCREMENT,
 `user_id` int(10) NOT NULL DEFAULT '0',
 `title` varchar(255) DEFAULT NULL,
 `datetime` int(15) NOT NULL DEFAULT '0',
 `content` longtext,
 `utid` int(10) NOT NULL DEFAULT '0',
 `c_zf` int(10) NOT NULL DEFAULT '0',
 `c_read` int(10) NOT NULL DEFAULT '0',
 `c_rwzf` int(10) NOT NULL DEFAULT '0',
 `is_yc` int(5) NOT NULL DEFAULT '0',
 `yc_fxt` int(5) NOT NULL DEFAULT '0',
 `yc_fxjg` int(10) NOT NULL DEFAULT '0',
 `is_rw` int(5) NOT NULL DEFAULT '0',
 `rw_datee` int(15) NOT NULL DEFAULT '0',
 `rw_fxc` int(10) NOT NULL DEFAULT '0',
 `rw_fxd` int(10) NOT NULL DEFAULT '0',
 `rw_fxjg` int(10) NOT NULL DEFAULT '0',
 `rw_isff` int(5) NOT NULL DEFAULT '0',
 PRIMARY KEY (`topic_id`),
 KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS pay_info;

CREATE TABLE `pay_info` (
 `pay_id` int(10) NOT NULL AUTO_INCREMENT,
 `user_id` int(10) NOT NULL DEFAULT '0',
 `money` int(10) NOT NULL DEFAULT '0',
 `datetime` int(15) NOT NULL DEFAULT '0',
 `ap_sid` varchar(255) DEFAULT NULL,
 `ap_mid` varchar(255) DEFAULT NULL,
 `ap_pid` varchar(255) DEFAULT NULL,
 `openid` varchar(255) DEFAULT NULL,
 `dd_name` text,
 `money_s` int(10) NOT NULL DEFAULT '0',
 `isdh` int(5) NOT NULL default '0',
 `tid` int(5) NOT NULL default '0',
 `topic_id` int(10) NOT NULL default '0',
 `info` varchar(255) DEFAULT NULL,
 `fkfs` int(10) NOT NULL default '0',
 PRIMARY KEY (`pay_id`),
 KEY `user_id` (`user_id`),
 KEY `topic_id` (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS tx_info;

CREATE TABLE `tx_info` (
 `tx_id` int(10) NOT NULL AUTO_INCREMENT,
 `user_id` int(10) NOT NULL DEFAULT '0',
 `money` int(10) NOT NULL DEFAULT '0',
 `money_s` int(10) NOT NULL DEFAULT '0',
 `datetime` int(15) NOT NULL DEFAULT '0',
 `ap_sid` varchar(255) DEFAULT NULL,
 `ap_pid` varchar(255) DEFAULT NULL,
 `openid` varchar(255) DEFAULT NULL,
 `isfs` int(5) NOT NULL default '0',
 `iscg` int(5) NOT NULL default '0',
 `req` longtext,
 `res` longtext,
 PRIMARY KEY (`tx_id`),
 KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS url;

CREATE TABLE `url` (
 `url_id` int(10) NOT NULL AUTO_INCREMENT,
 `code` varchar(255) DEFAULT NULL,
 `url` text,
 PRIMARY KEY (`url_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS log_rmb;

CREATE TABLE `log_rmb` (
 `log_rmb_id` int(10) NOT NULL AUTO_INCREMENT,
 `user_id` int(10) NOT NULL DEFAULT '0',
 `datetime` int(15) NOT NULL DEFAULT '0',
 `ye` int(10) NOT NULL DEFAULT '0',
 `tid` int(5) NOT NULL DEFAULT '0',
 `content` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`log_rmb_id`),
 KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS log_action;

CREATE TABLE `log_action` (
 `log_action_id` int(10) NOT NULL AUTO_INCREMENT,
 `admin_id` int(10) NOT NULL DEFAULT '0',
 `user_id` int(10) NOT NULL DEFAULT '0',
 `topic_id` int(10) NOT NULL DEFAULT '0',
 `jfx_id` int(10) NOT NULL DEFAULT '0',
 `datetime` int(15) NOT NULL DEFAULT '0',
 `content` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`log_action_id`),
 KEY `admin_id` (`admin_id`),
 KEY `user_id` (`user_id`),
 KEY `topic_id` (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS log_sms;

CREATE TABLE `log_sms` (
 `log_sms_id` int(10) NOT NULL AUTO_INCREMENT,
 `datetime` int(15) NOT NULL DEFAULT '0',
 `mobile` varchar(255) DEFAULT NULL,
 `content` varchar(255) DEFAULT NULL,
 `is_cg` int(5) NOT NULL DEFAULT '0',
 `info` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`log_sms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ci_sessions;

CREATE TABLE `ci_sessions` (
 `id` varchar(40) NOT NULL,
 `ip_address` varchar(45) NOT NULL,
 `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
 `data` blob NOT NULL,
 PRIMARY KEY (`id`),
 KEY `ci_sessions_timestamp` (`timestamp`)
);
