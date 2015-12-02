<?php 
	$pager_data = "action=search&rec_per_page=".(int) $filter['rec_per_page']."&ip=".htmlentities($filter['ip'])."&port=".(int) $filter['port']."&state=".htmlentities($filter['state'])."&protocol=".htmlentities($filter['protocol'])."&service=".htmlentities($filter['service'])."&banner=".htmlentities($filter['banner'])."&text=".htmlentities($filter['text'])."&exact-match=".$filter['exact-match']."&page=";
	$rpp_data	= "action=search&ip=".htmlentities($filter['ip'])."&port=".(int) $filter['port']."&state=".htmlentities($filter['state'])."&protocol=".htmlentities($filter['protocol'])."&service=".htmlentities($filter['service'])."&banner=".htmlentities($filter['banner'])."&text=".htmlentities($filter['text'])."&exact-match=".$filter['exact-match']."&page=1&rec_per_page=";
	$data_prev	= "action=search&rec_per_page=".(int) $filter['rec_per_page']."&ip=".htmlentities($filter['ip'])."&port=".(int) $filter['port']."&state=".htmlentities($filter['state'])."&protocol=".htmlentities($filter['protocol'])."&service=".htmlentities($filter['service'])."&banner=".htmlentities($filter['banner'])."&text=".htmlentities($filter['text'])."&&exact-match=".$filter['exact-match']."page=".($results['pagination']['page']-1);
	$data_next	= "action=search&rec_per_page=".(int) $filter['rec_per_page']."&ip=".htmlentities($filter['ip'])."&port=".(int) $filter['port']."&state=".htmlentities($filter['state'])."&protocol=".htmlentities($filter['protocol'])."&service=".htmlentities($filter['service'])."&banner=".htmlentities($filter['banner'])."&text=".htmlentities($filter['text'])."&exact-match=".$filter['exact-match']."&page=".($results['pagination']['page']+1);
	$data_search= "action=search&rec_per_page=".(int) $filter['rec_per_page']."&ip=".htmlentities($filter['ip'])."&port=".(int) $filter['port']."&state=".htmlentities($filter['state'])."&protocol=".htmlentities($filter['protocol'])."&service=".htmlentities($filter['service'])."&page=1&banner=".htmlentities($filter['banner'])."&exact-match=".$filter['exact-match']."&text=";
?>
<div class="widget-body">
	<div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
		<div class="row-fluid">
			<div class="span6">
				<div class="dataTables_length" id="sample_1_length">
					<label>
						<select class="input-small" aria-controls="sample_1" size="1" name="rec_per_page" onchange="searchData('<?php echo $rpp_data;?>' + this.value)">
							<option value="10"<?php if ($filter['rec_per_page'] == 10): echo ' selected="selected"'; endif;?>>10</option>
							<option value="20"<?php if ($filter['rec_per_page'] == 20): echo ' selected="selected"'; endif;?>>20</option>
							<option value="30"<?php if ($filter['rec_per_page'] == 30): echo ' selected="selected"'; endif;?>>30</option>
							<option value="50"<?php if ($filter['rec_per_page'] == 50): echo ' selected="selected"'; endif;?>>50</option>
							<option value="100"<?php if ($filter['rec_per_page'] == 100): echo ' selected="selected"'; endif;?>>100</option>
						</select>
						records per page
					</label>
				</div>
			</div>
			<div class="span6">
				<div id="sample_1_filter" class="dataTables_filter">
					<label>Search: <input class="input-small" aria-controls="sample_1" type="text" onkeyup="searchDataText('<?php echo $data_search;?>'+this.value);" value="<?php echo htmlentities($filter['text']);?>"></label>
				</div>
			</div>
		</div> <!-- end of .row-fluid -->
                        
                        
		<table class="table table-striped table-bordered table-hover" id="sample_1">
			<thead>
				<tr>
					<th class="ip">IP</th>
					<th class="banner">Banner/Title</th>
					<th class="port">Port</th>
					<th class="service">Service</th>
					<th class="protocol text-center">Protocol</th>
			  </tr>
		   </thead>
		   <tbody>
		   <?php
		   foreach ($results['data'] as $k => $r):
		   ?>
		   <tr class="odd gradeX">
				 <td class="ip"><a href="javascript:void(0);" onclick="return showIpHistory('<?php echo $r['ipaddress']?>', 'ip-<?php echo $k;?>', '<?php echo $r['host_id'];?>')"><?php echo $r['ipaddress'];?></a></td>
				 <td class="banner">
					 <?php if (!empty($r['banner'])):?>
						 <strong>Banner:</strong> <?php echo htmlentities($r['banner']);?>
					 <?php endif; ?>
					 <?php if (!empty($r['title'])):?>
					 <strong>Title:</strong> <?php echo htmlentities($r['title']);?>
					<?php endif; ?>
				 </td>
				 <td class="port"><?php echo $r['port_id'];?></td>
				 <td class="service">
					 <?php if ($r['service'] !== 'title'): ?>
						<?php echo htmlentities($r['service']);?>
					 <?php endif; ?>
				 </td>
				 <td class="protocol"><?php echo htmlentities($r['protocol']);?></td>
			</tr>
		   <?php
		   endforeach;
		   ?>
		   </tbody>
		</table>
                        
		<div class="row-fluid">
			<div class="span6">
				<div id="sample_1_info" class="dataTables_info">Showing <?php echo ++$results['pagination']['from'];?> to <?php echo $results['pagination']['to'];?></div>
			</div>
			<div class="span6">
				<div class="dataTables_paginate paging_bootstrap pagination">
					<ul>
						<?php if ($results['pagination']['page'] > 1 && $results['pagination']['next']): ?>
							<li class="prev">
								<a href="javascript:void(0);" onclick="searchData('<?php echo $data_prev; ?>');">← Prev</a>
							</li>
						<?php endif; ?>

						<?php if ($results['pagination']['page'] > 0 && $results['pagination']['next']): ?>
							<?php for ($i=1; $i<=$results['pagination']['page']; $i++):?>
								<?php if (($results['pagination']['page']-3) < $i):?>
								<li class="<?php if ($results['pagination']['page'] == $i): echo "active"; endif;?>">
									<a href="javascript:void(0);" onclick="searchData('<?php echo $pager_data.$i; ?>');"><?php echo (int) $i;?></a>
								</li>
								<?php endif; ?>
							<?php endfor; ?>
						<?php endif; ?>

						<?php if ($results['pagination']['next']): ?>
							<li>
								<a href="javascript:void(0);" onclick="searchData('<?php echo $pager_data.$i; ?>');"><?php echo (int) ++$results['pagination']['page'];?></a>
							</li>
							<li class="next<?php if ($results['pagination']['page'] == $results['pagination']['pages']): echo " disabled"; endif; ?>">
								<a href="javascript:void(0);" onclick="searchData('<?php echo $data_next; ?>');">Next →</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div> <!-- end of .row-fluid -->
	</div> <!-- end of #sample_1_wrapper -->
</div> <!-- end of .widget-body -->