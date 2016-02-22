			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>好文章管理</h2>
					<ol class="breadcrumb">
						<li>
							<a href="<?php echo getpageurl($cname.'/topic_add/'); ?>"><i class="fa fa-plus-square-o"></i> 添加好文章</a>
						</li>
					</ol>
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
											<th>标题</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i=0;
										foreach($sql as $v){
											echo '<tr class="grade'.(($i%2)>0?'C':'X').'">';
											echo '<td>'.$v->title.'</td>';
											echo '<td class="center">';
											echo '<a href="'.getpageurl($cname.'/topic_edit/'.$v->topic_id.'/').'">修改</a>';
											echo ' | <a href="#" onclick="if(confirm(\'确定删除？\'))location.href=\''.getpageurl($cname.'/topic_del/'.$v->topic_id.'/').'?'.http_build_query($search).'\';return false;" style="color: #f00;">删除</a>';
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