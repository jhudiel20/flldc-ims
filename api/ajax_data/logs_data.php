<?php
require_once __DIR__ . '/../DBConnection.php';
require_once __DIR__ . '/../config/config.php'; // Adjusted path for config.php

header("Content-type: application/json; charset=utf-8");

$query_limit = isset($_GET['size']) && $_GET['size'] == 'true' ? PHP_INT_MAX : 20;
$table_name = "logs";
$sorters = isset($_GET['sort']) ? $_GET['sort'] : [];
$page = isset($_GET['page']) ? (int)$_GET['page'] - 1 : 0;
$start = $page * $query_limit;

$sort_field = 'logs.id';
$sort_dir = 'DESC';

$query_fields = ['logs.id', 'logs.user_id', 'logs.action_made']; //used for query

if (!empty($sorters)) {
    $valid_sorts = ['id', 'user_id', 'action_made', 'date_created']; //used for tabulator header
    $sort_field = in_array($sorters[0]['field'], $valid_sorts) ? $sorters[0]['field'] : $sort_field;
    $sort_dir = in_array($sorters[0]['dir'], ['asc', 'desc']) ? $sorters[0]['dir'] : $sort_dir;
}

$filters = isset($_GET['filter']) ? $_GET['filter'] : [];
$filter_clauses = [];
$filter_params = [];

foreach ($filters as $filter) {
    if (isset($filter['field']) && isset($filter['value'])) {
        $field = $filter['field'];
        $value = $filter['value'];

        if ($filter['field'] == 'date_created') {
            $value = '%' . $filter['value'] . '%';
            $filter_clauses[] = "TO_CHAR(logs.date_created, 'YYYY-MM-DD HH12:MI:SS AM') ILIKE :$field";
            $filter_params[$field] = $value;
        } else {
            $value = '%' . $filter['value'] . '%';
            $filter_clauses[] = "$field ILIKE :$field";
            $filter_params[$field] = $value;
        }
    }
}

$filter_sql = !empty($filter_clauses) ? 'WHERE ' . implode(' AND ', $filter_clauses) : '';

$count_query = "SELECT COUNT(DISTINCT logs.id) as count
                FROM logs
                JOIN user_account ON logs.user_id = user_account.id
                $filter_sql";

$count_stmt = $conn->prepare($count_query);
$count_stmt->execute($filter_params);
$total_query = (int) $count_stmt->fetchColumn();

$pages = $total_query > 0 ? ceil($total_query / $query_limit) : 1;
$select_fields = implode(', ', $query_fields);
$data_query = "SELECT $select_fields, TO_CHAR(logs.date_created, 'YYYY-MM-DD HH12:MI:SS AM') as date_created, 
                       user_account.fname, user_account.mname, user_account.lname
                FROM logs
                JOIN user_account ON logs.user_id = user_account.ID $filter_sql
                ORDER BY $sort_field $sort_dir
                LIMIT :limit OFFSET :offset";

                // // Store the query for debugging/logging
                // $query_debug = "SELECT $select_fields, TO_CHAR(date_created, 'YYYY-MM-DD HH12:MI:SS AM') as date_created
                // FROM logs 
                // JOIN user_account ON logs.user_id = user_account.ID $filter_sql 
                // ORDER BY $sort_field $sort_dir
                // LIMIT $query_limit OFFSET $start";

$data_stmt = $conn->prepare($data_query);
$data_stmt->bindValue(':limit', $query_limit, PDO::PARAM_INT);
$data_stmt->bindValue(':offset', $start, PDO::PARAM_INT);

foreach ($filter_params as $key => $value) {
    $data_stmt->bindValue(":$key", $value);
}

$data_stmt->execute();
$rows = $data_stmt->fetchAll(PDO::FETCH_ASSOC);

$response = [
    "last_page" => $pages,
    "total_record" => $total_query,
    "data" => $rows
];

echo json_encode($response);
?>
