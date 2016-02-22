	<div class="middle-box text-center loginscreen">
        <div>
            <div>
                <h1 class="logo-name" style="font-size: 100px;">登 录</h1>
            </div>
            <form class="m-t" role="form" method="post" action="<?php echo getpageurl($cname.'/login_post/'); ?>" id="login_form">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="用户名" require>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="密码" require>
                </div>
                <button id="form_bt" type="submit" class="btn btn-primary block full-width m-b">登 录</button>
            </form>
        </div>
    </div>
<script type="text/javascript">
$(function(){
	$('#login_form').submit(function(){
		var is_jx=1;
		$(this).find("input[require]").each(function(){
			if($.trim($(this).val())==''){
				is_jx=0;
				$(this).addClass('error');
			}
		});
		if(is_jx>0){
			$('#form_bt').attr('disabled', 'disabled');
		}else{
			return false;
		}
	});
});
</script>