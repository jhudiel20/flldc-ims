<?php
require_once __DIR__ . '/../DBConnection.php';
require_once __DIR__ . '/../../public/config/config.php';

header("Content-type: application/json; charset=utf-8");

$query_limit = isset($_GET['size']) && $_GET['size'] == 'true' ? PHP_INT_MAX : 20;
$table_name = "logs";
$sorters = isset($_GET['sort']) ? $_GET['sort'] : [];
$page = isset($_GET['page']) ? (int)$_GET['page'] - 1 : 0;
$start = $page * $query_limit;

$sort_field = 'DATE_CREATED';
$sort_dir = 'DESC';

if (!empty($sorters)) {
    $valid_sorts = ['ID', 'USER_ID', 'ACTION_MADE', 'DATE_CREATED'];
    $sort_field = in_array($sorters[0]['field'], $valid_sorts) ? $sorters[0]['field'] : $sort_field;
    $sort_dir = in_array($sorters[0]['dir'], ['asc', 'desc']) ? $sorters[0]['dir'] : $sort_dir;
}

$filters = isset($_GET['filter']) ? $_GET['filter'] : [];
$filter_clauses = [];
$filter_params = [];

foreach ($filters as $filter) {
    if (isset($filter['field']) && isset($filter['value'])) {
        $field = $filter['field'];
        $value = '%' . $filter['value'] . '%';
        $filter_clauses[] = "$field ILIKE :$field";
        $filter_params[$field] = $value;
    }
}

$filter_sql = !empty($filter_clauses) ? 'WHERE ' . implode(' AND ', $filter_clauses) : '';

$count_query = "SELECT COUNT(DISTINCT logs.ID) as count
                FROM logs
                JOIN ldims_accounts.user_account ON logs.user_id = user_account.ID
                $filter_sql";

$count_stmt = $conn->prepare($count_query);
$count_stmt->execute($filter_params);
$total_query = (int) $count_stmt->fetchColumn();

$pages = $total_query > 0 ? ceil($total_query / $query_limit) : 1;

$data_query = "SELECT logs.ID, logs.USER_ID, logs.ACTION_MADE, 
                       TO_CHAR(logs.DATE_CREATED, 'YYYY-MM-DD HH12:MI:SS AM') as DATE_CREATED, 
                       user_account.FNAME, user_account.MNAME, user_account.LNAME
                FROM logs
                JOIN ldims_accounts.user_account ON logs.user_id = user_account.ID
                $filter_sql
                ORDER BY $sort_field $sort_dir
                LIMIT :limit OFFSET :offset";

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
