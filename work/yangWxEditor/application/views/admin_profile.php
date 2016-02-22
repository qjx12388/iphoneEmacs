			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>个人资料</h2>
				</div>
			</div>
			<div class="wrapper wrapper-content">
				<div class="row">
					<div class="col-lg-6">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>基本资料</h5>
							</div>
							<div class="ibox-content">
								<form method="post" action="<?php echo getpageurl($cname.'/profile_post/'); ?>" class="form-horizontal">
									<div class="form-group">
										<label class="col-sm-3 control-label">用户名</label>
										<div class="col-sm-9">
											<p class="form-control-static"><?php echo $user->username; ?></p>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label">姓名</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="name" value="<?php echo $user->name; ?>">
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<div class="col-sm-4 col-sm-offset-3">
											<button class="btn btn-primary" type="submit">保存</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>修改密码</h5>
							</div>
							<div class="ibox-content">
								<form method="post" action="<?php echo getpageurl($cname.'/password_post/'); ?>" class="form-horizontal" id="pwd_form">
									<div class="form-group">
										<label class="col-sm-3 control-label">原密码</label>
										<div class="col-sm-9">
											<input type="password" class="form-control" name="password_o" require>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label">新密码</label>
										<div class="col-sm-9">
											<input type="password" class="form-control" id="password_n" name="password_n" require>
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label">确认密码</label>
										<div class="col-sm-9">
											<input type="password" class="form-control" id="password_c" name="password_c">
										</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<div class="col-sm-4 col-sm-offset-3">
											<button class="btn btn-primary" type="submit" id="form_bt">保存</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
<script type="text/javascript">
$(function(){
	$('#pwd_form').submit(function(){
		var is_jx=1;
		$(this).find("input[require]").each(function(){
			if($.trim($(this).val())==''){
				is_jx=0;
				$(this).addClass('error');
			}
		});
		if($.trim($('#password_n').val())!='' && $('#password_c').val()!=$('#password_n').val()){
			is_jx=0;
			$('#password_c').addClass('error');
		}
		if(is_jx>0){
			$('#form_bt').attr('disabled', 'disabled');
		}else{
			return false;
		}
	});
});
</script>