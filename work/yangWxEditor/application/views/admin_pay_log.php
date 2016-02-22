			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>支付记录<?php if(isset($u))echo '：'.$u->username.' '.$u->name; ?></h2>
				</div>
			</div>
			<div class="wrapper wrapper-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="ibox-content">
								<?php if(isset($sql)){ ?>
								<table class="table table-striped table-bordered table-hover dataTables-example">
									<thead>
										<tr>
											<th>openid</th>
											<th>支付时间</th>
											<th>支付金额（元）</th>
											<th>账单名称</th>
											<th>对账号</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i=0;
										foreach($sql as $v){
											echo '<tr class="grade'.(($i%2)>0?'C':'X').'">';
											echo '<td>'.$v->openid.'</td>';
											echo '<td>'.date('Y-n-j H:i', $v->datetime).'</td>';
											echo '<td>'.($v->money_s/100).'</td>';
											echo '<td>'.$v->dd_name.'</td>';
											echo '<td>'.$v->ap_pid.'</td>';
											echo '</tr>';
											$i++;
										}
										?>
									</tbody>
								</table>
								<?php
									echo $page;
								}else{
									echo '没有符合条件的记录';
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>