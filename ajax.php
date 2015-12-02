<?php 
require dirname(__FILE__).'/includes/config.php';
$host_id = (int) $_GET['host_id'];
$q = "SELECT * FROM ports WHERE ip =".$host_id." ORDER BY scanned_ts DESC";
$results = DB::fetchAll($q);
if (!empty($results)) {
	?>

	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th class="">Banner/Title</th>
				<th class="">Port</th>
				<th class="">Service</th>
				<th class="">Protocol</th>
			</tr>
		</thead>
		<tbody>
	<?php
	foreach ($results as $k => $r)
	{
		?>
			<tr class="odd gradeX">
				<td class="">
                    <?php if (!empty($r['banner'])):?>
                        <strong>Banner:</strong> <?php echo htmlentities($r['banner']);?>
                    <?php endif; ?>
                    <?php if (!empty($r['title'])):?>
                        <strong>Title:</strong> <?php echo htmlentities($r['title']);?>
                    <?php endif; ?>
                </td>
				<td class=""><?php echo $r['port_id'];?></td>
				<td class=""><?php if ($r['service'] !== 'title'): echo htmlentities($r['service']); endif;?></td>
				<td><?php echo htmlentities($r['protocol']);?></td>
			</tr>
		<?php
	} 
	?>
	</table>

	<?php
}