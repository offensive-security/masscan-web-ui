<?php
require dirname(__FILE__).'/config.php';
$ip = (int) $_GET['ip'];
if ($ip > 0):
	$q = "SELECT ip as ipaddress, port_id, service, protocol, banner, title FROM data WHERE ip =".(int) $ip." ORDER BY scanned_ts DESC";
	$results = DB::fetchAll($q);
else:
	$results = array();
endif;
if (!empty($results)): ?>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th class="banner">Banner/Title</th>
				<th class="port">Port</th>
				<th class="service">Service</th>
				<th class="protocol">Protocol</th>
			</tr>
		</thead>
		<tbody>
	<?php foreach ($results as $k => $r): ?>
		<tr>
			<td>
				<?php if (!empty($r['banner'])):?>
					<strong>Banner:</strong> <?php echo htmlentities($r['banner']);?>
				<?php endif; ?>
				<?php if (!empty($r['title'])):?>
					<strong>Title:</strong> <?php echo htmlentities($r['title']);?>
				<?php endif; ?>
			</td>
			<td><?php echo (int) $r['port_id'];?></td>
			<td>
				<?php if ($r['service'] !== 'title'): echo htmlentities($r['service']); endif;?>
				<?php if ($r['service'] == 'http'): ?>
					<a href="http://<?php echo long2ip($r['ipaddress']);?>" target="_blank"><i class="glyphicon glyphicon-new-window"></i></a>
				<?php endif; ?>
			</td>
			<td><?php echo htmlentities($r['protocol']);?></td>
		</tr>
	<?php endforeach; ?>
	</table>
	<?php
endif;