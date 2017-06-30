<?php
/**
 * This script is only runnable form command line
 */
if (substr(php_sapi_name(), 0, 3) != 'cli'):
    die('This script can only be run from command line!');
endif;
include dirname(__FILE__).'/includes/functions.php';
/**
 * Convert seconds to minutes, hours..
 * NOTICE : Approximate, assumes months have 30 days.
 */
function seconds2human($ss)
{
    $s = $ss%60;
    $mins = floor(($ss%3600)/60);
    $hours = floor(($ss%86400)/3600);
    $days = floor(($ss%2592000)/86400);
    $months = floor($ss/2592000);
    $text = '';
    if ($months > 0) {
        $text .= $months." months,";
    }
    if ($days > 0) {
        $text .= $days." days,";
    }
    if ($hours > 0) {
        $text .= $hours." hours,";
    }
    if ($mins > 0) {
        $text .= $mins." minutes,";
    }
    if ($s > 0) {
        $text .= $s." seconds";
    }
    return $text;
}
if (!extension_loaded('simplexml')) {
    echo "This script require php-xml package.".PHP_EOL;
    echo "Install the package, restart webserver and run script again.".PHP_EOL;
    exit;
}
/**
 * Magic starts here
 */
$start_ts = time();
require dirname(__FILE__).'/config.php';
if (!isset($argv[1])):
	die('Please provide a file name to import!'."\n");
endif;
$tmp = pathinfo($argv[1]);
if ($tmp['dirname'] == "."):
	$filepath = dirname(__FILE__).'/'.$argv[1];
else:
	$filepath = $argv[1];
endif;
if (!is_file($filepath)):
	echo "File:".$filepath;
	echo PHP_EOL;
	echo 'File does not exist!';
    echo PHP_EOL;
	exit;
endif;
do {
	echo PHP_EOL;
	echo "Do you want to clear the database before importing (yes/no)?: ";
	$handle = fopen ("php://stdin","r");
	$input = fgets($handle);
} while (!in_array(trim($input), array('yes', 'no')));
$db = getPdo();
if (trim(strtolower($input)) == 'yes'):
	echo PHP_EOL;
	echo "Clearing the db";
	echo PHP_EOL;
    $db->exec("TRUNCATE TABLE data");
endif;
echo "Reading file";
echo PHP_EOL;
$content =  utf8_encode(file_get_contents($filepath));
echo "Parsing file";
echo PHP_EOL;
$xml = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_COMPACT | LIBXML_PARSEHUGE);
if ($xml === false):
    die('There is a problem with this xml file?!'.PHP_EOL);
endif;
$total		= 0;
$inserted	= 0;
echo "Processing data (This may take some time depending on file size)";
echo PHP_EOL;
$q = "INSERT INTO data (ip, port_id, scanned_ts, protocol, state, reason, reason_ttl, service, banner, title) VALUES (:ip, :port, :scanned_ts, :protocol, :state, :reason, :reason_ttl, :service, :banner, :title)";
$stmt = $db->prepare($q);
$stmt->bindParam(':ip', $ip, PDO::PARAM_INT);
$stmt->bindParam(':port', $port, PDO::PARAM_INT);
$stmt->bindParam(':scanned_ts', $scanned_ts);
$stmt->bindParam(':protocol', $protocol, PDO::PARAM_STR);
$stmt->bindParam(':state', $state, PDO::PARAM_STR);
$stmt->bindParam(':reason', $reason, PDO::PARAM_STR);
$stmt->bindParam(':reason_ttl', $reason_ttl, PDO::PARAM_INT);
$stmt->bindParam(':service', $service, PDO::PARAM_STR);
$stmt->bindParam(':banner', $banner, PDO::PARAM_STR);
$stmt->bindParam(':title', $title, PDO::PARAM_STR);

foreach ($xml->host as $host):

    foreach ($host->ports as $p):
        $ip         = sprintf('%u', ip2long($host->address['addr']));
		$ts         = (int) $host['endtime'];
		$scanned_ts = date("Y-m-d H:i:s", $ts);
        $port       = (int) $p->port['portid'];
        $protocol   = (string) $p->port['protocol'];
        if (isset($p->port->service)):
            $service = (string) $p->port->service['name'];
            if ($service == 'title'):
                if (isset($p->port->service['banner'])):
                    $title = $p->port->service['banner'];
                else:
                    $title = '';
                endif;
                $banner = '';
            else:
                if (isset($p->port->service['banner'])):
                    $banner = $p->port->service['banner'];
                else:
                    $banner = '';
                endif;
                $title = '';
            endif;
        else:
            $service = '';
            $banner = '';
            $title = '';
        endif;
        $state      = (string) $p->port->state['state'];
        $reason     = (string) $p->port->state['reason'];
        $reason_ttl = (int) $p->port->state['reason_ttl'];
        $total++;
        if ($stmt->execute()):
            $inserted++;
        endif;
	endforeach;

endforeach;
if (DB_DRIVER == 'pgsql') {
    $q = "UPDATE data SET searchtext = to_tsvector('english', title || '' || banner || '' || service || '' || protocol || '' || port_id)";
    $db->exec($q);
}
$end_ts = time();
echo PHP_EOL;
echo "Summary:";
echo PHP_EOL;
echo "Total records:".$total."\n";
echo "Inserted records:".$inserted."\n";
$secs = $end_ts - $start_ts;
echo "Took about:".seconds2human($secs);
echo PHP_EOL;