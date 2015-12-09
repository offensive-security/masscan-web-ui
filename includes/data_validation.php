<?php
/**
 * Input Validation
 */
$errors = array();
$filter = array();
$filter['ip'] = '';
if (isset($_GET['ip']) && !empty($_GET['ip']) && is_string($_GET['ip'])):
	$filter['ip'] = strip_tags(trim($_GET['ip']));
	if (!preg_match("/^[0-9\.]{1,15}$/", $filter['ip'])):
		$errors[] = "IP address (".htmlentities($filter['ip']).") is not in valid!";
		$filter['ip'] = '';
	else:
		$parts = explode('.', $filter['ip']);
		if (count($parts) > 0 && count($parts) <5):
			foreach ($parts as $part):
				if (!empty($part) && ($part > 255 || $part < 0)):
					$errors[] = "IP address (".htmlentities($filter['ip']).") is not valid!";
					$filter['ip'] = '';
					break;
				endif;
			endforeach;
		else:
			$filter['ip'] = '';
			$errors[] = "IP address is not valid!";
		endif;
	endif;
endif;
$filter['port'] = 0;
if (isset($_GET['port']) && !empty($_GET['port']) && is_string($_GET['port']) && (int) $_GET['port'] > 0 && (int) $_GET['port'] <= 65535):
	$filter['port'] = (int) $_GET['port'];
endif;
$filter['protocol']		= isset($_GET['protocol']) && !empty($_GET['protocol']) && is_string($_GET['protocol'])	?	DB::escape($_GET['protocol'])	:	'';
$filter['state']		= isset($_GET['state']) && !empty($_GET['state']) && is_string($_GET['state'])	?	DB::escape($_GET['state'])	:	'';
$filter['service']		= isset($_GET['service']) && !empty($_GET['service']) && is_string($_GET['service'])	?	DB::escape($_GET['service'])	:	'';
$filter['banner']		= isset($_GET['banner']) && !empty($_GET['banner'])	&& is_string($_GET['banner'])	?	DB::escape($_GET['banner'])	:	'';
$filter['exact-match']	= isset($_GET['exact-match']) && (int) $_GET['exact-match'] === 1 ?	1	:	0;
$filter['text']			= isset($_GET['text']) && !empty($_GET['text'])	&& is_string($_GET['text'])	?	DB::escape($_GET['text'])	:	'';
$filter['page']			= isset($_GET['page']) && (int) $_GET['page'] > 1	?	(int) $_GET['page']	:	1;
$filter['rec_per_page']	= isset($_GET['rec_per_page']) && in_array((int) $_GET['rec_per_page'], array(10,20,40,50,100))	?	(int) $_GET['rec_per_page']	:	10;
if (defined('EXPORT')):
	$results = browse($filter, true);
else:
	$results = browse($filter);
endif;