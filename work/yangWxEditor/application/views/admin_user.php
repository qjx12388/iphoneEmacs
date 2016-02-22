			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>用户管理</h2>
				</div>
			</div>
			<div class="wrapper wrapper-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="ibox-content">
								<form method="get" action="" class="input-group">
									<input type="text" class="form-control" name="q" value="<?php if(isset($search['q']))echo $search['q']; ?>">
									<span class="input-group-btn">
										<button type="submit" class="btn btn-primary">搜索</button>
									</span>
								</form>
							</div>
							<div class="ibox-content">
								<?php if(isset($sql)){ ?>
								<table class="table table-striped table-bordered table-hover dataTables-example">
									<thead>
										<tr>
											<th>用户名</th>
											<th>姓名</th>
											<th>类型</th>
											<th>备注</th>
											<th>注册时间</th>
											<th>状态</th>
											<th>账户余额（元）</th>
											<th>文章</th>
											<th>阅读</th>
											<th>转发</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i=0;
										foreach($sql as $v){
											echo '<tr class="grade'.(($i%2)>0?'C':'X').'">';
											echo '<td>'.$v->username.'</td>';
											echo '<td>'.$v->name.'</td>';
											echo '<td>'.$al[$v->tid].'用户</td>';
											echo '<td>'.$v->bz.'</td>';
											echo '<td>'.date('Y-n-j H:i', $v->regdate).'</td>';
											echo '<td>'.($v->hydate>time()?'已付费，有效期：'.date('Y-n-j H:i', $v->hydate):'未付费').'</td>';
											echo '<td>'.($v->ye/100).'</td>';
											echo '<td>'.$v->c_topic.'</td>';
											echo '<td>'.$v->c_read.'</td>';
											echo '<td>'.$v->c_zf.'</td>';
											echo '<td class="center">';
											echo '<a href="'.getpageurl($cname.'/tx/').'?u='.$v->user_id.'">提现记录</a>';
											echo ' | <a href="'.getpageurl($cname.'/utopic/').'?u='.$v->user_id.'">文章</a>';
											echo ' | <a href="'.getpageurl($cname.'/user_edit/'.$v->user_id.'/').'">修改</a>';
											if($v->hydate<time())echo ' | <a href="#" onclick="alert(\'您好，您使用的是免费版，没有此管理功能，如需购买，请联系QQ：4006761898  微信：22223288 或微信客服：wangdanlili\');return false;">设置一年付费</a>';
											echo '</td>';
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