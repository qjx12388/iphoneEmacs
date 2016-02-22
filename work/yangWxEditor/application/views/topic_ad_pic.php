<script type="text/javascript">
$(function(){
	<?php
	if($oss!='')$pic=$this->main->oss_url($oss);
	if($pic!=''){
	?>
	parent.uf('<?php echo $pic; ?>');
	<?php }else{ ?>
	parent.ue();
	<?php } ?>
});
</script>