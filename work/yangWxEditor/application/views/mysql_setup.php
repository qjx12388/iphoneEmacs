<?php
$fwsc_cf='fwsc.php';
if(file_exists($fwsc_cf)){
	require_once($fwsc_cf);
}
?>
	<div class="middle-box text-center loginscreen">
        <div>
            <div>
                <h1 class="logo-name" style="font-size: 100px;">安 装</h1>
            </div>
			<?php echo $cname;?>
            <form class="m-t" role="form" method="post" action="<?php echo getpageurl($cname.'/setup_post/'); ?>" id="login_form">
                <div class="form-group">
                    <input type="text" name="sn" class="form-control" placeholder="授权SN码" require>
                    <br/><a href="http://www.guanggaoke.com/index.php/topic/view/657/">购买获取授权SN码</a>
                </div>
                <div class="form-group">
                    <input type="text" name="db_h" class="form-control" placeholder="MySQL数据库链接" value="<?php if(isset($fwsc_db))echo $fwsc_db['h']; ?>" require>
                </div>
                <div class="form-group">
                    <input type="text" name="db_u" class="form-control" placeholder="数据库用户名" value="<?php if(isset($fwsc_db))echo $fwsc_db['u']; ?>" require>
                </div>
                <div class="form-group">
                    <input type="text" name="db_p" class="form-control" placeholder="数据库密码" value="<?php if(isset($fwsc_db))echo $fwsc_db['p']; ?>">
                </div>
                <div class="form-group">
                    <input type="text" name="db_n" class="form-control" placeholder="数据库名称" value="<?php if(isset($fwsc_db))echo $fwsc_db['n']; ?>" require>
                </div>
                <button id="form_bt" type="submit" class="btn btn-primary block full-width m-b">安 装</button>
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