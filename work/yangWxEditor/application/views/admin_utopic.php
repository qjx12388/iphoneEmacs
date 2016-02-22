			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>文章管理<?php if(isset($u))echo '：'.$u->username.' '.$u->name; ?></h2>
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
										<?php
										if(isset($search)){
											$aq=$search;
											if(isset($aq['q']))unset($aq['q']);
											if(count($aq)>0){
												foreach($aq as $k=>$v)echo '<input type="hidden" name="'.$k.'" value="'.$v.'">';
											}
										}
										?>
									</span>
								</form>
							</div>
							<div class="ibox-content">
								<?php if(isset($sql)){ ?>
								<table class="table table-striped table-bordered table-hover dataTables-example">
									<thead>
										<tr>
											<th>标题</th>
											<th>用户</th>
											<th>转发</th>
											<th>查看</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i=0;
										foreach($sql as $v){
											echo '<tr class="grade'.(($i%2)>0?'C':'X').'">';
											echo '<td><a href="'.getpageurl('topic/view/'.$v->topic_id.'/').'" target="_blank">'.$v->title.'</a></td>';
											echo '<td>'.$v->username.' '.$v->name.'</td>';
											echo '<td>'.$v->c_zf.'</td>';
											echo '<td>'.$v->c_read.'</td>';
											echo '<td class="center">';
											echo '<a href="#" onclick="alert(\'您好，您使用的是免费版，没有此管理功能，如需购买，请联系QQ：4006761898  微信：22223288 或微信客服：wangdanlili\');return false;" style="color: #f00;">删除</a>';
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