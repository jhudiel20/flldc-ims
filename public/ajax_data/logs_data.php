<?php
require_once __DIR__ . '/../DBConnection.php';
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

error_reporting(0);
ini_set('display_errors', 0);

if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')){
    include HTTP_404;
    exit();
}

header("Content-type: application/json; charset=utf-8");

$query_limit = 20;
$table_name = "logs";
$field_query = '*';    
$pages = 0;
$start = 0;
$size = 0;

$sorters = array();
$orderby = "DATE_CREATED DESC";
$sql_where = "";
$sql_conds = "";
$sql_where_array = array();
$to_encode = array();
$output = "";
$total_query = 0;
$flag_all = false;

$dbfield = array('logs.ID', 'logs.USER_ID', 'logs.ACTION_MADE', 'FNAME', 'MNAME', 'LNAME', 'EXT_NAME');
$db_orig = array('ID', 'USER_ID', 'ACTION_MADE', 'DATE_CREATED');

if (isset($_GET['filter'])) {
    $filters = array();
    $sort_filters = array();
    $filters = $_GET['filter'];
    foreach ($filters as $filter) {
        if (isset($filter['field'])) {
            $id = $filter['field'];
            $sort_filters[$id] = $filter['value'];
        }
    }
    foreach ($db_orig as $id) {
        if (isset($sort_filters[$id])) {
            $value = $sort_filters[$id];
            array_push($sql_where_array, $id . ' ILIKE :' . $id); // PostgreSQL uses ILIKE for case-insensitive search
        }
    }
}

if (!empty($sql_where_array)) {
    $temp_arr = implode(' AND ', $sql_where_array);
    $sql_where = (empty($temp_arr)) ? '' : $temp_arr;
}

if (isset($_GET['sort'])) {
    $sorters = $_GET['sort'];
    $tag = array('asc', 'desc');
    if (in_array($sorters[0]['field'], $db_orig) AND in_array($sorters[0]['dir'], $tag)) {
        $orderby = $sorters[0]['field'] . ' ' . $sorters[0]['dir'];
    }
}

if (isset($_GET['size'])) {
    if ($_GET['size'] == 'true') {
        $flag_all = true;
    } else {
        $query_limit = ($_GET['size'] > $query_limit) ? $_GET['size'] : $query_limit;
    }
}

$total_query = 0;
$field_query = 'COUNT(DISTINCT logs.ID) as count';
$sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;
$default_query = "SELECT " . $field_query . ", TO_CHAR(logs.DATE_CREATED, 'YYYY-MM-DD HH24:MI:SS') as DATE_CREATED FROM logs 
JOIN user_account ON logs.user_id = user_account.ID " . $sql_conds . " ORDER BY " . $orderby;

$stmt = $conn->prepare($default_query);
foreach ($filters as $filter) {
    if (isset($filter['field'])) {
        $field = $filter['field'];
        $value = $filter['value'];
        $stmt->bindValue(':' . $field, '%' . $value . '%'); // Bind parameters for ILIKE
    }
}
$stmt->execute();
$total_query = $stmt->fetchColumn();

$pages = ($total_query === 0) ? 1 : ceil($total_query / ($query_limit));
if (isset($_GET['page'])) {
    $page_no = $_GET['page'] - 1;
    $start = $page_no * $query_limit;
}

$start_no = ($start >= $total_query) ? $total_query : $start;

$field_query = implode(',', $dbfield);
$sql_conds = (empty($sql_where)) ? '' : 'WHERE ' . $sql_where;

$default_query = "SELECT " . $field_query . ", TO_CHAR(logs.DATE_CREATED, 'YYYY-MM-DD HH24:MI:SS') as DATE_CREATED FROM logs 
JOIN user_account ON logs.user_id = user_account.ID " . $sql_conds . " ORDER BY " . $orderby;

$limit = " LIMIT " . $query_limit . " OFFSET " . $start;
if ($flag_all) {
    $limit = '';
    $pages = 1;
}
$sql_limit = $default_query . ' ' . $limit;

$stmt = $conn->prepare($sql_limit);
foreach ($filters as $filter) {
    if (isset($filter['field'])) {
        $field = $filter['field'];
        $value = $filter['value'];
        $stmt->bindValue(':' . $field, '%' . $value . '%'); // Bind parameters for ILIKE
    }
}
$stmt->execute();
$to_encode = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($to_encode)) {
    $output = json_encode(["last_page" => 1, "data" => "", "total_record" => 0]);
} else {
    $output = json_encode(["last_page" => $pages, "data" => $to_encode, "total_record" => $total_query]);
}

echo $output; // output
?>
