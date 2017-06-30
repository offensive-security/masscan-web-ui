<?php
function pre_var_dump($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}
function browse($filter, $export = false)
{
    $db = new PDO(DB_DRIVER.":host=".DB_HOST.";dbname=".DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $records_per_page = (int)$filter['rec_per_page'];
    if (isset($filter['page']) && $filter['page'] > 1):
        $page = (int)$filter['page'];
    else:
        $page = 1;
    endif;
    $from = ($page - 1) * $records_per_page;
    $q1 = "SELECT ip AS ipaddress, port_id, protocol, state, reason, service, banner, title";
    $q2 = "SELECT COUNT(*) as total_records";
    $q = " FROM data WHERE 1 = 1";

    if (!empty($filter['ip'])):
        list($start_ip, $end_ip) = getStartAndEndIps($filter['ip']);
        $q .= " AND (ip >= $start_ip AND ip <= $end_ip)";
    endif;
    if (isset($filter['port']) && (int) $filter['port'] > 0 && (int) $filter['port'] <= 65535):
        $q .= " AND port_id = " . (int) $filter['port'];
    endif;
    if (!empty($filter['protocol'])):
        $q .= " AND protocol = '" . DB::escape($filter['protocol']) . "'";
    endif;
    if (!empty($filter['state'])):
        $q .= " AND state = '" . DB::escape($filter['state']) . "'";
    endif;
    if (!empty($filter['service'])):
        $q .= " AND service = '" . DB::escape($filter['service']) . "'";
    endif;
    if (!empty($filter['banner'])):
        if ((int)$filter['exact-match'] === 1):
            $q .= " AND (banner LIKE BINARY \"%" . $filter['banner'] . "%\" OR title LIKE BINARY \"%" . $filter['banner'] . "%\")";
        else:
            $q .= " AND match(title, banner) AGAINST (\"" . DB::escape($filter['banner']) . "\" IN NATURAL LANGUAGE MODE)";
        endif;
    endif;
    if (!empty($filter['text'])):
        $q .= " AND (match(title, banner) AGAINST (\"" . DB::escape($filter['text']) . "\" IN NATURAL LANGUAGE MODE)
                        OR service = \"" . DB::escape($filter['text']) . "%\"
                        OR protocol = \"" . DB::escape($filter['text']) . "%\"
                        OR port_id = \"" . (int)$filter['text'] . "%\")";
    endif;
    if (isset($start_ip)):
        $q3 = " ORDER BY ip ASC";
    else:
        $q3 = " ORDER BY scanned_ts DESC";
    endif;

    if (!$export):
        $q4 = " LIMIT $from, $records_per_page";
    else:
        $q4 = "";
    endif;
    try {
        $stmt = $db->query($q1 . $q . $q3 . $q4);
    }
    catch(PDOException $ex) {
        echo "An Error occured!";
        echo $ex->getMessage();
        die;
    }
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($export) {
        return $data;
    }
    $tmp2 = $db->query($q2 . $q);
    $total = $tmp2->fetch(PDO::FETCH_ASSOC);
    $to = $from + $records_per_page < $total['total_records'] ? $from + $records_per_page : $total['total_records'];
    $pages = $total ['total_records'] > 1 ? ceil($total ['total_records'] / $records_per_page) : 0;
    return array(
        'data' => $data,
        'pagination' => array(
            'page' => $page,
            'pages' => $pages,
            'records' => $total ['total_records'],
            'from' => ++$from,
            'to' => $to)
    );
}

function getStartAndEndIps($ip)
{
    $start_ip   = '';
    $end_ip     = '';
    $ip         = trim($ip, '.');
    $p          = explode('.', trim($ip));
    for ($i = 0; $i < 4; $i++):
        if ($i > 0):
            $start_ip .= '.';
            $end_ip .= '.';
        endif;
        if (isset($p[$i])):
            $start_ip .= $p[$i];
            $end_ip .= $p[$i];
        else:
            $start_ip .= "0";
            $end_ip .= "255";
        endif;
    endfor;
    return array(ip2long($start_ip), ip2long($end_ip));
}