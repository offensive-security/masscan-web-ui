<?php 
require dirname(__FILE__).'/config.php';
require dirname(__FILE__).'/includes/functions.php';
define('EXPORT', true);
require dirname(__FILE__).'/includes/data_validation.php';
$export_data="IP Address,Port,Service,Protocol,State\n";
if (!empty($results)):
	foreach ($results as $res):
		$export_data .= long2ip($res['ipaddress']) . ",";
		$export_data .= $res['port_id'] . ",";
		$export_data .= $res['service'] . ",";
		$export_data .= $res['protocol'] . ",";
		$export_data .= $res['state'] . ",";
		$export_data .= "\n";
	endforeach;
	$name = strftime('export_%m_%d_%Y.csv');
	header('Content-Disposition: attachment;filename=' . $name);
	header('Content-Type: text/csv');
	echo $export_data;
endif;
die;
