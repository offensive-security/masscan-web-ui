<?php
if (substr(php_sapi_name(), 0, 3) != 'cli'):
    die('This script can only be run from command line!');
endif;
$start_ts = time();
require dirname(__FILE__).'/includes/config.php';
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

if (trim(strtolower($input)) == 'yes'):
	echo PHP_EOL;
	echo "Clearing the db";
	echo PHP_EOL;
	$q = "TRUNCATE TABLE hosts";
	DB::query($q);
	$q = "TRUNCATE TABLE ports";
	DB::query($q);
endif;
echo "Reading file";
echo PHP_EOL;
$content =  utf8_encode(file_get_contents($filepath));
echo "Parsing file";
echo PHP_EOL;
$xml = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_COMPACT | LIBXML_PARSEHUGE);
if ($xml === false):
    die('There is a problem with this xml file?!');
endif;
$total		= 0;
$inserted	= 0;
echo "Processing data (This may take some time depending on file size)";
echo PHP_EOL;
foreach ($xml->host as $host):
    $q = "SELECT host_id FROM hosts WHERE ip = '".DB::escape((string) $host->address['addr'])."'" ;
	$tmp = DB::fetch($q);
	if (isset($tmp['host_id']) && (int) $tmp['host_id'] > 0):
		$host_id = (int) $tmp['host_id']; 
	else:
		$q = "INSERT INTO hosts SET host_id = null, ip = '".DB::escape((string) $host->address['addr'])."'";
		$tmp = DB::query($q);
		$host_id = DB::insertId();
	endif;
	foreach ($host->ports as $p):
        $total++;
		$ts = (int) $host['endtime'];
		$scanned_ts = date("Y-m-d H:i:s", $ts);

        $port = (string) $p->port['portid'];
        $protocol = (string) $p->port['protocol'];
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

        $state = (string) $p->port->state['state'];
        $reason = (string) $p->port->state['reason'];
        $reason_ttl = (string) $p->port->state['reason_ttl'];

        $q = "INSERT INTO ports SET id = null,
                ip = ".(int) $host_id.",
                port_id = ".(int) $port.",
                scanned_ts = '".DB::escape($scanned_ts)."',
                protocol = '".DB::escape($protocol)."',
                state = '".DB::escape($state)."',
                reason = '".DB::escape($reason)."',
                reason_ttl = '".(int) $reason_ttl."',
                service = '".DB::escape($service)."',
                banner = '".DB::escape($banner)."',
                title = '".DB::escape($title)."'
                ";
        DB::execute($q);
        $inserted++;
	endforeach;
endforeach;
$end_ts = time();
echo PHP_EOL;
echo "Summary:";
echo PHP_EOL;
echo "Total records:".$total."\n";
echo "Inserted records:".$inserted."\n";
$secs = $end_ts - $start_ts;
echo "Took about:".seconds2human($secs);
echo PHP_EOL;