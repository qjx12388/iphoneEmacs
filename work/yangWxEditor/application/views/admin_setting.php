			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>系统设置</h2>
				</div>
			</div>
			<div class="wrapper wrapper-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<form method="post" action="<?php echo getpageurl($cname.'/setting_post/'); ?>" class="form-horizontal" enctype="multipart/form-data">
								<div class="ibox-title">
									<h5>基本设置</h5>
								</div>
								<div class="ibox-content">
									<div class="form-group">
										<label class="col-sm-2 control-label">内测（不收费）</label>
										<div class="col-sm-4">
											<label class="checkbox-inline"><input type="radio" name="is_cs" value="0"<?php if($main->is_cs==0)echo ' checked'; ?>>关闭</label>
											<label class="checkbox-inline"><input type="radio" name="is_cs" value="1"<?php if($main->is_cs==1)echo ' checked'; ?>>开启</label>
										</div>
										<label class="col-sm-2 control-label">免费试用天数</label>
										<div class="col-sm-4">
											<div class="input-group m-b">
												<input type="text" class="form-control" name="mfts" value="<?php echo $main->mfts; ?>">
												<span class="input-group-addon">天</span>
											</div>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">年服务费</label>
										<div class="col-sm-4">
											<div class="input-group m-b">
												<span class="input-group-addon">&yen;</span> 
												<input type="text" class="form-control" name="fy" value="<?php echo $main->fy/100; ?>">
											</div>
										</div>
										<label class="col-sm-2 control-label">推荐奖励</label>
										<div class="col-sm-4">
											<div class="input-group m-b">
												<span class="input-group-addon">&yen;</span> 
												<input type="text" class="form-control" name="fy_jl" value="<?php echo $main->fy_jl/100; ?>">
											</div>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">下级收益奖励</label>
										<div class="col-sm-10">
											<div class="input-group m-b">
												<span class="input-group-addon">&yen;</span> 
												<input type="text" class="form-control" name="fy_tdjl" value="<?php echo $main->fy_tdjl/100; ?>">
											</div>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">免费提现最低金额</label>
										<div class="col-sm-4">
											<div class="input-group m-b">
												<span class="input-group-addon">&yen;</span> 
												<input type="text" class="form-control" name="tx_qs" value="<?php echo $main->tx_qs/100; ?>">
											</div>
										</div>
										<label class="col-sm-2 control-label">手续费</label>
										<div class="col-sm-4">
											<div class="input-group m-b">
												<span class="input-group-addon">&yen;</span> 
												<input type="text" class="form-control" name="tx_fy" value="<?php echo $main->tx_fy/100; ?>">
											</div>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">注册成功后前往</label>
										<div class="col-sm-4">
											<label class="checkbox-inline"><input type="radio" name="reg_t" value="0"<?php if($main->reg_t==0)echo ' checked'; ?>>登录页</label>
											<label class="checkbox-inline"><input type="radio" name="reg_t" value="1"<?php if($main->reg_t==1)echo ' checked'; ?>>自定网址</label>
										</div>
										<label class="col-sm-2 control-label">自定网址</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="reg_u" value="<?php echo $main->reg_u; ?>">
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<div class="col-sm-9 b-r">
											<h4>免费用户文章顶部图片广告</h4>
											<input type="text" disabled name="ad_pic" placeholder="请输入图片网址" class="form-control">
											<label>或者</label>
											<input type="file" disabled name="ad_file" class="form-control" accept="image/*">
										</div>
										<div class="col-sm-3">
											<p class="text-center">
												<?php
												//if($main->ad_pic!='')echo '<input type="hidden" name="ad_pico" value="'.$main->ad_pic.'">';
												if($main->ad_oss!=''){
													//echo '<input type="hidden" name="ad_oss" value="'.$main->ad_oss.'">';
													$main->ad_pic=$this->main->oss_url($main->ad_oss);
												}
												if($main->ad_pic=='')$main->ad_pic='static/images/blank.png';
												?>
												<img src="<?php echo $main->ad_pic; ?>" class="ywr_rpic">
											</p>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">广告链接</label>
										<div class="col-sm-10">
											<input type="text" disabled class="form-control" name="ad_u" value="<?php echo $main->ad_u; ?>">
										</div>
									</div>
								</div>
								<div class="ibox-title" style="display: none;">
									<h5>集分享设置</h5>
								</div>
								<div class="ibox-content" style="display: none;">
									<div class="form-group">
										<label class="col-sm-2 control-label">每次价格</label>
										<div class="col-sm-4">
											<div class="input-group m-b">
												<span class="input-group-addon">&yen;</span> 
												<input type="text" class="form-control" name="fy_jfx" value="<?php echo $main->fy_jfx/100; ?>">
											</div>
										</div>
										<label class="col-sm-2 control-label">免费发布数量</label>
										<div class="col-sm-4">
											<div class="input-group m-b">
												<input type="text" class="form-control" name="jfx_mfc" value="<?php echo $main->jfx_mfc; ?>">
												<span class="input-group-addon">条</span>
											</div>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<div class="col-sm-9 b-r">
											<h4>免费集分享顶部图片广告</h4>
											<input type="text" name="jad_pic" placeholder="请输入图片网址" class="form-control">
											<label>或者</label>
											<input type="file" name="jad_file" class="form-control" accept="image/*">
										</div>
										<div class="col-sm-3">
											<p class="text-center">
												<?php
												if($main->jfx_ad_pic!='')echo '<input type="hidden" name="jad_pico" value="'.$main->jfx_ad_pic.'">';
												if($main->jfx_ad_oss!=''){
													echo '<input type="hidden" name="jad_oss" value="'.$main->jfx_ad_oss.'">';
													$main->jfx_ad_pic=$this->main->oss_url($main->jfx_ad_oss);
												}
												if($main->jfx_ad_pic=='')$main->jfx_ad_pic='static/images/blank.png';
												?>
												<img src="<?php echo $main->jfx_ad_pic; ?>" class="ywr_rpic">
											</p>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">广告链接</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="jfx_ad_u" value="<?php echo $main->jfx_ad_u; ?>">
										</div>
									</div>
								</div>
								<div class="ibox-title">
									<h5>微信设置</h5>
								</div>
								<div class="ibox-content">
									<div class="form-group">
										<label class="col-sm-2 control-label">微信号</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="wx_name" value="<?php echo $main->wx_name; ?>">
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">AppId</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="wx_app_id" value="<?php echo $main->wx_app_id; ?>">
										</div>
										<label class="col-sm-2 control-label">AppSecret</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="wx_app_secret" value="<?php echo $main->wx_app_secret; ?>">
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<div class="col-sm-9 b-r">
											<h4>二维码</h4>
											<input type="text" name="pic_pic" placeholder="请输入图片网址" class="form-control">
											<label>或者</label>
											<input type="file" name="pic_file" class="form-control" accept="image/*">
										</div>
										<div class="col-sm-3">
											<p class="text-center">
												<?php
												if($main->wx_pic!='')echo '<input type="hidden" name="pic_pico" value="'.$main->wx_pic.'">';
												if($main->wx_oss!=''){
													echo '<input type="hidden" name="pic_oss" value="'.$main->wx_oss.'">';
													$main->wx_pic=$this->main->oss_url($main->wx_oss);
												}
												if($main->wx_pic=='')$main->wx_pic='static/images/blank.png';
												?>
												<img src="<?php echo $main->wx_pic; ?>" class="ywr_rpic">
											</p>
										</div>
									</div>
								</div>
								<div class="ibox-title">
									<h5>微信支付提现设置</h5>
								</div>
								<div class="ibox-content">
									<div class="form-group">
										<label class="col-sm-2 control-label">支付方式</label>
										<div class="col-sm-10">
											<p class="form-control-static">微信商户平台版</p>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">商户号</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="wx_pay_si" value="<?php echo $main->wx_pay_si; ?>">
										</div>
										<label class="col-sm-2 control-label">商户支付密钥</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="wx_pay_sk" value="<?php echo $main->wx_pay_sk; ?>">
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">证书pem格式</label>
										<div class="col-sm-4">
											<input type="file" class="form-control" name="key_1_file">
											<span class="help-block m-b-none">
												<?php if($main->wx_pay_cert!='')echo '已上传，'; ?>
												apiclient_cert.pem
											</span>
										</div>
										<label class="col-sm-2 control-label">证书密钥pem格式</label>
										<div class="col-sm-4">
											<input type="file" class="form-control" name="key_2_file">
											<span class="help-block m-b-none">
												<?php if($main->wx_pay_key!='')echo '已上传，'; ?>
												apiclient_key.pem
											</span>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">支付使用独立公众号</label>
										<div class="col-sm-10">
											<label class="checkbox-inline"><input type="radio" name="wx_pay_o" value="0"<?php if($main->wx_pay_o==0)echo ' checked'; ?>>关闭</label>
											<label class="checkbox-inline"><input type="radio" name="wx_pay_o" value="1"<?php if($main->wx_pay_o==1)echo ' checked'; ?>>开启</label>
										</div>
									</div>
									<div id="wpo_1"<?php if($main->wx_pay_o==0)echo ' style="display: none;"'; ?>>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">AppId</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="wx_o_app_id" value="<?php echo $main->wx_o_app_id; ?>">
										</div>
										<label class="col-sm-2 control-label">AppSecret</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="wx_o_app_secret" value="<?php echo $main->wx_o_app_secret; ?>">
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">商户号</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="wx_o_pay_si" value="<?php echo $main->wx_o_pay_si; ?>">
										</div>
										<label class="col-sm-2 control-label">商户支付密钥</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="wx_o_pay_sk" value="<?php echo $main->wx_o_pay_sk; ?>">
										</div>
									</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">JS API支付授权目录</label>
										<div class="col-sm-10">
											<p class="form-control-static"><?php echo $this->config->item('base_url').'wxpay/'; ?></p>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">告警通知URL</label>
										<div class="col-sm-10">
											<p class="form-control-static"><?php echo getpageurl('pay/wx_alert/'); ?></p>
										</div>
									</div>
								</div>
								<div class="ibox-title">
									<h5>短信设置</h5>
								</div>
								<div class="ibox-content">
									<div class="form-group">
										<label class="col-sm-2 control-label">API网址</label>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="api_u" value="<?php echo $main->api_u; ?>">
										</div>
										<label class="col-sm-1 control-label">签名</label>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="api_qm" value="<?php echo $main->api_qm; ?>">
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">API帐号</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="api_n" value="<?php echo $main->api_n; ?>">
										</div>
										<label class="col-sm-2 control-label">API密码</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="api_p" value="<?php echo $main->api_p; ?>">
										</div>
									</div>
								</div>
								<div class="ibox-title">
									<h5>文件上传设置</h5>
								</div>
								<div class="ibox-content">
									<div class="form-group">
										<label class="col-sm-2 control-label">上传方式</label>
										<div class="col-sm-10">
											<label class="checkbox-inline"><input type="radio" name="is_cos" value="0"<?php if($main->is_cos==0)echo ' checked'; ?>>本地上传</label>
											<label class="checkbox-inline"><input type="radio" name="is_cos" value="1"<?php if($main->is_cos==1)echo ' checked'; ?>>上传到COS</label>
										</div>
									</div>
									<div class="cos_1"<?php if($main->is_cos!=1)echo ' style="display: none;"'; ?>>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">APP ID</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="cos_aid" value="<?php echo $main->cos_aid; ?>">
										</div>
										<label class="col-sm-2 control-label">Bucket</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="cos_b" value="<?php echo $main->cos_b; ?>">
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-2 control-label">secretID</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="cos_sid" value="<?php echo $main->cos_sid; ?>">
										</div>
										<label class="col-sm-2 control-label">secretKey</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="cos_key" value="<?php echo $main->cos_key; ?>">
										</div>
									</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<div class="col-sm-4 col-sm-offset-2">
											<button class="btn btn-primary" type="submit">保存</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
<script type="text/javascript">
$(function(){
	$("input[name='is_cos']").click(function(){
		if($(this).val()=='0'){
			$('.cos_1').hide();
		}else{
			$('.cos_1').show();
		}
	});
	$("input[name='wx_pay_o']").click(function(){
		if($(this).val()=='0'){
			$('#wpo_1').hide();
		}else{
			$('#wpo_1').show();
		}
	});
});
</script>