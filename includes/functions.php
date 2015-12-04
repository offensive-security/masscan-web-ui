<?php
/**
 * Some common functions
 */
function pre_var_dump($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}

function browse($filter, $export = false)
{
    $records_per_page = (int)$filter['rec_per_page'];
    if (isset($filter['page']) && $filter['page'] > 1):
        $page = (int)$filter['page'];
    else:
        $page = 1;
    endif;
    $from = ($page - 1) * $records_per_page;
    $q1 = "SELECT p.*, h.host_id, h.ip AS ipaddress";
    $q2 = "SELECT COUNT(*) as total_records";
    $q = " FROM ports as p
			LEFT JOIN hosts AS h ON (h.host_id = p.ip)
 			WHERE 1 = 1";

    if (!empty($filter['ip'])) {
        $q .= " AND h.ip LIKE (\"" . DB::escape($filter['ip']) . "%\") ";
    }
    if (isset($filter['port']) && (int)$filter['port'] > 0 && (int)$filter['port'] <= 65535) {
        $q .= " AND p.port_id = " . (int)$filter['port'];
    }
    if (!empty($filter['protocol'])) {
        $q .= " AND p.protocol = '" . DB::escape($filter['protocol']) . "'";
    }
    if (!empty($filter['state'])) {
        $q .= " AND p.state = '" . DB::escape($filter['state']) . "'";
    }
    if (!empty($filter['service'])) {
        $q .= " AND p.service = '" . DB::escape($filter['service']) . "'";
    }
    if (!empty($filter['banner'])) {
        if ((int)$filter['exact-match'] === 1):
            $q .= " AND (p.banner LIKE BINARY \"%" . $filter['banner'] . "%\" OR p.title LIKE BINARY \"%" . $filter['banner'] . "%\")";
        else:
            //$q .= " AND match(title, banner) AGAINST (\"".DB::escape($filter['banner'])."\" IN NATURAL LANGUAGE MODE)";
            $q .= " AND (p.banner LIKE \"%" . $filter['banner'] . "%\" OR p.title LIKE \"%" . $filter['banner'] . "%\")";
        endif;
    }
    if (!empty($filter['text'])):
        $q .= " AND (match(title, banner) AGAINST (\"" . DB::escape($filter['text']) . "\" IN NATURAL LANGUAGE MODE)
                        OR h.ip LIKE (\"" . DB::escape($filter['text']) . "%\")
                        OR p.service = \"" . DB::escape($filter['text']) . "%\"
                        OR p.protocol = \"" . DB::escape($filter['text']) . "%\"
                        OR p.port_id = \"" . (int)$filter['text'] . "%\")";
    endif;
    $q .= " ORDER BY p.scanned_ts DESC";
    if (!$export):
        $q3 = " LIMIT $from, $records_per_page";
    else:
        $q3 = "";
    endif;
    $data = DB::fetchAll($q1 . $q . $q3);
    $executionTimes['main'] = DB::getQueryExecutionTime();
    if ($export) {
        return $data;
    }
    $total = DB::fetch($q2 . $q);
    $to = $from + $records_per_page < $total['total_records'] ? $from + $records_per_page : $total['total_records'];
    $pages = $total ['total_records'] > 1 ? ceil($total ['total_records'] / $records_per_page) : 0;
    if (count($data) > $records_per_page):
        $to = $from + $records_per_page;
    else:
        $to = count($data);
    endif;
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