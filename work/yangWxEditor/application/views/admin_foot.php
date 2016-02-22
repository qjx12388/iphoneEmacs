<?php if(!isset($no_side) || $no_side!=1){ ?>
			<div class="footer">
				<div>
					<strong>Copyright</strong> 文章传播系统 &copy; <?php echo date('Y'); ?> <a href="http://www.guanggaoke.com/">广告客</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="cp/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="cp/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="cp/js/hplus.js?v=2.2.0"></script>
<script src="cp/js/plugins/pace/pace.min.js"></script>
<?php
}
if(isset($session['msg']) && $session['msg']!=''){
	$this->session->unset_userdata('msg');
?>
<link href="cp/css/plugins/toastr/toastr.min.css" rel="stylesheet">
<script src="cp/js/plugins/toastr/toastr.min.js"></script>
<script type="text/javascript">
$(function(){
	toastr.options={
		"closeButton": true,
		"progressBar": true,
	};
	toastr.warning('<?php echo $session['msg']; ?>');
})
</script>
<?php } ?>
</body>
</html>