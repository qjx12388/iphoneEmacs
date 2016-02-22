<style type="text/css">
body {
	background: #f6f6f6;
}
table {
	background: #ccc;
}
th, td {
	background: #fff;
}
</style>
<?php if(isset($tu)){ ?>
	<br/><br/>
	<table width="90%" align="center" cellspacing="1" cellpadding="5">
		<tr>
			<th>团队</th>
			<th>成员数</th>
			<th>总收益</th>
		</tr>
		<?php
		foreach($tu as $v){
			echo '<tr>';
			echo '<td>';
			if($v->td_name==''){
				if($v->name=='')$v->name=mocode($v->username);
				$v->td_name=$v->name.'的团队';
			}
			echo $v->td_name;
			echo '</td>';
			echo '<td>'.$v->c_td.'人</td>';
			echo '<td>'.($v->c_tdsy/100).'元</td>';
			echo '</tr>';
		}
		?>
	</table>
<?php }else{ ?>
	<div class="center"><br/><br/>没有团队</div>
<?php } ?>