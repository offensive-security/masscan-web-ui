<?php 
require dirname(__FILE__).'/config.php';
require dirname(__FILE__).'/includes/functions.php';
define('EXPORT', true);
require dirname(__FILE__).'/includes/data_validation.php';
if (!empty($results)):
	$xml = new DOMDocument("1.0");
	$root = $xml->createElement("nmaprun");
	$root->setAttribute('scanner', 'massscan');
	$root->setAttribute('start', time());
	$root->setAttribute('version', '1.0-BETA');
	$root->setAttribute('xmloutputversion', '1.03');
	$xml->appendChild($root);
	foreach ($results as $res):
		$host = $xml->createElement("host");
		$host->setAttribute('endtime', strtotime($res['scanned_ts']));
		$address = $xml->createElement('address');
		$address->setAttribute('addr', $res['ipaddress']);
		$address->setAttribute('addrtype', 'ipv4');
		$root->appendChild($host);
		$ports = $xml->createElement('ports');
		$port = $xml->createElement('port');
		$port->setAttribute('protocol', $res['protocol']);
		$port->setAttribute('port_id', $res['port_id']);
		$port->setAttribute('state', $res['state']);
		$port->setAttribute('reason', $res['reason']);
		$port->setAttribute('reason_ttl', $res['reason_ttl']);
		$ports->appendChild($port);
		$host->appendChild($address);
		$host->appendChild($ports);
	endforeach;
	$xml->appendChild($root);
	$xml->formatOutput = true;
	$name = strftime('export_%m_%d_%Y.xml');
	header('Content-Disposition: attachment;filename=' . $name);
	header('Content-Type: text/xml');
	echo $xml->saveXML();
endif;
die;